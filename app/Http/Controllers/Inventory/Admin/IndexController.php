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

        $allOperations = InventoryOperation::select('id', 'name')->get();

        $operationWiseProduct = [];

        foreach($allOperations as $item){

           

            $name = $item->name;
            $operation_id  = $item->id;

            $result = InventoryOldProduct::with('category')
            ->where('operation_id', $operation_id)
            ->select('cat_id', DB::raw('count(*) as total'))
            ->groupBy('cat_id')
            ->get()
            ->toArray();

            $arr2=[
                'lavel' => $name,
                'val'   => $result
            ];

            array_push($operationWiseProduct, $arr2);

        }
 
      
    

        //dd($arr, $allOperations);


        $remainProduct = InventoryNewProduct::with('category')
        ->where('delete_temp', 0)
        ->where('give_st', 0)
        ->groupBy('cat_id')
        ->selectRaw('count(*) as total, cat_id')
        ->get();



        return response()->json(['remainProduct'=> $remainProduct, 'operationWiseProduct'=> $operationWiseProduct  ],200);

    }



   
    //category
    public function category(){
        //dd("test");
        $allData = HardwareCategory::with('subcat')->orderBy('name')->get();
        
        return response()->json($allData);
    }


}
