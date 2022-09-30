<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;

class LoginRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        $rules = [
            'email' => 'required|email',
            'password' => 'required|min:5|max:12'
        ];
        return $rules;
    }

    public function messages()
    {
        return [
            'email.required' => 'O campo email é obrigatorio!',
            'email.email' => 'Insira um email valido!',
            'password.min' => 'O campo senha não pode conter menos de 5 caracteres!',
            'password.max' => 'O campo senha não pode conter mais de 15 caracteres!',
            'password.required' =>'O campo senha é obrigatorio!'
        ];
    }

    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'success' => false,
            'error' => true,
            'msg' =>  'Error ao validar campos',
            'data' => [],
            'token' => [],
            'type_error' => $validator->errors()
        ],401));
    }
}
