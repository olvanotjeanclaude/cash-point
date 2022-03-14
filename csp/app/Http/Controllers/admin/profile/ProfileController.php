<?php

namespace App\Http\Controllers\admin\profile;

use App\Models\User;
use App\Models\Province;
use Illuminate\Http\Request;
use App\Helper\ImageUploadHelper;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        return view("admin.profile.index", compact("user"));
    }

    public function edit()
    {
        $user = Auth::user();
        $provinces = Province::all();
        return view("admin.profile.edit", compact("user","provinces"));
    }

    public function update(Request $request)
    {
        $user = $request->user();
        $allEmails = User::pluck("email")->toArray();

        $data = $request->except('_token');

        if ($user->email !== $data["email"] && in_array($data["email"], $allEmails)) {
            return back()->with("errorEmail", "Sistemde seçtiğiniz e-posta var. Lütfen başka e-postayı girin.");
        }

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
            return redirect("/admin/profile")->with('success', 'Profiliniz başarılı bir şekilde güncellendi.');
        }

        return redirect("/admin/profile")->with('error', 'Profil güncelleme sırasında bir sorun oluştu. Daha sonra tekrar deneyiniz!');
    }
}
