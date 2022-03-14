<?php

namespace App\Http\Controllers\admin\user;

use App\Models\User;
use Illuminate\Http\Request;

use App\Helper\ImageUploadHelper;
use App\Http\Controllers\Controller;
use App\Models\Province;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        $users = User::where("permission","!=",4)->orderBy("id", "desc")->get();
        return view("admin.user.index", compact("users"));
    }


    public function create()
    {
        $provinces = Province::all();
        return view("admin.user.create", compact('provinces'));
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
        $data["user_id"] =Auth::user()->id;
        $data["status"] = true;


        $insert = User::create($data);

        if ($insert) {
            return redirect("/admin/users")->with('success', 'Kullanıcı başarılı bir şekilde eklendi.');
        }

        return redirect()->back()->with('error', 'Kullanıcı kaydı sırasında bir sorun oluştu. Daha sonra tekrar deneyiniz!')->withInput();
    }


    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        $provinces = Province::all();
        return view("admin.user.edit", compact("user", "provinces"));
    }

    public function update(Request $request)
    {
        $id = $request->route('user');
        $user = User::findOrFail($id);
        $allEmails = User::pluck("email")->toArray();

        $data = $request->except('_token');

        if ($user->email !== $data["email"] && in_array($data["email"], $allEmails)) {
            return back()->with("errorEmail", "Sistemde seçtiğiniz e-posta var. Lütfen başka e-postayı girin.");
        }

        if (isset($data['image'])) {
            deleteImage($user->image);
            switch (Auth::user()->permission) {
                case '3':
                    $data['image'] = ImageUploadHelper::upload(rand(1, 9000), "staff", $data['image']);
                    break;
                case '4':
                    $data['image'] = ImageUploadHelper::upload(rand(1, 9000), "customer", $data['image']);
                    break;
                default:
                    $data['image'] = ImageUploadHelper::upload(rand(1, 9000), "users", $data['image']);
                    break;
            }
        }

        $update = $user->update($data);

        if ($update) {
            return redirect()->route("admin.users.index")->with('success', 'Kullanıcı başarılı bir şekilde güncellendi.');
        }

        return redirect()->back()->with('error', 'Kullanıcı güncelleme sırasında bir sorun oluştu. Daha sonra tekrar deneyiniz!');
    }


    public function destroy($id)
    {
        $user = User::findOrFail($id);
        deleteImage($user->image);

        $delete = $user->delete();
        $result = [];


        if ($delete) {
            $result["success"] = "Kullanıcı başarılı bir şekilde silindi.";
            $result["type"] = "success";
            //return redirect()->route('admin.users.index')->with('success', 'Kullanıcı başarılı bir şekilde silindi.');
        } else {
            $result["type"] = "error";
            $result["error"] = "Kullanıcı silinirken sırasında bir sorun oluştu. Daha sonra tekrar deneyiniz!";
        }

        return response()->json($result);
    }
}
