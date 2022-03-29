<?php

namespace App\Http\Controllers\PBI\Admin\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Http\Controllers\PBI\Admin\API\StoreController;
use Carbon\Carbon;

class IndexController extends Controller
{
    use StoreController;

    //action
    public function action(Request $request){

        // dd($request->all());

        // Validations
        request()->validate([
            'start' => 'required',
            'end' => 'required',
            'type' => 'required',
            'tbl_model' => 'required',
        ]);

        $start      = $request->start;
        $end        = $request->end;
        $type       = $request->type;
        $tbl_model  = $request->tbl_model;


        //***************************************************//
        //***************************************************//
        //********************Start Farm *********************//
        //***************************************************//
        //***************************************************//

        // BI_FARM_AQUA_PURCHASE
        if($tbl_model == 'PbiFarmAquaPurchase'){

            $modelName   = 'App\Models\Pbi\PbiFarmAquaPurchase';
            $tblName     = 'BI_FARM_AQUA_PURCHASE';
            $oracleField = 'PURCHASE_DATE'; 
            $mysqlField  = 'purchase_date';
            
            // Store Data
            if(!empty($start) && !empty($end) && !empty($modelName) && !empty($tblName) && !empty($oracleField) && !empty($mysqlField)){
                $this->storeDataByDateTblModel($start, $end, $modelName, $tblName, $oracleField, $mysqlField );
            }
        }

        // BI_FARM_AQUA_SALES
        elseif($tbl_model == 'PbiFarmAquaSale'){

            $modelName   = 'App\Models\Pbi\PbiFarmAquaSale';
            $tblName     = 'BI_FARM_AQUA_SALES';
            $oracleField = 'SALE_DATE'; 
            $mysqlField  = 'sale_date';
            
            // Store Data
            if(!empty($start) && !empty($end) && !empty($modelName) && !empty($tblName) && !empty($oracleField) && !empty($mysqlField)){
                $this->storeDataByDateTblModel($start, $end, $modelName, $tblName, $oracleField, $mysqlField );
            }
        }

        // BI_FARM_POULTRY_PURCHASE
        elseif($tbl_model == 'PbiFarmPoultryPurchase'){

            $modelName   = 'App\Models\Pbi\PbiFarmPoultryPurchase';
            $tblName     = 'BI_FARM_POULTRY_PURCHASE';
            $oracleField = 'PURCHASE_DATE'; 
            $mysqlField  = 'purchase_date';
            
            // Store Data
            if(!empty($start) && !empty($end) && !empty($modelName) && !empty($tblName) && !empty($oracleField) && !empty($mysqlField)){
                $this->storeDataByDateTblModel($start, $end, $modelName, $tblName, $oracleField, $mysqlField );
            }
        }

        // BI_FARM_POULTRY_SALES
        elseif($tbl_model == 'PbiFarmPoultrySale'){

            $modelName   = 'App\Models\Pbi\PbiFarmPoultrySale';
            $tblName     = 'BI_FARM_POULTRY_SALES';
            $oracleField = 'SALE_DATE'; 
            $mysqlField  = 'sale_date';
            
            // Store Data
            if(!empty($start) && !empty($end) && !empty($modelName) && !empty($tblName) && !empty($oracleField) && !empty($mysqlField)){
                $this->storeDataByDateTblModel($start, $end, $modelName, $tblName, $oracleField, $mysqlField );
            }
        }

        //***************************************************//
        //***************************************************//
        //********************End Farm *********************//
        //***************************************************//
        //***************************************************//


        



        //***************************************************//
        //***************************************************//
        //********************Start Food *********************//
        //***************************************************//
        //***************************************************//

        // BI_FOOD_FURTHER_SALES
        elseif($tbl_model == 'PbiFoodFurtherSale'){

            $modelName   = 'App\Models\Pbi\PbiFoodFurtherSale';
            $tblName     = 'BI_FOOD_FURTHER_SALES';
            $oracleField = 'SALE_DATE'; 
            $mysqlField  = 'sale_date';
            
            // Store Data
            if(!empty($start) && !empty($end) && !empty($modelName) && !empty($tblName) && !empty($oracleField) && !empty($mysqlField)){
                $this->storeDataByDateTblModel($start, $end, $modelName, $tblName, $oracleField, $mysqlField );
            }
        }

        // BI_FOOD_SLAUGHTER_SALES
        elseif($tbl_model == 'PbiFoodSlaughterSale'){

            $modelName   = 'App\Models\Pbi\PbiFoodSlaughterSale';
            $tblName     = 'BI_FOOD_SLAUGHTER_SALES';
            $oracleField = 'SALE_DATE'; 
            $mysqlField  = 'sale_date';
            
            // Store Data
            if(!empty($start) && !empty($end) && !empty($modelName) && !empty($tblName) && !empty($oracleField) && !empty($mysqlField)){
                $this->storeDataByDateTblModel($start, $end, $modelName, $tblName, $oracleField, $mysqlField );
            }
        }

        //***************************************************//
        //***************************************************//
        //********************Start Food *********************//
        //***************************************************//
        //***************************************************//




        //***************************************************//
        //***************************************************//
        //********************Start Feed *********************//
        //***************************************************//
        //***************************************************//

        // BI_FEED_PRODUCTION
        elseif($tbl_model == 'PbiFeedProduction'){

            $modelName   = 'App\Models\Pbi\PbiFeedProduction';
            $tblName = 'BI_FEED_PRODUCTION';
            $oracleField = 'PRODUCTION_DATE'; 
            $mysqlField  = 'production_date';
            
            // Store Data
            if(!empty($start) && !empty($end) && !empty($modelName) && !empty($tblName) && !empty($oracleField) && !empty($mysqlField)){
                $this->storeDataByDateTblModel($start, $end, $modelName, $tblName, $oracleField, $mysqlField );
            }
        }

        // BI_FEED_PURCHASE
        elseif($tbl_model == 'PbiFeedPurchase'){

            $modelName   = 'App\Models\Pbi\PbiFeedPurchase';
            $tblName     = 'BI_FEED_PURCHASE';
            $oracleField = 'PURCHASE_DATE'; 
            $mysqlField  = 'purchase_date';
            
            // Store Data
            if(!empty($start) && !empty($end) && !empty($modelName) && !empty($tblName) && !empty($oracleField) && !empty($mysqlField)){
                $this->storeDataByDateTblModel($start, $end, $modelName, $tblName, $oracleField, $mysqlField );
            }
        }

        // BI_FEED_SALES
        elseif($tbl_model == 'PbiFeedSale'){

            $modelName   = 'App\Models\Pbi\PbiFeedSale';
            $tblName     = 'BI_FEED_SALES';
            $oracleField = 'SALE_DATE'; 
            $mysqlField  = 'sale_date';
            
            // Store Data
            if(!empty($start) && !empty($end) && !empty($modelName) && !empty($tblName) && !empty($oracleField) && !empty($mysqlField)){
                $this->storeDataByDateTblModel($start, $end, $modelName, $tblName, $oracleField, $mysqlField );
            }
        }

        //***************************************************//
        //***************************************************//
        //********************End Feed *********************//
        //***************************************************//
        //***************************************************//
        




        //***************************************************//
        //***************************************************//
        //********************End Expense *********************//
        //***************************************************//
        //***************************************************//
        
        // BI_EXPENSE
        elseif($tbl_model == 'PbiExpense'){

            $modelName   = 'App\Models\Pbi\PbiExpense';
            $tblName     = 'BI_EXPENSE';
            $oracleField = 'EXPENSE_DATE'; 
            $mysqlField  = 'expense_date';
            
            // Store Data
            if(!empty($start) && !empty($end) && !empty($modelName) && !empty($tblName) && !empty($oracleField) && !empty($mysqlField)){
                $this->storeDataByDateTblModel($start, $end, $modelName, $tblName, $oracleField, $mysqlField );
            }
        }
        
        //***************************************************//
        //***************************************************//
        //********************End Feed *********************//
        //***************************************************//
        //***************************************************//
        
        else{
            $tblName = '';
            $msg = 'Sorry !! Somthing going wrong <br>'.$start. ' to '. $end;
        }

        
        $msg = $tblName.' Data Refreshed Successfully <br>'.$start. ' to '. $end;
        return response()->json(['tblName'=>$tblName, 'msg'=>$msg, 'icon'=>'success'], 200);

    }


