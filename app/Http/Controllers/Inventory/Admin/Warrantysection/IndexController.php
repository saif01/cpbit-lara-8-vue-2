<?php

namespace App\Http\Controllers\Inventory\Admin\Warrantysection;

use App\Models\Inventory\InventoryNewProduct;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Carbon\Carbon;

class IndexController extends Controller
{
    //warranty_product
    public function warranty_product(){

        $paginate       = Request('paginate', 10);
        $search         = Request('search', '');
        $sort_direction = Request('sort_direction', 'desc');
        $sort_field     = Request('sort_field', 'id');

        $allData = InventoryNewProduct::with('makby', 'category', 'subcategory')
            ->where('delete_temp', '!=', '1')
            ->whereNotNull('warranty')
            ->orderBy($sort_field, $sort_direction)
            ->search( trim(preg_replace('/\s+/' ,' ', $search)) )
            ->paginate($paginate);

        return response()->json($allData, 200);

    }


    //expire_product
    public function expire_product(){
        //$dt = Carbon::now()->toDateString();
        //$dt->toDateString(); // Equivalent: echo $dt->format('Y-m-d');


        $paginate       = Request('paginate', 10);
        $search         = Request('search', '');
        $sort_direction = Request('sort_direction', 'desc');
        $sort_field     = Request('sort_field', 'id');

        $allData = InventoryNewProduct::with('makby', 'category', 'subcategory')
            ->where('delete_temp', '!=', '1')
            ->where('warranty', '>=', Carbon::now()->format('Y-m-d'))
            ->orderBy($sort_field, $sort_direction)
            ->search( trim(preg_replace('/\s+/' ,' ', $search)) )
            ->paginate($paginate);

        return response()->json($allData, 200);

    }
}
