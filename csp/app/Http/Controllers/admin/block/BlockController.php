<?php

namespace App\Http\Controllers\admin\block;

use App\Models\Block;
use App\Models\ProjectHaveBlock;
use App\Models\Province;
use App\Models\Floor;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class BlockController extends Controller
{
    public function index()
    {
        if(isset($_GET['id'])){
          $id = $_GET['id'];
          $blocks =  Block::where("project_id", $id)->get();
        }else{

          $blocks =  Block::orderBy("id", "desc")->get();

        }


        return view("admin.block.index", compact("blocks"));
    }

    public function get_floors($id){
      $floors = Floor::where('block_id', $id)->get();
      return response()->json($floors);
    }


    public function create()
    {
        return view("admin.block.create");
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

        $newBranch = Block::create($data);

        if ($newBranch) {
            return redirect()->route("admin.blocks.index", ['id' => $request->project_id ])->with('success', 'Blok başarılı bir şekilde eklendi.');
        }

        return redirect()->back()->with('error', 'Durum kaydı sırasında bir sorun oluştu. Daha sonra tekrar deneyiniz!')->withInput();
    }


    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $block = Block::findOrFail($id);
        return view("admin.block.edit", compact("block"));
    }

    public function update(Request $request)
    {
      $data = $request->except("_token");
      $id = $request->route('block');
      $block = Block::findOrFail($id);
      $insert = $block->update($data);

      if ($insert) {
          return back()->with('success', 'Blok başarılı bir şekilde güncellendi.');
      }
      return redirect()->back()->with('error', 'Blok güncelleme sırasında bir sorun oluştu. Daha sonra tekrar deneyiniz!')->withInput();
    }


    public function destroy($id)
    {
        $status = Block::findOrFail($id);
        $delete = $status->delete();

        if ($delete) {
            $result["success"] = "Blok başarılı bir şekilde silindi.";
            $result["type"] = "success";
            //return redirect()->route('admin.manager.index')->with('success', 'Şübe başarılı bir şekilde silindi.');
        } else {
            $result["type"] = "error";
            $result["error"] = "Blok silinirken sırasında bir sorun oluştu. Daha sonra tekrar deneyiniz!";
        }

        return response()->json($result);
    }
}
