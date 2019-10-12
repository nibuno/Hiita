<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

use App\Point;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 * TOPページ
 */
Route::get('/', 'LandingController@index');

/**
 * 的中表示
 */

Route::get('/dashboard', 'PointController@index')->middleware('auth');

/**
 * 的中追加
 */
Route::post('/point', 'PointController@post');

// Route::post('/point', function (Request $request) {

// });

/**
 * 的中編集
 */

/**
 * 的中削除　TODO: Controllerへの移行
 */
Route::delete('/point/{point}', function (Point $point) {
    $point->delete();

    return redirect('/dashboard');
});


Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
