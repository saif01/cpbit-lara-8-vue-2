<?php

namespace App\Http\Controllers\iVCA\Admin\Reports;


trait CommonFunction
{


    // manufacturer Summary Report
    public function manufacturerSummaryReport($allData = null){

        if( $allData != null ){

            //    storage
            $storage_result = $this->avgResultCalculation($allData, $fieldName ="storage", $numberOfItem = 4, $maxValuePerQs = 4); 

            $production_qs_result = $this->avgResultCalculation($allData, $fieldName ="production_qs", $numberOfItem = 4, $maxValuePerQs = 4); 
            // safety
            $safety_result = $this->avgResultCalculation($allData, $fieldName ="safety", $numberOfItem = 4, $maxValuePerQs = 4); 

            // env_sur_con
            $env_sur_con_result = $this->avgResultCalculation($allData, $fieldName ="env_sur_con", $numberOfItem = 4, $maxValuePerQs = 4); 

                //equipment
            $equipment_result = $this->avgResultCalculation($allData, $fieldName ="equipment", $numberOfItem = 3, $maxValuePerQs = 4);

            //cooperate
            $cooperate_result = $this->avgResultCalculation($allData, $fieldName ="cooperate", $numberOfItem = 3, $maxValuePerQs = 4); 


            // dd($storage_result, $production_qs_result, $safety_result,  $env_sur_con_result, $equipment_result , $cooperate_result);

            // Sum of all section max value
            $totalmaxSectionValue  = $storage_result->maxSectionValue +
                                    $production_qs_result->maxSectionValue +
                                    $safety_result->maxSectionValue +
                                    $env_sur_con_result->maxSectionValue +
                                    $equipment_result->maxSectionValue +
                                    $cooperate_result->maxSectionValue ;


            // Sum of all section actual value
            $totalavgActualvalue  = $storage_result->avgActualvalue +
                                    $production_qs_result->avgActualvalue +
                                    $safety_result->avgActualvalue +
                                    $env_sur_con_result->avgActualvalue +
                                    $equipment_result->avgActualvalue +
                                    $cooperate_result->avgActualvalue ;
                                    
            // Avg value of all section
            $totalavgPercentagevalue  = ( 100 * $totalavgActualvalue ) / $totalmaxSectionValue;
            $totalavgPercentagevalue = (float)number_format($totalavgPercentagevalue, 4, '.', '');

            return [
                'allData'=>$allData,
                'storage_result'=>$storage_result,
                'production_qs_result'=>$production_qs_result,
                'safety_result'=>$safety_result,
                'env_sur_con_result'=>$env_sur_con_result,
                'equipment_result'=>$equipment_result,
                'cooperate_result'=>$cooperate_result,
                'totalmaxSectionValue'=>$totalmaxSectionValue,
                'totalavgActualvalue'=>$totalavgActualvalue,
                'totalavgPercentagevalue'=>$totalavgPercentagevalue,
            ];

           

        }else{

            return [
                'allData'=>'',
                'storage_result'=>'',
                'production_qs_result'=>'',
                'safety_result'=>'',
                'env_sur_con_result'=>'',
                'equipment_result'=>'',
                'cooperate_result'=>'',
                'totalmaxSectionValue'=>'',
                'totalavgActualvalue'=>'',
                'totalavgPercentagevalue'=>'',
            ];

             

        }
    }

