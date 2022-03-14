<?php

namespace App\Http\Controllers\admin\consultant;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class ConsultantController extends Controller
{
    public function index(Request $request)
    {
        $staffIds = explode(",", $request->user()->consultants);
        $consultants = User::whereIn("id", $staffIds)->orderBy("name","asc")->get();
        $staffs = User::where("permission", 3)->whereNotIn("id", $staffIds)->get();
        return view("admin.manager.consultants", compact('consultants', 'staffs'));
    }

    public function store(Request $request)
    {
        $consultants = $request["staff_id"];
        $oldConsultants= explode(",",Auth::user()->consultants);
        $consultants =array_merge($oldConsultants,$consultants);
    
        $consultants = implode(",",$consultants);

        $update = $request->user()->update(["consultants" => $consultants]);

        if ($update) {
            return back()->with('success', 'Danışman başarılı bir şekilde güncellendi.');
        }

        return redirect()->back()->with('error', 'Danışman güncelleme sırasında bir sorun oluştu. Daha sonra tekrar deneyiniz!');
    }

    public function destroy($id, Request $request)
    {
        $result = [];
        $consultants = explode(",", Auth::user()->consultants);
        $consultants = array_filter($consultants, function ($staff_id) use ($id) {
            return $staff_id != $id;
        });

        $consultants = implode(",",$consultants);

        $success =  $request->user()->update(["consultants" => $consultants]);

        if ($success) {
            $result["success"] = "Danışman başarılı bir şekilde silindi.";
            $result["type"] = "success";
        } else {
            $result["type"] = "error";
            $result["error"] = "Danışman silinirken sırasında bir sorun oluştu. Daha sonra tekrar deneyiniz!";
        }

        return response()->json($result);
    }
}
