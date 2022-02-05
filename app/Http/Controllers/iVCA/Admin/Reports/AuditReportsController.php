<?php

namespace App\Http\Controllers\iVCA\Admin\Reports;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\iVCA\ivcaAuditMroToken;
use App\Models\iVCA\ivcaAuditMroManufacturer;

use App\Models\iVca\ivcaTemplateMroManufacturer;
use DB;

use App\Http\Controllers\iVCA\Admin\Reports\CommonFunction;

class AuditReportsController extends Controller
{
    use CommonFunction;

    //index 
    public function index(){

        $paginate       = Request('paginate', 10);
        $search         = Request('search', '');
        $sort_direction = Request('sort_direction', 'desc');
        $sort_field     = Request('sort_field', 'id');

        $allData = ivcaAuditMroToken::with(['vendor', 'audits.auditordata'])
                ->whereHas('audits', function($query){
                    $query->where( 'status', '1' ); // role with no admin
                })
                ->orderBy($sort_field, $sort_direction)
                ->search( trim(preg_replace('/\s+/' ,' ', $search)) )
                ->paginate($paginate);
               
        //dd($allData);

        return response()->json($allData, 200);

    }

    // single_audit_data
    public function single_audit_data($id){

        $templateData = ivcaTemplateMroManufacturer::first();
        $auditData = ivcaAuditMroManufacturer::with(['auditordata', 'vendor'])->find($id);

        // dd($templateData); 

        if( $auditData->status == 1 ){

           $singleAuditReport = $this->manufacturerSingleRiport($auditData);

            //dd( $singleAuditReport );
            return response()->json(['singleAuditReport'=>$singleAuditReport, 'templateData'=>$templateData ], 200);

        }else{
            return response()->json(['No Data Available'], 204);
        }

        // return response()->json(['auditData'=>$auditData, 'templateData'=>$templateData ], 200);

    } 

    


    // summary_audit_data
    public function summary_audit_data(Request $request){
        $token = $request->token;

        $allData = ivcaAuditMroManufacturer::with(['vendor', 'auditordata'])
                    ->where('token', $token)
                    ->where('status', 1)
                    ->orderBy('id')
                    ->get();

        // dd($token, $allData, $allData->isEmpty());

        if( ! $allData->isEmpty() ){

            $finalResult = $this->manufacturerSummaryReport($allData);

            return response()->json($finalResult, 200);

        }else{
            return response()->json(['No Data Available'], 204);
        }
        
    }



    



    // pdf_summary_manufacturer

}