    // manufacturer Single Report
    public function manufacturerSingleRiport($auditData = null){

        if( $auditData ){
            
            // storage
            $storageSection = $this->sumOfSectionByFieldName($auditData, $fieldName ="storage", $numberOfItem=4, $maxValuePerQs=4);

            // production_qs
            $production_qsSection = $this->sumOfSectionByFieldName($auditData, $fieldName ="production_qs", $numberOfItem=4, $maxValuePerQs=4);

            // safety
            $safetySection = $this->sumOfSectionByFieldName($auditData, $fieldName ="safety", $numberOfItem=4, $maxValuePerQs=4);

            // env_sur_con
            $env_sur_conSection = $this->sumOfSectionByFieldName($auditData, $fieldName ="env_sur_con", $numberOfItem=4, $maxValuePerQs=4);

            // equipment
            $equipmentSection = $this->sumOfSectionByFieldName($auditData, $fieldName ="equipment", $numberOfItem=3, $maxValuePerQs=4);

            // cooperate
            $cooperateSection = $this->sumOfSectionByFieldName($auditData, $fieldName ="cooperate", $numberOfItem=3, $maxValuePerQs=4);

            // All sections sum of actual values
            $sumOfSectionActualVal =   $storageSection->totalActualVal + 
                                $production_qsSection->totalActualVal +
                                $safetySection->totalActualVal +
                                $env_sur_conSection->totalActualVal +
                                $equipmentSection->totalActualVal +
                                $cooperateSection->totalActualVal;


            // All sections sum of actual values
            $sumOfSectionMaxVal =      $storageSection->totalMaxVal + 
                                $production_qsSection->totalMaxVal +
                                $safetySection->totalMaxVal +
                                $env_sur_conSection->totalMaxVal +
                                $equipmentSection->totalMaxVal +
                                $cooperateSection->totalMaxVal;

            $avgSectionPercentageVal = ( $sumOfSectionActualVal * 100 ) / $sumOfSectionMaxVal;
            $avgSectionPercentageVal = (float)number_format($avgSectionPercentageVal, 4, '.', '');

            return (object) [
                'auditData'                  => $auditData,
                'storageSection'             => $storageSection,
                'production_qsSection'       => $production_qsSection, 
                'safetySection'              => $safetySection, 
                'env_sur_conSection'         => $env_sur_conSection, 
                'equipmentSection'           => $equipmentSection, 
                'cooperateSection'           => $cooperateSection,
                'sumOfSectionMaxVal'         => $sumOfSectionMaxVal,
                'sumOfSectionActualVal'      => $sumOfSectionActualVal,
                'avgSectionPercentageVal'    => $avgSectionPercentageVal,  
            ];


        }else{

            return (object) [
                'auditData'                  => '',
                'storageSection'             => '',
                'production_qsSection'       => '', 
                'safetySection'              => '', 
                'env_sur_conSection'         => '', 
                'equipmentSection'           => '', 
                'cooperateSection'           => '',
                'sumOfSectionMaxVal'         => '',
                'sumOfSectionActualVal'      => '',
                'avgSectionPercentageVal'    => '',  
            ];
        }
        
    }







    // importerSummaryReport
    public function importerSummaryReport($allData = null){

        if( $allData != null ){

            //    storage
            $storage_result = $this->avgResultCalculation($allData, $fieldName ="storage", $numberOfItem = 4, $maxValuePerQs = 4); 

            $production_qs_result = $this->avgResultCalculation($allData, $fieldName ="production_qs", $numberOfItem = 4, $maxValuePerQs = 4); 
            // safety
            $safety_result = $this->avgResultCalculation($allData, $fieldName ="safety", $numberOfItem = 4, $maxValuePerQs = 4); 

            // env_sur_con
            $env_sur_con_result = $this->avgResultCalculation($allData, $fieldName ="env_sur_con", $numberOfItem = 4, $maxValuePerQs = 4); 

            //cooperate
            $cooperate_result = $this->avgResultCalculation($allData, $fieldName ="cooperate", $numberOfItem = 3, $maxValuePerQs = 4); 


            // dd($storage_result, $production_qs_result, $safety_result,  $env_sur_con_result, $equipment_result , $cooperate_result);

            // Sum of all section max value
            $totalmaxSectionValue  = $storage_result->maxSectionValue +
                                    $production_qs_result->maxSectionValue +
                                    $safety_result->maxSectionValue +
                                    $env_sur_con_result->maxSectionValue +
                                    $cooperate_result->maxSectionValue ;


            // Sum of all section actual value
            $totalavgActualvalue  = $storage_result->avgActualvalue +
                                    $production_qs_result->avgActualvalue +
                                    $safety_result->avgActualvalue +
                                    $env_sur_con_result->avgActualvalue +
                                    $cooperate_result->avgActualvalue ;
                                    
            // Avg value of all section
            $totalavgPercentagevalue  = ( 100 * $totalavgActualvalue ) / $totalmaxSectionValue;
            $totalavgPercentagevalue = (float)number_format($totalavgPercentagevalue, 4, '.', '');

            return [
                'allData'=>$allData,
                'storage_result'=>$storage_result,
                'production_qs_result'=>$production_qs_result,
                'safety_result'=>$safety_result,
                'env_sur_con_result'=>$env_sur_con_result,
                'cooperate_result'=>$cooperate_result,
                'totalmaxSectionValue'=>$totalmaxSectionValue,
                'totalavgActualvalue'=>$totalavgActualvalue,
                'totalavgPercentagevalue'=>$totalavgPercentagevalue,
            ];

           

        }else{

            return [
                'allData'=>'',
                'storage_result'=>'',
                'production_qs_result'=>'',
                'safety_result'=>'',
                'env_sur_con_result'=>'',
                'cooperate_result'=>'',
                'totalmaxSectionValue'=>'',
                'totalavgActualvalue'=>'',
                'totalavgPercentagevalue'=>'',
            ];

             

        }
    }


