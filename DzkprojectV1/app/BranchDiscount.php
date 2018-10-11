<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BranchDiscount extends Model
{
    use SoftDeletes;
    
    protected $table = 'branch_has_discount';

    protected $primaryKey = 'idbranch_has_discount';
    public $incrementing = false;
    protected $dates = ['deleted_at'];

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
