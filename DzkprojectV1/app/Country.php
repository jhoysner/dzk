<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
	protected $table = 'country';
	protected $primarykey = 'idcountry';
    protected $fillable = [
        'name', 'isocode'
    ];
}