    // importerSingleRiport
    public function importerSingleRiport($auditData = null){

        if( $auditData ){
            
            // storage
            $storageSection = $this->sumOfSectionByFieldName($auditData, $fieldName ="storage", $numberOfItem=4, $maxValuePerQs=4);

            // production_qs
            $production_qsSection = $this->sumOfSectionByFieldName($auditData, $fieldName ="production_qs", $numberOfItem=4, $maxValuePerQs=4);

            // safety
            $safetySection = $this->sumOfSectionByFieldName($auditData, $fieldName ="safety", $numberOfItem=4, $maxValuePerQs=4);

            // env_sur_con
            $env_sur_conSection = $this->sumOfSectionByFieldName($auditData, $fieldName ="env_sur_con", $numberOfItem=4, $maxValuePerQs=4);

            // cooperate
            $cooperateSection = $this->sumOfSectionByFieldName($auditData, $fieldName ="cooperate", $numberOfItem=3, $maxValuePerQs=4);

            // All sections sum of actual values
            $sumOfSectionActualVal =   $storageSection->totalActualVal + 
                                $production_qsSection->totalActualVal +
                                $safetySection->totalActualVal +
                                $env_sur_conSection->totalActualVal +
                                $cooperateSection->totalActualVal;


            // All sections sum of actual values
            $sumOfSectionMaxVal =      $storageSection->totalMaxVal + 
                                $production_qsSection->totalMaxVal +
                                $safetySection->totalMaxVal +
                                $env_sur_conSection->totalMaxVal +
                                $cooperateSection->totalMaxVal;

            $avgSectionPercentageVal = ( $sumOfSectionActualVal * 100 ) / $sumOfSectionMaxVal;
            $avgSectionPercentageVal = (float)number_format($avgSectionPercentageVal, 4, '.', '');

            return (object) [
                'auditData'                  => $auditData,
                'storageSection'             => $storageSection,
                'production_qsSection'       => $production_qsSection, 
                'safetySection'              => $safetySection, 
                'env_sur_conSection'         => $env_sur_conSection, 
                'cooperateSection'           => $cooperateSection,
                'sumOfSectionMaxVal'         => $sumOfSectionMaxVal,
                'sumOfSectionActualVal'      => $sumOfSectionActualVal,
                'avgSectionPercentageVal'    => $avgSectionPercentageVal,  
            ];


        }else{

            return (object) [
                'auditData'                  => '',
                'storageSection'             => '',
                'production_qsSection'       => '', 
                'safetySection'              => '', 
                'env_sur_conSection'         => '', 
                'cooperateSection'           => '',
                'sumOfSectionMaxVal'         => '',
                'sumOfSectionActualVal'      => '',
                'avgSectionPercentageVal'    => '',  
            ];
        }
        
    }


