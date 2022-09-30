<?php

namespace App\Http\Requests;

use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;

class AuthRequest extends FormRequest
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

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */


    public function rules()
    {


        $method = $this->method();
        $id = Auth::user()->id ?? '';

        $rules = [
            'last_name' => 'required|min:3|max:15|alpha',
            'first_name' => 'required|min:3|max:15|alpha',
            'password' => 'required|min:5|max:12|confirmed',
            'password_confirmation' => 'required|min:5|max:12',
            'email' => 'required|email|unique:users,email',
        ];

        if ($method === 'PUT') {
            $rules['email'] = "required|email|unique:users,email,{$id},id";
            $rules['password'] = 'nullable|min:5|max:12';
            $rules['password_confirmation'] = 'nullable|min:5|max:12';
        }

        return $rules;
    }

    public function messages()
    {
        return [
            'last_name.required' => 'O campo primeiro nome é obrigatorio!',
            'last_name.min' => 'O campo  primeiro nome não pode conter menos de 3 caracteres!',
            'last_name.max' => 'O campo primeiro nome não pode conter mais de 15 caracteres!',
            'last_name.alpha' => 'O campo primeiro nome não pode conter numeros ou espaços!',
            'first_name.required' => 'O campo sobrenome é obrigatorio!',
            'first_name.alpha' => 'O campo sobrenome não pode conter numeros ou espaços!',
            'first_name.min' => 'O campo sobrenome não pode conter menos de 3 caracteres!',
            'first_name.max' => 'O campo sobrenome não pode conter mais de 15 caracteres!',
            'email.required' => 'O campo email é obrigatorio!',
            'email.email' => 'Insira um email valido!',
            'email.unique' => 'Este email já esta em uso!',
            'password.required' => 'O campo senha é obrigatorio!',
            'password.min' => 'O campo senha não pode conter menos de 5 caracteres!',
            'password.max' => 'O campo senha não pode conter mais de 15 caracteres!',
            'password.confirmed' => 'As senhas não comferem',
            'password_confirmation.required' => 'O campo comfirmar senha é obrigatorio!',
            'password_confirmation.min' => 'O campo comfirmar senha não pode conter menos de 5 caracteres',
            'password_confirmation.max' => 'O campo comfirmar senha não pode conter mais de 15 caracteres',
        ];
    }
}
