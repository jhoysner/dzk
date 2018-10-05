<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class City extends Model
{
  protected $table = 'city';

  protected $primaryKey = 'idcity';
  public $incrementing = false;

  protected $dates = ['deleted_at'];

  protected $fillable = [
      'idcity',
      'name',
      'country_idcountry',
      'state_idstate'
  ];

  protected $hidden  = [
      'created_at', 'updated_at', 'deleted_at',
  ];
}
