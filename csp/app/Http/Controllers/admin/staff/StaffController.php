<?php

namespace App\Http\Controllers\admin\staff;

use App\Models\User;
use App\Models\Province;
use Illuminate\Http\Request;
use App\Helper\ImageUploadHelper;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class StaffController extends Controller
{
    public function index()
    {
        $staffs =  User::where("id", "!=", Auth::user()->id)->where("permission", 3)->get();
        return view("admin.staff.index", compact("staffs"));
    }

    public function create()
    {
        return view("admin.staff.create");
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

        if (getUserPermission() == "admin" || getUserPermission() == "manager") {
            $data["status"] = true;
        }

        $data["is_ilimited"] = isset($data["finished_at"]) ? false : true;

        $data["password"] = Hash::make($data["password"]);
        $data["permission"] = 3;
        $data["user_id"] = Auth::user()->id;
        $data["status"] = true;

        $image = (isset($data['image'])) ? ImageUploadHelper::upload(rand(1, 9000), "users", $data['image']) : "";
        $data["image"] = $image;

        $insert = User::create($data);

        if ($insert) {
            return redirect()
                ->route("admin.user.create_branch", ["user_type" => "staff", "id" => $insert->id])
                ->with('success', 'Personel başarılı bir şekilde eklendi. Şimdi Bu personelin sübesi ekleyebilirsiniz.');
        }

        return redirect()->back()->with('error', 'Personel kaydı sırasında bir sorun oluştu. Daha sonra tekrar deneyiniz!')->withInput();
    }

    public function edit($id)
    {
        $staff = User::findOrFail($id);
        $provinces = Province::all();

        return view("admin.staff.edit", compact("staff", "provinces"));
    }
    public function show($id)
    {
        $staff = User::findOrFail($id);
        return view('admin.staff.show', compact('staff'));
    }


    public function update(Request $request)
    {
        $id = $request->route('staff');
        $user = User::findOrFail($id);
        $allEmails = User::pluck("email")->toArray();

        $data = $request->except('_token');

        if ($user->email !== $data["email"] && in_array($data["email"], $allEmails)) {
            return back()->with("errorEmail", "Sistemde seçtiğiniz e-posta var. Lütfen başka e-postayı girin.");
        }

        $data["is_ilimited"] = isset($data["finished_at"]) ? false : true;

        if (isset($data['image'])) {
            deleteImage($user->image);
            if ((Auth::user()->permission == 1) || (Auth::user()->permission == 2)) {
                $data['image'] = ImageUploadHelper::upload(rand(1, 9000), "users", $data['image']);
            } elseif (Auth::user()->permission == 3) {
                $data['image'] = ImageUploadHelper::upload(rand(1, 9000), "staff", $data['image']);
            }
        }

        $update = $user->update($data);

        if ($update) {
            return redirect("/admin/staffs/$id")->with('success', 'Personel başarılı bir şekilde güncellendi.');
        }

        return redirect()->back()->with('error', 'Personel güncelleme sırasında bir sorun oluştu. Daha sonra tekrar deneyiniz!');
    }

   
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        deleteImage($user->image);

        $delete = $user->delete();
        $result = [];


        if ($delete) {
            $result["success"] = "Personel başarılı bir şekilde silindi.";
            $result["type"] = "success";
            //return redirect()->route('admin.users.index')->with('success', 'Personel başarılı bir şekilde silindi.');
        } else {
            $result["type"] = "error";
            $result["error"] = "Personel silinirken sırasında bir sorun oluştu. Daha sonra tekrar deneyiniz!";
        }

        return response()->json($result);
    }
}
