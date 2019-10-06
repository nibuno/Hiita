<?php

namespace App\Http\Controllers;

use App\Point;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PointController extends Controller
{
    public function index() 
    {
        $points = Point::orderBy('created_at', 'desc')->get();

        $user = Auth::user();
        
        return view('points', [
            'points' => $points,
            'user' => $user
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
    
        return redirect('/');
    }
}
