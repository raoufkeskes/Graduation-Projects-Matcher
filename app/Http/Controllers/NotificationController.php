<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Notification;

class NotificationController extends Controller
{

    public function Reset(Request $request)
    {
    	Notification::where([['user_id',$request->user_id],['is_New',1]])->update(['is_New' => 0] );
    	return response()->json(['user_id' => $request->user_id]);

    }

   

}

