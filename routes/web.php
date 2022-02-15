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
                Route::get('/car-data', 'IndexController@CarData');

                // driver leave
                Route::post('/store_leave', 'IndexController@store_leave');

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



    //iVCA 
    Route::namespace('iVCA')->prefix('ivca')->group(function(){

        // Admin
        Route::middleware(['can:roomAdmin'])->namespace('Admin')->prefix('admin')->group(function(){

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
        Route::middleware(['can:roomAdmin'])->namespace('User')->group(function(){

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
            });

           
            Route::get('{any?}', 'IndexController@index');
        });



        //Hardware Admin 
        Route::middleware(['can:hardAdmin'])->namespace('HardwareAdmin')->prefix('h_admin')->group(function(){

            // Others
            Route::namespace('Others')->group(function(){

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

            });

            
            Route::get('{any?}', 'IndexController@index');
        });

        // User
        Route::middleware(['can:cms'])->namespace('User')->group(function(){

            //Application 
            Route::prefix('app')->group(function(){
               
                Route::post('/complain', 'ApplicationController@complain');
               
                Route::get('/category', 'ApplicationController@category');
                Route::get('/subcategory/{id}', 'ApplicationController@subcategory');
            });


            Route::get('{any?}', 'IndexController@index');
        });
    });
    // CMS End








    
    //Route::get('/', 'IndexController@index')->middleware('auth');
    Route::namespace('Dashboard')->group(function(){

        Route::get('{any?}', 'IndexController@index')->name('dashboard');
    });
    

});



