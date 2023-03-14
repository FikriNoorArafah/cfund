<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => 'required|min:4',
            'email' => 'required|email:rfc,dns|unique:users,email',
            'telephone' => 'required|unique:users,telephone',
            'password' => 'required|min:8',
        ];
    }
}
