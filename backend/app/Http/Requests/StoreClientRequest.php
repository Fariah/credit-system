<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreClientRequest extends FormRequest
{
    /**
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'age' => 'required|integer|min:18|max:60',
            'region' => 'required|string|in:PR,BR,OS',
            'income' => 'required|numeric|min:0',
            'score' => 'required|integer|min:0',
            'pin' => 'required|string',
            'email' => 'required|email',
            'phone' => 'required|string',
        ];
    }
}
