<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DiscountRequest extends FormRequest
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
            // 'iddiscount' => 'required',
            'title' => 'required',
            'description' => 'required',
            // 'image' => 'required',
            'startdate' => 'required',
            'enddate' => 'required',
            'outstanding' => 'required',
            // 'conditions' => 'required',
            // 'restrictions' => 'required',
            // 'amountapproved' => 'required',
            // 'amountavailable' => 'required',
            // 'amountredeemed' => 'required',
            'normalprice' => 'required',
            'discountprice' => 'required',
            'discountpercentage' => 'required',
            'discountcategory_iddiscountcategory' => 'required',
            'commerce_idcommerce' => 'required',
        ];
    }
}
