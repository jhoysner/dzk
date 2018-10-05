<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Params extends Model
{
    use SoftDeletes;
    protected $dates = ['deleted_at'];

    protected $table = 'params';
	protected $primarykey = 'idparams';
    protected $fillable = [
        'key', 'val'
    ];
}
