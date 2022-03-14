<?php

namespace App\Http\Controllers\admin\vision;

use App\Models\Vision;
use Illuminate\Http\Request;
use App\Helper\ImageUploadHelper;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class VisionController extends Controller
{
    public function index()
    {
        $vision = Vision::first();
        return view("admin.vision.index", compact("vision"));
    }

    public function create()
    {
        return view("admin.vision.create");
    }


    public function edit()
    {
        $vision = Vision::first();
        return view("admin.vision.edit", compact("vision"));
    }

    public function update(Request $request)
    {
        $data = $request->except('_token');

        $vision = Vision::first();

        $data["user_id"] = Auth::id();

        if ($vision) {
            $update = $vision->update($data);
        } else {
            $update =  Vision::create($data);
        }

        if ($update) {
            return redirect()->route('admin.visions.index')->with('success', 'Vizyon başarılı bir şekilde güncellendi.');
        }

        return redirect()->back()->with('error', 'Vizyon güncelleme sırasında bir sorun oluştu. Daha sonra tekrar deneyiniz!');
    }


    public function destroy($id)
    {
        $user = Vision::findOrFail($id);
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
