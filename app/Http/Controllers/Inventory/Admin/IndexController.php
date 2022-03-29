<?php

namespace App\Http\Controllers\Inventory\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Auth;
use App\Models\Cms\Hardware\HardwareCategory;
use App\Models\User;
use DB;

use App\Models\Inventory\InventoryNewProduct;
use App\Models\Inventory\InventoryOperation;
use App\Models\Inventory\InventoryOldProduct;

class IndexController extends Controller
{
    //index
    public function index(){
        $roles = Auth::user()->roles->pluck('name');
        // $ivcaData = Auth::user()->ivca_roles->pluck('name');
        // // Merge collections
        // $roles = $roleData->merge($ivcaData);
        return view('inventory.admin.index', compact('roles'));
    }


    // dashboard_data
    public function dashboard_data(){

        $remainProduct = InventoryNewProduct::with('category')
                ->where('delete_temp', 0)
                ->where('give_st', 0)
                ->groupBy('cat_id')
                ->selectRaw('count(*) as total, cat_id')
                ->get()
                ->toArray();

        $operationWiseProduct = InventoryOldProduct::with('operation')
                ->where('delete_temp', 0)
                ->where('operation_id', '!=', 0)
                ->groupBy('operation_id')
                ->selectRaw('count(*) as total, operation_id')
                //->select('*',  DB::raw('count(*) as total'))
                ->get()
                ->toArray();

                
        $chartData = InventoryNewProduct::with('category')
            ->where('delete_temp', 0)
            ->select('*',  DB::raw('count(*) as total'))
            ->groupBy('cat_id')
            ->get();

        return response()->json(['remainProduct'=> $remainProduct, 'operationWiseProduct'=> $operationWiseProduct, 'chartData'=> $chartData  ],200);

    }



   
    //category
    public function category(){
        //dd("test");
        $allData = HardwareCategory::with('subcat')->orderBy('name')->get();
        
        return response()->json($allData);
    }


}
