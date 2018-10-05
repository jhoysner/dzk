<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class State extends Model
{
    protected $table = 'state';
    protected $primarykey = 'idstate';
    protected $fillable = [
        'name','country_idcountry'
    ];
}
