<?php

namespace App;

use Laravel\Passport\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasApiTokens,Notifiable,HasRoles;

    //softdeletes
    use SoftDeletes;
    protected $dates = ['deleted_at'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    public $incrementing = false;
    
    protected $primarykey = 'id';
    protected $fillable = [
        'id','firstname', 'middlename', 'lastname', 'birthday', 'phone', 'image', 'email', 'password', 
        'address', 'latitude', 'longitude', 'provider', 'provider_id', 'access_token', 'lastlogin', 
        'attemps', 'status', 'city_idcity', 'state_idstate', 'country_idcountry'
    ];


    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
         'remember_token','password'
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

    //Helpers
        /**
     * Get existing or make new access token
     */
    public function makeApiToken()
    {
        return $this->createToken('API')->accessToken;
    }

    /**
     * Get token
     *
     * @return bool
     */
    public function getToken()
    {
        return $this->token();
    }



}
