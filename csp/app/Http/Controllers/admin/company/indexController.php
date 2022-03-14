<?php

namespace App\Http\Controllers\admin\company;

use App\Helper\ImageUploadHelper;
use App\Helper\PermaLinkHelper;
use App\Http\Controllers\Controller;
use App\User;
use Faker\Provider\Company;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class indexController extends Controller
{
  public function index()
  {
    return view('admin.company.index');
  }

  public function data(Request $request)
  {
    $result = DataTables::of(User::where('permission', 4))
      ->addColumn('permission', function ($query) {
        if ($query->permission == 4) {
          return '<label class="badge badge-info">Firma</label>';
        }
      })
      ->editColumn('email', function ($query) {
        return '<a href="mailto:' . $query->email . '">' . $query->email . '</a>';
      })
      ->addColumn('edit', function ($query) {
        return '<a class="btn btn-success btn-block btn-sm" href="' . route('admin.company.edit', ['id' => $query->id]) . '">Düzenle</a>';
      })
      ->addColumn('delete', function ($query) {
        return '<a class="btn btn-danger btn-block btn-sm remove-btn" style="color: #fff;" data-url="' . route('admin.company.delete', ['id' => $query->id]) . '">Sil</a>';
      })
      ->rawColumns(["permission", "email", "consultants", "edit", "delete"])
      ->make(true);

    return $result;
  }

  public function create()
  {
    return view('admin.company.create');
  }

  public function store(Request $request)
  {
    $all = $request->except("_token");
    $image = (isset($all['image'])) ? ImageUploadHelper::upload(rand(1, 9000), "company", $all['image']) : "";

    $array = [
      'permission' => '4',
      'name' => $all['name'],
      'surname' => $all['surname'],
      'email' => $all['email'],
      'password' => md5($request->input('password')),
      'phone' => $all['phone'],
      'company_name' => $all['company_name'],
      'slug' => PermaLinkHelper::permalink($all['company_name']),
      'description' => $all['description'],
      'image' => $image
    ];

    $insert = User::create($array);

    if ($insert) {
      return redirect('admin/company')->with('success', 'Firma başarılı bir şekilde eklendi.');
    } else {
      return redirect()->back()->with('error', 'Firma kaydı sırasında bir sorun oluştu. Daha sonra tekrar deneyiniz!')->withInput();
    }
  }

  public function edit($id)
  {
    $c = User::where('id', $id)->count();

    if ($c != 0) {
      $data = User::where('id', $id)->get();
      return view('admin.company.edit', ["data" => $data]);
    } else {
      return abort(404);
    }
  }

  public function update(Request $request)
  {
    $id = $request->route('id');
    $c = User::where('id', $id)->count();

    if ($c != 0) {
      $all = $request->except("_token");
      $data = User::where('id', $id)->get();

      $array = [
        'permission' => '4',
        'name' => $all['name'],
        'surname' => $all['surname'],
        'email' => $all['email'],
        'phone' => $all['phone'],
        'company_name' => $all['company_name'],
        'slug' => PermaLinkHelper::permalink($all['company_name']),
        'description' => $all['description'],
      ];

      if (isset($all['image'])) {
        unlink(public_path($data[0]['image']));
        $array['image'] = ImageUploadHelper::upload(rand(1, 9000), "company", $all['image']);
      }

      $update = User::where('id', $id)->update($array);

      if ($update) {
        return redirect('admin/company')->with('success', 'Firma başarılı bir şekilde güncellendi.');
      } else {
        return redirect()->back()->with('error', 'Firma güncelleme sırasında bir sorun oluştu. Daha sonra tekrar deneyiniz!');
      }
    } else {
      return abort(404);
    }
  }

  public function delete($id)
  {
    $c = User::where('id', $id)->count();
    $data = User::where('id', $id)->get();

    if ($c != 0) {
      $delete = User::where('id', $id)->delete();

      if ($delete) {
        delete_image($data[0]['image']);
        return redirect('admin/company')->with('success', 'Firma başarılı bir şekilde silindi.');
      } else {
        return redirect()->back()->with('error', 'Firma silinirken sırasında bir sorun oluştu. Daha sonra tekrar deneyiniz!');
      }
    } else {
      return abort(404);
    }
  }
}
