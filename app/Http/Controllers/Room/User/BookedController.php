<?php

namespace App\Http\Controllers\Room\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Room\RoomBooking;
use App\Models\Room\Room;
use Auth;
use Carbon\Carbon;
use App\Http\Controllers\Room\CommonFunctions;


class BookedController extends Controller
{
    use CommonFunctions;

    //data
    public function data(){

        $allData = RoomBooking::with('room')
            ->where('user_id', Auth::user()->id)
            ->where('status', '=', '1')
            ->where('end', '>=', Carbon::now())
            ->orderBy('start', 'asc')
            ->get();
       
       // dd($allData);

        return response()->json($allData, 200);
    }
}
