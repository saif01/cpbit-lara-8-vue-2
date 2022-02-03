<?php

namespace App\Http\Controllers\Sms\User;
use DB;

trait ReportMak{

    // SmsSalesOrder
    public function SmsSalesOrder($operationCode = null,  $orderDate = null ){

        // $orderDate = '2022-02-01';
        // $operationCode = '11';

        $groupObjData = DB::connection('oracle_db')->table('IT_SMS_SALES_ORDER')
                ->where('OPERATION_CODE', $operationCode)
                ->whereDate('INVOICE_DATE',  $orderDate)
                ->get()
                ->groupBy('CUSTOMER_CODE');

        //dd($groupObjData);

        $finalArray = [];

        foreach($groupObjData as $value){

            //dd($value, $value[0]->SMS_NO );

            $SMS_NO         = $value[0]->SMS_NO;
            $CUSTOMER_CODE  = $value[0]->CUSTOMER_CODE;
            $CUSTOMER_NAME  = $value[0]->CUSTOMER_NAME;

            $inv_date         = date("d-m-Y", strtotime($value[0]->INVOICE_DATE));
            $sum_tot_Price    = 0;
            $sum_tot_quantity = 0;
            $sum_tot_weight   = 0;

            foreach( $value as $row2 ){
                $sum_tot_Price += $row2->AMOUNT;
                $sum_tot_quantity += $row2->QUANTITY;
                $sum_tot_weight += $row2->WEIGHT;
            }


            $inv_tot = '';
            $inv_tot_bng = '';

            foreach( $value as $row ){
                $inv        = $row->INVOICE_NO;
                $ammount    = $row->AMOUNT;
                $inv_tot .= "Inv. ". $inv ." = ". $ammount ." Tk. ";
                //English to bangla
                $inv_bng    = $this->E2B($inv);
                $ammount_bng = $this->E2B($ammount);
                $inv_tot_bng .= $inv_bng ." = ". $ammount_bng." টাকা। ";

            }


            //English to bangla
            $SMS_NO_bng             = $this->E2B($SMS_NO);
            $CUSTOMER_CODE_bng      = $this->E2B($CUSTOMER_CODE);
            $inv_date_bng           = $this->E2B($inv_date);
            $sum_tot_Price_bng      = $this->E2B($sum_tot_Price);
            $sum_tot_quantity_bng   = $this->E2B($sum_tot_quantity);
            $sum_tot_weight_bng     = $this->E2B($sum_tot_weight);

            // //Header SMS
            // $Message  = "Number " .$SMS_NO. PHP_EOL ;
            // $Message .= "Total Order " .$sum_tot_Price. PHP_EOL ;
            // $Message .= "Total Quantity " .$sum_tot_quantity. PHP_EOL ;
            // $Message .= "Total Weight " .$sum_tot_weight. PHP_EOL ;
            // $Message .= "Date " . $inv_date ;




            $finalArray[] = array(

                'SMS_NO'                => $SMS_NO,
                // 'inv_date'              => $inv_date,
                // 'sum_tot_Price'         => $sum_tot_Price,
                // 'inv_tot'               => $inv_tot,
                // 'CUSTOMER_CODE'         => $CUSTOMER_CODE,
                // 'sum_tot_quantity'      => $sum_tot_quantity,
                // 'sum_tot_weight'        => $sum_tot_weight,

                'inv_date_bng'          => $inv_date_bng,
                'sum_tot_Price_bng'     => $sum_tot_Price_bng,
                'inv_bng'               => $inv_tot_bng,
                'CUSTOMER_CODE_bng'     => $CUSTOMER_CODE_bng,
                'CUSTOMER_NAME'         => $CUSTOMER_NAME,

                'sum_tot_quantity_bng'  => $sum_tot_quantity_bng,
                'sum_tot_weight_bng'    => $sum_tot_weight_bng,
                //'message'               => $Message,

            );


        }


        

        //dd($finalArray);

        return $finalArray;

    }


    // SmsSalesPayment
    public function SmsSalesPayment($Code = null,  $Date = null ){

        // $Date = '2022-02-01';
        // $Code = '11';

        $groupObjData = DB::connection('oracle_db')->table('IT_SMS_SALES_PAYMENT')
                ->where('OPERATION_CODE', $Code)
                ->whereDate('RECEIPT_DATE',  $Date)
                ->get()
                ->groupBy('CUSTOMER_CODE');

        //dd($groupObjData);

        $finalArray = [];

        foreach($groupObjData as $value){

            $SMS_NO         = $value[0]->SMS_NO;
            $CUSTOMER_CODE  = $value[0]->CUSTOMER_CODE;
            $CUSTOMER_NAME  = $value[0]->CUSTOMER_NAME;

            $RECEIPT_DATE   = date("d-m-Y", strtotime($value[0]->RECEIPT_DATE));
            $sum_tot_Price  = 0;

            foreach( $value as $row2 ){
                $sum_tot_Price += $row2->AMOUNT;
            }


            $RECEIPT_NO_tot = '';
            $RECEIPT_NO_tot_bng = '';

            foreach( $value as $row ){
                $RECEIPT_NO  = $row->RECEIPT_NO;
                $ammount     = $row->AMOUNT;
                $RECEIPT_NO_tot    .= "RC. ". $RECEIPT_NO ." = ". $ammount ." Tk. " . PHP_EOL ;
                //English to bangla
                $RECEIPT_NO_bng    = $this->E2B($RECEIPT_NO);
                $ammount_bng = $this->E2B($ammount);
                $RECEIPT_NO_tot_bng .= $RECEIPT_NO_bng ." = ". $ammount_bng." টাকা।  " . PHP_EOL ;

            }

            //English to bangla
            $SMS_NO_bng             = $this->E2B($SMS_NO);
            $CUSTOMER_CODE_bng      = $this->E2B($CUSTOMER_CODE);
            $RECEIPT_DATE_bng       = $this->E2B($RECEIPT_DATE);
            $sum_tot_Price_bng      = $this->E2B($sum_tot_Price);

            $finalArray[] = array(

                'SMS_NO'                => $SMS_NO,
                //'RECEIPT_DATE'          => $RECEIPT_DATE,
                //'sum_tot_Price'         => $sum_tot_Price,
                //'RECEIPT_NO_tot'        => $RECEIPT_NO_tot,
                //'CUSTOMER_CODE'         => $CUSTOMER_CODE,


                'RECEIPT_DATE_bng'      => $RECEIPT_DATE_bng,
                'sum_tot_Price_bng'     => $sum_tot_Price_bng,
                'RECEIPT_NO_tot_bng'    => $RECEIPT_NO_tot_bng,
                'CUSTOMER_CODE_bng'     => $CUSTOMER_CODE_bng,
                'CUSTOMER_NAME'         => $CUSTOMER_NAME,


            );


        }


        

        //dd($finalArray);

        return $finalArray;

    }
 





    //English to bangla
    public function E2B($num){
        $bn = array("১", "২", "৩", "৪", "৫", "৬", "৭", "৮", "৯", "০");
        $en = array("1", "2", "3", "4", "5", "6", "7", "8", "9", "0");
        return str_replace($en, $bn, $num);
    }


}