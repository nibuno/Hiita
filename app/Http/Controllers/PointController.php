<?php

namespace App\Http\Controllers;

use App\Point;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


class PointController extends Controller
{
    public function index() 
    {
        $today = date('Y-m-d');

        $user = Auth::user();

        $points = DB::table('points')
                        ->orderBy('created_at', 'asc')
                        // ->whereRaw("user_id = $user->id")
                        ->whereDate('created_at', '=', "$today")
                        ->whereDate('updated_at', '=', "$today")
                        ->get();

        $issyame = DB::table('points')
                        ->orderBy('created_at', 'desc')
                        // ->whereRaw("user_id = $user->id")
                        ->whereDate('created_at', '=', "$today")
                        ->whereDate('updated_at', '=', "$today")
                        ->sum('one');

                        $nissyame = DB::table('points')
                        ->orderBy('created_at', 'desc')
                        // ->whereRaw("user_id = $user->id")
                        ->whereDate('created_at', '=', "$today")
                        ->whereDate('updated_at', '=', "$today")
                        ->sum('two');

                        $sanssyame = DB::table('points')
                        ->orderBy('created_at', 'desc')
                        // ->whereRaw("user_id = $user->id")
                        ->whereDate('created_at', '=', "$today")
                        ->whereDate('updated_at', '=', "$today")
                        ->sum('three');

                        $yonssyame = DB::table('points')
                        ->orderBy('created_at', 'desc')
                        // ->whereRaw("user_id = $user->id")
                        ->whereDate('created_at', '=', "$today")
                        ->whereDate('updated_at', '=', "$today")
                        ->sum('four');

        $yakazu = DB::table('points')
                        ->orderBy('created_at', 'asc')
                        // ->whereRaw("user_id = $user->id")
                        ->whereDate('created_at', '=', "$today")
                        ->whereDate('updated_at', '=', "$today")
                        ->count() * 4;
        
        return view('points', [
            'points' => $points,
            'user' => $user,
            'issyame' => $issyame,
            'nissyame' => $nissyame,
            'sanssyame' => $sanssyame,
            'yonssyame' => $yonssyame,
            'yakazu' => $yakazu,
        ]);
    }

    public function post(Request $request)
    {
        $user = Auth::user();
        // $validator = $request->validate ([
        //     'memo' => 'max:255',
        // ]);
    
        // if ($validator->fails()) {
        //     return redirect('/')
        //         ->withInput()
        //         ->withErrors($validator);
        // }
    
        $point = new Point();
    
        $point->memo  = $request->memo;
        $point->one   = $request->one;
        $point->two   = $request->two;
        $point->three = $request->three;
        $point->four  = $request->four;

        $point->user_id = $user->id;
    
        $point->save();
    
        return redirect('/dashboard');
    }
}
