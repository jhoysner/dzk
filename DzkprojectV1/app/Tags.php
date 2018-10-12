<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Tags extends Model
{
    use SoftDeletes;
    protected $dates = ['deleted_at'];

    protected $table = 'tags';
	protected $primaryKey = 'idtags';
	
	public $incrementing = false;

    protected $fillable = [
        'idtags',
        'name'
    ];

    protected $hidden  = [
        'created_at', 'updated_at', 'deleted_at',
    ];

    public function commerces()
    {

    }

    public function discounts()
    {
    	
    }
}
