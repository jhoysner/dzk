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
}
