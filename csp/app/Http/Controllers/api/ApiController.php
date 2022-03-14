<?php

namespace App\Http\Controllers\api;

use App\Models\Bid;
use App\Models\Sale;
use App\Models\User;
use App\Models\Branch;
use App\Models\Meeting;
use App\Models\Project;
use App\Models\Customer;
use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class ApiController extends Controller
{
    public function count_items(Request $request)
    {
        $all = $request->except('_token');

        $control = $all['control'];

        $result = [];

        if ($control) {
            if (Auth::user()->permission == 1) {
                $result['countUser'] = User::where('permission', '!=', 1)->where("permission", "!=", 3)->count();
            }

            $result['countManager'] = User::where('permission', 2)->count();
            $result["countStaff"] = User::where("permission", 3)->count();

            $result["countConsultant"] = $this->countConsultant();

            $result["countCustomer"] = Customer::count();
            $result["countMyCustomer"] = $this->count_my_customer();

            $result["countBranch"] = Branch::count();
            $result["countMyBranch"] = $request->user()->branchs()->count();

            $result["countMeeting"] = Meeting::has("customer")->count();
            $result["countMyMeeting"] = $request->user()->my_meetings()->count();
            $result["countNextMeeting"] = Auth::user()->permission == 3 ? Meeting::where("user_id", Auth::user()->id)->whereDate("date_time", ">=", date("Y-m-d"))->count() : Meeting::count();

            $result["countProject"] = Project::count();
            
            $result["countSale"] = Sale::when(getUserPermission() == "staff", function ($q) {
                $q->where('user_id', Auth::user()->id);
            })->count();

            $result["countMyBids"] = Bid::where('user_id', Auth::user()->id)->count();
        }

        return response()->json($result);
    }

    public function check_staff_usage_date()
    {
        $today = date("Y-m-d");
        $staffs = User::Staffs();
        $results = [];

        if (count($staffs) > 0) {
            foreach ($staffs as  $staff) {
                if (!$staff->is_ilimited && $today > $staff->finished_at) {
                    $staff->update(["status" => false]);
                }

                $results[] = ["id" => $staff->id, "full_name" => $staff->full_name, "status" => $staff->status, "is_ilimited" => $staff->is_ilimited, "finished_at" => $staff->finished_at];
            }
        }

        return response()->json($results);
    }

    private function count_my_customer()
    {
        $request = request();
        $count = 0;
        if ($request->user()->permission == 1 || $request->user()->permission == 2) {
            $staffIds = explode(",", $request->user()->consultants);
            $count = Customer::whereIn("user_id", $staffIds)->count();
        } else {
            $count =  Customer::where("user_id", Auth::user()->id)->count();
        }

        return $count;
    }

    private function countConsultant()
    {
        $request = request();
        $staffIds = explode(",", $request->user()->consultants);
        return User::whereIn("id", $staffIds)->orderBy("name", "asc")->count();
    }
}
