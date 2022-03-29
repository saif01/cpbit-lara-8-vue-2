<?php

namespace App\Http\Controllers\Inventory\Admin\Reportsection;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;


use App\Models\Inventory\InventoryNewProduct;
use App\Models\Inventory\InventoryOperation;
use App\Models\Inventory\InventoryOldProduct;
use App\Models\User;
use Auth;
use App\Http\Controllers\Common\ImageUpload;

use App\Exports\inventory\newProduct;
use Maatwebsite\Excel\Facades\Excel;
use DB;

class IndexController extends Controller
{

    //index
    // public function index(){

    //     $paginate         = Request('paginate', 10);
    //     $search           = Request('search', '');
    //     $sort_direction   = Request('sort_direction', 'desc');
    //     $sort_field       = Request('sort_field', 'id');
    //     $search_operation = Request('search_operation', '');

    //     $allData = InventoryOldProduct::with('operation')
    //         ->where('delete_temp', '!=', '1')
    //         ->orderBy($sort_field, $sort_direction)
    //         ->search( trim(preg_replace('/\s+/' ,' ', $search)) )
    //         ->paginate($paginate);


    //     return response()->json($allData, 200);

    // }

    
    //operation
    // public function operation(){

    //     $allData = InventoryOperation::select('id', 'name')->get()->toArray();

    //     return response()->json($allData);

    // }


    //index
    public function index(){

        $paginate       = Request('paginate', 10);
        $search         = Request('search', '');
        $sort_direction = Request('sort_direction', 'desc');
        $sort_field     = Request('sort_field', 'id');

        $search_field     = Request('search_field', '');
        $sort_by_product  = Request('sort_by_product', '');
        $sort_by_startDate    = Request('sort_by_startDate', '');
        $sort_by_endDate    = Request('sort_by_endDate', '');

        $allDataQuery = InventoryNewProduct::with('makby', 'category', 'subcategory', 'newold')
            ->where('delete_temp', '!=', '1');



        // sort_by_product
        if(!empty($sort_by_product) && $sort_by_product != 'All'){
            $allDataQuery->where('name', $sort_by_product);
        }

        // sort_by_startDate

        if(!empty($sort_by_startDate) && !empty($sort_by_endDate) ){
            
            $allDataQuery ->whereDate('created_at', '>=', $sort_by_startDate)
                      ->whereDate('created_at', '<=', $sort_by_endDate);
        }

            // Search
        if(!empty($search_field) && $search_field != 'All' && $search_field != 'cat_id' && $search_field != 'subcat_id'){

            $val = trim(preg_replace('/\s+/' ,' ', $search));
            $allDataQuery->where($search_field, 'LIKE', '%'.$val.'%');

        }elseif($search_field == 'cat_id'){

            $val = trim(preg_replace('/\s+/' ,' ', $search));

            $allDataQuery->whereHas( 'category', function($query) use($val){
                //$query->where( 'name', $search_field );
                $query->where('name', 'LIKE', '%'.$val.'%');
            });

        }
        elseif($search_field == 'subcat_id'){

            $val = trim(preg_replace('/\s+/' ,' ', $search));

            $allDataQuery->whereHas( 'subcategory', function($query) use($val){
                //$query->where( 'name', $search_field );
                $query->where('name', 'LIKE', '%'.$val.'%');
            });

        }
        else{
            $allDataQuery->search( trim(preg_replace('/\s+/' ,' ', $search)) );
        }


         // Final Data
        $allData =  $allDataQuery->orderBy($sort_field, $sort_direction)
                ->paginate($paginate);

        return response()->json($allData, 200);

    }


    // sort_by_product
    public function sort_by_product(){
        $allData = InventoryNewProduct::whereNotNull('name')
            ->select('name')
            ->orderBy('name')
            ->groupBy('name')
            ->get()
            ->toArray();

        // Custom Field Data Add
        $custom = collect( [['name' => 'All']] );
        $allData = $custom->merge($allData);

        return response()->json($allData,200);
    }


