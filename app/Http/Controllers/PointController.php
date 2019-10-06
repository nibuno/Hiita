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
}
