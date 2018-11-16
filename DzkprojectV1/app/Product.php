<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use SoftDeletes;
    protected $dates = ['deleted_at'];

    protected $table = 'product';
	protected $primaryKey = 'idproduct';
	public $incrementing = false;

    protected $fillable = [
        'idproduct',
        'name', 
        'reference', 
        'usestock',
        'image',
        'producttype_idproductype',
        'commerce_idcommerce'
    ];

    protected $hidden  = [
        'created_at', 'updated_at', 'deleted_at',
    ];

	public function type()
    {
      return $this->belongsTo('App\ProductType', 'producttype_idproducttype', 'idproducttype');
    }

    public function commerces()
    {
      return $this->belongsTo('App\Commerce', 'commerce_idcommerce', 'idcommerce');
    }
}