    // storeFarmAquaSales
    public function storeFarmAquaSales(){

        // dd('okkk');

        $days = $this->daysFarmAquaSales;
        $start = $this->startFarmAquaSales;
        $end = $this->endFarmAquaSales;

        $modelName   = 'App\Models\Pbi\BiFoodFurtherSale';
        $tblName     = 'BI_FARM_AQUA_SALES';
        $oracleField = 'SALE_DATE'; 
        $mysqlField  = 'sale_date';


        if(!empty($days)){
            // Back form now 
            $start = date('Y-m-d', strtotime(date('Y-m-d'). '-'.$days.' day'));
            $end = date('Y-m-d');
            // Store Data
            if(!empty($start) && !empty($end) && !empty($modelName) && !empty($tblName) && !empty($oracleField) && !empty($mysqlField)){
                    $this->storeDataByDateTblModel($start, $end, $modelName, $tblName, $oracleField, $mysqlField );
                }
            
            //Success Notifications
            $this->dispatchBrowserEvent('notifications', ['icon' => 'success',
            'message' => 'Last '.$days.' Days Data inserted Successfully']);
            return;
        }
        elseif( !empty($start) && !empty($end) ){
            // Start and end by date
            if( strtotime($start) > strtotime($end) ){
                //return 'Error date !! start: '. $start . ' ,End: '. $end;
                $this->dispatchBrowserEvent('notifications', ['icon' => 'error',
                'message' => 'Error date !! start: '. $start . ' ,End: '. $end]);
                return;
            }

            // Store Data
            if(!empty($start) && !empty($end) && !empty($modelName) && !empty($tblName) && !empty($oracleField) && !empty($mysqlField)){
                $this->storeDataByDateTblModel($start, $end, $modelName, $tblName, $oracleField, $mysqlField );
            }
            
            //Success Notifications
            $this->dispatchBrowserEvent('notifications', ['icon' => 'success',
            'message' => 'Data Refreshed Successfully <br>'.$start. ' to '. $end]);
            return;
        }else{
            // Error Notifications
            $this->dispatchBrowserEvent('notifications', ['icon' => 'error',
            'message' => 'Sorry!! Try again']);
            return;
        }

 
         
    }



}
