<?php

namespace App\Http\Controllers;

use App\Ride;
use App\RideUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;

class HomeController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $full_rides = Ride::all();

        // Если есть ещё места, то удаляется из коллекции
        $full_rides_array = $full_rides->reject(function($item, $key) {
            if ($item->seats > $item->count_users()) return true;
        });

        $rides = Ride::with(['owner', 'users'])
            ->where('start_at', '>=', now()->format('y-m-d'))
            ->whereNotIn('id', $full_rides_array->pluck('id'))
            ->limit(10);

        if (Input::get('search'))
            $rides->where('origin', 'LIKE', "%{$request->get('search')}%")
                ->orWhere('destination', 'LIKE', "%{$request->get('search')}%");

        if (Input::get('filter') === 'default' || Input::get('filter') === null)
            $rides->orderByDesc('created_at');
        elseif(Input::get('filter') === 'lower_price')
            $rides->orderBy('price');
        elseif(Input::get('filter') === 'high_price')
            $rides->orderByDesc('price');

        if (Auth::check()) {
            // Вытягиваются id всех поездок, к которым пользователь уже присоединился
            $ride_user = RideUsers::select('ride_id')->where('user_id', Auth::id())->get();
            $rides = $rides->where('user_id', '<>', Auth::id())->whereNotIn('id', $ride_user->pluck('ride_id'));
        }

        $rides = $rides->paginate(10);

        return view('index', [
            'rides' => $rides,
        ]);
    }
}
