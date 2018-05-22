<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Ride extends Model
{
    protected $fillable = [
        'user_id',
        'origin',
        'destination',
        'seats',
        'price',
        'more',
        'start_at'
    ];

    public function users()
    {
        return $this->belongsToMany('App\User', 'ride_users');
    }

    public function owner()
    {
        return $this->belongsTo('App\User', 'user_id');
    }

    public function ride_users()
    {
        return $this->hasMany('App\RideUsers');
    }

    public function count_users()
    {
        return $this->hasMany('App\RideUsers')->count();
    }

    public function associate_rides()
    {
        return $this->hasMany('App\RideUsers');
    }
}
