<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BranchRequest extends FormRequest
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
          //'idbranch'          => 'required',
          'name'              => 'required|string|max:128',
          'address'           => 'required|string|max:256',
          'schedule'          => 'required|string|max:512',
          'phone1'            => 'required|string|max:20',
          'phone2'            => 'required|string|max:20',
          //'image'             => 'mimes:jpg, jpeg, png, bmp',
          'latitude'          => 'nullable|numeric',
          'longitude'         => 'nullable|numeric',
          'commerce_idcommerce' => 'required',
          'country_idcountry' => 'required',
          'state_idstate'     => 'required',
          'city_idcity'       => 'required',
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
