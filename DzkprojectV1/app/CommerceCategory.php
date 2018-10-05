<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CommerceCategory extends Model
{
  protected $table = 'commercecategory';

  protected $primaryKey = 'idcommercecategory';
  public $incrementing = false;

  protected $dates = ['deleted_at'];

  protected $fillable = [
      'idcommercecategory',
      'name',
      'image',
      'icon'
  ];

  protected $hidden  = [
      'created_at', 'updated_at', 'deleted_at',
  ];

  public function commerces()
  {
    return $this->hasMany('App\commerce');
  }
}
