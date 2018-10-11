<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Params extends Model
{
    use SoftDeletes;
    protected $dates = ['deleted_at'];

    protected $table = 'params';
	protected $primaryKey = 'idparams';
	
	public $incrementing = false;

    protected $fillable = [
        'idparams',
        'key', 
        'val', 
        'description'
    ];

    protected $hidden  = [
        'created_at', 'updated_at', 'deleted_at',
    ];
}
