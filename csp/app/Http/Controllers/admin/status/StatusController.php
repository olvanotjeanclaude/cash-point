<?php

namespace App\Http\Controllers\admin\status;

use App\Models\Status;
use App\Models\Province;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class StatusController extends Controller
{
    public function index()
    {
        $statuses =  Status::orderBy("id", "desc")->get();

        return view("admin.status.index", compact("statuses"));
    }

    public function my_branchs()
    {
        $branchs = Auth::user()->branchs;

        return view("admin.branch.my-branch", compact("branchs"));
    }


    public function create()
    {
        return view("admin.status.create");
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

        $newBranch = Status::create($data);



        if ($newBranch) {
            return redirect()->route("admin.statuses.index")->with('success', 'Durum başarılı bir şekilde eklendi.');
        }

        return redirect()->back()->with('error', 'Durum kaydı sırasında bir sorun oluştu. Daha sonra tekrar deneyiniz!')->withInput();
    }


    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $status = Status::findOrFail($id);
        return view("admin.status.edit", compact("status"));
    }

    public function update(Request $request)
    {
      $id = $request->route('status');
      $status = Status::findOrFail($id);
      $data = $request->except('_token');
      $update = $status->update($data);

      if ($update) {
          return back()->with('success', 'Durum başarılı bir şekilde güncellendi.');
      }
      return redirect()->back()->with('error', 'Durum güncelleme sırasında bir sorun oluştu. Daha sonra tekrar deneyiniz!');
    }


    public function destroy($id)
    {
        $status = Status::findOrFail($id);

        $delete = $status->delete();

        if ($delete) {
            $result["success"] = "Durum başarılı bir şekilde silindi.";
            $result["type"] = "success";
            //return redirect()->route('admin.manager.index')->with('success', 'Şübe başarılı bir şekilde silindi.');
        } else {
            $result["type"] = "error";
            $result["error"] = "Durum silinirken sırasında bir sorun oluştu. Daha sonra tekrar deneyiniz!";
        }

        return response()->json($result);
    }
}
