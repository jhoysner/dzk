<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class StateListing extends Model
{
    protected $table = 'statelisting';

    protected $primaryKey = 'idstatelisting';
    public $incrementing = false;

    protected $dates = ['deleted_at'];

    protected $fillable = [
        'idstatelisting',
        'name'
    ];

    protected $hidden  = [
        'created_at', 'updated_at', 'deleted_at',
    ];
}
