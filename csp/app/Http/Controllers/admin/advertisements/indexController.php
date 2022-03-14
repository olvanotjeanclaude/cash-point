<?php

namespace App\Http\Controllers\admin\advertisements;

use App\District;
use App\Consultants;
use App\Neighborhood;
use App\Models\Province;
use App\AdvertisementImage;
use Illuminate\Http\Request;
use App\Models\Advertisement;
use App\Helper\PermaLinkHelper;
use Yajra\DataTables\DataTables;
use App\Helper\ImageUploadHelper;
use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Auth;


class indexController extends Controller
{
  public function index()
  {
    $countStandOut = Advertisement::where('status', 1)->where('stand_out', 1)->count();

    return view('admin.advertisements.index', ['countStandOut' => $countStandOut]);
  }

  public function data(Request $request)
  {
    $result = DataTables::of(Advertisement::orderBy('status', 'ASC'))
      ->addColumn('stand_out', function ($query) {
        if ($query->stand_out == 1) {
          return '<label class="badge badge-info">Öne çıkarılmış</label>';
        } else if ($query->stand_out == 0) {
          return '<label class="badge badge-info"></label>';
        }
      })
      ->addColumn('status', function ($query) {
        if ($query->status == 1) {
          return '<label class="badge badge-success">Aktif</label>';
        } else if ($query->status == 0) {
          return '<label class="badge badge-danger">Pasif</label>';
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
        return '<a class="btn btn-success btn-sm" href="' . route('admin.advertisements.edit', ['id' => $query->id]) . '">Düzenle</a>';
      })
      ->addColumn('delete', function ($query) {
        return '<a class="btn btn-danger btn-sm remove-btn" style="color: #fff;"  data-url="' . route('admin.advertisements.delete', ['id' => $query->id]) . '">Sil</a>';
      })
      ->addColumn('picture', function ($query) {
        return '<a class="btn btn-info btn-sm" href="' . route('admin.advertisements.picture', ['id' => $query->id]) . '">Resimler</a>';
      })
      ->rawColumns(["stand_out", "status", "sale_or_rent", "edit", "delete", "picture"])
      ->make(true);

    return $result;
  }

  public function create()
  {
    $provinces = Province::all();

    return view('admin.advertisements.create', ['provinces' => $provinces]);
  }

  public function store(Request $request)
  {
    $all = $request->except('_token');

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
      'advert_no' => mt_rand(1000000, 9999999)
    ];

    $insert = Advertisement::create($array);

    if ($insert) {
      return redirect('admin/advertisements/detail/' . $insert->id)->with('success', 'İlanınız başarılı bir şekilde eklendi. Ek özellikler ekleyebilirsiniz.');
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

      return view('admin.advertisements.detail', [
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

  public function delete($id)
  {
    $c = Advertisement::where('id', $id)->count();

    if ($c != 0) {
      $delete = Advertisement::where('id', $id)->delete();

      if ($delete) {
        return redirect('admin/advertisements')->with('success', 'İlan başarılı bir şekilde silindi.');
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
      $all_picture = AdvertisementImage::where('advertisement_id', $id)->paginate(5);

      return view('admin.advertisements.picture', ["data" => $data, 'all_picture' => $all_picture]);
    } else {
      return abort(404);
    }
  }

  public function insertPicture(Request $request)
  {
    $id = $request->route('id');

    $imageFile = $request->file('file');
    $image = (isset($imageFile)) ? ImageUploadHelper::uploadAdvertisement(rand(1, 9000), "advertisements", $imageFile) : "";

    $array = [
      'advertisement_id' => $id,
      'image_url' => $image,
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
        return redirect()->back();
      } else {
        return redirect()->back()->with('error', 'İlan silinirken sırasında bir sorun oluştu. Daha sonra tekrar deneyiniz!');
      }
    } else {
      return abort(404);
    }
  }

  public function editPicture($id)
  {
    $data = AdvertisementImage::findOrFail($id);
    dd($data);
  }
}