    // export_data
    public function export_data(Request $request) 
    {
        $search         = Request('search', '');
        $sort_direction = Request('sort_direction', 'desc');
        $sort_field     = Request('sort_field', 'id');

        $search_field       = Request('search_field', '');
        $sort_by_product    = Request('sort_by_product', '');
        $sort_by_startDate  = Request('sort_by_startDate', '');
        $sort_by_endDate    = Request('sort_by_endDate', '');

        $allDataQuery = InventoryNewProduct::with('makby', 'category', 'subcategory', 'newold')
            ->where('delete_temp', '!=', '1');



        // sort_by_product
        if(!empty($sort_by_product) && $sort_by_product != 'All'){
            $allDataQuery->where('name', $sort_by_product);
        }

        // sort_by_startDate

        if(!empty($sort_by_startDate) && !empty($sort_by_endDate) ){
            
            $allDataQuery ->whereDate('created_at', '>=', $sort_by_startDate)
                      ->whereDate('created_at', '<=', $sort_by_endDate);
        }

            // Search
        if(!empty($search_field) && $search_field != 'All' && $search_field != 'cat_id' && $search_field != 'subcat_id'){

            $val = trim(preg_replace('/\s+/' ,' ', $search));
            $allDataQuery->where($search_field, 'LIKE', '%'.$val.'%');

        }elseif($search_field == 'cat_id'){

            $val = trim(preg_replace('/\s+/' ,' ', $search));

            $allDataQuery->whereHas( 'category', function($query) use($val){
                //$query->where( 'name', $search_field );
                $query->where('name', 'LIKE', '%'.$val.'%');
            });

        }
        elseif($search_field == 'subcat_id'){

            $val = trim(preg_replace('/\s+/' ,' ', $search));

            $allDataQuery->whereHas( 'subcategory', function($query) use($val){
                //$query->where( 'name', $search_field );
                $query->where('name', 'LIKE', '%'.$val.'%');
            });

        }
        else{
            $allDataQuery->search( trim(preg_replace('/\s+/' ,' ', $search)) );
        }

        $allDataQuery->orderBy($sort_field, $sort_direction);

        $allData = $allDataQuery->where('give_st', 1)->get();

        // issue 
        $issue = $allDataQuery->count();
        $issue_unit_price = $allDataQuery->where('unit_price', '!=', 0)->groupBy('unit_price')->first();
        $issue_amount = $allDataQuery->sum('unit_price');

        // damage
        $allDataQuery->where('damage_st', 1)->get();

        $damage = $allDataQuery->count();
        $damage_unit_price = $allDataQuery->where('unit_price', '!=', 0)->groupBy('unit_price')->first();
        $damage_amount = $allDataQuery->sum('unit_price');

        




        ///////////////// all added product data ////////////////////
        $allDataQuery2 = InventoryNewProduct::with('makby', 'category', 'subcategory', 'newold')
            ->where('delete_temp', '!=', '1');



        // sort_by_product
        if(!empty($sort_by_product) && $sort_by_product != 'All'){
            $allDataQuery2->where('name', $sort_by_product);
        }

        // sort_by_startDate

        if(!empty($sort_by_startDate) && !empty($sort_by_endDate) ){
            
            $allDataQuery2 ->whereDate('created_at', '>=', $sort_by_startDate)
                      ->whereDate('created_at', '<=', $sort_by_endDate);
        }

            // Search
        if(!empty($search_field) && $search_field != 'All' && $search_field != 'cat_id' && $search_field != 'subcat_id'){

            $val = trim(preg_replace('/\s+/' ,' ', $search));
            $allDataQuery2->where($search_field, 'LIKE', '%'.$val.'%');

        }elseif($search_field == 'cat_id'){

            $val = trim(preg_replace('/\s+/' ,' ', $search));

            $allDataQuery2->whereHas( 'category', function($query) use($val){
                //$query->where( 'name', $search_field );
                $query->where('name', 'LIKE', '%'.$val.'%');
            });

        }
        elseif($search_field == 'subcat_id'){

            $val = trim(preg_replace('/\s+/' ,' ', $search));

            $allDataQuery2->whereHas( 'subcategory', function($query) use($val){
                //$query->where( 'name', $search_field );
                $query->where('name', 'LIKE', '%'.$val.'%');
            });

        }
        else{
            $allDataQuery2->search( trim(preg_replace('/\s+/' ,' ', $search)) );
        }

        $allDataQuery2->orderBy($sort_field, $sort_direction);

        $received = $allDataQuery2->count();
        $received_unit_price = $allDataQuery2->where('unit_price', '!=', 0)->groupBy('unit_price')->first();
        $received_amount = $allDataQuery2->sum('unit_price');

        $lengthData = [$received,$received_unit_price,$received_amount, $issue,$issue_unit_price,$issue_amount, $damage,$damage_unit_price,$damage_amount];


        //dd($lengthData);
       return Excel::download(new newProduct($allData, $lengthData), 'product-' . time() . '.xlsx');
    }
}
