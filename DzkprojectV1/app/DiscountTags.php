<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DiscountTags extends Model
{
    use SoftDeletes;
    
    protected $table = 'discount_has_tags';

    protected $primaryKey = 'iddiscount_has_tags';
    public $incrementing = false;
    protected $dates = ['deleted_at'];

    protected $fillable = [
        'iddiscount_has_tags',
        'discount_iddiscount',
        'tags_idtags',
    ];

    protected $hidden  = [
        'created_at', 'updated_at', 'deleted_at',
    ];
}
