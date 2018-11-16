<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Branch extends Model
{
    use SoftDeletes;

    protected $table = 'branch';

    protected $primaryKey = 'idbranch';
    public $incrementing = false;

    protected $dates = ['deleted_at'];

    protected $fillable = [
        'idbranch',
        'name',
        'address',
        'schedule',
        'phone1',
        'phone2',
        'image',
        'latitude',
        'longitude',
        'commerce_idcommerce',
        'country_idcountry',
        'state_idstate',
        'city_idcity'
    ];

    protected $hidden  = [
        'created_at', 'updated_at', 'deleted_at',
    ];

    public function countries()
    {
      return $this->belongsTo('App\Country', 'country_idcountry', 'idcountry');
    }

    public function states()
    {
      return $this->belongsTo('App\State', 'state_idstate', 'idstate');
    }

    public function cities()
    {
      return $this->belongsTo('App\City', 'city_idcity', 'idcity');
    }

    public function commerces()
    {
      return $this->belongsTo('App\Commerce', 'commerce_idcommerce', 'idcommerce');
    }

    public function  discounts(){
        return $this->belongsToMany('App\Discount','branch_has_discount')->withPivot('idbranch_has_discount','discounthours', 'amountapproved','amountavailable','amountredeemed')->whereNull('branch_has_discount.deleted_at');
    }

    public function products(){
        return $this->belongsToMany('App\Product','branch_has_product')->withPivot('idbranch_has_product','stock','commerce_idcommerce')->whereNull('branch_has_product.deleted_at');
    }
}
