<?php

namespace App\Http\Controllers\admin\password;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;

class indexController extends Controller
{
  public function index($id)
  {
    $c = User::where('id', $id)->count();

    if ($c != 0) {
      return view('admin.password.index');
    } else {
      return abort(404);
    }
  }

  public function update(Request $request)
  {
    $id = $request->route('id');
    if ($id != 0) {
      $password = md5($request->post('password'));
      $re_password = md5($request->post('re_password'));

      if ($password != $re_password) {
        return redirect()->back()->with('error', 'Şifreler uyuşmuyor. Tekrar Deneyiniz!');
      } else {
        $data = [
          'password' => $password
        ];

        $update = User::where('id', $id)->update($data);
        if ($update) {
          return redirect()->back()->with('success', 'Şifreniz başarılı bir şekilde güncellendi.');
        } else {
          return redirect()->back()->with('error', 'Şifre güncelleme sırasında bir sorun oluştu. Daha sonra tekrar deneyiniz!');
        }
      }
    } else {
      return abort(404);
    }
  }
}
