<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MarketPlaceListing extends Model
{
    protected $table = 'marketplacelisting';

    protected $primaryKey = 'idmarketplacelisting';
    public $incrementing = false;

    protected $dates = ['deleted_at'];

    protected $fillable = [
        'idmarketplacelisting',
        'applicationdate',
        'processdate',
        'alignmentdate',
        'finaldate',
        'deliverdate',
        'observations',
        'feedback',
        'initprice',
        'inittaxe',
        'inittotalprice',
        'finaltaxes',
        'finalprice',
        'finaltotalprice',
        'user_id',
        'commerce_idcommerce',
        'branch_idbranch'
    ];

    protected $hidden  = [
        'created_at', 'updated_at', 'deleted_at',
    ];
}
