<?php

namespace App\Http\Controllers\Inventory\Admin\Productsection;

use App\Models\Inventory\InventoryOldProduct;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class IndexController extends Controller
{
    //given_product
    public function given_product(){

        $paginate       = Request('paginate', 10);
        $search         = Request('search', '');
        $sort_direction = Request('sort_direction', 'desc');
        $sort_field     = Request('sort_field', 'id');

        $allData = InventoryOldProduct::with('makby', 'category', 'subcategory', 'operation', 'newtbldata')
            ->whereHas('newtbldata', function($q){
                $q->select('document');
            })
            ->where('delete_temp', '!=', '1')
            ->where('new_pro_id', '!=', '0')
            ->orderBy($sort_field, $sort_direction)
            ->search( trim(preg_replace('/\s+/' ,' ', $search)) )
            ->paginate($paginate);
            //dd($allData);

        return response()->json($allData, 200);

    }


    //running_product
    public function running_product(){

        $paginate       = Request('paginate', 10);
        $search         = Request('search', '');
        $sort_direction = Request('sort_direction', 'desc');
        $sort_field     = Request('sort_field', 'id');

        $allData = InventoryOldProduct::with('makby', 'category', 'subcategory', 'operation')
            ->where('delete_temp', '!=', '1')
            ->where('type', 'Running')
            ->orderBy($sort_field, $sort_direction)
            ->search( trim(preg_replace('/\s+/' ,' ', $search)) )
            ->paginate($paginate);
            //dd($allData);

        return response()->json($allData, 200);

    }


    //damaged_product
    public function damaged_product(){

        $paginate       = Request('paginate', 10);
        $search         = Request('search', '');
        $sort_direction = Request('sort_direction', 'desc');
        $sort_field     = Request('sort_field', 'id');

        $allData = InventoryOldProduct::with('makby', 'category', 'subcategory', 'operation')
            ->where('delete_temp', '!=', '1')
            ->where('type', 'Damaged')
            ->orderBy($sort_field, $sort_direction)
            ->search( trim(preg_replace('/\s+/' ,' ', $search)) )
            ->paginate($paginate);
            //dd($allData);

        return response()->json($allData, 200);

    }
}
