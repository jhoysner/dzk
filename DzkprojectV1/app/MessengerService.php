<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MessengerService extends Model
{
    
    protected $table = 'messengerservice';

    protected $primaryKey = 'idmessengerservice';
    public $incrementing = false;
    // protected $dates = ['deleted_at'];

    protected $fillable = [
        'idmessengerservice',
        'subject',
        'message',
        'thread',
        'users_id_from',
        'users_id_to',
        'commerce_idcommerce',
        'branch_idbranch',
        'messengerservicetopic_idmessengerservicetopic',
        'read_at',
    ];

    protected $hidden  = [
        // 'created_at', 
        // 'updated_at', 
        'deleted_at',
    ];

    public function from()
    {
      return $this->belongsTo('App\User', 'users_id_from', 'id');
    }    
    public function commerce()
    {
      return $this->belongsTo('App\Commerce', 'commerce_idcommerce', 'idcommerce');
    }

}
