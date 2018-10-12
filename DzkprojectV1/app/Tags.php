<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Tags extends Model
{
    use SoftDeletes;
    protected $dates = ['deleted_at'];

    protected $table = 'tags';
	protected $primaryKey = 'idtags';
	
	public $incrementing = false;

    protected $fillable = [
        'idtags',
        'name'
    ];

    protected $hidden  = [
        'created_at', 'updated_at', 'deleted_at',
    ];

    public function commerces()
    {
		return $this->belongsToMany('App\Commerce','commerce_has_tags')->withPivot('idcommerce_has_tags','commerce_idcommerce', 'tags_idtags')->whereNull('commerce_has_tags.deleted_at');
    }

    public function discounts()
    {
    	return $this->belongsToMany('App\Discount','discount_has_tags')->withPivot('iddiscount_has_tags','discount_iddiscount', 'tags_idtags')->whereNull('discount_has_tags.deleted_at');
    }
}
