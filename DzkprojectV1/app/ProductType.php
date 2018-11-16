<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductType extends Model
{
    use SoftDeletes;
    protected $dates = ['deleted_at'];

    protected $table = 'producttype';
	protected $primaryKey = 'idproducttype';
	public $incrementing = false;

    protected $fillable = [
        'idproducttype',
        'name'
    ];

    protected $hidden  = [
        'created_at', 'updated_at', 'deleted_at',
    ];
}
