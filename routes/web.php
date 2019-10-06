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
 * 的中表示
 */

Route::get('/', 'PointController@index');

/**
 * 的中追加
 */
Route::post('/point', function (Request $request) {
    $validator = Validator::make($request->all(), [
        'memo' => 'max:255',
    ]);

    if ($validator->fails()) {
        return redirect('/')
            ->withInput()
            ->withErrors($validator);
    }

    $point = new Point();

    $point->memo  = $request->memo;
    $point->one   = $request->one;
    $point->two   = $request->two;
    $point->three = $request->three;
    $point->four  = $request->four;

    $point->save();

    return redirect('/');
});

/**
 * 的中編集
 */

/**
 * 的中削除
 */
Route::delete('point/{point}', function (Point $point) {
    //
});
Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
