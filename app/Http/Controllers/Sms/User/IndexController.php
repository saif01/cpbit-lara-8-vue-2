<?php

namespace App\Http\Controllers\Sms\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Auth;
use App\Models\Sms\SmsOperation;

use App\Exports\SalesSMS;
use App\Exports\PaymentSMS;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Controllers\Sms\User\ReportMake;

use DB;

use App\Http\Controllers\Sms\User\ReportMak;

class IndexController extends Controller
{
    use ReportMak;

    //index
    public function index(){
        $roles = Auth::user()->roles->pluck('name');
        // $ivcaData = Auth::user()->ivca_roles->pluck('name');
        // // Merge collections
        // $roles = $roleData->merge($ivcaData);
        return view('sms.user.index', compact('roles'));
    }


    // operations
    public function operations(){
       
        $data = Auth::user()->sms_roles()->select('name', 'code')->get()->toArray();
        //dd( $data);
        return response()->json($data);
 
    }

    //Report Download
    public function report_download2(Request $request){

        //dd( Request('code'), Request('type'), Request('date'), $request->all());

        $date = Request('date');
        $code = Request('code');
        $type = Request('type');

        // Convert Date
        $date = date_create($date);
        $date = date_format($date, 'd/m/Y');

        

        $opName = SmsOperation::where('code', '=', $code)->select('name') ->first();
        $operationName = $opName->name;

        $Object = new ReportMake();

        if($type == 'Sales_Order'){


            $allData = $Object->SMS_Sales_Order_Raw_Data($date, $code);
            if(!empty($allData)){

                if(isset($allData['error'])){
                    return back()->with([
                        'icon' => 'error',
                        'errors' => 'Sorry!! API Problem'
                       ]);
                }else{

                        $fieldName = 'CUSTOMER_CODE';
                        $groupData = $Object->GroupByFielsName($allData, $fieldName);
                        //data short by rec. asc
                        usort($groupData, function ($item1, $item2) {
                            return $item1[0]['INVOICE_NO'] <=> $item2[0]['INVOICE_NO'];
                        });
                        $groupObjData = (object) $groupData;
                        //INV SMS Format Data
                        $invSmsFormatData = $Object->Sale_Order_Sms_Excel_Format($groupObjData);

                        $Namedate=str_replace("/","_", $date);
                        $fileName ="Sales Order SMS - ".$operationName . " (".$Namedate.")".".xlsx";

                        return Excel::download(new SalesSMS($invSmsFormatData), $fileName);

                }
            }
            else{
                //If Data Empty
                return back()->with([
                    'icon' => 'error',
                    'errors' => 'Sorry!! No Data Available'
                ]);

            }

        }
        elseif($type == 'Sales_Payment')
        {

            $allData = $Object->SMS_Sales_Payment_Raw_Data($date, $code);
            if(!empty($allData)){

                if(isset($allData['error'])){
                    return back()->with([
                        'icon' => 'error',
                        'errors' => 'Sorry!! API Problem'
                       ]);
                }else{

                    $fieldName = 'CUSTOMER_CODE';
                    $groupData = $Object->GroupByFielsName($allData, $fieldName);
                    //data short by rec. asc
                    usort($groupData, function ($item1, $item2) {
                        return $item1[0]['RECEIPT_NO'] <=> $item2[0]['RECEIPT_NO'];
                    });
                    $groupObjData = (object) $groupData;

                    $invSmsFormatData = $Object->Sale_Payment_Sms_Excel_Format($groupObjData);

                    $Namedate=str_replace("/","_", $date);

                    //Formate Of Download Reports
                    //csv, xlsx, xls,
                    $fileName ="Sales Payment SMS - ".$operationName . " (".$Namedate.")".".xlsx";

                    return Excel::download(new PaymentSMS($invSmsFormatData),  $fileName);
                }

            }
            else{
               //If Data Empty
               return back()->with([
                'icon' => 'error',
                'errors' => 'Sorry!! No Data Available'
               ]);
            }

        }else{
            //return "Error 404";
            return back()->with([
                'icon' => 'error',
                'errors' => 'Sorry!! Somthing Going Wrong'
            ]);
        }



    }

    public function report_download(){
        $date = Request('date');
        $code = Request('code');
        $type = Request('type');

        if($type == 'Sales_Order'){

            $data = $this->SmsSalesPayment($code, $date);
            // return Excel::download(new SalesSMS($invSmsFormatData), $fileName);
            return Excel::download(new SalesSMS($data), 'sales.xlsx');

        }
        elseif($type == 'Sales_Payment'){

            $data = $this->SmsSalesPayment($code, $date);
            // return Excel::download(new SalesSMS($invSmsFormatData), $fileName);
            return Excel::download(new PaymentSMS($data), 'payment.xlsx');

        }
        else{

            return response()->json('Error', 500);

        }



    }



    // test
    public function test(){

        $Code = '11';
        $Date = '2022-02-01';

        // $data =  $this->SmsSalesOrder();
        // $data =  $this->SmsSalesOrder( $Code, $Date );

        $data = $this->SmsSalesPayment($Code, $Date);
        dd( $data );

       

        return $response;
    }




   


}
