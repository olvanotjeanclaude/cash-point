<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;
use Illuminate\Foundation\Auth\RegistersUsers;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);
    }

    public function register(Request $request)
    {
        $data = $request->except("_token");
        $rules = [
            "name" => "required",
            "surname" => "required",
            "email" => "required|email",
            "gender" => "required",
            "password" => "required|min:6",
            "password_confirmation" => "required|same:password"
        ];

        $messages = [
            "name.required" => "Adı: Bu alanın doldurulması zorunludur.",
            "surname.required" => "Soyad:  Bu alanın doldurulması zorunludur.",
            "email.required" => "E-posta: Bu alanın doldurulması zorunludur.",
            "gender.required" => "Cinsiyet: Bu alanın doldurulması zorunludur.",
            "email.required" => "E-posta: Bu alanın doldurulması zorunludur..",
            "email.email" => "E-posta: Geçerli e-postayı girin.",
            "password.required" => "Şifreyi boş bırakılmaz",
            "password.min" => "Şifre en az 6 karakter olmalıdır.",
            "password_confirmation.required" => "Şifre onay alanı zorunludur.",
            "password_confirmation.same" => "Şifre onayı ve şifre eşleşmelidir.."
        ];

        $validator = Validator::make($data, $rules, $messages);

        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->withInput();
        }

        $data["is_term_accepted"] = isset($data["is_term_accepted"]) ? true : false;
        $data["password"] = Hash::make($data["password"]);

        unset($data["password_confirmation"]);
      
       $insert = User::create($data);

        if ($insert) {
            return redirect()->route("login")->with('success', 'Hesabı başarılı bir şekilde oluştu.');
        } 

        return redirect()->back()->with('error', 'Hesabı oluştururken bir sorun oluştu. Daha sonra tekrar deneyiniz!')->withInput();
    }
}
