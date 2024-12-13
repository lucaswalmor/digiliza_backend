<?php

namespace App\Http\Controllers;

use App\Http\Requests\ReservaRequest;
use App\Http\Resources\PaginationResource;
use App\Http\Resources\ReservaResource;
use App\Models\Mesa;
use App\Models\Reserva;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ReservaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Reserva::with(['user', 'mesa', 'cliente']);
    
        // Filtros
        if ($request->filled('cliente')) {
            $query->whereHas('cliente', function ($q) use ($request) {
                $q->where('nome', 'LIKE', '%' . $request->cliente . '%');
            });
        }
    
        if ($request->filled('colaborador')) {
            $query->whereHas('user', function ($q) use ($request) {
                $q->where('name', 'LIKE', '%' . $request->colaborador . '%');
            });
        }
    
        if ($request->filled('dat_inicio')) {
            $query->whereDate('dat_inicio', $request->dat_inicio);
        }
    
        // Paginação
        $reservas = $query->paginate(10);
    
        return new PaginationResource(
            ReservaResource::collection($reservas)
        );
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ReservaRequest $request)
    {
        DB::beginTransaction();
    
        try {
            $mesa = Mesa::where('id', $request->mesa['id'])->first();
    
            if ($mesa->status) {
                throw new Exception("Esta mesa já está reservada para este horário!");
            }
    
            $mesa->update(['status' => RESERVADO]);
    
            Reserva::create([
                'mesa_id' => $request->mesa['id'],
                'cliente_id' => $request->cliente['id'],
                'user_id' => Auth::id(),
                'dat_inicio' => Carbon::parse($request->dat_inicio)->format('Y-m-d'),
                'horario' => $request->horario,
            ]);
    
            DB::commit();
    
            return response()->json(['message' => 'Reserva concluída com sucesso!'], 201);
    
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $reserva = Reserva::with(['user', 'mesa', 'cliente'])->first();
        return new ReservaResource($reserva);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Reserva $reserva)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        DB::beginTransaction();
    
        try {
            // Busca a reserva
            $reserva = Reserva::findOrFail($id);
    
            // Verifica se a mesa foi alterada e se está reservada
            $mesa = Mesa::findOrFail($request->mesa['id']);
    
            if ($mesa->status && $mesa->id !== $reserva->mesa_id) {
                throw new Exception("Esta mesa já está reservada para este horário!");
            }
    
            // Atualiza a mesa anterior para DISPONÍVEL, se foi alterada
            if ($mesa->id !== $reserva->mesa_id) {
                Mesa::where('id', $reserva->mesa_id)->update(['status' => DISPONIVEL]);
            }
    
            // Atualiza a nova mesa para RESERVADO
            $mesa->update(['status' => RESERVADO]);
    
            // Atualiza a reserva
            $reserva->update([
                'mesa_id' => $request->mesa['id'],
                'cliente_id' => $request->cliente['id'],
                'user_id' => Auth::id(),
                'dat_inicio' => Carbon::parse($request->dat_inicio)->format('Y-m-d'),
                'horario' => $request->horario,
            ]);
    
            DB::commit();
    
            return response()->json(['message' => 'Reserva atualizada com sucesso!'], 200);
    
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $reserva = Reserva::with('mesa')->find($id);
    
            if (!$reserva) {
                return response()->json([
                    'error' => 'Reserva não encontrada.'
                ], 404);
            }
    
            DB::transaction(function () use ($reserva) {
                // Atualiza o status da mesa para "DISPONÍVEL"
                $reserva->mesa->update(['status' => DISPONIVEL]);
    
                // Exclui a reserva
                $reserva->delete();
            });
    
            return response()->json([
                'message' => 'Reserva excluída com sucesso!'
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'error' => 'Ocorreu um erro ao excluir a reserva.',
                'details' => $e->getMessage(),
            ], 500);
        }
    }
}
