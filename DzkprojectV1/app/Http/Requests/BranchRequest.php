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
          'name'              => 'required',
          'address'           => 'required',
          'schedule'          => 'required',
          'phone1'            => 'numeric|required',
          'phone2'            => 'numeric|required',
          //'image'             => 'mimes:jpg, jpeg, png, bmp',
          'latitude'          => 'numeric',
          'longitude'         => 'numeric',
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
        ];
    }
}
