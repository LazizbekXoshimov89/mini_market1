<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CategoryStoreRequest extends FormRequest
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
            "market_id"=> "required",
            ];
    }

    public function messages(): array{
        return [
            "title.required"=> "Kateqoriya nomi kiritilmadi",
            "title.string"=> "Kateqoriya nomi string bo'lishi kerak!",
            "title.min:3"=> "Kateqoriya nomi kamida 3 belgidan iborat bo'lishi kerak!",
            "market_id.required"=> "Market nomi tanlanmadi",
        ];  }
    }

