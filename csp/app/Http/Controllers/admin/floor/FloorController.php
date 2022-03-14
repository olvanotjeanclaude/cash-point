<?php

namespace App\Http\Controllers\admin\floor;

use App\Models\Floor;
use App\Models\Province;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class FloorController extends Controller
{
    public function index()
    {
        $id = $_GET['id'];

        $floors =  Floor::where('block_id', $id)->orderBy("id", "desc")->get();

        return view("admin.floor.index", compact("floors"));
    }


    public function create()
    {
        return view("admin.floor.create");
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

        $newFloor = Floor::create($data);

        if ($newFloor) {
            return redirect()->route("admin.floors.index", ['id' => $request->block_id])->with('success', 'Şübe başarılı bir şekilde eklendi.');
        }

        return redirect()->back()->with('error', 'Şübe kaydı sırasında bir sorun oluştu. Daha sonra tekrar deneyiniz!')->withInput();
    }


    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $floor = Floor::findOrFail($id);
        return view("admin.floor.edit", compact("floor"));
    }

    public function update(Request $request)
    {
        $id = $request->route('floor');
        $floor = Floor::findOrFail($id);
        $data = $request->except('_token');
        $update = $floor->update($data);
        if ($update) {
            return back()->with('success', 'Kat başarılı bir şekilde güncellendi.');
        }

        return redirect()->back()->with('error', 'Şübe güncelleme sırasında bir sorun oluştu. Daha sonra tekrar deneyiniz!');
    }


    public function destroy($id)
    {
        $floor = Floor::findOrFail($id);
        $delete = $floor->delete();


        if ($delete) {
            $result["success"] = "Kat başarılı bir şekilde silindi.";
            $result["type"] = "success";
            //return redirect()->route('admin.manager.index')->with('success', 'Şübe başarılı bir şekilde silindi.');
        } else {
            $result["type"] = "error";
            $result["error"] = "Kat silinirken sırasında bir sorun oluştu. Daha sonra tekrar deneyiniz!";
        }

        return response()->json($result);
    }
}
