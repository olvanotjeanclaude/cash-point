<?php

namespace App\Http\Controllers\admin\advertisement;

use App\Models\District;
use App\Models\Province;
use App\Models\Neighborhood;
use Illuminate\Http\Request;
use App\Models\Advertisement;
use App\Helper\PermaLinkHelper;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class AdvertisementController extends Controller
{
  public function index()
  {
    $countStandOut = Advertisement::where('status', 1)->where('stand_out', 1)->count();

    $advertisements = Advertisement::all();

    return view('admin.advertisements.index', compact("countStandOut", "advertisements"));
  }

  public function create()
  {
    $provinces = Province::all();

    return view('admin.advertisements.create', ['provinces' => $provinces]);
  }

  public function getDistrictList(Request $request)
  {
    $all = $request->except('_token');
    $province_key = $all['province_key'];

    $district_list = DB::table('districts')
      ->where('district_province_key', $province_key)
      ->pluck('district_name', 'district_key');

    return response()->json($district_list);
  }

  public function getNeighborhoodList(Request $request)
  {
    $all = $request->except('_token');
    $district_key = $all['district_key'];

    $neighborhood_list = DB::table('neighborhoods')
      ->where('neighborhood_district_key', $district_key)
      ->pluck('neighborhood_name', 'neighborhood_key');

    return response()->json($neighborhood_list);
  }

  public function store(Request $request)
  {
    $all = $request->except('_token');

    $all["user_id"] = Auth::user()->id;
    $all["status"] = false;
    $all["stand_out"] = false;
    $all['slug'] = PermaLinkHelper::permalink($all['title']);
    $all['listing_date'] = date('Y-m-d H:i:s');
    $all['advert_no'] = mt_rand(1000000, 9999999);

    $insert = Advertisement::create($all);

    if ($insert) {
      return redirect('admin/advertisements/detail/' . $insert->id)->with('success', 'İlanınız başarılı bir şekilde eklendi. Ek özellikler ekleyebilirsiniz.');
    }

    return redirect()->back()->with('error', 'İlan kaydı sırasında bir sorun oluştu. Daha sonra tekrar deneyiniz!')->withInput();
  }

  public function detail($id)
  {
    $c = Advertisement::where('id', $id)->count();

    if ($c != 0) {
      $data = Advertisement::where('id', $id)->get();

      $province = Province::where('province_key', $data[0]['province'])->get();
      $district = District::where('district_key', $data[0]['district'])->get();
      $neighborhood = Neighborhood::where('neighborhood_key', $data[0]['neighborhood'])->get();

      return view('admin.advertisements.detail', [
        "data" => $data,
        'province' => $province,
        'district' => $district,
        'neighborhood' => $neighborhood
      ]);
    }

    return abort(404);
  }

  public function updateDetail(Request $request)
  {
    $id = $request->route('id');
    $advertissement = Advertisement::findOrFail($id);
    $all = $request->except('_token');
    dd($all);


    if (count($all["apartment_facades"]) > 0) {
      $dataAparts = [];
      $aparts = $advertissement->apartment_facades();
      if ($aparts->count() > 0) {
        $aparts->delete();
      }
      foreach ($all["apartment_facades"] as $apartment_facade) {
        $dataAparts[] = ["advertissement_id" => $id, "apartment_facade" => $apartment_facade];
      }
      $aparts->createMany($dataAparts);
      unset($all["apartment_facades"]);
    }

    $update = $advertissement->update($all);

    if ($update) {
      return redirect('admin/advertisements')->with('success', 'İlanınız onay sürecine alınmıştır.');
    } else {
      return redirect()->back()->with('error', 'Kullanıcı güncelleme sırasında bir sorun oluştu. Daha sonra tekrar deneyiniz!');
    }
  }

  public function edit($id)
  {
    $c = Advertisement::where('id', $id)->count();

    if ($c != 0) {
      $data = Advertisement::where('id', $id)->get();
      $consultantId = explode(',', $data[0]['consultants_id']);

      $consultants = [];
      $provinces = Province::all();

      $district_list = DB::table('districts')
        ->where('district_province_key', $data[0]['province'])
        ->pluck('district_name', 'district_key');

      $neighborhood_list = DB::table('neighborhoods')
        ->where('neighborhood_district_key', $data[0]['district'])
        ->pluck('neighborhood_name', 'neighborhood_key');

      $dataFacades = Advertisement::find($id)->apartment_facades()->pluck("apartment_facade")->toArray();
      $countStandOut = Advertisement::where('status', 1)->where('stand_out', 1)->count();

      return view('admin.advertisements.edit', [
        "data" => $data,
        "consultants" => $consultants,
        "consultantId" => $consultantId,
        "provinces" => $provinces,
        "district_list" => $district_list,
        "neighborhood_list" => $neighborhood_list,
        "dataFacades" => $dataFacades,
        "countStandOut" => $countStandOut
      ]);
    } else {
      return abort(404);
    }
  }

  public function edits($id)
  {
    $c = Advertisement::where('id', $id)->count();

    if ($c != 0) {
      $data = Advertisement::where('id', $id)->get();

      $province = Province::where('province_key', $data[0]['province'])->get();
      $district = District::where('district_key', $data[0]['district'])->get();
      $neighborhood = Neighborhood::where('neighborhood_key', $data[0]['neighborhood'])->get();

      $countStandOut = Advertisement::where('status', 1)->where('stand_out', 1)->count();
      $dataFacades = Advertisement::find($id)->apartment_facades()->pluck("apartment_facade")->toArray();

      return view('admin.advertisements.edit', [
        "data" => $data,
        'province' => $province,
        'district' => $district,
        'neighborhood' => $neighborhood,
        'countStandOut' => $countStandOut,
        "dataFacades" => $dataFacades
      ]);
    } else {
      return abort(404);
    }
  }

  public function update(Request $request)
  {
    $id = $request->route('id');
    $c = Advertisement::where('id', $id)->count();

    if ($c != 0) {
      $all = $request->except("_token");

      $array = [
        'status' => $all['status'],
        'stand_out' => $all['stand_out'],
        'listing_date' => date('Y-m-d H:i:s'),
        'last_date' => $all['last_date']
      ];

      $update = Advertisement::where('id', $id)->update($array);

      if ($update) {
        return redirect('admin/advertisements')->with('success', 'İlan ayarları başarılı bir şekilde güncellendi.');
      } else {
        return redirect()->back()->with('error', 'İlan güncelleme sırasında bir sorun oluştu. Daha sonra tekrar deneyiniz!');
      }
    } else {
      return abort(404);
    }
  }
}
