<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductUnitOfMeasurement extends Model
{
    protected $table = 'productunitofmeasurement';

    protected $primaryKey = 'idproductounitofmeasurement';
    public $incrementing = false;

    protected $dates = ['deleted_at'];

    protected $fillable = [
        'idproductounitofmeasurement',
        'name'
    ];

    protected $hidden  = [
        'created_at', 'updated_at', 'deleted_at',
    ];
}
