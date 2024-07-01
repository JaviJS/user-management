<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
class UpdateUserRequest extends FormRequest
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
        $userId = $this->route('id');
        return [
            'name' => 'required|alpha',
            'last_name' => 'required|alpha',
            "email" => 'required|email|unique:users,email,'. $userId,
            "phone" => 'required',
            "birthday_date" => 'required|date_format:d-m-Y',
            "role" => 'required|in:admin,usuario',
            "status" => 'required|in:Activo,Inactivo',
            'photo_user' => 'sometimes|file|extensions:jpg,png'
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
            "phone" => 'teléfono',
            "birthday_date" => 'fecha de cumpleaños',
            "role" => 'rol',
            "status" => 'estado',
            'photo_user' => 'foto de usuario'
        ];
    }
}
