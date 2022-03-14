<?php

namespace App\Http\Controllers\admin\type;

use App\Models\Type;
use App\Models\Province;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class TypeController extends Controller
{
    public function index()
    {
        $types =  Type::orderBy("id", "desc")->get();

        return view("admin.type.index", compact("types"));
    }

    public function create()
    {
        return view("admin.type.create");
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

        $newBranch = Type::create($data);

        if ($newBranch) {
            return redirect()->route("admin.types.index")->with('success', 'Durum başarılı bir şekilde eklendi.');
        }

        return redirect()->back()->with('error', 'Durum kaydı sırasında bir sorun oluştu. Daha sonra tekrar deneyiniz!')->withInput();
    }


    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $type = Type::findOrFail($id);
        return view("admin.type.edit", compact("type"));
    }

    public function update(Request $request)
    {
      $id = $request->route('type');
      $room = Type::findOrFail($id);
      $data = $request->except('_token');
      $update = $room->update($data);

      if ($update) {
          return back()->with('success', 'Daire Tipi başarılı bir şekilde güncellendi.');
      }
      return redirect()->back()->with('error', 'Daire tipi güncelleme sırasında bir sorun oluştu. Daha sonra tekrar deneyiniz!');
    }


    public function destroy($id)
    {
        $status = Type::findOrFail($id);

        $delete = $status->delete();

        if ($delete) {
            $result["success"] = "Konut Tipi başarılı bir şekilde silindi.";
            $result["type"] = "success";
            //return redirect()->route('admin.manager.index')->with('success', 'Şübe başarılı bir şekilde silindi.');
        } else {
            $result["type"] = "error";
            $result["error"] = "Konut Tipi silinirken sırasında bir sorun oluştu. Daha sonra tekrar deneyiniz!";
        }

        return response()->json($result);
    }
}
