<?php

namespace App\Http\Requests\Activities;

use Illuminate\Foundation\Http\FormRequest;

class StoreActivityRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'type' => 'required|in:call,meeting,email,task,note',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'scheduled_at' => 'nullable|date|after_or_equal:now',
            'company_id' => 'required|exists:companies,id',
            'contact_id' => 'nullable|exists:contacts,id',
        ];
    }

    public function messages(): array
    {
        return [
            'type.required' => 'The activity type is required.',
            'title.required' => 'The activity title is required.',
            'company_id.required' => 'Please select a company.',
            'scheduled_at.after_or_equal' => 'The scheduled date must be in the future.',
        ];
    }
}