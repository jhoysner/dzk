<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserHasDiscountStatus extends Model
{
    use SoftDeletes;
    
    protected $table = 'userhasdiscountstatus';

    protected $primaryKey = 'iduserhasdiscountstatus';
    public $incrementing = false;
    protected $dates = ['deleted_at'];

    protected $fillable = [
    	'iduserhasdiscountstatus',
    	'name',
    	'isfinal'
    ];

    protected $hidden  = [
        'created_at', 'updated_at', 'deleted_at',
    ];

    public function userHasDiscounts() {
    	return $this->hasMany('App\UserHasDiscount');
    }
}
