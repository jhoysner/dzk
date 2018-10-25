<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Discount extends Model
{

    use SoftDeletes;

    protected $table = 'discount';

    protected $primaryKey = 'iddiscount';
    public $incrementing = false;

    protected $dates = ['deleted_at'];


    protected $fillable = [
        'iddiscount',
        'title',
        'description',
        'image',
        'startdate',
        'enddate',
        'outstanding',
        'conditions',
        'restrictions',
        'amountapproved',
        'amountavailable',
        'amountredeemed',
        'normalprice',
        'discountprice',
        'discountpercentage',
        'discountcategory_iddiscountcategory',
        'currency_idcurrency'
    ];

    protected $hidden  = [
        'created_at', 'updated_at', 'deleted_at',
    ];


    public function  branchs(){
        return $this->belongsToMany('App\Branch','branch_has_discount')->withPivot('idbranch_has_discount','discounthours', 'amountapproved','amountavailable','amountredeemed')->whereNull('branch_has_discount.deleted_at');
    }

    public function tags()
    {
        return $this->belongsToMany('App\Tags','discount_has_tags')->withPivot('iddiscount_has_tags','discount_iddiscount', 'tags_idtags')->whereNull('discount_has_tags.deleted_at');   
    }   

    public function categories()
    {
       return $this->belongsTo('App\DiscountCategory', 'discountcategory_iddiscountcategory', 'iddiscountcategory');
    }

}
