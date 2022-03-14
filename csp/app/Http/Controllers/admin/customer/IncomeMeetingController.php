<?php

namespace App\Http\Controllers\admin\customer;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Meeting;
use Illuminate\Support\Facades\Auth;

class IncomeMeetingController extends Controller
{
    public function index(Request $request)
    {
        $incomeMeetings= Meeting::has("customer")->when(getUserPermission()=="staff",function($q){
            return   $q->where('user_id', Auth::user()->id);
        })
        ->whereDate("date_time",">=",date("Y-m-d"))->orderBy("date_time","desc")->get();

        return view('admin.income-meeting.index', compact("incomeMeetings"));
    }

    public function create(Request $request)
    {
        $customers = Customer::all();
        if(getUserPermission()=="staff"){
            $customers = Customer::where("user_id",$request->user()->id)->get();
        }
        $customer_id = $request->get("customer_id");
       
        return view('admin.income-meeting.create', compact("customers","customer_id"));
    }
}