<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DiscountCategory extends Model
{
    use SoftDeletes;

    protected $table = 'discountcategory';

    protected $primaryKey = 'iddiscountcategory';
    public $incrementing = false;

    protected $dates = ['deleted_at'];

    protected $fillable = [
        'iddiscountcategory',
        'name',
        'image',
        'icon',
  
      ];

    protected $hidden  = [
        'created_at', 'updated_at', 'deleted_at',
    ];
}
