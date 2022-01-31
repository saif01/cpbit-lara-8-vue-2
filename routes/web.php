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




// Auth Route Start
Route::middleware('auth')->namespace('App\Http\Controllers')->group(function(){

    // // Demo Start
    // Route::namespace('Room')->prefix('room')->group(function(){

    //     // Admin
    //     Route::middleware(['can:roomAdmin'])->namespace('Admin')->prefix('admin')->group(function(){

    //         //Room 
    //         Route::namespace('Room')->prefix('room')->group(function(){
    //             Route::get('/index', 'IndexController@index');
    //             Route::post('/store', 'IndexController@store');
    //             Route::put('/update/{id}', 'IndexController@update');
    //             Route::delete('/destroy_temp/{id}', 'IndexController@destroy_temp');
    //             Route::delete('/destroy/{id}', 'IndexController@destroy');
    //             Route::post('/status/{id}', 'IndexController@status');
    //         });

           
    //         Route::get('{any?}', 'IndexController@index');
    //     });

    //     // User
    //     Route::middleware(['can:room'])->namespace('User')->group(function(){


    //         Route::get('{any?}', 'IndexController@index');
    //     });
    // });
    // // Demo End

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


    //CarPool
    Route::namespace('Carpool')->prefix('carpool')->group(function(){

        // Admin
        Route::middleware(['can:carAdmin'])->namespace('Admin')->prefix('admin')->group(function(){

            //Car
            Route::namespace('Car')->prefix('car')->group(function(){
                Route::get('/index', 'IndexController@index');
                Route::post('/store', 'IndexController@store');
                Route::put('/update/{id}', 'IndexController@update');

                // delete
                Route::get('/delete/{id}', 'IndexController@delete');
                Route::delete('/destroy_temp/{id}', 'IndexController@destroyTemp');
                
                // status
                Route::post('/status/{id}', 'IndexController@status');
                // temporary
                Route::post('/temporary/{id}', 'IndexController@temporary');
                // deadline
                Route::post('/deadline-store', 'IndexController@deadlineStore');
                Route::get('/deadline-clear/{id}', 'IndexController@deadlineClear');
                
            });

            //Driver
            Route::namespace('Driver')->prefix('driver')->group(function(){
                Route::get('/index', 'IndexController@index');
                Route::post('/store', 'IndexController@store');
                Route::put('/update/{id}', 'IndexController@update');
                Route::delete('/destroy_temp/{id}', 'IndexController@destroyTemp');
                // status
                Route::post('/status/{id}', 'IndexController@status');

                 // car data
                Route::get('/car-data', 'IndexController@CarData');

            });

            //Destination
            Route::namespace('Destination')->prefix('destination')->group(function(){
                Route::get('/index', 'IndexController@index');
                Route::post('/store', 'IndexController@store');
                Route::put('/update/{id}', 'IndexController@update');
                Route::delete('/destroy/{id}', 'IndexController@destroy');
            });

            //Reports
            Route::namespace('Report')->prefix('report')->group(function(){
                Route::get('/index', 'IndexController@index');

                Route::get('/driver-leave', 'IndexController@DriverLeave');
                Route::get('/car-maintenance', 'IndexController@CarMaintenance');
                Route::get('/car-requisition', 'IndexController@CarRequisition');
                Route::get('/car-driver/{id}', 'IndexController@CarDriver');
                Route::get('/bookby-user/{id}', 'IndexController@bookbyUser');


                // car data
                Route::get('/car-data', 'IndexController@CarData');
                
                

            });


            Route::get('{any?}', 'IndexController@index');

        });


        // User
        Route::middleware(['can:room'])->namespace('User')->group(function(){

            Route::prefix('booking')->group(function(){
                Route::get('/data', 'BookingController@data');
                Route::post('/car', 'BookingController@car');
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
    //End CarPool


    // SMS Start
    Route::namespace('SMS')->prefix('sms')->group(function(){

        // Admin
        Route::middleware(['can:roomAdmin'])->namespace('Admin')->prefix('admin')->group(function(){

            // User Management
            Route::namespace('User')->prefix('user')->group(function(){
                Route::get('/index', 'IndexController@index');
            
                Route::post('/status_admin/{id}', 'IndexController@status_admin');
                Route::post('/status_user/{id}', 'IndexController@status_user');

                Route::get('/roles_data', 'IndexController@roles_data');
                Route::post('/roles_update', 'IndexController@roles_update');  
                
                Route::get('/departments', 'IndexController@departments');
                Route::get('/zoneoffices', 'IndexController@zoneoffices');

            });

            //Operation 
            Route::namespace('Operation')->prefix('operation')->group(function(){
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


            Route::get('{any?}', 'IndexController@index');
        });
    });
    // SMS End












    
    //Route::get('/', 'IndexController@index')->middleware('auth');
    Route::namespace('Dashboard')->group(function(){

        Route::get('{any?}', 'IndexController@index')->name('dashboard');
    });
    

});



