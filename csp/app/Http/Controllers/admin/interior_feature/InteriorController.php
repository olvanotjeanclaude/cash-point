<?php

namespace App\Http\Controllers\admin\interior_feature;

use App\Models\InteriorFeature;
use App\Models\Province;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class InteriorController extends Controller
{
    public function index()
    {
        $features =  InteriorFeature::orderBy("id", "desc")->get();

        return view("admin.interior.index", compact("features"));
    }


    public function create()
    {
        return view("admin.interior.create");
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

        $newBranch = InteriorFeature::create($data);



        if ($newBranch) {
            return redirect()->route("admin.interior-feature.index")->with('success', 'İç Özellik başarılı bir şekilde eklendi.');
        }

        return redirect()->back()->with('error', 'İç Özellik kaydı sırasında bir sorun oluştu. Daha sonra tekrar deneyiniz!')->withInput();
    }


    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $interior = InteriorFeature::findOrFail($id);
        return view("admin.interior.edit", compact("interior"));
    }

    public function update(Request $request)
    {
        $id = $request->route('interior_feature');
        $interior = InteriorFeature::findOrFail($id);
        $data = $request->except('_token');
        $update = $interior->update($data);

        if ($update) {
            return back()->with('success', 'Cephe başarılı bir şekilde güncellendi.');
        }
        return redirect()->back()->with('error', 'Cephe güncelleme sırasında bir sorun oluştu. Daha sonra tekrar deneyiniz!');
    }


    public function destroy($id)
    {
        $feature = InteriorFeature::findOrFail($id);

        $delete = $feature->delete();

        if ($delete) {
            $result["success"] = "İç Özellik başarılı bir şekilde silindi.";
            $result["type"] = "success";
            //return redirect()->route('admin.manager.index')->with('success', 'Şübe başarılı bir şekilde silindi.');
        } else {
            $result["type"] = "error";
            $result["error"] = "İç Özellik silinirken sırasında bir sorun oluştu. Daha sonra tekrar deneyiniz!";
        }

        return response()->json($result);
    }
}
