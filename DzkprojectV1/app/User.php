<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable
{
    use Notifiable;

    //softdeletes
    use SoftDeletes;
    protected $dates = ['deleted_at'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    
    protected $primarykey = ['id'];
    protected $fillable = [
        'firstname', 'middlename', 'lastname', 'birthday', 'phone', 'image', 'email', 'password', 
        'address', 'latitude', 'longitude', 'provider', 'provider_id', 'access_token', 'lastlogin', 
        'attemps', 'status', 'city_idcity', 'state_idstate', 'country_idcountry','password'
    ];

    public $incrementing = false;




    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
         'remember_token',
    ];
}
