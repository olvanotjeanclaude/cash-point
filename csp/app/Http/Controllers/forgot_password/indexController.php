<?php

namespace App\Http\Controllers\forgot_password;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class indexController extends Controller
{
  public function index()
  {
    return view('emails.index');
  }

  public function create(Request $request)
  {
    $c = User::where('email', $request['email'])->count();

    $data = ['email' => $request['email']];

    if ($c != 0) {
      // Artık Mail Göndericez
      Mail::send("emails.details", $data, function ($message) use ($request) {
        $message->subject('IMSIAD Satıştaki Projeler | Şifremi Unuttum');
        $message->from('satistakiprojelerinfotr@gmail.com', 'İMSİAD Satıştaki Projeler');
        $message->to($request['email']);
      });

      return redirect()->back()->with("success", "E-posta Gönderildi");

    } else {
      return redirect()->back()->with("error", "Sistemde kayıtlı değilsiniz");
    }
  }

  public function resetPassword($email)
  {
    return view('emails.create', ['email' => $email]);
  }

  public function updatePassword(Request $request)
  {
    $email = $request->route('email');
    $c = User::where('email', $email)->count();

    if ($c != 0) {
      $password = md5($request->post('password'));
      $re_password = md5($request->post('re_password'));

      if ($password != $re_password) {
        return redirect()->back()->with('error', 'Şifreler uyuşmuyor. Tekrar Deneyiniz!');
      } else {
        $data = ['password' => $password];

        $update = User::where('email', $email)->update($data);
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
