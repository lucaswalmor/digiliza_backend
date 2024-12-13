<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ReservaResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'cliente' => [
                'id' => $this->cliente->id,
                'nome' => $this->cliente->nome,
            ],
            'usuario' => [
                'id' => $this->user->id,
                'nome' => $this->user->nome,
            ],
            'mesa' => [
                'id' => $this->mesa->id,
                'numero' => $this->mesa->numero,
            ],
            'horario' => $this->horario,
            'dat_inicio' => Carbon::parse($this->dat_inicio)->format('d/m/Y'),
            'dat_reserva' => Carbon::parse($this->dat_inicio)->format('d/m/Y') . ' ' . $this->horario,
        ];
    }
}
