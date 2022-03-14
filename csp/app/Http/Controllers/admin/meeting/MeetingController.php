<?php

namespace App\Http\Controllers\admin\meeting;

use App\Models\Meeting;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Customer;
use Illuminate\Support\Facades\Auth;

class MeetingController extends Controller
{
    public function index()
    {
        $meetings = Meeting::has("customer")->orderBy("date_time", "desc")->get();
        return view("admin.meeting.index", compact("meetings"));
    }

    public function create()
    {
        $customers = Customer::when(getUserPermission() == "staff", function ($query) {
            $query->where('user_id', Auth::user()->id);
        })->orderBy("name", "asc")->get();
        $customer_id = request()->get("customer_id");
        $customer = Customer::find($customer_id);
        $customer_id = $customer != null ? $customer->id : null;

        return view("admin.meeting.create", compact("customers", "customer_id"));
    }

    public function edit($id)
    {
        $meeting = Meeting::findOrFail($id);
        $customers = Customer::orderBy("name", "asc")->get();
        return view("admin.meeting.edit", compact("meeting", "customers"));
    }

    public function store(Request $request)
    {
        $data = $request->except("_token");
        $data["user_id"] = Auth::user()->id;

        $newMeeting = Meeting::create($data);

        if ($newMeeting) {
            return redirect("/admin/customers/$request->customer_id")->with('success', 'Görüşme başarılı bir şekilde eklendi.');
        }

        return redirect()->back()->with('error', 'Görüşme kaydı sırasında bir sorun oluştu. Daha sonra tekrar deneyiniz!')->withInput();
    }

    public function update(Request $request)
    {
        $data = $request->except("_token");
        $meeting = Meeting::findOrFail($request->meeting);
        $insert = $meeting->update($data);

        if ($insert) {
            return redirect("/admin/my-meetings")->with('success', 'Görüşme başarılı bir şekilde güncellendi.');
        }

        return redirect()->back()->with('error', 'Görüşme güncelleme sırasında bir sorun oluştu. Daha sonra tekrar deneyiniz!')->withInput();
    }

    public function my_meetings()
    {
        $meetings = Meeting::has("customer")->where("user_id", Auth::user()->id)->orderBy("date_time", "desc")->get();

        return view("admin.meeting.my-meeting", compact("meetings"));
    }

    public function destroy($id)
    {
        $meeting = Meeting::findOrFail($id);
        $delete = $meeting->delete();

        $result = [];

        if ($delete) {
            $result["success"] = "Görüşme başarılı bir şekilde silindi.";
            $result["type"] = "success";
        } else {
            $result["type"] = "error";
            $result["error"] = "Görüşme silinirken  bir sorun oluştu. Daha sonra tekrar deneyiniz!";
        }

        return response()->json($result);
    }
}
