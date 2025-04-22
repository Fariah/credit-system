<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class IssueCreditRequest extends FormRequest
{
    /**
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'pin' => 'required|string',
            'name' => 'required|string',
            'amount' => 'required|numeric|min:1',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
        ];
    }
}
