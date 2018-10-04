<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Commerce extends Model
{
    use SoftDeletes;

    protected $table = 'commerce';

    protected $primaryKey = 'idcommerce';
    public $incrementing = false;

    protected $dates = ['deleted_at'];

    protected $fillable = [
        'idcommerce',
        'name',
        'phone1',
        'phone2',
        'email',
        'image',
        'web',
        'country_idcountry',
        'state_idstate',
        'city_idcity',
        'commercecategory_idcommercecategory',
    ];

    protected $hidden  = [
        'created_at', 'updated_at', 'deleted_at',
    ];
}
