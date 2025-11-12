<?php

namespace App\Http\Requests\Deals;

use Illuminate\Foundation\Http\FormRequest;

class StoreDealRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'amount' => 'nullable|numeric|min:0',
            'stage' => 'required|in:prospect,qualification,proposal,negotiation,closed_won,closed_lost',
            'expected_close_date' => 'nullable|date|after_or_equal:today',
            'company_id' => 'required|exists:companies,id',
            'contact_id' => 'nullable|exists:contacts,id',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'El nombre de la oportunidad es obligatorio.',
            'stage.required' => 'La etapa es obligatoria.',
            'stage.in' => 'La etapa seleccionada no es válida.',
            'amount.numeric' => 'El monto debe ser un número válido.',
            'amount.min' => 'El monto no puede ser negativo.',
            'expected_close_date.after_or_equal' => 'La fecha de cierre esperada no puede ser en el pasado.',
            'company_id.required' => 'La empresa es obligatoria.',
            'company_id.exists' => 'La empresa seleccionada no existe.',
            'contact_id.exists' => 'El contacto seleccionado no existe.',
        ];
    }
}