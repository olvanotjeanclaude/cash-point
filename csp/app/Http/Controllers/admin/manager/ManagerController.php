<?php

namespace App\Http\Controllers\admin\manager;

use App\Models\User;
use App\Models\Province;
use Illuminate\Http\Request;
use App\Helper\ImageUploadHelper;
use App\Http\Controllers\Controller;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ManagerController extends Controller
{
    public function index()
    {
        $managers =  User::where("id", "!=", Auth::user()->id)->where("permission", 2)->orderBy("id", "desc")->get();
        return view("admin.manager.index", compact("managers"));
    }


    public function create()
    {
        $staffs = User::staffs();
        return view("admin.manager.create", compact("staffs"));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function store(Request $request)
    {
        $data = $request->except("_token");

        if (in_array($data["email"], User::emails())) {
            return back()->with("errorEmail", "Sistemde seçtiğiniz e-posta var. Lütfen başka e-postayı girin.")->withInput();
        }

        $image = (isset($data['image'])) ? ImageUploadHelper::upload(rand(1, 9000), "users", $data['image']) : "";
        $data["image"] = $image;
        $data["password"] = Hash::make($data["password"]);
        $data["created_date"] = date("Y-m-d");
        $data["permission"] = 2;
        $data["user_id"] = Auth::user()->id;
        $data["status"] = true;
        
        if(isset($data["staff_id"])){
            $data["consultants"] = implode(",", $data["staff_id"]);
            $data = Arr::except($data, ["staff_id"]);
        }

        $insert = User::create($data);
        if ($insert) {
            return redirect()->route("admin.managers.index")->with('success', 'Yönetici başarılı bir şekilde eklendi.');
        }

        return redirect()->back()->with('error', 'Yönetici kaydı sırasında bir sorun oluştu. Daha sonra tekrar deneyiniz!')->withInput();
    }


    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        $provinces = Province::all();
        $selectedStaffs= explode(",",$user->consultants) ;
        $staffs= User::staffs();
        return view("admin.manager.edit", compact("user", "provinces","staffs","selectedStaffs"));
    }

    public function update(Request $request)
    {
        $id = $request->route('manager');
   
        $user = User::findOrFail($id);
        $allEmails = User::pluck("email")->toArray();

        $data = $request->except('_token');

        if ($user->email !== $data["email"] && in_array($data["email"], $allEmails)) {
            return back()->with("errorEmail", "Sistemde seçtiğiniz e-posta var. Lütfen başka e-postayı girin.");
        }

        if (isset($data['image'])) {
            deleteImage($user->image);
            if ((Auth::user()->permission == 1) || (Auth::user()->permission == 2)) {
                $data['image'] = ImageUploadHelper::upload(rand(1, 9000), "manager", $data['image']);
            } elseif (Auth::user()->permission == 3) {
                $data['image'] = ImageUploadHelper::upload(rand(1, 9000), "staff", $data['image']);
            }
        }

        if(isset($data["staff_id"])){
            $data["consultants"] = implode(",", $data["staff_id"]);
            $data = Arr::except($data, ["staff_id"]);
        }

        $update = $user->update($data);

        if ($update) {
            return redirect()->route("admin.managers.index")->with('success', 'Yönetici başarılı bir şekilde güncellendi.');
        }

        return redirect()->back()->with('error', 'Yönetici güncelleme sırasında bir sorun oluştu. Daha sonra tekrar deneyiniz!');
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        deleteImage($user->image);

        $delete = $user->delete();
        $result = [];

        if ($delete) {
            $result["success"] = "Yönetici başarılı bir şekilde silindi.";
            $result["type"] = "success";
            //return redirect()->route('admin.manager.index')->with('success', 'Yönetici başarılı bir şekilde silindi.');
        } else {
            $result["type"] = "error";
            $result["error"] = "Yönetici silinirken sırasında bir sorun oluştu. Daha sonra tekrar deneyiniz!";
        }

        return response()->json($result);
    }
}
