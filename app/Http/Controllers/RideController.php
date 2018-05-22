<?php

namespace App\Http\Controllers;

use App\Ride;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RideController extends Controller
{
    public function add()
    {
        return view('modules.rides.add');
    }

    public function create(Request $request)
    {
        $ride = Ride::create([
            'user_id' => Auth::id(),
            'origin' => $request->origin,
            'destination' => $request->destination,
            'seats' => $request->seats,
            'price' => $request->price,
            'more' => $request->more,
            'start_at' => dateformat($request->start_at)
        ]);

        createMsg(1, 'Поездка успешно создана!');
        return redirect()->route('profile.index');
    }

    public function join($id)
    {
        $ride = Ride::find($id);
        $ride->users()->attach(Auth::id());
    }

    public function unjoin($id)
    {
        $ride = Ride::find($id);
        $ride->users()->detach(Auth::id());
    }
}
