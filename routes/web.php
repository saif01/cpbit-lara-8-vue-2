<?php

use Illuminate\Support\Facades\Route;


// Login
Route::namespace('App\Http\Controllers\Login')->group(function(){

    Route::get('/login', 'IndexController@login')->name('login');
    Route::post('/login_action', 'IndexController@login_action');
    Route::get('/logout', 'IndexController@logout');

    Route::get('/test', 'ADLogin@Data'); 

});

// Register
Route::namespace('App\Http\Controllers\Register')->prefix('register')->group(function(){

    Route::get('/', 'IndexController@index')->name('register');
    Route::post('/check', 'IndexController@check');
    Route::post('/store', 'IndexController@store');

});

// Auth Route Start
Route::middleware('auth')->namespace('App\Http\Controllers')->group(function(){


    Route::namespace('SuperAdmin')->prefix('super_admin')->group(function(){

        // User Management
        Route::namespace('User')->prefix('user')->group(function(){
            Route::get('/index', 'IndexController@index');
            Route::post('/store', 'IndexController@store');
            Route::put('/update/{id}', 'IndexController@update');
            Route::delete('/destroy/{id}', 'IndexController@destroy');
            Route::post('/status/{id}', 'IndexController@status');

            Route::post('/status_admin/{id}', 'IndexController@status_admin');
            Route::post('/status_user/{id}', 'IndexController@status_user');

            Route::get('/roles_data', 'IndexController@roles_data');
            Route::post('/roles_update', 'IndexController@roles_update');    
        });

        // Role Management
        Route::namespace('Role')->prefix('role')->group(function(){
            Route::get('/index', 'IndexController@index');
            Route::post('/store', 'IndexController@store');
            Route::put('/update/{id}', 'IndexController@update');
            Route::delete('/destroy_temp/{id}', 'IndexController@destroy_temp');
            Route::delete('/destroy/{id}', 'IndexController@destroy');
            Route::post('/status/{id}', 'IndexController@status');
        });

        Route::get('{any?}', 'IndexController@index')->name('super.admin.dashboard');
    });




    
    //Route::get('/', 'IndexController@index')->middleware('auth');
    Route::namespace('Dashboard')->group(function(){

        Route::get('{any?}', 'IndexController@index')->name('dashboard');
    });
    

});



