<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MarketPlaceListingDetail extends Model
{
    protected $table = 'marketplacelistingdetail';

    protected $primaryKey = 'idmarketplacelistingdetail';
    public $incrementing = false;
    public $timestamps = false;

    protected $fillable = [
        'idmarketplacelistingdetail',
        'quantity',
        'unitprice',
        'taxes',
        'totalprice',
        'marketplacelisting_idmarketplacelisting',
        'product_idproduct',
        'productunitofmeasurement_idproductunitofmeasurement',
        'commerce_idcommerce',
        'branch_idbranch',
        'users_id',
        'statelisting_idstatelisting'
    ];


    public function state()
    {
      return $this->belongsTo('App\StateListing', 'statelisting_idstatelisting', 'idstatelisting');
    }

    public function product()
    {
        return $this->belongsTo('App\Product', 'product_idproduct', 'idproduct');
    }
    

}
