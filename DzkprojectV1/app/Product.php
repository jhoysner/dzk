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
        'price',
        'taxpercentage',
        'image',
        'producttype_idproductype',
        'commerce_idcommerce',
        'productunitofmeasurement_idproductunitofmeasurement'
    ];

    protected $hidden  = [
        'created_at', 'updated_at', 'deleted_at',
    ];

	public function type()
    {
      return $this->belongsTo('App\ProductType', 'producttype_idproducttype', 'idproducttype');
    }

    public function units()
    {
      return $this->belongsTo('App\ProductUnitOfMeasurement', 'productunitofmeasurement_idproductunitofmeasurement', 'idproductunitofmeasurement');
    }

    public function commerces()
    {
      return $this->belongsTo('App\Commerce', 'commerce_idcommerce', 'idcommerce');
    }

    public function branchs()
    {
        return $this->belongsToMany('App\Branch','branch_has_product')->withPivot('idbranch_has_product','stock','commerce_idcommerce', 'product_idproduct','branch_idbranch')->whereNull('branch_has_product.deleted_at');
    }
}
