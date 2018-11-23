<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserContactChat extends Model
{
    
    protected $table = 'userscontactchat';

    protected $primaryKey = 'iduserscontactchat';
    public $incrementing = false;

    // protected $dates = ['deleted_at'];

    protected $fillable = [
      'iduserscontactchat',
      'users_id',
      'contactuser_id',
      'commerce_idcommerce',
    ];

    protected $hidden  = [
        'created_at', 'updated_at',
    ];

    public function user()
    {
      return $this->belongsTo('App\User', 'users_id', 'id');
    }

    public function contact()
    {
      return $this->belongsTo('App\User', 'contactuser_id', 'id');
    }
}
