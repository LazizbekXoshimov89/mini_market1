<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SellingPriceCreateRequest extends FormRequest
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
            "product_variant_id" => "required",
            "price" => "required|numeric",
            "market_id" => "required",
        ];
    }

    public function messages()
    {
        return [
            "product_variant_id.required" => "mahsulot kiritilmadi",
            "price.required" => "sotish narxi kiritilmadi",
            "price.numeric" => "sotish narxi raqam bo'lishi kerak",
            "market_id.required" => "market tanlanmadi",
        ];
    }
}
