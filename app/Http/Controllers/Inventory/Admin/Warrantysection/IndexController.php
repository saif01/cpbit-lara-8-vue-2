<?php

namespace App\Http\Controllers\Inventory\Admin\Warrantysection;

use App\Models\Inventory\InventoryNewProduct;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Carbon\Carbon;

use App\Exports\inventory\warranty\warrantyProduct;
use App\Exports\inventory\warranty\expireProduct;
use Maatwebsite\Excel\Facades\Excel;

class IndexController extends Controller
{
    //warranty_product
    public function warranty_product(){

        $paginate       = Request('paginate', 10);
        $search         = Request('search', '');
        $sort_direction = Request('sort_direction', 'desc');
        $sort_field     = Request('sort_field', 'id');

        $search_field  = Request('search_field', '');

        $allDataQuery = InventoryNewProduct::with('makby', 'category', 'subcategory')
            ->where('delete_temp', '!=', '1')
            ->whereNotNull('warranty');


        // Search
        if(!empty($search_field) && $search_field != 'All' && $search_field != 'cat_id' && $search_field != 'subcat_id'){

            $val = trim(preg_replace('/\s+/' ,' ', $search));
            $allDataQuery->where($search_field, 'LIKE', '%'.$val.'%');

        }
        elseif($search_field == 'cat_id'){

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


    //expire_product
    public function expire_product(){

        $paginate       = Request('paginate', 10);
        $search         = Request('search', '');
        $sort_direction = Request('sort_direction', 'desc');
        $sort_field     = Request('sort_field', 'id');

        $search_field  = Request('search_field', '');

        $allDataQuery = InventoryNewProduct::with('makby', 'category', 'subcategory')
            ->where('delete_temp', '!=', '1')
            ->where('warranty', '>=', Carbon::now()->format('Y-m-d'));



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



    // export warranty
    public function export_data_warranty(Request $request) 
    {
        $search         = Request('search', '');
        $sort_direction = Request('sort_direction', 'desc');
        $sort_field     = Request('sort_field', 'id');

        $search_field  = Request('search_field', '');

        $allDataQuery = InventoryNewProduct::with('makby', 'category', 'subcategory')
            ->where('delete_temp', '!=', '1')
            ->whereNotNull('warranty');


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
        $allData =  $allDataQuery->orderBy($sort_field, $sort_direction)->get();

        //dd($allData);

        return Excel::download(new warrantyProduct($allData), 'product-' . time() . '.xlsx');
    }




    // export expire
    public function export_data_expire(Request $request) 
    {
        $search         = Request('search', '');
        $sort_direction = Request('sort_direction', 'desc');
        $sort_field     = Request('sort_field', 'id');

        $search_field  = Request('search_field', '');

        $allDataQuery = InventoryNewProduct::with('makby', 'category', 'subcategory')
            ->where('delete_temp', '!=', '1')
            ->where('warranty', '>=', Carbon::now()->format('Y-m-d'));



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
        $allData =  $allDataQuery->orderBy($sort_field, $sort_direction)->get();

        return Excel::download(new expireProduct($allData), 'product-' . time() . '.xlsx');
    }
}
