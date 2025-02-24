<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class InvoiceStorerequest extends FormRequest
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

     public function rules()
     {
        return [
            "partner_id"=> "required",
            //"date_time"=> "required|date_format:Y-m-d",
            //"total_value"=> "required|integer",
            "comment"=> "required|string|min:3",
            "type"=> "required",
               ];
    }

    public function messages()
    {
        return [
            "partner_id.required"=> "Hamkor tanlanmadi",
            "date_time.required"=> "sana kiritilmadi!",
            "date_time.date_format"=> "sana kiritilmadi",
            //"total_value.required"=> "ha o'sha ",
            "comment.required"=> "Izoh kiritilmadi!",
            "comment.string"=> "izoh string bo'lishi kerak!",
            "comment.min:3"=> "izoh kamida 3 belgidan iborat bo'lishi kerak!",
            "type.required"=> "tur tanlanmadi!",

        ];
    }

}
