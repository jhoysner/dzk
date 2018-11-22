<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MarketPlaceListingDetail extends Model
{
    protected $table = 'marketplacelistingdetail';

    protected $primaryKey = 'idmarketplacelistingdetail';
    public $incrementing = false;

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
        'users_id',
        'statelisting_idstatelisting'
    ];

}
