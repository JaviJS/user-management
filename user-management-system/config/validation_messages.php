<?php
return [
    /*
    |--------------------------------------------------------------------------
    | Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines contain the default error messages used by
    | the validator class. Some of these rules have multiple versions such
    | as the size rules.
    |
    */

    'accepted' => 'El campo :attribute debe ser aceptado.',
    'active_url' => 'El campo :attribute no es una URL válida',
    'after' => 'El campo :attribute debe ser una fecha después de :date.',
    'alpha' => 'El campo :attribute solo puede contener letras.',
    'alpha_dash' => 'El campo :attribute solo puede contener letras, números y guiones.',
    'alpha_num' => 'El campo :attribute solo puede contener letras y números.',
    'array' => 'El campo :attribute debe ser un arreglo.',
    'before' => 'El campo :attribute debe ser una fecha antes de :date.',
    'between' => [
        'numeric' => 'El campo :attribute debe estar entre :min y :max.',
        'file' => 'El campo :attribute debe estar entre :min y :max kilobytes.',
        'string' => 'El campo :attribute debe estar entre :min y :max caracteres.',
        'array' => 'El campo :attribute debe tener entre :min y :max elementos.'
    ],
    'boolean' => 'El campo :attribute debe ser verdadero o falso.',
    'confirmed' => 'La confirmación del campo :attribute no coincide.',
    'date' => 'El campo :attribute no es una fecha válida',
    'date_format' => 'El campo :attribute no coincide con el formato :format.',
    'different' => 'El campo :attribute y :other deben ser diferentes.',
    'digits' => 'El campo :attribute debe tener :digits dígitos.',
    'digits_between' => 'El campo :attribute debe tener entre :min y :max dígitos.',
    'email' => 'El campo :attribute debe ser una dirección de correo válida.',
    'filled' => 'El campo :attribute es obligatorio.',
    'exists' => 'El campo :attribute seleccionado es inválido.',
    'image' => 'El campo :attribute debe ser una imagen.',
    'in' => 'El campo :attribute seleccionado es inválido.',
    'integer' => 'El campo :attribute debe ser un número entero.',
    'ip' => 'El campo :attribute debe ser una dirección IP válida.',
    'max' => [
        'numeric' => 'El campo :attribute no puede ser mayor que :max.',
        'file' => 'El campo :attribute no puede ser mayor que :max kilobytes.',
        'string' => 'El campo :attribute no puede ser mayor que :max caracteres.',
        'array' => 'El campo :attribute no puede tener más de :max elementos.',
    ],
    'mimes' => 'El campo :attribute debe ser un archivo de tipo: :values.',
    'min' => [
        'numeric' => 'El campo :attribute debe ser al menos :min.',
        'file' => 'El campo :attribute debe ser al menos de :min kilobytes.',
        'string' => 'El campo :attribute debe tener al menos :min caracteres.',
        'array' => 'El campo :attribute debe tener al menos :min elementos.',
    ],
    'not_in' => 'El campo :attribute seleccionado es inválido.',
    'numeric' => 'El campo :attribute debe ser un número.',
    'regex' => 'El campo formato de :attribute es inválido.',
    'required' => 'El campo :attribute es obligatorio.',
    'required_if' => 'El campo :attribute es obligatorio cuando :other es :value.',
    'required_with' => 'El campo :attribute es obligatorio cuando :values está presente.',
    'required_with_all' => 'El campo :attribute es obligatorio cuando :values está presente.',
    'required_without' => 'El campo :attribute es obligatorio cuando :values no está presente.',
    'required_without_all' => 'El campo :attribute es obligatorio cuando ninguno de :values está presente.',
    'same' => 'El campo :attribute y :other deben coincidir.',
    'size' => [
        'numeric' => 'El campo :attribute debe ser :size.',
        'file' => 'El campo :attribute debe ser de :size kilobytes.',
        'string' => 'El campo :attribute debe tener :size caracteres.',
        'array' => 'El campo :attribute debe contener :size elementos.',
    ],
    'timezone' => 'El campo :attribute debe ser una zona válida.',
    'unique' => 'El campo :attribute ya ha sido tomado.',
    'url' => 'El campo formato de :attribute es inválido.',

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | Here you may specify custom validation messages for attributes using the
    | convention "attribute.rule" to name the lines. This makes it quick to
    | specify a specific custom language line for a given attribute rule.
    |
    */
    'custom' => [
        'uppercase' => 'La contraseña debe incluir al menos una letra mayúscula.',
        'lowercase' => 'La contraseña debe incluir al menos una letra minúscula.',
        'number' => 'La contraseña debe incluir al menos un número.',
        'symbol' => 'La contraseña debe incluir al menos un símbolo especial (@$!%*?&#).',
        'whitespace' => 'La contraseña no puede contener espacios en blanco.',
    ],
];