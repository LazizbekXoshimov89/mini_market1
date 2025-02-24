<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MarketStoreRequest extends FormRequest
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
            "title"=> "required|string|min:3",
            "adress"=> "required|string|min:3",
        ];
    }

    public function messages(){
        return[
            "title.required"=> "market nomi kiritilmadi",
            "title.string"=> "market nomi string bo'lishi kerak!",
            "title.min:3"=> "market nomi kamida 3 belgidan iborat bo'lishi kerak!",
            "adress.required"=> "manzil kiritilmadi",
            "adress.string"=> "manzil string bo'lishi kerak!",
            "adress.min:3"=> "manzil kamida 3 belgidan iborat bo'lishi kerak!",
        ];
    }
}
