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


    // public function mainIpReport(){
    //     $search             = Request('search', '');
    //     $sort_direction     = Request('sort_direction', 'desc');
    //     $sort_field         = Request('sort_field', 'id');
    //     $sort_by_name       = Request('sort_by_name', '');
    //     $sort_by_day        = Request('sort_by_day', '');
    //     $sort_by_startDate  = Request('sort_by_startDate', '');
    //     $sort_by_endDate    = Request('sort_by_endDate', '');

    //     $dataQuery = NetworkMainipPing::with('makby');

    //     // show by group name
    //     if(!empty( $sort_by_name )){
    //        $dataQuery->where('ip', $sort_by_name); 
    //     }

    //     // sort_by_day
    //     if(!empty($sort_by_day)){
    //         $date = Carbon::today()->subDays($sort_by_day);
    //         $dataQuery->where('created_at', '>=', $date );
    //     }
        
    //     // sort_by_startDate
    //     if(!empty($sort_by_startDate) && !empty($sort_by_endDate) ){

    //         $date1 = $sort_by_startDate.' 00:01:00';
    //         $date2 = $sort_by_endDate.' 23:59:59';
            
    //         $dataQuery->whereBetween('created_at',[$date1,$date2]);

    //     }else if(empty($sort_by_startDate) && empty($sort_by_endDate) ){

    //         $dataQuery->where('created_at', '>=', Carbon::now()->subMonth()->toDateTimeString());
            
    //     }

    //     $allData2 = $dataQuery->orderBy($sort_field, $sort_direction)
    //         ->search( trim(preg_replace('/\s+/' ,' ', $search)) );            

        
    //     $allGroupData = $allData2
    //         ->select('*', DB::raw('DATE(created_at) as date'))
    //         ->get()
    //         ->groupBy('date');

    //     $allData = $allData2
    //         ->select('*', DB::raw('DATE(created_at) as date'),DB::raw('count(ip) as length'))
    //         ->groupBy('date')
    //         ->get();


               


    //         // foreach($allGroupData as $item){
    //         //     echo $item;
    //         //     // Arr::add($allGroupData, 'test', $item->length);

    //         // }

    //     // if($allGroupData){
    //     //     $offlineDetails=[];
    //     //     $time = '';
    //     //     $count = 0;
    //     //     foreach($allGroupData as $sub_val){
    //     //         $time .= '( ';
    //     //         $time .= date('h:i A', strtotime($sub_val['created_at'])). " - ";
    //     //         $newtimestamp = strtotime($sub_val['created_at'].'+ 10 minute');
    //     //         $time .= date('h:i A', $newtimestamp);
    //     //         $time .= ') ';
                

    //     //         $count++;
                
                
    //     //     }
    //     //     if($count >= 143){
    //     //             $msg = "Full Day Night Offline";
    //     //             array_push($offlineDetails, $msg);
    //     //         }else{
    //     //             return $time;
    //     //             //array_push($offlineDetails, $time);
    //     //         }
    //     // }

    //     //echo($time);



    //         // if($allData2){
    //         //     $date = [];
    //         //     foreach($allData2 as $item){
    //         //         array_push($date, $item[0]->date);

    //         //         //return $item[0]->date;
    //         //     }
    //         // }

    //         // if($allData2){
    //         //     $name = [];
    //         //     foreach($allData2 as $item){
    //         //         array_push($name, $item[0]->name);

    //         //         //return $item[0]->name;
    //         //     }
    //         // }

    //         //$allData = $allData2->prepend($date, 'date')->prepend($name, 'name');


    //     return response()->json(['allData'=> $allData, 'groupData'=> $allGroupData]);
    //     //return response()->json($allData, 200);

    // }

    public function mainIpReport(){

        $paginate           = Request('paginate', 10);
        $search             = Request('search', '');
        $sort_direction     = Request('sort_direction', 'desc');
        $sort_field         = Request('sort_field', 'id');
        $sort_by_name       = Request('sort_by_name', '');
        $sort_by_day        = Request('sort_by_day', '');
        $sort_by_startDate  = Request('sort_by_startDate', '');
        $sort_by_endDate    = Request('sort_by_endDate', '');

        $dataQuery = NetworkMainipPing::with('makby');

        // show by group name
        if(!empty( $sort_by_name )){
           $dataQuery->where('ip', $sort_by_name); 
        }

        // sort_by_day
        if(!empty($sort_by_day)){
            $date = Carbon::today()->subDays($sort_by_day);
            $dataQuery->where('created_at', '>=', $date );
        }
        
        // sort_by_startDate
        if(!empty($sort_by_startDate) && !empty($sort_by_endDate) ){

            $date1 = $sort_by_startDate.' 00:01:00';
            $date2 = $sort_by_endDate.' 23:59:59';

            $dataQuery->whereDate('created_at', '>=', $date1)
                        ->whereDate('created_at', '<=', $date2);

        }else if(empty($sort_by_startDate) && empty($sort_by_endDate) ){

            $dataQuery->where('created_at', '>=', Carbon::now()->subMonth()->toDateTimeString());

        }
            
        $allData = $dataQuery->orderBy($sort_field, $sort_direction)
            ->search( trim(preg_replace('/\s+/' ,' ', $search)) )
            ->select('*', DB::raw('DATE(created_at) as date'))
            ->groupBy('date')
            ->paginate($paginate);

            //dd($allData);

            //dd($allData);
            

            // if($allData){
            //     $offlineTime = [];
            //     $time = '';
            //     $count = 0;
            //     // foreach($allData as $sub_val){
            //     //     $count++; 

            //     //     $totalOfflineTime = ($count * 10);
            //     //     if($totalOfflineTime >= 60){
            //     //         $hours = round($totalOfflineTime/60, 2);
            //     //         $time .= $hours. " Hours";
            //     //         array_push($offlineTime, $time); 
            //     //     }else{
            //     //         $time .= $totalOfflineTime. " Minutes";
            //     //         array_push($offlineTime, $time); 
            //     //     }
            //     // }

               
                
                
            // }

            // if($allData){
            //     $offlineDetails=[];
            //     $time = '';
            //     $count = 0;
            //     // foreach($allData as $sub_val){
            //     //     $time .= '( ';
            //     //     $time .= date('h:i A', strtotime($sub_val['created_at'])). " - ";
            //     //     $newtimestamp = strtotime($sub_val['created_at'].'+ 10 minute');
            //     //     $time .= date('h:i A', $newtimestamp);
            //     //     $time .= ') ';

            //     //     $count++;
                    
            //     //     if($count >= 143){
            //     //         $msg = "Full Day Night Offline";
            //     //         array_push($offlineDetails, $msg);
            //     //     }else{
            //     //         array_push($offlineDetails, $time);
            //     //     }




            //     // if($count >= 143){
            //     //     return "Full Day Night Offline<br>";
            //     // }else{
            //     //     return $time;
            //     // }

            //     //dd($offlineDetails);

                
            // }

        // return response()->json(['allData'=> $allData, 'offlineTime'=> $offlineTime, 'offlineDetails'=> $offlineDetails]);


        return response()->json(['allData'=> $allData]);

    }







    // main ip report end
}
