<?php

namespace App\Http\Controllers\Inventory\Admin\Reportsection;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class IndexController extends Controller
{

    //index
    public function index(){

        $paginate         = Request('paginate', 10);
        $search           = Request('search', '');
        $sort_direction   = Request('sort_direction', 'desc');
        $sort_field       = Request('sort_field', 'id');
        $search_operation = Request('search_operation', '');

        $allData = InventoryOldProduct::with('operation')
            ->where('delete_temp', '!=', '1')
            ->orderBy($sort_field, $sort_direction)
            ->search( trim(preg_replace('/\s+/' ,' ', $search)) )
            ->paginate($paginate);


        return response()->json($allData, 200);

    }

    
    //operation
    public function operation(){

        $allData = InventoryOperation::select('id', 'name')->get()->toArray();

        return response()->json($allData);

    }
}
