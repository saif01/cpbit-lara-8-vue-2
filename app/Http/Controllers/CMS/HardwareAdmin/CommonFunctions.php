<?php

namespace App\Http\Controllers\CMS\HardwareAdmin;

use App\Models\Cms\Hardware\HardwareSubcategory;
use App\Models\Cms\Hardware\HardwareCategory;

trait CommonFunctions {


    public static function checksubCat($cat, $name){
        $data = HardwareSubcategory::where('cat_id', $cat)->where('name',$name)->count();


        if($data > 0){
            return true;
        }else{
            return false;
        }

    }


}
