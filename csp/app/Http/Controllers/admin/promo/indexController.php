<?php

namespace App\Http\Controllers\admin\promo;

use App\Helper\ImageUploadHelper;
use App\Http\Controllers\Controller;
use App\Promo;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class indexController extends Controller
{
  public function index()
  {
    $promos = DB::table('promos')
      ->select('promos.*', 'users.company_name')
      ->join('users', 'promos.company_id','=', 'users.id')
      ->orderBy('status', 'DESC')
      ->paginate(5);

    $bottomPromos = Promo::where('location', 1)->where('status', 1)->get();
    $rightPromo = Promo::where('location', 2)->where('status', 1)->get();

    return view('admin.promo.index', [
      'promos' => $promos,
      'bottomPromos' => $bottomPromos,
      'rightPromo' => $rightPromo
    ]);
  }

  public function create()
  {
    $companies = User::where('permission', 4)->get();

    return view('admin.promo.create', [
      'companies' => $companies,
    ]);
  }

  public function right_create()
  {
    $companies = User::where('permission', 4)->get();

    return view('admin.promo.right_create', [
      'companies' => $companies,
    ]);
  }

  public function store(Request $request)
  {
    $all = $request->except('_token');
    $image = (isset($all['image'])) ? ImageUploadHelper::uploadAdvertisement(rand(1, 9000), "pr", $all['image']) : "";

    $array = [
      'company_id' => $all['company_id'],
      'image' => $image,
      'status' => true,
      'location' => 1,
      'user_id' => Auth::user()->id,
      'finished_at' => $all['finished_at']
    ];

    $insert = Promo::create($array);

    if ($insert) {
      return redirect('admin/promo')->with('success', 'Reklam başarılı bir şekilde eklendi.');
    } else {
      return redirect()->back()->with('error', 'Reklam kaydı sırasında bir sorun oluştu. Daha sonra tekrar deneyiniz!')->withInput();
    }
  }

  public function right_store(Request $request)
  {
    $all = $request->except('_token');
    $image = (isset($all['image'])) ? ImageUploadHelper::uploadAdvertisement(rand(1, 9000), "pr", $all['image']) : "";

    $array = [
      'company_id' => $all['company_id'],
      'image' => $image,
      'status' => true,
      'location' => 2,
      'user_id' => Auth::user()->id,
      'finished_at' => $all['finished_at']
    ];

    $insert = Promo::create($array);

    if ($insert) {
      return redirect('admin/promo')->with('success', 'Reklam başarılı bir şekilde eklendi.');
    } else {
      return redirect()->back()->with('error', 'Reklam kaydı sırasında bir sorun oluştu. Daha sonra tekrar deneyiniz!')->withInput();
    }
  }

  public function edit($id)
  {
    $c = Promo::where('id', $id)->count();

    if ($c != 0) {
      $data = Promo::where('id', $id)->get();
      $companies = User::where('permission', 4)->get();

      return view('admin.promo.edit', [
        "data" => $data,
        'companies' => $companies
      ]);
    } else {
      return abort(404);
    }
  }

  public function update(Request $request)
  {
    $id = $request->route('id');
    $c = Promo::where('id', $id)->count();

    if ($c != 0) {
      $all = $request->except("_token");
      $data = Promo::where('id', $id)->get();

      $array = [
        'status' => $all['status'],
        'finished_at' => $all['finished_at']
      ];

      if (isset($all['image'])) {
        unlink(public_path($data[0]['image']));
        $array['image'] = ImageUploadHelper::uploadAdvertisement(rand(1, 9000), "pr", $all['image']);
      }

      $update = Promo::where('id', $id)->update($array);

      if ($update) {
        return redirect('admin/promo')->with('success', 'Reklam başarılı bir şekilde güncellendi.');
      } else {
        return redirect()->back()->with('error', 'Reklam güncelleme sırasında bir sorun oluştu. Daha sonra tekrar deneyiniz!');
      }

    } else {
      return abort(404);
    }
  }

  public function delete($id)
  {
    $c = Promo::where('id', $id)->count();
    $data = Promo::where('id', $id)->get();

    if ($c != 0) {
      if(file_exists($data[0]["image"])){
        unlink(($data[0]['image']));
      }
      $delete = Promo::where('id', $id)->delete();

      if ($delete) {
        return redirect('admin/promo')->with('success', 'Reklam başarılı bir şekilde silindi.');
      } else {
        return redirect()->back()->with('error', 'Reklam silinirken sırasında bir sorun oluştu. Daha sonra tekrar deneyiniz!');
      }
    } else {
      return abort(404);
    }
  }
}
