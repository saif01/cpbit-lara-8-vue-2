<?php

namespace App\Http\Controllers\PBI\Admin\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Carbon\Carbon;
use DB;
use DateTime;

trait StoreController 
{
    // **************** Common Methods **************
    // **************** Common Methods **************
    // **************** Common Methods **************
    // **************** Common Methods **************
    // **************** Common Methods **************
    // **************** Common Methods **************
    // **************** Common Methods **************
    // **************** Common Methods **************
    // **************** Common Methods **************

    public function storeDataByDateTblModel( $start=null, $end=null, $modelName=null, $tblName=null, $oracleField=null, $mysqlField=null){

        // $start = '2022-03-01';
        // $end = '2022-03-12';
      
        $startFm = new DateTime($start);
        $endFm = new DateTime($end);
        $interval = $startFm->diff($endFm);
        $days = $interval->format('%a');
      
        $interval=15;
        
        for ($i=$interval; $i <= $days; $i += $interval) { 
            // check interval
            if($days >= $interval) {
                // Set new End  by adding interval days
                $newend = date('Y-m-d', strtotime($start. '+'.$interval.' day'));
                
                // **************** start oracle to mysql data store **************
                $this->storeCommonByModalTbl($start, $end, $modelName, $tblName, $oracleField, $mysqlField);
                // **************** end oracle to mysql data store **************
                $start = $newend;
            }
        }
        $this->storeCommonByModalTbl($start, $end, $modelName, $tblName, $oracleField, $mysqlField);

        return true;
    }

    public function storeCommonByModalTbl($start=null, $end=null, $modelName=null, $tblName=null, $oracleField=null, $mysqlField=null){

        // Response Form oracle
        $response = DB::connection('oracle_db')->table($tblName)
        ->whereDate($oracleField,'<=', $end)
        ->whereDate($oracleField,'>=', $start)
        ->get();

        if( !empty($response) ){

            $olddata = $modelName::whereDate($mysqlField,'<=', $end)
            ->whereDate($mysqlField,'>=', $start)->delete();

            // Data Insert
            foreach ($response as $obj)  {
                foreach ($obj as $key => $value) {
                    $insertArr[$key] = $value;
                }
                $modelName::create($insertArr);
            }

            return true;
       }

    }


    // **************** Common Methods **************
    // **************** Common Methods **************
    // **************** Common Methods **************
    // **************** Common Methods **************
    // **************** Common Methods **************
    // **************** Common Methods **************
    // **************** Common Methods **************
    // **************** Common Methods **************
    // **************** Common Methods **************


}
