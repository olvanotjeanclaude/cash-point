<?php

namespace App\Http\Controllers\admin\facade;

use App\Models\Facade;
use App\Models\Province;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class FacadeController extends Controller
{
    public function index()
    {
        $facades =  Facade::orderBy("id", "desc")->get();

        return view("admin.facade.index", compact("facades"));
    }


    public function create()
    {
        return view("admin.facade.create");
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

        $newBranch = Facade::create($data);



        if ($newBranch) {
            return redirect()->route("admin.facades.index")->with('success', 'Cephe başarılı bir şekilde eklendi.');
        }

        return redirect()->back()->with('error', 'Durum kaydı sırasında bir sorun oluştu. Daha sonra tekrar deneyiniz!')->withInput();
    }


    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $facade = Facade::findOrFail($id);
        return view("admin.facade.edit", compact("facade"));
    }

    public function update(Request $request)
    {
      $id = $request->route('facade');
      $facade = Facade::findOrFail($id);
      $data = $request->except('_token');
      $update = $facade->update($data);

      if ($update) {
          return back()->with('success', 'Cephe başarılı bir şekilde güncellendi.');
      }
      return redirect()->back()->with('error', 'Cephe güncelleme sırasında bir sorun oluştu. Daha sonra tekrar deneyiniz!');
    }


    public function destroy($id)
    {
        $facade = Facade::findOrFail($id);

        $delete = $facade->delete();

        if ($delete) {
            $result["success"] = "Cephe başarılı bir şekilde silindi.";
            $result["type"] = "success";
            //return redirect()->route('admin.manager.index')->with('success', 'Şübe başarılı bir şekilde silindi.');
        } else {
            $result["type"] = "error";
            $result["error"] = "Cephe silinirken sırasında bir sorun oluştu. Daha sonra tekrar deneyiniz!";
        }

        return response()->json($result);
    }
}
