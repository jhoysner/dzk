<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CommerceTags extends Model
{
    use SoftDeletes;
    
    protected $table = 'commerce_has_tags';

    protected $primaryKey = 'idcommerce_has_tags';
    public $incrementing = false;
    protected $dates = ['deleted_at'];

    protected $fillable = [
        'idcommerce_has_tags',
        'commerce_idcommerce',
        'tags_idtags',
    ];

    protected $hidden  = [
        'created_at', 'updated_at', 'deleted_at',
    ];
}
