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


    public function countries()
    {
      return $this->belongsTo('App\Country', 'country_idcountry', 'idcountry');
    }

    public function states()
    {
      return $this->belongsTo('App\State', 'state_idstate', 'idstate');
    }

    public function cities()
    {
      return $this->belongsTo('App\City', 'city_idcity', 'idcity');
    }

    public function  discounts(){
        return $this->belongsToMany('App\Discount','users_has_discount','users_id')->withPivot('idusers_has_discount','charcode', 'qrcode','validfrom','validto','userhasdiscountstatus_iduserhasdiscountstatus' )->whereNull('users_has_discount.deleted_at');
    }
}
