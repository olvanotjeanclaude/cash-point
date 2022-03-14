<?php

namespace App\Http\Controllers\admin\room;

use App\Models\Room;
use App\Models\Province;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class RoomController extends Controller
{
    public function index()
    {
        $rooms =  Room::orderBy("id", "desc")->get();

        return view("admin.room.index", compact("rooms"));
    }


    public function create()
    {
        return view("admin.room.create");
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

        $newRoom = Room::create($data);



        if ($newRoom) {
            return redirect()->route("admin.rooms.index")->with('success', 'Oda başarılı bir şekilde eklendi.');
        }

        return redirect()->back()->with('error', 'Oda kaydı sırasında bir sorun oluştu. Daha sonra tekrar deneyiniz!')->withInput();
    }


    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $room = Room::findOrFail($id);
        return view("admin.room.edit", compact("room"));
    }

    public function update(Request $request)
    {

      $id = $request->route('room');
      $room = Room::findOrFail($id);
      $data = $request->except('_token');
      $update = $room->update($data);

      if ($update) {
          return back()->with('success', 'Oda Tipi başarılı bir şekilde güncellendi.');
      }
      return redirect()->back()->with('error', 'Oda Tipi güncelleme sırasında bir sorun oluştu. Daha sonra tekrar deneyiniz!');

    }


    public function destroy($id)
    {
        $room = Room::findOrFail($id);

        $delete = $room->delete();

        if ($delete) {
            $result["success"] = "Oda başarılı bir şekilde silindi.";
            $result["type"] = "success";
            //return redirect()->route('admin.manager.index')->with('success', 'Şübe başarılı bir şekilde silindi.');
        } else {
            $result["type"] = "error";
            $result["error"] = "Oda silinirken sırasında bir sorun oluştu. Daha sonra tekrar deneyiniz!";
        }

        return response()->json($result);
    }
}
