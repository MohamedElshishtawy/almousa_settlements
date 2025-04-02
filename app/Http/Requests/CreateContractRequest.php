<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateContractRequest extends FormRequest
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
            'reference_number' => 'nullable|string|max:255',
            'company_name' => 'nullable|string|max:255',
            'project_name' => 'nullable|string|max:255',
            'start_date' => 'nullable|date|before:end_date',
            'end_date' => 'nullable|date|after:start_date',
            'contract_amount_without_tax' => 'nullable|numeric',
            'tax_percentage' => 'nullable|numeric',
            'modified_tax' => 'nullable|numeric',
            'deduction_ratio' => 'nullable|numeric',
            'note' => 'nullable|string',
            'commission_date' => 'nullable|date',
            'award_date' => 'nullable|date',
            'contract_signing_date' => 'nullable|date',
            'contract_type_id' => 'nullable|exists:contract_types,id', // Ensure contract_type_id exists
        ];
    }
}
