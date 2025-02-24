<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RepositoryActionRequest extends FormRequest
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
           // "product_variant_id"=> "required",
            //"count"=> "required",
           // "price"=> "required",
           // "invoice_id"=> "required",
        ];
    }

    public function messages(){
        return[
            "product_variant_id.required"=> "product nomi kiritilmadi",
            "count.required"=> "miqdori kiritilmadi",
            "price.required"=> "kirim narxi kiritilmadi",
            "invoice_id.required"=> "invoice tanlanmadi",
        ];
    }
}
