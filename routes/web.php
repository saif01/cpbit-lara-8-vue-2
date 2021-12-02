<?php

use Illuminate\Support\Facades\Route;

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

// Login
Route::namespace('App\Http\Controllers\Login')->group(function(){

    Route::get('/login', 'IndexController@login')->name('login');
    Route::post('/login_action', 'IndexController@login_action');
    Route::get('/logout', 'IndexController@logout');

    Route::get('/test', 'ADLogin@Data');

});


Route::middleware('auth')->namespace('App\Http\Controllers')->group(function(){

    //Route::get('/', 'IndexController@index')->middleware('auth');
    Route::namespace('Dashboard')->group(function(){

        Route::get('{any?}', 'IndexController@index')->name('dashboard');
    });
    

});



