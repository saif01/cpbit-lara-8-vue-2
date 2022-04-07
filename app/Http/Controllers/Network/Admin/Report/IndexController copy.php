<?php

namespace App\Http\Controllers\Admin\Network;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Network\NetworkMainipPing;
use App\Models\Network\NetworkMainip;
use App\Models\Network\NetworkSubipPing;
use App\Models\Network\NetworkSubip;
use App\Models\Network\NetworkGroupName;
use DataTables;
use Carbon\Carbon;
use DB;

 
class ReportController extends Controller
{
    //All Data
    public function MainIp(){


        // $date = Carbon::today()->subdays(2);
        // //$data = NetworkMainipPing::where('created_at', '>=', $date)->get()->groupBy('ip');
        // $data = NetworkMainipPing::where('ip', '10.64.235.250')
        //         ->select('*', DB::raw('DATE(created_at) as date'))
        //         ->orderBy('id', 'desc')
        //         ->take(100)
        //         ->get()
        //         ->groupBy('date');
                

        // $total = $data->count();

        // foreach ($data as $key => $value) { 
        //     echo $key . "<br>"; 
        //     echo $datGroup = $value[0]->ip. "<br>";
        //     echo $datGroup = $value[0]->name. "<br>";

        //     $count = 0;

        //     foreach ($value as $su_bkey => $sub_val) { 

        //         //echo $su_bkey . "<br>"; 
        //         // echo $sub_val['name']. "<br>"; 
        //         // echo $sub_val['ip']. "<br>"; 
        //         //echo date('Y-m-d', strtotime($sub_val->created_at)). "<br>";
        //         echo date('H:i:s A', strtotime($sub_val->created_at)). " -- To -- "; 

        //         $newtimestamp = strtotime($sub_val->created_at.'+ 10 minute');
        //         echo date('H:i:s A', $newtimestamp). "<br><br>"; 

        //         $count++; 
            
        //     }

        //     echo $count. "<br>"; 
        //     $totalOfflineTime = ($count * 10);
        //     if($totalOfflineTime >= 60){
        //         $hours = round($totalOfflineTime/60, 2);
        //         echo "Total Offline : ". $hours. " Hours<br><br>";
        //     }else{
        //         echo "Total Offline : ". $totalOfflineTime. " Minuts <br><br>";
        //     }
            
           
            
        //     echo "<hr>";
        // } 

        // dd($total);



        $ipData = NetworkMainip::where('status', 1)->orderBy('name')->get();

        if(request()->ajax())
        {

            if( !empty(request()->reportType) && !empty(request()->ip) )
            {

                $days = request()->reportType;
                $date = Carbon::today()->subDays($days);

                //$data = NetworkMainipPing::where('created_at', '>=', $date)->where('ip', request()->ip)->get();
                $data = NetworkMainipPing::where('ip', request()->ip)
                ->where('created_at', '>=', $date)
                ->select('*', DB::raw('DATE(created_at) as date'))
                ->orderBy('id', 'desc')
                ->get()
                ->groupBy('date');

               // return DataTables::of($data)->make();

            }
            elseif( !empty(request()->to_date) && !empty(request()->ip) )
            {

                $from_date = date("Y-m-d", strtotime(request()->from_date)) . " ". "00:01:00";
                $to_date   = date("Y-m-d", strtotime(request()->to_date)) . " ". "23:59:59";

                //$data = NetworkMainipPing::whereBetween( 'created_at', [$from_date, $to_date] )->get();

                $data = NetworkMainipPing::where('ip', request()->ip)
                ->whereBetween('created_at', [$from_date, $to_date])
                ->select('*', DB::raw('DATE(created_at) as date'))
                ->orderBy('id', 'desc')
                ->get()
                ->groupBy('date');

            }
            else
            {
                // $sevenDays = Carbon::today()->subDays(7);
                // $data = NetworkMainipPing::where('created_at', '>=', $sevenDays)->get();
                $date = Carbon::today()->subMonth(1);
              
                $data = NetworkMainipPing::where('ip', request()->ip)
                ->where('created_at', '>=', $date)
                ->select('*', DB::raw('DATE(created_at) as date'))
                ->orderBy('id', 'desc')
                ->get()
                ->groupBy('date');
            }


            


            //dd($data);


            return DataTables::of($data)

            ->addColumn('ipData', function($data){
                return $data[0]->ip;
            })

            ->addColumn('ipName', function($data){
                return $data[0]->name;
            })

            ->addColumn('offlineDate', function($data){
                return date('Y-m-d', strtotime($data[0]->created_at));
            })

            ->addColumn('offlineTime', function($data){
                $button = '';
                $count = 0;
                foreach($data as $sub_val){
                    $count++; 
                }

                //$button .= $count ."<br>";

               
                $totalOfflineTime = ($count * 10);
                if($totalOfflineTime >= 60){
                    $hours = round($totalOfflineTime/60, 2);
                        $button .= $hours. " Hours";
                }else{
                        $button .= $totalOfflineTime. " Minuts";
                }

                return $button;
            })

            ->addColumn('offlineDetails', function($data){
                $button = '';
                $count = 0;
                foreach($data as $sub_val){
                    $button .= '( ';
                    $button .= date('h:i A', strtotime($sub_val['created_at'])). " - ";
                    $newtimestamp = strtotime($sub_val['created_at'].'+ 10 minute');
                    $button .= date('h:i A', $newtimestamp);
                    $button .= ' )  ';

                    $count++;
                }

                if($count >= 143){
                    return "Full Day Night Offline<br>";
                }else{
                    return $button;
                }
            })

            ->rawColumns(['ipData', 'ipName', 'offlineDate', 'offlineTime', 'offlineDetails'])
            ->make(true);

        }


        return view('admin.network.reports.main-ip', compact('ipData'));
    }



    //All Data
    public function SubIp(){

        $groupData = NetworkGroupName::orderBy('name')->get();

        if(request()->ajax())
        {
            $group_name = request()->group_name;

            if( !empty(request()->reportType) )
            {

                $days = request()->reportType;
                $date = Carbon::today()->subDays($days);

                if(request()->group_name){
                    $data = NetworkSubipPing::where('group_name', $group_name)->where('created_at', '>=', $date)->latest();
                }else{
                    $data = NetworkSubipPing::where('created_at', '>=', $date)->latest();
                }

            }
            elseif( !empty(request()->to_date) )
            {

                $from_date = request()->from_date;
                $to_date   = request()->to_date;

                if(request()->group_name ){
                    $data = NetworkSubipPing::where('group_name', $group_name)->whereBetween('created_at', [$from_date, $to_date])->latest();
                }else{
                    $data = NetworkSubipPing::whereBetween('created_at', [$from_date, $to_date])->latest();
                }

            }
            else
            {
                if(request()->group_name && request()->totalPing){
                    $data = NetworkSubipPing::where('group_name', $group_name)->orderBy('id', 'desc')->take( request()->totalPing )->get();
                }else{
                    $data = NetworkSubipPing::latest();
                }

            }


            return DataTables::of($data)

            ->addColumn('ipData', function($data){
               return $data->ip;
            })

            ->addColumn('pingTime', function($data){
                return date("F j, Y, g:i a", strtotime($data->created_at));
            })

            ->rawColumns(['ipData', 'pingTime'])
            ->make(true);

        }


        return view('admin.network.reports.sub-ip', compact('groupData'));
    }



    public function test(){
        $date = Carbon::today()->subMonth(1);
        $data = NetworkMainipPing::where('created_at', '>=', $date)->get()->groupBy('ip');
    }




}
