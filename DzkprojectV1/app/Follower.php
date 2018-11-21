<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Follower extends Model
{
    protected $table = 'follower';

    protected $primaryKey = 'idfollower';
    public $incrementing = false;
    // protected $dates = ['deleted_at'];

    protected $fillable = [
        'idfollower',
        'locked ',
        'users_id',
        'commerce_idcommerce',
    ];

    protected $hidden  = [
        'created_at', 
        'updated_at', 
        'deleted_at',
    ];


    public function user()
    {
        return $this->belongsTo('App\User', 'users_id', 'id');
    }

}
