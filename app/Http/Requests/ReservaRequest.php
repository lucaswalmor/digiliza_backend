<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ReservaRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'mesa.id' => 'required|exists:mesas,id',
            'cliente.id' => 'required|exists:clientes,id',
            'horario' => [
                'required',
                'date_format:H:i',
                'after_or_equal:18:00',
                'before_or_equal:23:59',
            ],
            'dat_inicio' => 'required|date|after_or_equal:today',
        ];
    }

    /**
     * Mensagens de erro personalizadas.
     *
     * @return array
     */
    public function messages(): array
    {
        return [
            'mesa_id.required' => 'A mesa de reserva é obrigatória.',
            'mesa_id.exists' => 'A mesa selecionada não existe.',
            'dat_inicio.required' => 'A data de início da reserva é obrigatória.',
            'dat_inicio.date' => 'A data de início não é uma data válida.',
            'dat_inicio.after_or_equal' => 'A data de início deve ser hoje ou uma data futura.',
            'horario.required' => 'O horário da reserva é obrigatório.',
            'horario.after_or_equal' => 'A reserva só pode ser feita após as 18:00.',
            'horario.before_or_equal' => 'A reserva deve começar antes das 23:59.',
        ];
    }
}
