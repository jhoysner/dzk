<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class State extends Model
{
  protected $table = 'state';

  protected $primaryKey = 'idstate';
  public $incrementing = false;

  protected $dates = ['deleted_at'];

  protected $fillable = [
      'idstate',
      'name',
      'country_idcountry'
  ];

  protected $hidden  = [
      'created_at', 'updated_at', 'deleted_at',
  ];

  public function commerces()
  {
    return $this->hasMany('App\commerce');
  }

  public function branchs()
  {
    return $this->hasMany('App\Branch');
  }
}
