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

use App\Task;
use Illuminate\Http\Request;

/**
 * 的中表示
 */

Route::get('/', function () {
    return view('points');
});

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