<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrderCheckouts extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'details',
        'store_id',
        'user_id',
        'table_no',
        'number',
        'total_price',
        'is_takeout',
        'is_finished',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'user_id'
    ];
}
