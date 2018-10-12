<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CommerceRequest extends FormRequest
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
     * @return array
     */
    public function rules()
    {
        return [
          //'idcommerce'        => 'required',
          'name'              => 'required|string|max:128',
          'phone1'            => 'required|string|max:20',
          'phone2'            => 'required|string|max:20',
          'email'             => 'required|email|max:45', //unique:commerce,email
          //'image'             => 'nullable|image64:jpeg,jpg,png',
          'web'               => 'nullable|string|max:128',
          'country_idcountry' => 'required',
          'state_idstate'     => 'required',
          'city_idcity'       => 'required',
          'commercecategory_idcommercecategory' => 'required'
        ];
    }

    public function messages()
    {
        return [
            'required' => 'El campo :attribute es obligatorio.',
            'numeric' => 'El campo :attribute es admite solo números.',
            'email' => 'El campo :attribute no contiene un email válido.',
            'mimes' => 'El campo :attribute admite solo formato de imagenes.',
            'max' =>  'El campo :attribute excede el limite permitido de caracteres.'
        ];
    }
}
