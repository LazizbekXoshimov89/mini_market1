<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OutputInvoiceRequest extends FormRequest
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
            "comment" => "required|string|min:3",
            "invoice_id" => "required",
            "products" => "required|array",
            "products.*.product_variant_id" => "required",
            "products.*.count" => "required"
        ];
    }

    public function messages()
    {
        return [
            "date_time.required" => "sana kiritilmadi!",
            "date_time.date_format" => "sana kiritilmadi",
            //"total_value.required"=> "ha o'sha ",
            "comment.required" => "Izoh kiritilmadi!",
            "comment.string" => "izoh string bo'lishi kerak!",
            "comment.min:3" => "izoh kamida 3 belgidan iborat bo'lishi kerak!",
            "type.required" => "tur tanlanmadi!",
            "type.string" => "ma'lumot matn shaklda kiritilishi kerak!",
            "type.in" => " turga 'output' tanlanmadi!",

        ];
    }
}
