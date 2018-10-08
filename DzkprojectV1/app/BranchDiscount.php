<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BranchDiscount extends Model
{
    
    protected $table = 'branch_has_discount';

    protected $primaryKey = 'idbranch_has_discount';
    public $incrementing = false;

    protected $fillable = [
        'idbranch_has_discount',
        'discounthours',
        'amountapproved',
        'amountavailable',
        'amountredeemed',
        'branch_idbranch',
        'discount_iddiscount',

    ];

    protected $hidden  = [
        'created_at', 'updated_at', 'deleted_at',
    ];
}
