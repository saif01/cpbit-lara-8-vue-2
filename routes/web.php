<?php

use Illuminate\Support\Facades\Route;

// Auth
Route::namespace('App\Http\Controllers\Auth')->group(function(){

    // Route::get('/login', 'IndexController@login')->name('login');
    Route::post('/login_action', 'LoginController@login_action');
    Route::get('/logout', 'LoginController@logout');

    Route::post('/register_check', 'RegisterController@check');
    Route::post('/register_store', 'RegisterController@store');

    Route::get('/test', 'ADLogin@Data'); 
    Route::get('login/{any?}', 'IndexController@index')->name('login');
    Route::get('register/{any?}', 'IndexController@index')->name('register');

});


// // Login
// Route::namespace('App\Http\Controllers\Login')->group(function(){

//     Route::get('/login', 'IndexController@login')->name('login');
//     Route::post('/login_action', 'IndexController@login_action');
//     Route::get('/logout', 'IndexController@logout');

//     Route::get('/test', 'ADLogin@Data'); 
//     Route::get('login/{any?}', 'IndexController@login')->name('login');
//     Route::get('register/{any?}', 'IndexController@login')->name('login');

// });

// Register
// Route::namespace('App\Http\Controllers\Register')->prefix('register')->group(function(){

//     Route::get('/', 'IndexController@index')->name('register');
//     Route::post('/check', 'IndexController@check');
//     Route::post('/store', 'IndexController@store');

// });

// Auth Route Start
Route::middleware('auth')->namespace('App\Http\Controllers')->group(function(){

    // SuperAdmin Start
    Route::middleware(['can:superadmin'])->namespace('SuperAdmin')->prefix('super_admin')->group(function(){

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
            
            Route::get('/zoneoffices', 'IndexController@zoneoffices');
            Route::get('/departments', 'IndexController@departments');

        });

        // Register Management
        Route::namespace('Register')->prefix('register')->group(function(){
            Route::get('/index', 'IndexController@index');
            Route::post('/store', 'IndexController@store');

            Route::get('/users_data', 'IndexController@users_data');

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

        // Zone Management
        Route::namespace('Zone')->prefix('zone')->group(function(){
            Route::get('/index', 'IndexController@index');
            Route::post('/store', 'IndexController@store');
            Route::put('/update/{id}', 'IndexController@update');
            Route::delete('/destroy_temp/{id}', 'IndexController@destroy_temp');
            Route::delete('/destroy/{id}', 'IndexController@destroy');
            Route::post('/status/{id}', 'IndexController@status');

            // Zone offices
            Route::prefix('offices')->group(function(){
                Route::get('/index', 'OfficesController@index');
                Route::post('/store', 'OfficesController@store');
                Route::put('/update/{id}', 'OfficesController@update');
                Route::delete('/destroy_temp/{id}', 'OfficesController@destroy_temp');
                Route::delete('/destroy/{id}', 'OfficesController@destroy');
                Route::post('/status/{id}', 'OfficesController@status');

                Route::get('/allzones', 'OfficesController@allzones');
                Route::get('/alloffices', 'OfficesController@alloffices');
            });
        });

        

        Route::get('{any?}', 'IndexController@index')->name('super.admin.dashboard');
    });
    // SuperAdmin End


    // Room Start
    Route::namespace('Room')->prefix('room')->group(function(){

        // Admin
        Route::middleware(['can:roomAdmin'])->namespace('Admin')->prefix('admin')->group(function(){

            //Room 
            Route::namespace('Room')->prefix('room')->group(function(){
                Route::get('/index', 'IndexController@index');
                Route::post('/store', 'IndexController@store');
                Route::put('/update/{id}', 'IndexController@update');
                Route::delete('/destroy_temp/{id}', 'IndexController@destroy_temp');
                Route::delete('/destroy/{id}', 'IndexController@destroy');
                Route::post('/status/{id}', 'IndexController@status');
            });

            //Report 
            Route::namespace('Report')->prefix('report')->group(function(){
                Route::get('/index', 'IndexController@index');
                Route::post('/store', 'IndexController@store');
                Route::put('/update/{id}', 'IndexController@update');
                Route::delete('/destroy_temp/{id}', 'IndexController@destroy_temp');
                Route::delete('/destroy/{id}', 'IndexController@destroy');
                Route::post('/status/{id}', 'IndexController@status');
            });


            Route::get('{any?}', 'IndexController@index');
        });

        // User
        Route::middleware(['can:room'])->namespace('User')->group(function(){

            Route::prefix('booking')->group(function(){
                Route::get('/data', 'BookingController@data');
                Route::post('/room', 'BookingController@room');
                Route::post('/store', 'BookingController@store');
            });

            Route::prefix('booked')->group(function(){
                Route::get('/data', 'BookedController@data');
                Route::get('/canceled', 'BookedController@canceled');
                Route::post('/byroom', 'BookedController@byroom');
                Route::post('/store', 'BookedController@store');
                Route::post('/status/{id}', 'BookedController@status');
            });


            Route::get('{any?}', 'IndexController@index');
        });



        
        
    });
    // Room End


    
    //Route::get('/', 'IndexController@index')->middleware('auth');
    Route::namespace('Dashboard')->group(function(){

        Route::get('{any?}', 'IndexController@index')->name('dashboard');
    });
    

});



