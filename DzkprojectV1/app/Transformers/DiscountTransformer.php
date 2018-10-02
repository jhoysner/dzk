<?php

namespace App\Transformers;

use App\Discount;
use League\Fractal\TransformerAbstract;

class DiscountTransformer extends TransformerAbstract
{
    /**
     * A Fractal transformer.
     *
     * @return array
     */
    public function transform(Discount $discount)
    {
        return [
            'id' => $discount->iddiscount,
            'title' => $discount->title,
            'description' => $discount->description,
            'image' => $discount->image,
            'startdate' => $discount->startdate,
            'enddate' => $discount->enddate,
            'outstanding' => $discount->outstanding,
            'conditions'  => $discount->conditions,
            'restrictions'  => $discount->restrictions,
            'amount_approved'  => $discount->amountapproved,
            'amount_available' => $discount->amountavailable,
            'amount_redeemed' => $discount->amountredeemed,
            'normal_price' => $discount->normalprice,
            'discount_price' => $discount->discountprice,
            'discount_percentage' => $discount->discountpercentage,
            'discount_category_id' => $discount->discountcategory_iddiscountcategory,
        ];
    }
}