    // retailerSummaryReport
    public function retailerSummaryReport($allData = null){

        if( $allData != null ){

            //    storage
            $storage_result = $this->avgResultCalculation($allData, $fieldName ="storage", $numberOfItem = 4, $maxValuePerQs = 4); 

            $production_qs_result = $this->avgResultCalculation($allData, $fieldName ="production_qs", $numberOfItem = 4, $maxValuePerQs = 4); 
            // safety
            $safety_result = $this->avgResultCalculation($allData, $fieldName ="safety", $numberOfItem = 4, $maxValuePerQs = 4); 

            // env_sur_con
            $env_sur_con_result = $this->avgResultCalculation($allData, $fieldName ="env_sur_con", $numberOfItem = 4, $maxValuePerQs = 4); 

            //cooperate
            $cooperate_result = $this->avgResultCalculation($allData, $fieldName ="cooperate", $numberOfItem = 3, $maxValuePerQs = 4); 


            // dd($storage_result, $production_qs_result, $safety_result,  $env_sur_con_result, $equipment_result , $cooperate_result);

            // Sum of all section max value
            $totalmaxSectionValue  = $storage_result->maxSectionValue +
                                    $production_qs_result->maxSectionValue +
                                    $safety_result->maxSectionValue +
                                    $env_sur_con_result->maxSectionValue +
                                    $cooperate_result->maxSectionValue ;


            // Sum of all section actual value
            $totalavgActualvalue  = $storage_result->avgActualvalue +
                                    $production_qs_result->avgActualvalue +
                                    $safety_result->avgActualvalue +
                                    $env_sur_con_result->avgActualvalue +
                                    $cooperate_result->avgActualvalue ;
                                    
            // Avg value of all section
            $totalavgPercentagevalue  = ( 100 * $totalavgActualvalue ) / $totalmaxSectionValue;
            $totalavgPercentagevalue = (float)number_format($totalavgPercentagevalue, 4, '.', '');

            return [
                'allData'=>$allData,
                'storage_result'=>$storage_result,
                'production_qs_result'=>$production_qs_result,
                'safety_result'=>$safety_result,
                'env_sur_con_result'=>$env_sur_con_result,
                'cooperate_result'=>$cooperate_result,
                'totalmaxSectionValue'=>$totalmaxSectionValue,
                'totalavgActualvalue'=>$totalavgActualvalue,
                'totalavgPercentagevalue'=>$totalavgPercentagevalue,
            ];

           

        }else{

            return [
                'allData'=>'',
                'storage_result'=>'',
                'production_qs_result'=>'',
                'safety_result'=>'',
                'env_sur_con_result'=>'',
                'cooperate_result'=>'',
                'totalmaxSectionValue'=>'',
                'totalavgActualvalue'=>'',
                'totalavgPercentagevalue'=>'',
            ];

             

        }
    }


    // retailerSingleRiport
    public function retailerSingleRiport($auditData = null){

        if( $auditData ){
            
            // storage
            $storageSection = $this->sumOfSectionByFieldName($auditData, $fieldName ="storage", $numberOfItem=4, $maxValuePerQs=4);

            // production_qs
            $production_qsSection = $this->sumOfSectionByFieldName($auditData, $fieldName ="production_qs", $numberOfItem=4, $maxValuePerQs=4);

            // safety
            $safetySection = $this->sumOfSectionByFieldName($auditData, $fieldName ="safety", $numberOfItem=4, $maxValuePerQs=4);

            // env_sur_con
            $env_sur_conSection = $this->sumOfSectionByFieldName($auditData, $fieldName ="env_sur_con", $numberOfItem=4, $maxValuePerQs=4);

            // cooperate
            $cooperateSection = $this->sumOfSectionByFieldName($auditData, $fieldName ="cooperate", $numberOfItem=3, $maxValuePerQs=4);

            // All sections sum of actual values
            $sumOfSectionActualVal =   $storageSection->totalActualVal + 
                                $production_qsSection->totalActualVal +
                                $safetySection->totalActualVal +
                                $env_sur_conSection->totalActualVal +
                                $cooperateSection->totalActualVal;


            // All sections sum of actual values
            $sumOfSectionMaxVal =      $storageSection->totalMaxVal + 
                                $production_qsSection->totalMaxVal +
                                $safetySection->totalMaxVal +
                                $env_sur_conSection->totalMaxVal +
                                $cooperateSection->totalMaxVal;

            $avgSectionPercentageVal = ( $sumOfSectionActualVal * 100 ) / $sumOfSectionMaxVal;
            $avgSectionPercentageVal = (float)number_format($avgSectionPercentageVal, 4, '.', '');

            return (object) [
                'auditData'                  => $auditData,
                'storageSection'             => $storageSection,
                'production_qsSection'       => $production_qsSection, 
                'safetySection'              => $safetySection, 
                'env_sur_conSection'         => $env_sur_conSection, 
                'cooperateSection'           => $cooperateSection,
                'sumOfSectionMaxVal'         => $sumOfSectionMaxVal,
                'sumOfSectionActualVal'      => $sumOfSectionActualVal,
                'avgSectionPercentageVal'    => $avgSectionPercentageVal,  
            ];


        }else{

            return (object) [
                'auditData'                  => '',
                'storageSection'             => '',
                'production_qsSection'       => '', 
                'safetySection'              => '', 
                'env_sur_conSection'         => '', 
                'cooperateSection'           => '',
                'sumOfSectionMaxVal'         => '',
                'sumOfSectionActualVal'      => '',
                'avgSectionPercentageVal'    => '',  
            ];
        }
        
    }








