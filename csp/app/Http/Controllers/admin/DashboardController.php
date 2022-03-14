<?php

namespace App\Http\Controllers\admin;

use App\Models\User;
use App\Models\Branch;
use Illuminate\Http\Request;
use App\Models\IncomeMeeting;
use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Meeting;
use App\Models\Project;
use App\Models\Sale;
use App\Models\Transaction;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $currentUser = $request->user();

        $sumOrange = Transaction::Orange()->sum("amount");
        $sumTelma = Transaction::Telma()->sum("amount");
        $sumAirtel = Transaction::Airtel()->sum("amount");

        $transactions = Transaction::orderBy("added_at", "desc")->orderBy("time", "desc")->limit(10)->get();
        $deposits = Transaction::where("type", 1)->orderBy("added_at", "desc")->orderBy("time", "desc")->limit(10)->get();
        $withDraws = Transaction::where("type", 2)->orderBy("added_at", "desc")->orderBy("time", "desc")->limit(10)->get();

        return view("admin.index", compact(
            "transactions",
            "sumOrange",
            "sumTelma",
            "sumAirtel",
            "deposits",
            "withDraws"
        ));
    }
}
