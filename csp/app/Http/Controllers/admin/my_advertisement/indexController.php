<?php

namespace App\Http\Controllers\admin\my_advertisement;

use View;
use App\District;
use App\Province;
use Carbon\Carbon;
use App\Consultants;
use App\Neighborhood;
use App\Advertisement;
use App\AdvertisementImage;
use Illuminate\Http\Request;
use App\Helper\PermaLinkHelper;
use Yajra\DataTables\DataTables;
use App\Helper\ImageUploadHelper;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\Facades\Image;
use File;
use Illuminate\Support\Str;

class indexController extends Controller
{
  public function index()
  {
    return view('admin.my_advertisement.index');
  }

  public function data(Request $request)
  {
    $result = DataTables::of(Advertisement::where('user_id', Auth::user()->id))
      ->addColumn('advert_no', function ($query) {
        return '<label class="badge badge-info">' . $query->advert_no . '</label>';
      })
      ->addColumn('status', function ($query) {
        if ($query->status == 1) {
          return '<label class="badge badge-success">Aktif</label>';
        } else if ($query->status == 0) {
          return '<label class="badge badge-danger">İnceleniyor</label>';
        }
      })
      ->addColumn('sale_or_rent', function ($query) {
        if ($query->sale_or_rent == 1) {
          return '<label class="badge badge-warning">Satılık</label>';
        } else if ($query->sale_or_rent == 2) {
          return '<label class="badge badge-primary">Kiralık</label>';
        }
      })
      ->addColumn('edit', function ($query) {
        return '<a class="btn btn-success btn-sm" href="' . route('admin.my_advertisement.edit', ['id' => $query->id]) . '">Düzenle</a>';
      })
      ->addColumn('delete', function ($query) {
        return '<a class="btn btn-danger btn-sm remove-btn" style="color: #fff;"  data-url="' . route('admin.my_advertisement.delete', ['id' => $query->id]) . '">Sil</a>';
      })
      ->addColumn('picture', function ($query) {
        return '<a class="btn btn-info btn-sm" href="' . route('admin.my_advertisement.picture', ['id' => $query->id]) . '">Resimler</a>';
      })
      ->rawColumns(["advert_no", "status", "sale_or_rent", "edit", "delete", "picture"])
      ->make(true);

    return $result;
  }

  public function create()
  {
    $consultants = Consultants::where('user_id', Auth::user()->id)->get();
    $provinces = Province::all();

    return view('admin.my_advertisement.create', ['consultants' => $consultants, 'provinces' => $provinces]);
  }

  public function store(Request $request)
  {
    $all = $request->except('_token');
    $isDuplicated = false;

    if (isset($all['user_id'])) {
      $userId = array_unique($all['user_id']);
      $consultants_id = implode(',', $userId);

      $array = [
        'user_id' => Auth::user()->id,
        'status' => false,
        'stand_out' => false,
        'property_type' => $all['property_type'],
        'sale_or_rent' => $all['sale_or_rent'],
        'title' => $all['title'],
        'slug' => PermaLinkHelper::permalink($all['title']),
        'province' => $all['province'],
        'district' => $all['district'],
        'neighborhood' => $all['neighborhood'],
        'gross' => $all['gross'],
        'net' => $all['net'],
        'number_of_rooms' => $all['number_of_rooms'],
        'available_for_loan' => $all['available_for_loan'],
        'furniture_situation' => $all['furniture_situation'],
        'number_of_bathrooms' => $all['number_of_bathrooms'],
        'description' => $all['description'],
        'number_of_floors_in_the_building' => $all['number_of_floors_in_the_building'],
        'building_age' => $all['building_age'],
        'floor_location' => $all['floor_location'],
        'heating_type' => $all['heating_type'],
        'monthly_dues' => $all['monthly_dues'],
        'listing_date' => date('Y-m-d H:i:s'),
        'advert_no' => mt_rand(1000000, 9999999),
        'consultants_id' => $consultants_id
      ];
    } else {
      $array = [
        'user_id' => Auth::user()->id,
        'status' => false,
        'stand_out' => false,
        'property_type' => $all['property_type'],
        'sale_or_rent' => $all['sale_or_rent'],
        'title' => $all['title'],
        'slug' =>  PermaLinkHelper::permalink($all['title']),
        'province' => $all['province'],
        'district' => $all['district'],
        'neighborhood' => $all['neighborhood'],
        'gross' => $all['gross'],
        'net' => $all['net'],
        'number_of_rooms' => $all['number_of_rooms'],
        'available_for_loan' => $all['available_for_loan'],
        'furniture_situation' => $all['furniture_situation'],
        'number_of_bathrooms' => $all['number_of_bathrooms'],
        'description' => $all['description'],
        'number_of_floors_in_the_building' => $all['number_of_floors_in_the_building'],
        'building_age' => $all['building_age'],
        'floor_location' => $all['floor_location'],
        'heating_type' => $all['heating_type'],
        'monthly_dues' => $all['monthly_dues'],
        'listing_date' => date('Y-m-d H:i:s'),
        'advert_no' => mt_rand(1000000, 9999999),
        'consultants_id' => null,
      ];
    }

    $allTitle = Advertisement::pluck("title")->toArray();

    if (in_array($array["title"], $allTitle)) {
      return back()->with("error", "Girdiğiniz ilan başlığı zaten var. Lütfen başka bir başlık bulun.");
    }

    $insert = Advertisement::create($array);

    $dd = Advertisement::where('id', $insert->id)->firstOrFail();
    //$dd->consultants()->attach($all['user_id']);

    if ($insert) {
      return redirect('admin/my_advertisement/detail/' . $insert->id)->with('success', 'İlanınız başarılı bir şekilde eklendi. Ek özellikler ekleyebilirsiniz.');
    } else {
      return redirect()->back()->with('error', 'İlan kaydı sırasında bir sorun oluştu. Daha sonra tekrar deneyiniz!')->withInput();
    }
  }

