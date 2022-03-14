<?php

namespace App\Http\Controllers\Inventory\Admin\Deletedsection;

use App\Models\Inventory\InventoryNewProduct;
use App\Models\Inventory\InventoryOldProduct;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class IndexController extends Controller
{
    //new_product
    public function new_product(){

        $paginate       = Request('paginate', 10);
        $search         = Request('search', '');
        $sort_direction = Request('sort_direction', 'desc');
        $sort_field     = Request('sort_field', 'id');

        $allData = InventoryNewProduct::with('makby', 'category', 'subcategory')
            ->where('delete_temp', '1')
            ->orderBy($sort_field, $sort_direction)
            ->search( trim(preg_replace('/\s+/' ,' ', $search)) )
            ->paginate($paginate);

        return response()->json($allData, 200);

    }


    //old_product
    public function old_product(){

        $paginate       = Request('paginate', 10);
        $search         = Request('search', '');
        $sort_direction = Request('sort_direction', 'desc');
        $sort_field     = Request('sort_field', 'id');

        $allData = InventoryOldProduct::with('makby', 'category', 'subcategory')
            ->where('delete_temp', '1')
            ->orderBy($sort_field, $sort_direction)
            ->search( trim(preg_replace('/\s+/' ,' ', $search)) )
            ->paginate($paginate);

        return response()->json($allData, 200);

    }


    // destroy
    public function destroy(Request $request){

        if($request->location == 'new'){
            $data = InventoryNewProduct::find($request->id);
        }else if($request->location == 'old'){
            $data = InventoryOldProduct::find($request->id);
        }
        $success    =  $data->delete();
        return response()->json('success', 200);
      
    }

    // restore
    public function restore(Request $request){

        if($request->location == 'new'){
            $data = InventoryNewProduct::find($request->id);
        }else if($request->location == 'old'){
            $data = InventoryOldProduct::find($request->id);
        }

        $data->delete_temp = 0;
        $success           = $data->save();
        return response()->json('success', 200);
        
        
      
    }




    // destroy
    public function destroy_old_product(){
        
        $data       =  InventoryOldProduct::find($request->id);
        $success    =  $data->delete();
        return response()->json('success', 200);
      
    }

    // restore
    public function restore_old_product(){
        
        $data              = InventoryOldProduct::find($request->id);
        $data->delete_temp = 0;
        $success           = $data->save();
        return response()->json('success', 200);
      
    }
}
