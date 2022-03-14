<?php

namespace App\Http\Controllers\admin\consultants;

use App\Consultants;
use App\Helper\ImageUploadHelper;
use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\DataTables;

class indexController extends Controller
{
  public function index()
  {
    return view('admin.consultants.index');
  }

  public function data(Request $request)
  {
    $result = DataTables::of(Consultants::where('user_id', Auth::user()->id))
      ->editColumn('email', function ($query) {
        return '<a href="mailto:' . $query->email . '">' . $query->email . '</a>';
      })
      ->editColumn('phone', function ($query) {
        return '<a href="tel:' . $query->phone . '">' . $query->phone . '</a>';
      })
      ->addColumn('edit', function ($query) {
        return '<a class="btn btn-success btn-sm" href="' . route('admin.consultants.edit', ['id' => $query->id]) . '">Düzenle</a>';
      })
      ->addColumn('delete', function ($query) {
        return '<a class="btn btn-danger btn-sm remove-btn" style="color: #fff;"  data-url="' . route('admin.consultants.delete', ['id' => $query->id]) . '">Sil</a>';
      })
      ->rawColumns(["email", "phone", "edit", "delete"])
      ->make(true);

    return $result;
  }

  public function create()
  {
    return view('admin.consultants.create');
  }

  public function store(Request $request)
  {
    $all = $request->except('_token');

    $array = [
      'user_id' => Auth::user()->id,
      'name' => $all['name'],
      'surname' => $all['surname'],
      'email' => $all['email'],
      'phone' => $all['phone'],
    ];

    $insert = Consultants::create($array);

    if ($insert) {
      return redirect('admin/consultants/create')->with('success', 'Müşteri temsilcisi başarılı bir şekilde eklendi. Yeni bir danışman ekleyebilirsiniz.');
    } else {
      return redirect()->back()->with('error', 'Müşteri temsilcisi kaydı sırasında bir sorun oluştu. Daha sonra tekrar deneyiniz!')->withInput();
    }
  }

  public function edit($id)
  {
    $c = Consultants::where('id', $id)->count();

    if ($c != 0) {
      $data = Consultants::where('id', $id)->get();
      return view('admin.consultants.edit', ["data" => $data]);
    } else {
      return abort(404);
    }
  }

  public function update(Request $request)
  {
    $id = $request->route('id');
    $c = Consultants::where('id', $id)->count();

    if ($c != 0) {
      $all = $request->except("_token");

      $array = [
        'name' => $all['name'],
        'surname' => $all['surname'],
        'email' => $all['email'],
        'phone' => $all['phone']
      ];

      $update = Consultants::where('id', $id)->update($array);

      if ($update) {
        return redirect('admin/consultants')->with('success', 'Müşteri temsilcisi başarılı bir şekilde güncellendi.');
      } else {
        return redirect()->back()->with('error', 'Müşteri temsilcisi güncelleme sırasında bir sorun oluştu. Daha sonra tekrar deneyiniz!');
      }

    } else {
      return abort(404);
    }
  }

  public function delete($id)
  {
    $c = Consultants::where('id', $id)->count();

    if ($c != 0) {
      $delete = Consultants::where('id', $id)->delete();

      if ($delete) {
        return redirect('admin/consultants')->with('success', 'Müşteri temsilcisi başarılı bir şekilde silindi.');
      } else {
        return redirect()->back()->with('error', 'Müşteri temsilcisi silinirken sırasında bir sorun oluştu. Daha sonra tekrar deneyiniz!');
      }
    } else {
      return abort(404);
    }
  }
}
