<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class UserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool{
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
            "firstname" => 'required',
            "lastname" => 'required',
            "email" => "required|email",
            "password" => "required",
        ];
    }

    public function messages(): array{
        return [
            'firstname.required' => 'Por favor ingrese el nombre.',
            'lastname.required' => 'Por favor, ingrese el apellido.',
            'email.required' => 'Por favor ingrese el correo.',
            'email.email' => 'Por favor, ingrese un correo valido.',
            'password.required' => 'Por favor, ingrese un password.'
        ];
    }

    protected function failedValidation(Validator $validator){
        $response = response()->json([
            "meta" => ["success"=> false, "errors" =>$validator->errors()],
        ], 422);

        throw new HttpResponseException($response);
    }
}
