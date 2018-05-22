<?php

namespace App\Http\Controllers;

use App\Ride;
use App\RideUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function index()
    {
        $my_rides = Ride::with(['users'])->where('user_id', Auth::id())->orderByDesc('id')->get();
        $associate_rides = RideUsers::with(['ride', 'ride.owner'])->orderByDesc('created_at')->where('user_id', Auth::id())->paginate(2);

        return view('manage', [
            'my_rides' => $my_rides,
            'associate_rides' => $associate_rides
        ]);
    }
}
