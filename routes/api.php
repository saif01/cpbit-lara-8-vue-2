<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::namespace('App\Http\Controllers')->group(function(){


    Route::namespace('PBI\Admin\API')->prefix('powerbi-get')->group(function(){

        
        Route::get('farm-aqua-purchase', 'ShowController@farmAquaPurchase');
        Route::get('farm-aqua-sales', 'ShowController@farmAquaSales');
        Route::get('farm-poultry-purchase', 'ShowController@farmPoultryPurchase');
        Route::get('farm-poultry-sales', 'ShowController@farmPoultrySales');
        
        // Food
        Route::get('food-further-sales', 'ShowController@foodFurtherSales');
        Route::get('food-slaughter-sales', 'ShowController@foodSlaughterSales');

        // Feed
        Route::get('feed-production', 'ShowController@feedProduction');
        Route::get('feed-purchase', 'ShowController@feedPurchase');
        Route::get('feed-sales', 'ShowController@feedSales');

        Route::get('expense', 'ShowController@expense');



        // Route::get('feed-agro-sales', 'ShowController@feedAgroSales');
        // Route::get('feed-poultry-sales', 'ShowController@feedPoultrySales');
        // Route::get('feed-cattle-sales', 'ShowController@feedCattleSales');
        // Route::get('feed-aqua-sales', 'ShowController@feedAquaSales');
        // Route::get('map-unit-level', 'ShowController@mapUnitLevel');
        



        //Route::get('farm-aqua-sales-parm/{days}', 'ShowController@farmAquaSalesParm')->name('get.farm.aqua.sales.data.get.parms');



        Route::get('food-furthersales', 'ShowController@foodFurthersales');


    Route::get('test', 'ShowController@test');


    });


    // mobileapp
    Route::namespace('MobileApp')->prefix('mobileapp')->group(function(){

        Route::get('version', 'Version\IndexController@apiVersion');
        Route::get('user_access', 'User\IndexController@apiAsset');
    
    });

});