    // Average calculation for summary 
    public function avgResultCalculation( $allData, $fieldName, $numberOfItem=4, $maxValuePerQs=4 ){

        for($i=1; $i <= $numberOfItem; $i++){
            ${"total_".$fieldName."_".$i} = 0;
        }

        // ${"total_".$fieldName."_1"} = 0;
        // ${"total_".$fieldName."_2"} = 0;
        // ${"total_".$fieldName."_3"} = 0;
        // ${"total_".$fieldName."_4"} = 0;

        foreach( $allData as $item ){

            for($i=1; $i <= $numberOfItem; $i++){
                ${"total_".$fieldName."_".$i} += $item->{$fieldName."_".$i};
            }
            // ${"total_".$fieldName."_1"} += $item->{$fieldName."_1"};
            // ${"total_".$fieldName."_2"} += $item->{$fieldName."_2"};
            // ${"total_".$fieldName."_3"} += $item->{$fieldName."_3"};
            // ${"total_".$fieldName."_4"} += $item->{$fieldName."_4"};

        }
        
        //total audit count
        $totalAudit = $allData->count();

        // Sum of actual value
        $sum_of_actual_value = 0;
        for($i=1; $i <= $numberOfItem; $i++){
            $sum_of_actual_value += ${"total_".$fieldName."_".$i};
        }
        // Sum of
        // $sum_of_actual_value = ${"total_".$fieldName."_1"} + 
        //                      ${"total_".$fieldName."_2"} + 
        //                      ${"total_".$fieldName."_3"} + 
        //                      ${"total_".$fieldName."_4"} ;

        // max value per section
        $maxSectionValue = $numberOfItem * $maxValuePerQs;

        // Avg Actule Value per section                    
        $rawAvgActualvalue = $sum_of_actual_value/ $totalAudit;
        $avgActualvalue = (float)number_format($rawAvgActualvalue, 4, '.', '');

        $total_max_value = $numberOfItem * $maxValuePerQs * $totalAudit;
        // percentage calculation
        $rawResult = ( $sum_of_actual_value * 100 ) / $total_max_value;
        // covertion with last 4 digit
        $percentageResult = (float)number_format($rawResult, 4, '.', '');

        return (object) ['percentageResult'=> $percentageResult, 'avgActualvalue'=> $avgActualvalue, 'maxSectionValue'=> $maxSectionValue];
    }

    // For Single Audit 
    public function sumOfSectionByFieldName($auditData, $fieldName=null, $numberOfItem=4, $maxValuePerQs=4){

        // Total sum of max section value
        $totalMaxVal = $numberOfItem * $maxValuePerQs;

        // Total sum of actual section value
        $totalActualVal = 0;
        for($i=1; $i <= $numberOfItem; $i++){
            $totalActualVal += $auditData->{$fieldName."_".$i};
        }

        // Average section value
        $avgSectionVal = ( $totalActualVal * 100 ) / $totalMaxVal;
        $avgSectionVal = (float)number_format($avgSectionVal, 4, '.', '');

        return (object) ['totalMaxVal'=> $totalMaxVal, 'totalActualVal'=> $totalActualVal, 'avgSectionVal'=> $avgSectionVal];

    }
}
