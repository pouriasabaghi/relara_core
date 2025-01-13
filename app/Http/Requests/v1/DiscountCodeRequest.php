<?php

namespace App\Http\Requests\v1;

use App\Enums\DiscountTypeEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class DiscountCodeRequest extends FormRequest
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
            'code' => 'required|string',
            'type' => 'required',
            'value' => 'required|numeric',
            'min_cart_value' => 'nullable|numeric',
            'max_discount_value' => 'nullable|numeric',
            'usage_limit' => 'nullable|numeric',
            'expires_at' => 'numeric',
        ];
    }
}
