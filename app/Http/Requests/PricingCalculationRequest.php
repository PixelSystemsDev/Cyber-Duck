<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PricingCalculationRequest extends FormRequest
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
            'productId' => 'required',
            'quantity' => 'required|numeric',
            'cost' => 'required|numeric',
        ];
    }

    public function messages(): array
    {
        return [
            'productId.required' => 'The product id field is required.',
            'quantity.required' => 'The quantity field is required.',
            'quantity.numeric' => 'The quantity must be a number.',
            'cost.required' => 'The cost field is required.',
            'cost.numeric' => 'The cost must be a number.',
        ];
    }
}
