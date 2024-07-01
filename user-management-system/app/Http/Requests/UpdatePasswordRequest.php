<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePasswordRequest extends FormRequest
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
            "actual_password" => 'required',
            "new_password" => 'required|confirmed|string|min:8|max:16',
            "new_password_confirmation" => 'required',
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
            "actual_password" => 'contraseña actual',
            "new_password" => 'contraseña nueva',
            "new_password_confirmation" => 'confirmar contraseña nueva',
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
            $password = $this->input('new_password');
            $messages = $this->messages()['custom'];
            if (!preg_match('/[A-Z]/', $password)) {
                $validator->errors()->add('new_password', $messages['uppercase']);
            }
            if (!preg_match('/[a-z]/', $password)) {
                $validator->errors()->add('new_password', $messages['lowercase']);
            }
            if (!preg_match('/[0-9]/', $password)) {
                $validator->errors()->add('new_password', $messages['number']);
            }
            if (!preg_match('/[@$!%*?&#]/', $password)) {
                $validator->errors()->add('new_password', $messages['symbol']);
            }
            if (preg_match('/\s/', $password)) {
                $validator->errors()->add('new_password', $messages['whitespace']);
            }
        });
    }
}
