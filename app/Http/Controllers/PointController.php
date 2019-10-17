<?php

namespace App\Http\Controllers;

use App\Point;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PointController extends Controller
{
    public function index(Request $request) 
    {
        // パラメータが無ければそのままログインした日を取得する
        // あればそのパラメータにて行う

        $requestYmd = $request->input('Ymd');

        if (empty($requestYmd)) {
            $today = Carbon::today()->format('Y-m-d');
            $yesterday = Carbon::yesterday()->format('Y-m-d');
            $tomorrow = Carbon::tomorrow()->format('Y-m-d');

            $debug = 'true';
        } else {
            $requestDay = new Carbon($requestYmd);
            $today = $requestDay->format('Y-m-d');
            $yesterday = $requestDay->subDay()->format('Y-m-d');
            $tomorrow = $requestDay->addDay(2)->format('Y-m-d');

            $debug = 'false';
        }

        $user = Auth::user();

        /**
         * 的中の計算
         */
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
            'today' => $today,
            'tomorrow' => $tomorrow,
            'yesterday' => $yesterday,
            'user' => $user
        ]);
    }

    public function post(Request $request)
    {
        $user = Auth::user();
    
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

    // TODO: $points,$pointが重複しているためリファクタリング
    public function edit(Request $request,$id)
    {
        $point = new Point();

        $points = DB::table('points')
                        ->whereRaw("id = $id")
                        ->get();

        $point = Point::find($request->id);

        $userId = Auth::id();

        if ($point->user_id != $userId) {
            return redirect('/dashboard');
        } 

        return view('edit', [
            'point' => $point, 
            'points' => $points,
            'id' => $id,
        ]);
    }

    public function update(Request $request, Point $point)
    {
        $point->one   = $request->one;
        $point->two   = $request->two;
        $point->three = $request->three;
        $point->four  = $request->four;
        $point->memo  = $request->memo;

        $point->save();

        return redirect('/dashboard');
    }

    public function destroy(Point $point)
    {
        $point->delete();

        return redirect('/dashboard');
    }
}
