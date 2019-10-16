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
use App\Http\Controllers\PointController;

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
Route::post('/point', 'PointController@post')->middleware('auth');

/**
 * 的中編集画面
 */
// TODO: edit/{point} に修正してリファクタリング
Route::get('edit/{id}', 'PointController@edit')->middleware('auth');

/**
 * 的中更新
 */
Route::post('/update/{point}', 'PointController@update')->middleware('auth');

/**
 * 的中削除
 */
Route::delete('/point/{point}', 'PointController@destroy')->middleware('auth');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
