<?php

namespace App\Http\Controllers\admin\apartment;

use App\Models\Room;
use App\Models\Type;
use App\Models\Facade;
use App\Models\Status;
use App\Models\Apartment;
use App\Models\Province;
use App\Models\InteriorFeature;
use App\Models\ExteriorFeature;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Bid;
use App\Models\ApartmentPriceHistory;

class ApartmentController extends Controller
{
    public function index()
    {
        $id = $_GET['id'];
        $apartments =  Apartment::where('floor_id', $id)->orderBy("id", "desc")->get();
        return view("admin.apartment.index", compact("apartments"));
    }

    public function view($id){

      $apartment = Apartment::findOrFail($id);
      $interiors = InteriorFeature::get()->all();
      $exteriors = ExteriorFeature::get()->all();
      $bids = Bid::where('apartment_id', $id)->get();

      return view('admin.apartment.view', ['bids' => $bids, 'apartment' => $apartment, 'exteriors' => $exteriors, 'interiors' => $interiors]);
    }

    public function interior($id){

      $data = Apartment::findorfail($id);
      $interiors = InteriorFeature::get()->all();
      $exteriors = ExteriorFeature::get()->all();
      return view('admin.apartment.interior', ['data' => $data, 'interiors' => $interiors]);
    }

    public function interiorPost(Request $request){

      $apartment = Apartment::findorfail($request->apartment_id);
      $save = $apartment->InteriorFeature()->sync($request->interior);
      if($save){
        return redirect()->route("admin.int.features.index", ['id' => $request->apartment_id])->with('success', 'İç Özellikler başarılı bir şekilde eklendi.');
      }else{
        return redirect()->back()->with('error', 'İç özellik kaydı sırasında bir sorun oluştu. Daha sonra tekrar deneyiniz!')->withInput();
      }
    }

    public function exterior($id){

      $data = Apartment::findorfail($id);
      $exteriors = ExteriorFeature::get()->all();
      return view('admin.apartment.exterior', ['data' => $data, 'exteriors' => $exteriors]);
    }

    public function exteriorPost(Request $request){

      $apartment = Apartment::findorfail($request->apartment_id);
      $save = $apartment->ExteriorFeature()->sync($request->exterior);
      if($save){
        return redirect()->route("admin.ext.features.index", ['id' => $request->apartment_id])->with('success', 'Dış Özellikler başarılı bir şekilde eklendi.');
      }else{
        return redirect()->back()->with('error', 'Dış özellik kaydı sırasında bir sorun oluştu. Daha sonra tekrar deneyiniz!')->withInput();
      }
    }



    public function create(){

      $rooms = Room::get()->all();
      $types = Type::get()->all();
      $facades = Facade::get()->all();
      $statutes = Status::get()->all();
      return view("admin.apartment.create", ['rooms' => $rooms, 'types' => $types, 'facades' => $facades, 'statutes' => $statutes]);
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

        $newApartment = Apartment::insertGetId($data);

        $apartment = Apartment::findOrFail($newApartment);

        if ($newApartment) {
              ApartmentPriceHistory::create([
                'price' => $apartment->price,
                'apartment_id' => $apartment->id]);
            return redirect()->route("admin.apartments.index", ['id' => $request->floor_id])->with('success', 'Daire başarılı bir şekilde eklendi.');
        }

        return redirect()->back()->with('error', 'Daire kaydı sırasında bir sorun oluştu. Daha sonra tekrar deneyiniz!')->withInput();
    }


    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $apartment = Apartment::findOrFail($id);
        return view("admin.apartment.edit", compact("apartment"));
    }

    public function update(Request $request)
    {
        $id = $request->route('apartment');
        $apartment = Apartment::findOrFail($id);
        if($apartment->price != $request->price){
          ApartmentPriceHistory::create([
            'price' => $request->price,
            'apartment_id' => $apartment->id
          ]);
        }
        $data = $request->except('_token');
        $update = $apartment->update($data);

        if ($update) {
            return back()->with('success', 'Daire başarılı bir şekilde güncellendi.');
        }
        return redirect()->back()->with('error', 'Şübe güncelleme sırasında bir sorun oluştu. Daha sonra tekrar deneyiniz!');
    }


    public function destroy($id)
    {
        $apartment = Apartment::findOrFail($id);
        $delete = $apartment->delete();
        $result = [];
        if ($delete) {
            $result["success"] = "Daire başarılı bir şekilde silindi.";
            $result["type"] = "success";
            //return redirect()->route('admin.manager.index')->with('success', 'Şübe başarılı bir şekilde silindi.');
        } else {
            $result["type"] = "error";
            $result["error"] = "Daire silinirken sırasında bir sorun oluştu. Daha sonra tekrar deneyiniz!";
        }

        return response()->json($result);
    }
}
