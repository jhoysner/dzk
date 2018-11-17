<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BranchHasProduct extends Model
{
    use SoftDeletes;
    
    protected $table = 'branch_has_product';

    protected $primaryKey = 'idbranch_has_product';
    public $incrementing = false;
    protected $dates = ['deleted_at'];

    protected $fillable = [
        'idbranch_has_product',
        'stock',
        'branch_idbranch',
        'product_idproduct',
        'commerce_idcommerce'
    ];

    protected $hidden  = [
        'created_at', 'updated_at', 'deleted_at',
    ];

}
