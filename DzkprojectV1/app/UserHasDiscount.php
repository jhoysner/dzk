<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserHasDiscount extends Model
{
    use SoftDeletes;
    
    protected $table = 'users_has_discount';

    protected $primaryKey = 'idusers_has_discount';
    public $incrementing = false;
    protected $dates = ['deleted_at'];

    protected $fillable = [
        'idusers_has_discount',
        'charcode',
        'qrcode',
        'validfrom',
        'validto',
        'authorizedby',
        'authorizeddate',
        'redeemby',
        'redeemdate',
        'amount',
        'normalprice',
        'discountprice',
        'discountpercentage',
        'discount_iddiscount',
        'userhasdiscountstatus_iduserhasdiscountstatus',
        'commerce_idcommerce',
        'branch_idbranch',
        'users_id',

    ];

    protected $hidden  = [
        'created_at', 'updated_at', 'deleted_at',
    ];
}
