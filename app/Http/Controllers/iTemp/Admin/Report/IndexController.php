<?php

namespace App\Http\Controllers\iTemp\Admin\Report;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\iTemp\itempEmployeeTemp;
use App\Models\iTemp\itempOthersTemp;

use App\Exports\itemp\allEmployee;
use App\Exports\itemp\otherEmployee;
use Maatwebsite\Excel\Facades\Excel;

use Carbon\Carbon;

class IndexController extends Controller
{
    public function emp_rec(){
        $paginate       = Request('paginate', 10);
        $search         = Request('search', '');
        $sort_direction = Request('sort_direction', 'desc');
        $sort_field     = Request('sort_field', 'id'); 
        $sort_by_user    = Request('sort_by_user', '');
        $sort_by_day    = Request('sort_by_day', '');
        $sort_by_startDate    = Request('sort_by_startDate', '');
        $sort_by_endDate    = Request('sort_by_endDate', '');

        $allQuery =  itempEmployeeTemp::with('makby');


        // sort by car
        if(!empty($sort_by_user)){
            $allQuery->where('name', $sort_by_user );
        } 
        
        // sort_by_day

        if(!empty($sort_by_day)){
            $date = Carbon::today()->subDays($sort_by_day);
            $allQuery->where('created_at', '>=', $date );
        }
        
        
        // sort_by_startDate

        if(!empty($sort_by_startDate) && !empty($sort_by_endDate) ){
            
            $allQuery ->whereDate('created_at', '>=', $sort_by_startDate)
                      ->whereDate('created_at', '<=', $sort_by_endDate);
        }

        $allData =  $allQuery->orderBy($sort_field, $sort_direction)
            ->search( trim(preg_replace('/\s+/' ,' ', $search)) )
            ->paginate($paginate);

        return response()->json($allData, 200);


    }


    public function emp_data(){
        $allData = itempEmployeeTemp::whereNotNull('name')
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



    public function other_emp_rec(){
        $paginate       = Request('paginate', 10);
        $search         = Request('search', '');
        $sort_direction = Request('sort_direction', 'desc');
        $sort_field     = Request('sort_field', 'id'); 
        $sort_by_day    = Request('sort_by_day', '');
        $sort_by_startDate    = Request('sort_by_startDate', '');
        $sort_by_endDate    = Request('sort_by_endDate', '');

        $allQuery =  itempOthersTemp::with('makby'); 
        

        // sort_by_day
        if(!empty($sort_by_day)){
            $date = Carbon::today()->subDays($sort_by_day);
            $allQuery->where('created_at', '>=', $date );
        }
        
        
        // sort_by_startDate
        if(!empty($sort_by_startDate) && !empty($sort_by_endDate) ){
            
            $allQuery ->whereDate('created_at', '>=', $sort_by_startDate)
                      ->whereDate('created_at', '<=', $sort_by_endDate);
        }

        $allData =  $allQuery->orderBy($sort_field, $sort_direction)
            ->search( trim(preg_replace('/\s+/' ,' ', $search)) )
            ->paginate($paginate);

        return response()->json($allData, 200);


    }


    public function export_data_allemp(Request $request) 
    {
        $search         = Request('search', '');
        $sort_direction = Request('sort_direction', 'desc');
        $sort_field     = Request('sort_field', 'id'); 
        $sort_by_user    = Request('sort_by_user', '');
        $sort_by_day    = Request('sort_by_day', '');
        $sort_by_startDate    = Request('sort_by_startDate', '');
        $sort_by_endDate    = Request('sort_by_endDate', '');

        $allQuery =  itempEmployeeTemp::with('makby');


        // sort by car
        if(!empty($sort_by_user)){
            $allQuery->where('name', $sort_by_user );
        } 
        
        // sort_by_day

        if(!empty($sort_by_day)){
            $date = Carbon::today()->subDays($sort_by_day);
            $allQuery->where('created_at', '>=', $date );
        }
        
        
        // sort_by_startDate

        if(!empty($sort_by_startDate) && !empty($sort_by_endDate) ){
            
            $allQuery->whereDate('created_at', '>=', $sort_by_startDate)
                      ->whereDate('created_at', '<=', $sort_by_endDate);
        }


         // Final Data
        $allData =  $allQuery->orderBy($sort_field, $sort_direction)->get();

        //dd($allData);

        return Excel::download(new allEmployee($allData), 'employee-' . time() . '.xlsx');
    }


    public function export_data_otheremp(Request $request) 
    {
        $search             = Request('search', '');
        $sort_direction     = Request('sort_direction', 'desc');
        $sort_field         = Request('sort_field', 'id');
        $sort_by_day        = Request('sort_by_day', '');
        $sort_by_startDate  = Request('sort_by_startDate', '');
        $sort_by_endDate    = Request('sort_by_endDate', '');

        $allQuery =  itempOthersTemp::with('makby');
        
        // sort_by_day
        if(!empty($sort_by_day)){
            $date = Carbon::today()->subDays($sort_by_day);
            $allQuery->where('created_at', '>=', $date );
        }
        
        
        // sort_by_startDate
        if(!empty($sort_by_startDate) && !empty($sort_by_endDate) ){
            
            $allQuery->whereDate('created_at', '>=', $sort_by_startDate)
                      ->whereDate('created_at', '<=', $sort_by_endDate);
        }


        // Final Data
        $allData =  $allQuery->orderBy($sort_field, $sort_direction)->get();

        //dd($allData);

        return Excel::download(new otherEmployee($allData), 'employee-' . time() . '.xlsx');
    }
}
