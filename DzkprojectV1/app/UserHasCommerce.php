<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserHasCommerce extends Model
{
    protected $table = 'users_has_commerce';

    protected $primaryKey = 'idusers_has_commerce';
    public $incrementing = false;

    protected $dates = ['deleted_at'];

    protected $fillable = [
        'idusers_has_commerce',
        'users_id',
    	'commerce_idcommerce'
    ];

    protected $hidden  = [
        'created_at', 'updated_at', 'deleted_at',
    ];

    public function users()
    {
      return $this->belongsTo('App\User', 'users_id', 'id');
    }
}
