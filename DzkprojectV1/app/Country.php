<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Country extends Model
{
  protected $table = 'country';

  protected $primaryKey = 'idcountry';
  public $incrementing = false;

  protected $dates = ['deleted_at'];

  protected $fillable = [
      'idcountry',
      'name',
      'isocode'
  ];

  protected $hidden  = [
      'created_at', 'updated_at', 'deleted_at',
  ];
}
