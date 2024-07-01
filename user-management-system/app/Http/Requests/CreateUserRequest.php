<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateUserRequest extends FormRequest
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
            'name' => 'required|alpha',
            'last_name' => 'required|alpha',
            "email" => 'required|email|unique:users,email',
            "password" => 'required|confirmed|string|min:8|max:16',
            "password_confirmation" => 'required',
            "phone" => 'required',
            "birthday_date" => 'required|date_format:d-m-Y',
            "role" => 'required|in:admin,usuario',
            "status" => 'required|in:Activo,Inactivo',
            'photo_user' => 'required|file|extensions:jpg,png'
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return config('validation_messages');
    }

    /**
     * Define attribute names for rules.
     *
     * @return array<string, string>
     */
    public function attributes()
    {
        return [
            'name' => 'nombre',
            'last_name' => 'apellido',
            "email" => 'correo electrónico',
            "password" => 'contraseña',
            "password_confirmation" => 'confirmar contraseña',
            "phone" => 'teléfono',
            "birthday_date" => 'fecha de cumpleaños',
            "role" => 'rol',
            "status" => 'estado',
            'photo_user' => 'foto de usuario'
        ];
    }

    /**
     * Configure the validator instance.
     *
     * @param  \Illuminate\Validation\Validator  $validator
     * @return void
     */
    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            $password = $this->input('password');
            $messages = $this->messages()['custom'];
            if (!preg_match('/[A-Z]/', $password)) {
                $validator->errors()->add('password', $messages['uppercase']);
            }
            if (!preg_match('/[a-z]/', $password)) {
                $validator->errors()->add('password', $messages['lowercase']);
            }
            if (!preg_match('/[0-9]/', $password)) {
                $validator->errors()->add('password', $messages['number']);
            }
            if (!preg_match('/[@$!%*?&#]/', $password)) {
                $validator->errors()->add('password', $messages['symbol']);
            }
            if (preg_match('/\s/', $password)) {
                $validator->errors()->add('password', $messages['whitespace']);
            }
        });
    }
}