  public function detail($id)
  {
    $c = Advertisement::where('id', $id)->count();

    if ($c != 0) {
      $data = Advertisement::where('id', $id)->get();

      $province = Province::where('province_key', $data[0]['province'])->get();
      $district = District::where('district_key', $data[0]['district'])->get();
      $neighborhood = Neighborhood::where('neighborhood_key', $data[0]['neighborhood'])->get();

      return view('admin.my_advertisement.detail', [
        "data" => $data,
        'province' => $province,
        'district' => $district,
        'neighborhood' => $neighborhood
      ]);
    } else {
      return abort(404);
    }
  }

  public function updateDetail(Request $request)
  {
    $id = $request->route('id');
    $advertissement = Advertisement::findOrFail($id);
    $all = $request->except('_token');

    dd($all);

    if (count($all["apartment_facades"]) > 0) {
      $dataAparts = [];
      foreach ($all["apartment_facades"] as $apartment_facade) {
        $dataAparts[] = ["advertissement_id" => $id, "apartment_facade" => $apartment_facade];
      }
      $advertissement->apartment_facades()->createMany($dataAparts);
      unset($all["apartment_facades"]);
    }

    $update = $advertissement->update($all);

    if ($update) {
      return redirect('admin/my_advertisement')->with('success', 'İlanınız onay sürecine alınmıştır.');
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

      $consultants = Consultants::where('user_id', Auth::user()->id)->get();
      $provinces = Province::all();

      $district_list = DB::table('districts')
        ->where('district_province_key', $data[0]['province'])
        ->pluck('district_name', 'district_key');

      $neighborhood_list = DB::table('neighborhoods')
        ->where('neighborhood_district_key', $data[0]['district'])
        ->pluck('neighborhood_name', 'neighborhood_key');

      $advertissementFacades = Advertisement::find($id)->apartment_facades()->pluck("apartment_facade")->toArray();

      return view('admin.my_advertisement.edit', [
        "data" => $data,
        "consultants" => $consultants,
        "consultantId" => $consultantId,
        "provinces" => $provinces,
        "district_list" => $district_list,
        "neighborhood_list" => $neighborhood_list,
        "advertissementFacades" => $advertissementFacades
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

      if (isset($all['user_id'])) {
        $userId = array_unique($all['user_id']);
        $consultants_id = implode(',', $userId);

        $array = [
          'status' => false,
          'stand_out' => false,
          'consultants_id' => $consultants_id,

          'title' => $all['title'],
          'slug' => PermaLinkHelper::permalink($all['title']),
          'province' => $all['province'],
          'district' => $all['district'],
          'neighborhood' => $all['neighborhood'],
          'gross' => $all['gross'],
          'net' => $all['net'],
          'number_of_rooms' => $all['number_of_rooms'],
          'available_for_loan' => $all['available_for_loan'],
          'listing_date' => date('Y-m-d H:i:s'),
          'number_of_floors_in_the_building' => $all['number_of_floors_in_the_building'],
          'building_age' => $all['building_age'],
          'heating_type' => $all['heating_type'],
          'furniture_situation' => $all['furniture_situation'],
          'monthly_dues' => $all['monthly_dues'],
          'description' => $all['description'],
          'number_of_bathrooms' => $all['number_of_bathrooms'],
          'floor_location' => $all['floor_location'],

          'garden' => $all['garden'],
          'balcony' => $all['balcony'],
          'water_tank' => $all['water_tank'],
          'exterior' => $all['exterior'],
          'parking_lift' => $all['parking_lift'],
          'parking_lot' => $all['parking_lot'],
          'parking_garage' => $all['parking_garage'],
          'building_lift' => $all['building_lift'],
          'sound_insulation' => $all['sound_insulation'],
          'adsl' => $all['adsl'],
          'fiber_internet' => $all['fiber_internet'],
          'smart_house' => $all['smart_house'],
          'alarm' => $all['alarm'],
          'parent_bathroom' => $all['parent_bathroom'],
          'video_intercom' => $all['video_intercom'],
          'cellar' => $all['cellar'],
          'air_conditioning' => $all['air_conditioning'],
          'built_in' => $all['built_in'],
          'laminate' => $all['laminate'],
          'pvc_joinery' => $all['pvc_joinery'],
          'steel_door' => $all['steel_door'],
          'fireplace' => $all['fireplace'],
          'combi' => $all['combi'],
          'outdoor_swimming_pool' => $all['outdoor_swimming_pool'],
          'indoor_swimming_pool' => $all['indoor_swimming_pool'],
          'security' => $all['security'],
          'camera_system' => $all['camera_system'],
          'doorman' => $all['doorman'],
          'day_nursery' => $all['day_nursery'],
          'sports_field' => $all['sports_field'],
          'fire_escape' => $all['fire_escape'],
        ];
      } else {
        $array = [
          'status' => false,
          'stand_out' => false,
          'consultants_id' => null,
          'title' => $all['title'],
          'slug' => PermaLinkHelper::permalink($all['title']),
          'province' => $all['province'],
          'district' => $all['district'],
          'neighborhood' => $all['neighborhood'],
          'gross' => $all['gross'],
          'net' => $all['net'],
          'number_of_rooms' => $all['number_of_rooms'],
          'available_for_loan' => $all['available_for_loan'],
          'furniture_situation' => $all['furniture_situation'],
          'number_of_bathrooms' => $all['number_of_bathrooms'],
          'description' => $all['description'],
          'number_of_floors_in_the_building' => $all['number_of_floors_in_the_building'],
          'building_age' => $all['building_age'],
          'floor_location' => $all['floor_location'],
          'heating_type' => $all['heating_type'],
          'monthly_dues' => $all['monthly_dues'],
          'listing_date' => date('Y-m-d H:i:s'),
          'garden' => $all['garden'],
          'balcony' => $all['balcony'],
          'water_tank' => $all['water_tank'],
          'exterior' => $all['exterior'],
          'parking_lift' => $all['parking_lift'],
          'parking_lot' => $all['parking_lot'],
          'parking_garage' => $all['parking_garage'],
          'building_lift' => $all['building_lift'],
          'sound_insulation' => $all['sound_insulation'],
          'adsl' => $all['adsl'],
          'fiber_internet' => $all['fiber_internet'],
          'smart_house' => $all['smart_house'],
          'alarm' => $all['alarm'],
          'parent_bathroom' => $all['parent_bathroom'],
          'video_intercom' => $all['video_intercom'],
          'cellar' => $all['cellar'],
          'air_conditioning' => $all['air_conditioning'],
          'built_in' => $all['built_in'],
          'laminate' => $all['laminate'],
          'pvc_joinery' => $all['pvc_joinery'],
          'steel_door' => $all['steel_door'],
          'fireplace' => $all['fireplace'],
          'combi' => $all['combi'],
          'outdoor_swimming_pool' => $all['outdoor_swimming_pool'],
          'indoor_swimming_pool' => $all['indoor_swimming_pool'],
          'security' => $all['security'],
          'camera_system' => $all['camera_system'],
          'doorman' => $all['doorman'],
          'day_nursery' => $all['day_nursery'],
          'sports_field' => $all['sports_field'],
          'fire_escape' => $all['fire_escape'],
        ];
      }

      if (isset($all['rental_price'])) {
        $array['rental_price'] = $all['rental_price'];
      } else {
        $array['rental_price'] = null;
      }

      if (isset($all['sale_price'])) {
        $array['sale_price'] = $all['sale_price'];
      } else {
        $array['sale_price'] = null;
      }

      $advertissement = Advertisement::find($id);

      $allTitle = Advertisement::pluck("title")->toArray();

      if ($advertissement->title != $array["title"] && in_array($array["title"], $allTitle)) {
        return back()->with("error", "Girdiğiniz ilan başlığı zaten var. Lütfen başka bir başlık bulun.");
      }

      if (count($all["apartment_facades"]) > 0) {
        $dataAparts = [];
        $advertissement->apartment_facades()->delete();

        foreach ($all["apartment_facades"] as $apartment_facade) {
          $dataAparts[] = ["advertissement_id" => $id, "apartment_facade" => $apartment_facade];
        }

        $advertissement->apartment_facades()->createMany($dataAparts);
      }

      $update =  $advertissement->update($array);


      if ($update) {
        return redirect('admin/my_advertisement')->with('success', 'İlan ayarları başarılı bir şekilde güncellendi.');
      } else {
        return redirect()->back()->with('error', 'İlan güncelleme sırasında bir sorun oluştu. Daha sonra tekrar deneyiniz!');
      }
    } else {
      return abort(404);
    }
  }

  public function delete($id)
  {
    $c = Advertisement::where('id', $id)->count();

    if ($c != 0) {
      $delete = Advertisement::where('id', $id)->delete();

      if ($delete) {
        return redirect('admin/my_advertisement')->with('success', 'İlan başarılı bir şekilde silindi.');
      } else {
        return redirect()->back()->with('error', 'İlan silinirken sırasında bir sorun oluştu. Daha sonra tekrar deneyiniz!');
      }
    } else {
      return abort(404);
    }
  }

  public function picture($id)
  {
    $c = Advertisement::where('id', $id)->count();

    if ($c != 0) {
      $data = Advertisement::where('id', $id)->get();
      $all_picture = AdvertisementImage::where('advertisement_id', $id)->orderBy('id', 'DESC')->paginate(5);

      return view('admin.my_advertisement.picture', ["data" => $data, 'all_picture' => $all_picture]);
    } else {
      return abort(404);
    }
  }

  public function insertPicture(Request $request)
  {
    $id = $request->route('id');

    $imageFile = $request->file('file');
    $image = (isset($imageFile)) ? ImageUploadHelper::uploadAdvertisement(rand(1, 9000), "ad", $imageFile) : "";

    $array = [
      'advertisement_id' => $id,
      'image_url' => $image
    ];

    $insert = AdvertisementImage::create($array);
  }

  public function deletePicture($id)
  {
    $c = AdvertisementImage::where('id', $id)->count();
    $data = AdvertisementImage::where('id', $id)->get();

    if ($c != 0) {
      delete_image($data[0]["image_url"]);
      $delete = AdvertisementImage::where('id', $id)->delete();

      if ($delete) {
        return redirect()->back()->with("success", "Resmi bir şekilde silindi.");
      } else {
        return redirect()->back()->with('error', 'İlan resmi silinme sırasında bir sorun oluştu. Daha sonra tekrar deneyiniz!');
      }
    } else {
      return abort(404);
    }
  }

  public function editPicture($id)
  {
    $data = AdvertisementImage::findOrFail($id);
    return view("admin.my_advertisement.edit-picure", compact("data"));
  }

  public function uploadPicture($id, Request $request)
  {
    $response = [];
    $image = $request->image;
    $isUploaded = false;

    if ($image) {
      $destinationPath = "front_assets/uploads/ad";

      if (!File::exists($destinationPath)) {
        File::makeDirectory($destinationPath, 0755, true);
      }

      $image_array_1 = explode(";", $image);
      $image_array_2 = explode(",", $image_array_1[1]);
      $image_base64 = base64_decode($image_array_2[1]);

      $fileName = rand(1, 1000) . '-' . rand(1, 1000) . '.' . 'png';
      $file = $destinationPath . "/" . $fileName;

      $success = file_put_contents($file, $image_base64);

      if ($success) {
        $data = AdvertisementImage::find($id);
        if (file_exists($data->image_url)) {
          unlink($data->image_url);
        }
        $updated = $data->update(["image_url" => $file]);

        if ($updated) {
          $isUploaded = true;
          $response["message"] = "Edited successfully!";
          $response["success"] = '<img src="/' . $data->image_url . '" class="img-thumbnail" />';
        }
      }
    }

    if (!$isUploaded) {
      $response["error"] = "<p class='text-danger'>Error while uploading. Please try again!</p>";
    }

    return response()->json($response);
  }

  public function isCoverSetter(Request $request)
  {
    $id = $request->route('id');
    $parent_id = $request->route('parent_id');

    $all = $request->except('_token');
    $isCover = ($all['data'] === "true") ? 1 : 0;

    AdvertisementImage::where('id', $id)->where('advertisement_id', $parent_id)->update(['isCover' => $isCover]);
    AdvertisementImage::where('id', "!=", $id)->where('advertisement_id', $parent_id)->update(['isCover' => 0]);
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
}
