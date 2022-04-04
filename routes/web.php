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


        Route::get('/dashboard_data', 'IndexController@dashboard_data');

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
            
            Route::get('/zoneoffices', 'IndexController@zoneoffices')->withoutMiddleware(['can:superadmin']);
            Route::get('/departments', 'IndexController@departments')->withoutMiddleware(['can:superadmin']);

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
                Route::get('/free_car_data', 'IndexController@free_car_data');

                // driver leave
                Route::post('/store_leave', 'IndexController@store_leave');
                Route::post('/leave_status/{id}', 'IndexController@leave_status');

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

                // export_data
                Route::get('/export_data_all', 'IndexController@export_data_all');
                Route::get('/export_data_req', 'IndexController@export_data_req');
                Route::get('/export_data_maint', 'IndexController@export_data_maint');
                Route::get('/export_data_leave', 'IndexController@export_data_leave');
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

            // booked
            Route::prefix('booked')->group(function(){
                Route::get('/data', 'BookedController@data');
                Route::get('/destinations', 'BookedController@destinations');
                Route::get('/canceled', 'BookedController@canceled');
                Route::post('/bycar', 'BookedController@bycar');
                Route::post('/store', 'BookedController@store');
                Route::post('/status/{id}', 'BookedController@status');
            });

            // comment
            Route::prefix('comment')->group(function(){
                Route::get('/index', 'CommentController@index');
                Route::put('/update_comment', 'CommentController@update_comment');
                Route::get('/prev_comment/{id}', 'CommentController@PrevComment');
                Route::get('/car-data/{car_id}', 'CommentController@carData');
                Route::get('/comment_count', 'CommentController@comment_count');
            });

            //History
            Route::prefix('history')->group(function(){
                Route::get('/index', 'HistoryController@index');
                // car data
                Route::get('/car-data', 'HistoryController@CarData');
            });


            Route::get('{any?}', 'IndexController@index');
        });



    });
    //End CarPool


    // SMS Start
    Route::namespace('SMS')->prefix('sms')->group(function(){

        // Admin
        Route::middleware(['can:SMSAdmin'])->namespace('Admin')->prefix('admin')->group(function(){

            Route::get('/dashboard_data', 'IndexController@dashboard_data');

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
        Route::middleware(['can:SMS'])->namespace('User')->group(function(){

            Route::get('/operations', 'IndexController@operations');
            Route::get('/report_download', 'IndexController@report_download');

            Route::get('/test', 'IndexController@test');

            Route::get('{any?}', 'IndexController@index');
        });
    });
    // SMS End



    // CMS Start
    Route::namespace('CMS')->prefix('cms')->group(function(){

        // Application Admin
        Route::middleware(['can:appAdmin'])->namespace('ApplicationAdmin')->prefix('a_admin')->group(function(){

            Route::get('/dashboard_data', 'IndexController@dashboard_data');

            //Category 
            Route::namespace('Category')->prefix('category')->group(function(){
                Route::get('/index', 'IndexController@index');
                Route::post('/store', 'IndexController@store');
                Route::put('/update/{id}', 'IndexController@update');
                Route::delete('/destroy/{id}', 'IndexController@destroy');
            });

            //Subcategory 
            Route::namespace('Subcategory')->prefix('subcategory')->group(function(){
                Route::get('/index', 'IndexController@index');
                Route::post('/store', 'IndexController@store');
                Route::put('/update/{id}', 'IndexController@update');
                Route::delete('/destroy/{id}', 'IndexController@destroy');

                Route::get('/category', 'IndexController@category');
            });

            //Complain 
            Route::namespace('Complain')->prefix('complain')->group(function(){
                Route::get('/not_process', 'ComplainController@not_process');
                Route::get('/processing', 'ComplainController@processing');
                Route::get('/closed', 'ComplainController@closed');

                Route::get('/action/{id}', 'ActionController@action');
                Route::post('/action_remarks', 'ActionController@action_remarks');
            });

            //Reports 
            Route::namespace('Reports')->prefix('reports')->group(function(){
                Route::get('/index', 'IndexController@index');
                Route::get('/canceled', 'IndexController@canceled');
                Route::get('/export_data', 'IndexController@export_data');
                Route::get('/export_data_cancel', 'IndexController@export_data_cancel');
            });
        
            Route::get('{any?}', 'IndexController@index');
        });



        //Hardware Admin 
        Route::middleware(['can:hardAdmin'])->namespace('HardwareAdmin')->prefix('h_admin')->group(function(){

            Route::get('/zone_access', 'Complain\ComplainController@zone_access');

            // index
            Route::prefix('count')->group(function(){
                Route::get('/sidebar_count_data', 'IndexController@sidebar_count_data');
            });
            

            // Others
            Route::namespace('Others')->group(function(){

                //Category 
                Route::namespace('Category')->prefix('category')->group(function(){
                    Route::get('/index', 'IndexController@index');
                    Route::post('/store', 'IndexController@store');
                    Route::put('/update/{id}', 'IndexController@update');
                    Route::delete('/destroy/{id}', 'IndexController@destroy');

                    Route::get('/acsosoris', 'IndexController@acsosoris');
                });

                //Subcategory 
                Route::namespace('Subcategory')->prefix('subcategory')->group(function(){
                    Route::get('/index', 'IndexController@index');
                    Route::post('/store', 'IndexController@store');
                    Route::put('/update/{id}', 'IndexController@update');
                    Route::delete('/destroy/{id}', 'IndexController@destroy');

                    Route::get('/category', 'IndexController@category');
                });

                //Acsosoris 
                Route::namespace('Acsosoris')->prefix('acsosoris')->group(function(){
                    Route::get('/index', 'IndexController@index');
                    Route::post('/store', 'IndexController@store');
                    Route::put('/update/{id}', 'IndexController@update');
                    Route::delete('/destroy/{id}', 'IndexController@destroy');
                });

            });

            // User
            Route::namespace('User')->prefix('user')->group(function(){
                Route::get('/index', 'IndexController@index');
                Route::post('/roles_update', 'IndexController@roles_update');
            
                Route::get('/zone_data', 'IndexController@zone_data');

                //Draft 
                Route::prefix('role')->group(function(){
                    Route::get('/index', 'RoleController@index');
                    Route::post('/store', 'RoleController@store');
                    Route::put('/update/{id}', 'RoleController@update');
                    Route::delete('/destroy/{id}', 'RoleController@destroy');
                    Route::post('/status/{id}', 'RoleController@status');
                    Route::get('/all_data', 'RoleController@all_data');
                });
            });

            // Complain 
            Route::namespace('Complain')->prefix('complain')->group(function(){
                Route::get('/not_process', 'ComplainController@not_process');
                Route::get('/processing', 'ComplainController@processing');
                Route::get('/closed', 'ComplainController@closed');
                Route::get('/deliverable', 'ComplainController@deliverable');
                Route::get('/service', 'ComplainController@service');

                // Damaged
                Route::prefix('damaged')->group(function(){

                    Route::get('/all', 'DamagedController@all');
                    Route::get('/applicable', 'DamagedController@applicable');
                    Route::get('/applicable_partial', 'DamagedController@applicable_partial');
                    Route::get('/not_applicable', 'DamagedController@not_applicable');
                    Route::get('/not_applicable_partial', 'DamagedController@not_applicable_partial');

                    Route::get('/remaining_stock', 'DamagedController@remaining_stock');
                    Route::get('/inv_operations', 'DamagedController@inv_operations');

                });
            

                // HO Controller
                Route::prefix('ho_service')->group(function(){
                    Route::get('/index', 'HoController@index');
                    Route::get('/zone_data', 'HoController@zone_data');
                    // action_remarks
                    Route::post('/action_remarks', 'HoController@action_remarks');
                    Route::get('/action_remarks_data/{id}', 'HoController@action_remarks_data');
                });
                
                

                // Complain modify
                Route::get('/category', 'ModifyController@category');
                Route::post('/category_modify', 'ModifyController@category_modify');

                Route::get('/action/{id}', 'ActionController@action');
                Route::post('/action_remarks', 'ActionController@action_remarks');
                Route::post('/action_damaged', 'ActionController@action_damaged');
                Route::post('/action_quotation', 'ActionController@action_quotation');
                Route::post('/action_delivery', 'ActionController@action_delivery');

                // Send mail
                Route::get('/send_rem_email', 'IndexController@send_rem_email');
                Route::get('/get_user_zone', 'IndexController@get_user_zone');
            });

            //Draft 
            Route::namespace('Draft')->prefix('draft')->group(function(){
                Route::get('/index', 'IndexController@index');
                Route::post('/store', 'IndexController@store');
                Route::put('/update/{id}', 'IndexController@update');
                Route::delete('/destroy/{id}', 'IndexController@destroy');
                Route::post('/status/{id}', 'IndexController@status');
                Route::get('/all_data', 'IndexController@all_data');
            });

            // Reports
            Route::namespace('Reports')->prefix('reports')->group(function(){
                Route::get('/index', 'IndexController@index');
                Route::get('/damaged', 'IndexController@damaged');
                Route::get('/damaged_replace', 'IndexController@damaged_replace');
                
                // report
                Route::get('/export_data', 'IndexController@export_data');
                Route::get('/export_data_damage', 'IndexController@export_data_damage');
                Route::get('/export_data_damagereplace', 'IndexController@export_data_damagereplace');
                
            
            });

            
            Route::get('{any?}', 'IndexController@index');
        });
        // End Admin




        // User
        Route::middleware(['can:cms'])->namespace('User')->group(function(){

            //Application 
            Route::prefix('app')->group(function(){
            
                Route::post('/complain', 'ApplicationController@complain');
                Route::get('/category', 'ApplicationController@category');
                Route::get('/history', 'ApplicationController@history');
                
            });

            //Hardware 
            Route::prefix('hard')->group(function(){
            
                Route::post('/complain', 'HardwareController@complain');
                Route::get('/category', 'HardwareController@category');
                Route::get('/history', 'HardwareController@history');
                Route::get('/damage_apply', 'HardwareController@damage_apply');

            });


            Route::get('{any?}', 'IndexController@index');
        });
    });
    // CMS End



    // Inventory Start
    Route::namespace('Inventory')->prefix('inventory')->group(function(){

        // Admin
        Route::middleware(['can:inventory'])->namespace('Admin')->prefix('admin')->group(function(){

            Route::get('/dashboard_data', 'IndexController@dashboard_data');

            Route::get('/category', 'IndexController@category');

            // NewProduct Management
            Route::namespace('NewProduct')->prefix('new_product')->group(function(){
                Route::get('/index', 'IndexController@index');
                Route::post('/store', 'IndexController@store');
                Route::post('/update', 'IndexController@update');
                Route::delete('/destroy_temp', 'IndexController@destroy_temp');

                Route::post('/damage_status/{id}', 'IndexController@damage_status');
                

                // office
                Route::get('/office', 'IndexController@office');
                // deliver
                Route::post('/deliver', 'IndexController@deliver');

            });


            // OldProduct Management
            Route::namespace('OldProduct')->prefix('old_product')->group(function(){
                Route::get('/index', 'IndexController@index');
                Route::post('/store', 'IndexController@store');
                Route::put('/update', 'IndexController@update');
                Route::delete('/destroy_temp', 'IndexController@destroy_temp');

                // office
                Route::get('/office', 'IndexController@office');
                Route::get('/business_unit', 'IndexController@businessUnit');
                
            });

            //Operation 
            Route::namespace('Operation')->prefix('operation')->group(function(){
                Route::get('/index', 'IndexController@index');
                Route::post('/store', 'IndexController@store');
                Route::put('/update', 'IndexController@update');
                Route::delete('/destroy', 'IndexController@destroy');
            });


            //product section 
            Route::namespace('Productsection')->prefix('product')->group(function(){

                Route::prefix('given-product')->group(function(){
                    Route::get('/index', 'IndexController@given_product');

                    Route::get('/export_data', 'IndexController@export_data_given');                    
                });

                Route::prefix('running-product')->group(function(){
                    Route::get('/index', 'IndexController@running_product');

                    Route::get('/export_data', 'IndexController@export_data_running');                    
                });

                Route::prefix('damaged-product')->group(function(){
                    Route::get('/index', 'IndexController@damaged_product');

                    Route::get('/export_data', 'IndexController@export_data_damage');
                });
            });

            //Warranty section 
            Route::namespace('Warrantysection')->prefix('w-product')->group(function(){

                Route::prefix('warranty-product')->group(function(){
                    Route::get('/index', 'IndexController@warranty_product');

                    Route::get('/export_data', 'IndexController@export_data_warranty');
                });

                Route::prefix('expire-product')->group(function(){
                    Route::get('/index', 'IndexController@expire_product');

                    Route::get('/export_data', 'IndexController@export_data_expire');
                });
            });

            //Report section 
            Route::namespace('Reportsection')->prefix('report')->group(function(){
               
                Route::prefix('stock')->group(function(){
                    Route::get('/', 'StockController@index');
                    Route::get('/export_data', 'StockController@export_data');
                    Route::get('/export_view', 'StockController@export_view');
                });

            });

            //Deleted section 
            Route::namespace('Deletedsection')->prefix('delete')->group(function(){
                Route::prefix('new-product')->group(function(){
                    Route::get('/index', 'IndexController@new_product');    
                    Route::delete('/destroy', 'IndexController@destroy');
                    Route::put('/restore', 'IndexController@restore');
                });
                Route::prefix('old-product')->group(function(){
                    Route::get('/index', 'IndexController@old_product');
                    Route::delete('/destroy', 'IndexController@destroy');
                    Route::put('/restore', 'IndexController@restore');
                });
            });

           
            Route::get('{any?}', 'IndexController@index');
        });

        
    });
    // Inventory End




    // PBI Start
    Route::namespace('PBI')->prefix('pbi')->group(function(){

        // Admin
        Route::middleware(['can:powerbiAdmin'])->namespace('Admin')->prefix('admin')->group(function(){

            // User
            Route::namespace('User')->prefix('user')->group(function(){
                Route::get('/index', 'IndexController@index');
                Route::post('/roles_update', 'IndexController@roles_update');
             
                Route::get('/zone_data', 'IndexController@zone_data');

                //Draft 
                Route::prefix('role')->group(function(){
                    Route::get('/index', 'RoleController@index');
                    Route::post('/store', 'RoleController@store');
                    Route::put('/update/{id}', 'RoleController@update');
                    Route::delete('/destroy/{id}', 'RoleController@destroy');
                    Route::post('/status/{id}', 'RoleController@status');
                    Route::get('/all_data', 'RoleController@all_data');
                });
            });

            // API
            Route::namespace('API')->prefix('api')->group(function(){
                Route::post('/action', 'IndexController@action');
            });

           
            Route::get('{any?}', 'IndexController@index');
        });

        // User
        Route::middleware(['can:powerbi'])->namespace('User')->group(function(){

            Route::post('/report', 'ReportController@report');

            Route::get('{any?}', 'IndexController@index');
        });
    });
    // PBI End


    //iVCA 
    Route::namespace('iVCA')->prefix('ivca')->group(function(){

        // Admin
        Route::middleware(['can:ivcaAdminSection'])->namespace('Admin')->prefix('admin')->group(function(){

            Route::get('/dashboard_data', 'IndexController@dashboard_data');
            Route::get('/inactive_list', 'IndexController@inactive_list');


            // User Managment
            Route::namespace('User')->prefix('user')->group( function(){
                // User
                Route::prefix('list')->group( function(){
                    Route::get('/index', 'ListController@index');

                    Route::post('/roles_update', 'ListController@roles_update');
                    Route::get('/roles_data', 'ListController@roles_data');
                });
                // Role
                Route::prefix('role')->group( function(){
                    Route::get('/index', 'RoleController@index');
                    Route::post('/store', 'RoleController@store');
                    Route::put('/update/{id}', 'RoleController@update');
                    Route::delete('/destroy/{id}', 'RoleController@destroy');
                    Route::post('/status/{id}', 'RoleController@status');
                });

            });
            

            // Vendor
            Route::namespace('Vendor')->prefix('vendor')->group( function(){
                // List
                Route::prefix('list')->group( function(){
                    Route::get('/index', 'ListController@index');
                    Route::post('/store', 'ListController@store');
                    Route::put('/update/{id}', 'ListController@update');
                    Route::delete('/destroy/{id}', 'ListController@destroy');
                    Route::post('/status/{id}', 'ListController@status');
                });
                // black_list
                Route::prefix('black_list')->group( function(){
                    Route::get('/index', 'BlackListController@index');
                
                    Route::get('/vendor_list', 'BlackListController@vendor_list');
                    Route::post('/vendor_list_blacklist', 'BlackListController@vendor_list_blacklist');
                    Route::post('/vendor_list_status', 'BlackListController@vendor_list_status');
                });

            });


            // Tempalte
            Route::namespace('Tempalte')->prefix('tempalte')->group( function(){
                Route::get('/mro_manufacturer_data', 'MroManufacturerController@data');
                Route::post('/mro_manufacturer_store', 'MroManufacturerController@store');

                Route::get('/mro_importer_data', 'MroImporterController@data');
                Route::post('/mro_importer_store', 'MroImporterController@store');

                Route::get('/mro_retailer_data', 'MroRetailerController@data');
                Route::post('/mro_retailer_store', 'MroRetailerController@store');

                Route::get('/food_data', 'FoodController@data');
                Route::post('/food_store', 'FoodController@store');

            });


            // Schedule
            Route::namespace('Schedule')->prefix('schedule')->group( function(){

                Route::prefix('mro')->group( function(){
                    Route::get('/index', 'MroController@index');
                    Route::post('/store', 'MroController@store');
                    Route::put('/update/{id}', 'MroController@update');
                    //Route::delete('/destroy/{id}', 'MroController@destroy');
                    Route::post('/status/{id}', 'MroController@status');

                    Route::get('vendor_list', 'MroController@vendor_list');
                    Route::get('user_list', 'MroController@user_list');
                });

                Route::prefix('food')->group( function(){
                    Route::get('/index', 'FoodController@index');
                    Route::post('/store', 'FoodController@store');
                    Route::put('/update/{id}', 'FoodController@update');
                    //Route::delete('/destroy/{id}', 'FoodController@destroy');
                    Route::post('/status/{id}', 'FoodController@status');

                    Route::get('vendor_list', 'FoodController@vendor_list');
                    Route::get('user_list', 'FoodController@user_list');
                });

            

                
            });

        
            // Reports
            Route::namespace('Reports')->prefix('reports')->group(function(){
                // manufacturer
                Route::prefix('manufacturer')->group(function(){
                    Route::get('/index', 'ManufacturerController@index');
                    Route::get('/single_audit_data/{id}', 'ManufacturerController@single_audit_data');
                    Route::post('/summary_audit_data', 'ManufacturerController@summary_audit_data');

                    // manufacturer PDF
                    Route::prefix('pdf')->group(function(){
                        Route::get('/view_summary/{token}', 'ManufacturerController@view_summary');
                        Route::get('/download_summary/{token}', 'ManufacturerController@download_summary');
                        Route::get('/view/{id}', 'ManufacturerController@view');
                        Route::get('/download/{id}', 'ManufacturerController@download');
                    });
                });

                // importer
                Route::prefix('importer')->group(function(){
                    Route::get('/index', 'ImporterController@index');
                    Route::get('/single_audit_data/{id}', 'ImporterController@single_audit_data');
                    Route::post('/summary_audit_data', 'ImporterController@summary_audit_data');

                    // importer PDF
                    Route::prefix('pdf')->group(function(){
                        Route::get('/view_summary/{token}', 'ImporterController@view_summary');
                        Route::get('/download_summary/{token}', 'ImporterController@download_summary');
                        Route::get('/view/{id}', 'ImporterController@view');
                        Route::get('/download/{id}', 'ImporterController@download');
                    });
                });


                // retailer
                Route::prefix('retailer')->group(function(){
                    Route::get('/index', 'RetailerController@index');
                    Route::get('/single_audit_data/{id}', 'RetailerController@single_audit_data');
                    Route::post('/summary_audit_data', 'RetailerController@summary_audit_data');

                    // retailer PDF
                    Route::prefix('pdf')->group(function(){
                        Route::get('/view_summary/{token}', 'RetailerController@view_summary');
                        Route::get('/download_summary/{token}', 'RetailerController@download_summary');
                        Route::get('/view/{id}', 'RetailerController@view');
                        Route::get('/download/{id}', 'RetailerController@download');
                    });
                });


                // Food
                Route::prefix('food')->group(function(){
                    Route::get('/index', 'FoodController@index');
                    Route::get('/food_summery/{id}', 'FoodController@food_summery');
                
                    // Food PDF
                    Route::prefix('pdf')->group(function(){
                        Route::get('/view/{token}', 'FoodController@view');
                        Route::get('/download/{token}', 'FoodController@download');
                    });
                });
                
                
            });

            Route::get('{any?}', 'IndexController@index');

        });

        // User
        Route::middleware(['can:ivcaUserSection'])->namespace('User')->group(function(){

            // MRO 
            Route::namespace('Mro')->prefix('mro')->group(function(){
                Route::get('/index', 'ScheduleController@index');

                // Token Related
                Route::prefix('token')->group( function(){
                    Route::post('/create', 'TokenController@create');
                    Route::post('/check', 'TokenController@check');
                    Route::post('/check_by_user', 'TokenController@check_by_user');
                    Route::post('/data', 'TokenController@data');
                    Route::post('/tempplate_update', 'TokenController@tempplate_update');
                });

                Route::prefix('audit')->group( function(){

                    Route::post('/tempalte_data', 'AuditController@tempalte_data');

                    Route::prefix('template')->group( function(){
                        Route::post('/manufacturer', 'TemplateController@manufacturer');
                        Route::post('/importer', 'TemplateController@importer');
                        Route::post('/retailer', 'TemplateController@retailer');
                    });


                    Route::namespace('Store')->group(function(){

                        // manufacturer template data store
                        Route::prefix('manufacturer')->group(function(){
                            Route::post('/storage_store/{token}/{type}', 'ManufacturerController@storage_store');
                            Route::post('/production_qs_store/{token}/{type}', 'ManufacturerController@production_qs_store');
                            Route::post('/safety_store/{token}/{type}', 'ManufacturerController@safety_store');
                            Route::post('/env_sur_con_store/{token}/{type}', 'ManufacturerController@env_sur_con_store');
                            Route::post('/equipment_store/{token}/{type}', 'ManufacturerController@equipment_store');
                            Route::post('/cooperate_store/{token}/{type}', 'ManufacturerController@cooperate_store');
                            Route::post('/final_store/{token}/{type}', 'ManufacturerController@final_store');

                            Route::get('/audit_data/{token}', 'ManufacturerController@audit_data');
                        });

                        // importer template data store
                        Route::prefix('importer')->group(function(){
                            Route::post('/storage_store/{token}/{type}', 'ImporterController@storage_store');
                            Route::post('/production_qs_store/{token}/{type}', 'ImporterController@production_qs_store');
                            Route::post('/safety_store/{token}/{type}', 'ImporterController@safety_store');
                            Route::post('/env_sur_con_store/{token}/{type}', 'ImporterController@env_sur_con_store');
                            Route::post('/cooperate_store/{token}/{type}', 'ImporterController@cooperate_store');
                            Route::post('/final_store/{token}/{type}', 'ImporterController@final_store');

                            Route::get('/audit_data/{token}', 'ImporterController@audit_data');
                        });

                        // retailer template data store
                        Route::prefix('retailer')->group(function(){
                            Route::post('/storage_store/{token}/{type}', 'RetailerController@storage_store');
                            Route::post('/production_qs_store/{token}/{type}', 'RetailerController@production_qs_store');
                            Route::post('/safety_store/{token}/{type}', 'RetailerController@safety_store');
                            Route::post('/env_sur_con_store/{token}/{type}', 'RetailerController@env_sur_con_store');
                            Route::post('/cooperate_store/{token}/{type}', 'RetailerController@cooperate_store');
                            Route::post('/final_store/{token}/{type}', 'RetailerController@final_store');

                            Route::get('/audit_data/{token}', 'RetailerController@audit_data');
                        });

                    });

                
                });


            });


            // Food Audit Section
            Route::namespace('Food')->prefix('food')->group(function(){
                Route::get('/index', 'ScheduleController@index');

                // Token Related
                Route::prefix('token')->group( function(){
                    Route::post('/create', 'TokenController@create');
                    Route::post('/check', 'TokenController@check');
                    Route::post('/check_by_user', 'TokenController@check_by_user');
                    Route::post('/data', 'TokenController@data');
                    Route::post('/tempplate_update', 'TokenController@tempplate_update');
                });

                // Food Audit
                Route::prefix('audit')->group(function(){
                    Route::post('tempalte', 'TemplateController@template');
                    Route::get('data/{token}', 'AuditController@data');
                    // Store Audit Data
                    Route::prefix('store')->group(function(){
                        Route::post('/building_facilities_store/{token}', 'AuditController@building_facilities_store');
                        Route::post('/equipment_store/{token}', 'AuditController@equipment_store');
                        Route::post('/personnel_store/{token}', 'AuditController@personnel_store');
                        Route::post('/raw_materials_store/{token}', 'AuditController@raw_materials_store');
                        Route::post('/production_store/{token}', 'AuditController@production_store');
                        Route::post('/records_store/{token}', 'AuditController@records_store');
                        Route::post('/labeling_store/{token}', 'AuditController@labeling_store');
                        
                        Route::post('/final_store/{token}', 'AuditController@final_store');
                    });

                });

            });


            Route::get('{any?}', 'IndexController@Index');
        });

    });
    //End iVCA 


    // iTemp Start
    Route::namespace('iTemp')->prefix('itemp')->group(function(){

        // Admin
        Route::middleware(['can:itempAdmin'])->namespace('Admin')->prefix('admin')->group(function(){

            Route::get('/dashboard_data', 'IndexController@dashboard_data');

            // allemployee Management
            Route::namespace('Allemployee')->prefix('all-employee')->group(function(){
                Route::get('/index', 'IndexController@index');
                Route::post('/status/{id}', 'IndexController@status');
                Route::delete('/destroy/{id}', 'IndexController@deleteDataDirict');
            });

            Route::namespace('Allcheckpoint')->prefix('all-checkpoints')->group(function(){
                Route::get('/index', 'IndexController@index');
                Route::post('/store', 'IndexController@store');
                Route::put('/update', 'IndexController@update');
                Route::delete('/destroy/{id}', 'IndexController@deleteDataDirict');
            });


            Route::namespace('Report')->prefix('report')->group(function(){

                Route::prefix('employee-records')->group(function(){

                    Route::get('/index', 'IndexController@emp_rec');
                    Route::get('/emp_data', 'IndexController@emp_data');
                    Route::get('/export_data', 'IndexController@export_data_allemp');

                });

                Route::prefix('other-records')->group(function(){

                    Route::get('/other_emp_rec', 'IndexController@other_emp_rec');
                    Route::get('/export_data', 'IndexController@export_data_otheremp');
                    
                });
                
            });


           
            Route::get('{any?}', 'IndexController@index');
        });

        // User
        Route::middleware(['can:itemp'])->namespace('User')->group(function(){

            // allemployee Management
            Route::namespace('Allemployee')->prefix('all-employee')->group(function(){
                Route::get('/index', 'IndexController@index');
                Route::post('/store', 'IndexController@store');

                Route::get('/check_point', 'IndexController@check_point');

                
            });


            Route::namespace('Dashboard')->prefix('dashboard')->group(function(){
                
                Route::get('/dashboard_graph', 'IndexController@dashboard_graph');
                
            });

            Route::get('{any?}', 'IndexController@index');
        });
    });
    // iTemp End



    // network start
    Route::namespace('Network')->prefix('network')->group(function(){

        // Admin
        Route::middleware(['can:networkMonitor'])->namespace('Admin')->prefix('admin')->group(function(){
            Route::get('/dashboard_all', 'IndexController@dashboardData');

            Route::namespace('Allgroup')->prefix('all-group')->group(function(){
                Route::get('/index', 'IndexController@index');
                Route::post('/store', 'IndexController@store');
                Route::put('/update/{id}', 'IndexController@update');
                Route::delete('/destroy/{id}', 'IndexController@destroy');
            });

            Route::namespace('Mainip')->prefix('main-ip')->group(function(){
                Route::get('/index', 'IndexController@index');
                Route::post('/store', 'IndexController@store');
                Route::put('/update/{id}', 'IndexController@update');
                Route::delete('/destroy/{id}', 'IndexController@destroy');
                Route::post('/status/{id}', 'IndexController@status');

                Route::view('/singlePing', 'network.admin.ping');
                Route::get('/pingAll', 'IndexController@pingAll');
                

            });

            Route::namespace('Report')->prefix('report')->group(function(){
                Route::get('/mainip-report', 'IndexController@mainIpReport');
                Route::get('/ip_name', 'IndexController@ipName');


                // for subip
                Route::get('/suball-report', 'IndexController@subAllReport');
                Route::get('/group_name', 'IndexController@groupName');
            });

            Route::namespace('Subip')->prefix('sub-ip')->group(function(){
                Route::get('/index', 'IndexController@index');
                Route::post('/store', 'IndexController@store');
                Route::put('/update/{id}', 'IndexController@update');
                Route::delete('/destroy/{id}', 'IndexController@destroy');
                Route::post('/status/{id}', 'IndexController@status');
                Route::get('/group_name', 'IndexController@groupName');

                Route::view('/singlePing', 'network.admin.ping');
                Route::get('/pingAll', 'IndexController@pingAll');
            });


            Route::get('{any?}', 'IndexController@index');
        });
    });
    // network end



    // iaccess Start
    Route::namespace('iAccess')->prefix('iaccess')->group(function(){

        // user
        Route::namespace('User')->group(function(){

            Route::namespace('Form')->prefix('form')->group(function(){

                Route::prefix('email')->group(function(){
                    Route::post('/store', 'IndexController@email_store');
                    //[AllowAnonymous];
                    Route::get('/email_status/{id}', 'IndexController@email_status');
                    
                });

                Route::prefix('account')->group(function(){
                    Route::post('/store', 'IndexController@account_store');
                    Route::get('/account_status/{id}', 'IndexController@account_status');
                });

                Route::prefix('guest')->group(function(){
                    Route::post('/store', 'IndexController@guest_store');
                    Route::get('/guest_status/{id}', 'IndexController@guest_status');
                });

                Route::prefix('webaccess')->group(function(){
                    Route::post('/store', 'IndexController@webaccess_store');
                    Route::get('/internet_status/{id}', 'IndexController@internet_status');
                });
                
            });

            Route::namespace('Status')->prefix('status')->group(function(){
                Route::get('/index', 'IndexController@index');
            });



            Route::get('{any?}', 'IndexController@index');
        });

        
    });
    // iaccess End

    

    // mobile_app Start
    Route::namespace('MobileApp')->prefix('mobile_app')->group(function(){

              
        Route::prefix('guest')->group(function(){
            Route::post('/store', 'IndexController@guest_store');
            Route::get('/guest_status/{id}', 'IndexController@guest_status');
        });

        // User Management
        Route::namespace('User')->prefix('user')->group(function(){
            Route::get('/index', 'IndexController@index');
           
            Route::post('/status_admin/{id}', 'IndexController@status_admin');
            Route::post('/status_user/{id}', 'IndexController@status_user');

            Route::get('/roles_data', 'IndexController@roles_data');
            Route::post('/roles_update', 'IndexController@roles_update');  
            
            Route::get('/zoneoffices', 'IndexController@zoneoffices');
            Route::get('/departments', 'IndexController@departments');

        });

        // Version Management
        Route::namespace('Version')->prefix('version')->group(function(){
            Route::get('/index', 'IndexController@index');
            Route::post('/store', 'IndexController@store');
            Route::put('/update/{id}', 'IndexController@update');
            Route::delete('/destroy/{id}', 'IndexController@destroy');
            Route::post('/status/{id}', 'IndexController@status');
        });

        // Role 
        Route::namespace('Role')->prefix('role')->group(function(){
            Route::get('/index', 'IndexController@index');
            Route::post('/store', 'IndexController@store');
            Route::put('/update/{id}', 'IndexController@update');
            Route::delete('/destroy/{id}', 'IndexController@destroy');
            Route::post('/status/{id}', 'IndexController@status');
        });


        Route::get('{any?}', 'IndexController@index');
    });
    // mobile_app End


    

    // Email
    Route::namespace('Common\Email')->prefix('email')->group(function(){
        Route::get('/cms_app', 'ScheduleEmailCmsApplication@SEND');
        
    }); 



    
    //Route::get('/', 'IndexController@index')->middleware('auth');
    Route::namespace('Dashboard')->group(function(){

        Route::get('{any?}', 'IndexController@index')->name('dashboard');
    });
    

});



