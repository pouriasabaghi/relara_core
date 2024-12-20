<?php

namespace App\Http\Requests\v1;

use Illuminate\Foundation\Http\FormRequest;

class ProductVariantRequest extends FormRequest
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
        $rules = [
            'price' => 'nullable|numeric|min:0',
            'stock' => 'nullable|integer|min:0',
            'status' => 'nullable|string|in:available,unavailable,call',
        ];

        if ($this->method() === 'POST') {
            $rules['product_id'] = 'required|exists:products,id';
            $rules['attribute_values'] = 'required|array';
            $rules['attribute_values.*'] = 'exists:attribute_values,id';
        }

        return $rules;
    }
}
