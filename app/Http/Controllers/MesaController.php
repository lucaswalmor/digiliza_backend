<?php

namespace App\Http\Controllers;

use App\Http\Requests\MesaRequest;
use App\Http\Resources\MesaResource;
use App\Models\Mesa;
use Illuminate\Http\Request;

class MesaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $mesas = Mesa::orderBy('numero', 'asc')->get(); 
        return MesaResource::collection($mesas);
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
    public function store(MesaRequest $request)
    {
        $mesa = Mesa::create($request->validated());
        return new MesaResource($mesa);
    }

    /**
     * Display the specified resource.
     */
    public function show(Mesa $mesa)
    {
        return new MesaResource($mesa);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Mesa $mesa)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Mesa $mesa)
    {
        $mesa->update($request->validated());
        return new MesaResource($mesa);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Mesa $mesa)
    {
        $mesa->delete();
        return response()->json(['message' => 'Mesa deletada com sucesso'], 200);
    }
}
