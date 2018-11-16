<?php

return [
    'confirmed'            => 'La :attribute no coinciden.',
    'date'                 => 'El :attribute no es una fecha válida.',
    'email'                => 'El :attribute debe ser un correo electrónico válido.',
    'image'                => 'El :attribute debe ser una imagen.',
    'array'                => 'El :attribute debe ser un array.',
    'integer'              => 'El :attribute debe ser un entero.',
    'max'                  => [
        'numeric' => 'El :attribute no puede mayor a  :max.',
    ],
    'min'                  => [
        'numeric' => 'El :attribute debe tener un minimo de :min.',
        'string'  => 'La :attribute debe tener un minimo de :min caracteres.',
    ],
    'numeric'              => 'El :attribute debe ser un número.',
    'required'             => 'El campo :attribute es requerido.',
    'size'                 => [
        'numeric' => 'El :attribute debe ser :size.',
        'string'  => 'El :attribute debe ser :size caracteres.',
    ],
    'max'                  => [
        'numeric' => 'El :attribute no puede mayor a :max.',
        'file'    => 'El :attribute no puede mayor a :max kilobytes.',
        'string'  => 'El :attribute no puede mayor a :max caracteres.',
        'array'   => 'El :attribute no puede mayor a :max items.',
    ],
    'string'               => 'El :attribute debe ser una cadena de caracteres.',
    'unique'               => 'El :attribute ha sido utilizado.',


    'attributes' => [
        'name' => 'nombre',
        'email' => 'correo electrónico',
        'password' => 'contraseña',
        'firstname' => 'primer nombre',
        'lastname' => 'apellidos',
        'description' => 'descripción',
        'producttype_idprodcuttype' => 'Tipo Producto'
    ],
];
