<?php

namespace App\Http\Controllers\admin\exterior_feature;

use App\Models\ExteriorFeature;
use App\Models\Province;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class ExteriorController extends Controller
{
    public function index()
    {
        $features =  ExteriorFeature::orderBy("id", "desc")->get();

        return view("admin.exterior.index", compact("features"));
    }


    public function create()
    {
        return view("admin.exterior.create");
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

        $newBranch = ExteriorFeature::create($data);



        if ($newBranch) {
            return redirect()->route("admin.exterior-feature.index")->with('success', 'Dış Özellik başarılı bir şekilde eklendi.');
        }

        return redirect()->back()->with('error', 'Durum kaydı sırasında bir sorun oluştu. Daha sonra tekrar deneyiniz!')->withInput();
    }


    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $exterior = ExteriorFeature::findOrFail($id);
        return view("admin.exterior.edit", compact("exterior"));
    }

    public function update(Request $request)
    {
      $id = $request->route('exterior_feature');
      $exterior = ExteriorFeature::findOrFail($id);
      $data = $request->except('_token');
      $update = $exterior->update($data);

      if ($update) {
          return back()->with('success', 'Dış özellik bir şekilde güncellendi.');
      }
      return redirect()->back()->with('error', 'Dış özellik güncelleme sırasında bir sorun oluştu. Daha sonra tekrar deneyiniz!');
    }


    public function destroy($id)
    {
        $feature = ExteriorFeature::findOrFail($id);

        $delete = $feature->delete();

        if ($delete) {
            $result["success"] = "Dış Özellik başarılı bir şekilde silindi.";
            $result["type"] = "success";
            //return redirect()->route('admin.manager.index')->with('success', 'Şübe başarılı bir şekilde silindi.');
        } else {
            $result["type"] = "error";
            $result["error"] = "Dış Özellik silinirken sırasında bir sorun oluştu. Daha sonra tekrar deneyiniz!";
        }

        return response()->json($result);
    }
}
