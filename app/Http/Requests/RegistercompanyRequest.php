<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegistercompanyRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|min:4|unique:companies,name',
            'email' => 'required|email:rfc,dns|unique:companies,email',
            //    'username' => 'required|unique:users,username',
            'password' => 'required|min:8',
            'password_confirmation' => 'required|same:password'
        ];
    }
}
