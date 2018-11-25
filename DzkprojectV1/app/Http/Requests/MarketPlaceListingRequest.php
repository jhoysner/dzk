<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MarketPlaceListingRequest extends FormRequest
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
            'commerce_idcommerce' => 'required',
            'observations'        => 'nullable|string|max:1024',
            'feedback'            => 'nullable|string|max:1024',
            'detalle.*.quantity'  => 'required|integer',
            'detalle.*.unitprice' => 'required',
            'detalle.*.taxes'     => 'required',
            'detalle.*.product_idproduct'   => 'required',
            'detalle.*.productunitofmeasurement_idproductunitofmeasurement' => 'required',
            'detalle.*.branch_idbranch'     => 'required',
            'detalle.*.statelisting_idstatelisting' => 'required',
        ];
    }
}
