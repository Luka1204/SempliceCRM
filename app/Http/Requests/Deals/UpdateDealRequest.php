<?php

namespace App\Http\Requests\Deals;

use Illuminate\Foundation\Http\FormRequest;

class UpdateDealRequest extends FormRequest
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
}