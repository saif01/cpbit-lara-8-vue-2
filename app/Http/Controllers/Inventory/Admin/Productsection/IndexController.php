<?php

namespace App\Http\Controllers\Inventory\Admin\Productsection;

use App\Models\Inventory\InventoryOldProduct;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Exports\inventory\product\givenProduct;
use App\Exports\inventory\product\runningProduct;
use App\Exports\inventory\product\damageProduct;
use Maatwebsite\Excel\Facades\Excel;

class IndexController extends Controller
{
    //given_product
    public function given_product(){

        $paginate       = Request('paginate', 10);
        $search         = Request('search', '');
        $sort_direction = Request('sort_direction', 'desc');
        $sort_field     = Request('sort_field', 'id');

        $search_field  = Request('search_field', '');
        $business_unit  = Request('business_unit', '');

        $allDataQuery = InventoryOldProduct::with('makby', 'category', 'subcategory', 'operation', 'newtbldata')
            ->whereHas('newtbldata', function($q){
                $q->select('document');
            })
            ->where('delete_temp', '!=', '1')
            ->where('new_pro_id', '!=', '0');

        // business unit
        if(!empty($business_unit) && $business_unit != 'All'){
            $allDataQuery->where('business_unit', $business_unit);
        }

        // Search
        if(!empty($search_field) && $search_field != 'All' && $search_field != 'cat_id' && $search_field != 'subcat_id' && $search_field != 'operation'){

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
        elseif($search_field == 'operation'){

            $val = trim(preg_replace('/\s+/' ,' ', $search));

            $allDataQuery->whereHas( 'operation', function($query) use($val){
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


    //running_product
    public function running_product(){

        $paginate       = Request('paginate', 10);
        $search         = Request('search', '');
        $sort_direction = Request('sort_direction', 'desc');
        $sort_field     = Request('sort_field', 'id');

        $search_field  = Request('search_field', '');
        $business_unit  = Request('business_unit', '');

        $allDataQuery = InventoryOldProduct::with('makby', 'category', 'subcategory', 'operation')
            ->where('delete_temp', '!=', '1')
            ->where('type', 'Running');

        // business unit
        if(!empty($business_unit) && $business_unit != 'All'){
            $allDataQuery->where('business_unit', $business_unit);
        }

        // Search
        if(!empty($search_field) && $search_field != 'All' && $search_field != 'cat_id' && $search_field != 'subcat_id' && $search_field != 'operation'){

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
        elseif($search_field == 'operation'){

            $val = trim(preg_replace('/\s+/' ,' ', $search));

            $allDataQuery->whereHas( 'operation', function($query) use($val){
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

        
            //dd($allData);

        return response()->json($allData, 200);

    }


    //damaged_product
    public function damaged_product(){

        $paginate       = Request('paginate', 10);
        $search         = Request('search', '');
        $sort_direction = Request('sort_direction', 'desc');
        $sort_field     = Request('sort_field', 'id');

        $search_field  = Request('search_field', '');
        $business_unit  = Request('business_unit', '');

        $allDataQuery = InventoryOldProduct::with('makby', 'category', 'subcategory', 'operation')
            ->where('delete_temp', '!=', '1')
            ->where('type', 'Damaged');


            // business unit
        if(!empty($business_unit) && $business_unit != 'All'){
            $allDataQuery->where('business_unit', $business_unit);
        }

        // Search
        if(!empty($search_field) && $search_field != 'All' && $search_field != 'cat_id' && $search_field != 'subcat_id' && $search_field != 'operation'){

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
        elseif($search_field == 'operation'){

            $val = trim(preg_replace('/\s+/' ,' ', $search));

            $allDataQuery->whereHas( 'operation', function($query) use($val){
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





    // given export

    public function export_data_given(Request $request) 
    {
        $search         = Request('search', '');
        $sort_direction = Request('sort_direction', 'desc');
        $sort_field     = Request('sort_field', 'id');

        $search_field  = Request('search_field', '');
        $business_unit  = Request('business_unit', '');

        $allDataQuery = InventoryOldProduct::with('makby', 'category', 'subcategory', 'operation', 'newtbldata')
            ->whereHas('newtbldata', function($q){
                $q->select('document');
            })
            ->where('delete_temp', '!=', '1')
            ->where('new_pro_id', '!=', '0');

        // business unit
        if(!empty($business_unit) && $business_unit != 'All'){
            $allDataQuery->where('business_unit', $business_unit);
        }

        // Search
        if(!empty($search_field) && $search_field != 'All' && $search_field != 'cat_id' && $search_field != 'subcat_id' && $search_field != 'operation'){

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
        elseif($search_field == 'operation'){

            $val = trim(preg_replace('/\s+/' ,' ', $search));

            $allDataQuery->whereHas( 'operation', function($query) use($val){
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

        return Excel::download(new givenProduct($allData), 'product-' . time() . '.xlsx');
    }


    // running export
    public function export_data_running(Request $request) 
    {
        $search         = Request('search', '');
        $sort_direction = Request('sort_direction', 'desc');
        $sort_field     = Request('sort_field', 'id');

        $search_field  = Request('search_field', '');
        $business_unit  = Request('business_unit', '');

        $allDataQuery = InventoryOldProduct::with('makby', 'category', 'subcategory', 'operation')
            ->where('delete_temp', '!=', '1')
            ->where('type', 'Running');

        // business unit
        if(!empty($business_unit) && $business_unit != 'All'){
            $allDataQuery->where('business_unit', $business_unit);
        }

        // Search
        if(!empty($search_field) && $search_field != 'All' && $search_field != 'cat_id' && $search_field != 'subcat_id' && $search_field != 'operation'){

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
        elseif($search_field == 'operation'){

            $val = trim(preg_replace('/\s+/' ,' ', $search));

            $allDataQuery->whereHas( 'operation', function($query) use($val){
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

        return Excel::download(new runningProduct($allData), 'product-' . time() . '.xlsx');
    }



    // running damage
    public function export_data_damage(Request $request) 
    {
        $search         = Request('search', '');
        $sort_direction = Request('sort_direction', 'desc');
        $sort_field     = Request('sort_field', 'id');

        $search_field  = Request('search_field', '');
        $business_unit  = Request('business_unit', '');

        $allDataQuery = InventoryOldProduct::with('makby', 'category', 'subcategory', 'operation')
            ->where('delete_temp', '!=', '1')
            ->where('type', 'Damaged');


            // business unit
        if(!empty($business_unit) && $business_unit != 'All'){
            $allDataQuery->where('business_unit', $business_unit);
        }

        // Search
        if(!empty($search_field) && $search_field != 'All' && $search_field != 'cat_id' && $search_field != 'subcat_id' && $search_field != 'operation'){

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
        elseif($search_field == 'operation'){

            $val = trim(preg_replace('/\s+/' ,' ', $search));

            $allDataQuery->whereHas( 'operation', function($query) use($val){
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

        return Excel::download(new damageProduct($allData), 'product-' . time() . '.xlsx');
    }



}
