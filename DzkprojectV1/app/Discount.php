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
    ];

    protected $hidden  = [
        'created_at', 'updated_at', 'deleted_at',
    ];


    public function  branchs(){
        return $this->belongsToMany('App\Branch','branch_has_discount')->withPivot('idbranch_has_discount','discounthours', 'amountapproved','amountavailable','amountredeemed');
    }

}
