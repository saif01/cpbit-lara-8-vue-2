<?php

namespace App\Http\Controllers\Network\Admin\Report;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;

// for subip
use App\Models\Network\NetworkGroupName;
use App\Models\Network\NetworkSubipPing;

// for mainip
use App\Models\Network\NetworkMainip;
use App\Models\Network\NetworkMainipPing;

use DB;
use Datetime;
use Illuminate\Support\Arr;


class IndexController extends Controller
{

    // sub ip report start
    // subAllReport
    public function subAllReport(){

        $paginate           = Request('paginate', 10);
        $search             = Request('search', '');
        $sort_direction     = Request('sort_direction', 'desc');
        $sort_field         = Request('sort_field', 'id');
        $sort_by_name       = Request('sort_by_name', '');
        $sort_by_day        = Request('sort_by_day', '');
        $sort_by_startDate  = Request('sort_by_startDate', '');
        $sort_by_endDate    = Request('sort_by_endDate', '');

        $dataQuery = NetworkSubipPing::with('makby');

        // show by group name
        if(!empty( $sort_by_name )){
           $dataQuery->where('group_name', $sort_by_name); 
        }

        // sort_by_day
        if(!empty($sort_by_day)){
            $date = Carbon::today()->subDays($sort_by_day);
            $dataQuery->where('created_at', '>=', $date );
        }
        
        // sort_by_startDate 
        // if(!empty($sort_by_startDate) && !empty($sort_by_endDate) ){
            
        //     $dataQuery ->whereDate('start', '>=', $sort_by_startDate)
        //               ->whereDate('end', '<=', $sort_by_endDate);
        // }
            
        $allData = $dataQuery->orderBy($sort_field, $sort_direction)
            ->search( trim(preg_replace('/\s+/' ,' ', $search)) )
            ->paginate($paginate);

        return response()->json($allData, 200);

    }


    // get groupName
    public function groupName(){

        $allData = NetworkGroupName::select('name')->get();
        return response()->json($allData, 200);
    }

    // sub ip report end




    // main ip report start
    // get ip name 
    public function ipName(){
        $allData = NetworkMainip::select('ip','name')->get();

        return response()->json($allData, 200);
    }


   

    public function mainIpReport(){

        //$paginate           = Request('paginate', 10);
        //$search             = Request('search', '');
        //$sort_direction     = Request('sort_direction', 'desc');
        //$sort_field         = Request('sort_field', 'id');
        $sort_by_ip         = Request('sort_by_ip', '');
        $sort_by_day        = Request('sort_by_day', '');
        $sort_by_startDate  = Request('sort_by_startDate', '');
        $sort_by_endDate    = Request('sort_by_endDate', '');

       
        $dataQuery = NetworkMainipPing::where('ip', $sort_by_ip);

        // sort_by_startDate
        if( !empty($sort_by_day) ){
            $dataQuery->where('created_at', '>=', Carbon::today()->subDays($sort_by_day));
        }
        elseif(!empty($sort_by_startDate) && !empty($sort_by_endDate) ){

            $dataQuery->whereDate('created_at', '>=', $sort_by_startDate)
                        ->whereDate('created_at', '<=', $sort_by_endDate);
        } 
            
        $allData = $dataQuery
            ->select('*', DB::raw('DATE(created_at) as date'))
            //->orderBy('id', 'desc')
            ->get()
            ->groupBy('date')
            ->toArray();
            //->paginate($paginate);

            $finalArr = [];
            foreach($allData as $item){
                //dd($item);
                $duration = [];
                $count = 0;
                foreach($item as $key=>$item2){
                    array_push($duration, $item2['created_at']);
                    $count++;
                }
                $arr2 = [
                    'ip' => $item[0]['ip'],
                    'name' => $item[0]['name'],
                    'date' => $item[0]['date'],
                    'off' => $this->offCountByHrMin($count),
                    'duration' => $duration
                ];

                //dd($arr2);
                array_push($finalArr, $arr2);
            }

            //dd($finalArr);

        return response()->json($finalArr, 200);

    }


    // offCountBy Hours or Minuts
    public function offCountByHrMin($count=null){

        $totalOfflineTime = ($count * 10);
            if($totalOfflineTime >= 60){
                $hours = round($totalOfflineTime/60, 2);
                $totalOffline = $hours. " Hours";
            }else{
                $totalOffline = $totalOfflineTime. " Minuts";
            }

        return $totalOffline;
    }

    // main ip report end
}
