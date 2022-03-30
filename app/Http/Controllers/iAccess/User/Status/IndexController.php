<?php

namespace App\Http\Controllers\iAccess\User\Status;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Email\ScheduleEmailIaccessEmailReq;
use App\Models\Email\ScheduleEmailIaccessInternetReq;
use App\Models\Email\ScheduleEmailIaccessAccountReq;
use App\Models\Email\ScheduleEmailIaccessGuestReq;

use Auth;

class IndexController extends Controller
{
    public function index(){
        $paginate       = Request('paginate', 10);
        $search         = Request('search', '');
        $sort_direction = Request('sort_direction', 'desc');
        $sort_field     = Request('sort_field', 'id');

        $allData = ScheduleEmailIaccessEmailReq::where('created_by',Auth::user()->id)
            ->orderBy($sort_field, $sort_direction)
            ->search( trim(preg_replace('/\s+/' ,' ', $search)) )
            ->get()
            ->toArray();

        $allData2 = ScheduleEmailIaccessInternetReq::where('created_by',Auth::user()->id)
            ->orderBy($sort_field, $sort_direction)
            ->search( trim(preg_replace('/\s+/' ,' ', $search)) )
            ->get()
            ->toArray();

        $allData3 = ScheduleEmailIaccessAccountReq::where('created_by',Auth::user()->id)
            ->orderBy($sort_field, $sort_direction)
            ->search( trim(preg_replace('/\s+/' ,' ', $search)) )
            ->get()
            ->toArray();

        $allData4 = ScheduleEmailIaccessGuestReq::where('created_by',Auth::user()->id)
            ->orderBy($sort_field, $sort_direction)
            ->search( trim(preg_replace('/\s+/' ,' ', $search)) )
            ->get()
            ->toArray();


        return response()->json(['emailRequest'=>$allData, 'internetRequest'=>$allData2, 'accountRequest'=>$allData3, 'guestRequest'=>$allData4, 200]);
    }
}
