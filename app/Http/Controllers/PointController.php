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
                        ->whereRaw("user_id = $user->id")
                        ->whereDate('created_at', '=', "$today")
                        ->whereDate('updated_at', '=', "$today")
                        ->get();

        $totalPointsOfOne = DB::table('points')
                                ->whereRaw("user_id = $user->id")
                                ->whereDate('created_at', '=', "$today")
                                ->whereDate('updated_at', '=', "$today")
                                ->sum('one');

        $totalPointsOfTwo = DB::table('points')
                                ->whereRaw("user_id = $user->id")
                                ->whereDate('created_at', '=', "$today")
                                ->whereDate('updated_at', '=', "$today")
                                ->sum('two');

        $totalPointsOfThree = DB::table('points')
                                ->whereRaw("user_id = $user->id")
                                ->whereDate('created_at', '=', "$today")
                                ->whereDate('updated_at', '=', "$today")
                                ->sum('three');
        
        $totalPointsOfFour = DB::table('points')
                                ->whereRaw("user_id = $user->id")
                                ->whereDate('created_at', '=', "$today")
                                ->whereDate('updated_at', '=', "$today")
                                ->sum('four');

        $todayTotalPoints = $totalPointsOfOne + $totalPointsOfTwo + $totalPointsOfThree + $totalPointsOfFour;

        $todayShootsNumbers = DB::table('points')
                                ->whereRaw("user_id = $user->id")
                                ->whereDate('created_at', '=', "$today")
                                ->whereDate('updated_at', '=', "$today")
                                ->count() * 4;

        // 練習していない場合 Division by zero Error が起こるので回避するため
        if ($todayShootsNumbers === 0) {
            $hitPointsPercentage = 0;
        } else {
            $hitPointsPercentage = round(($todayTotalPoints / $todayShootsNumbers) * 100, 2);
        }

        return view('points', [
            'points' => $points,
            'todayTotalPoints' => $todayTotalPoints,
            'todayShootsNumbers' => $todayShootsNumbers,
            'hitPointsPercentage' => $hitPointsPercentage,
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
    
        return redirect('/dashboard');
    }
}
