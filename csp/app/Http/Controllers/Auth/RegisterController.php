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
            "name.required" => "Ad??: Bu alan??n doldurulmas?? zorunludur.",
            "surname.required" => "Soyad:  Bu alan??n doldurulmas?? zorunludur.",
            "email.required" => "E-posta: Bu alan??n doldurulmas?? zorunludur.",
            "gender.required" => "Cinsiyet: Bu alan??n doldurulmas?? zorunludur.",
            "email.required" => "E-posta: Bu alan??n doldurulmas?? zorunludur..",
            "email.email" => "E-posta: Ge??erli e-postay?? girin.",
            "password.required" => "??ifreyi bo?? b??rak??lmaz",
            "password.min" => "??ifre en az 6 karakter olmal??d??r.",
            "password_confirmation.required" => "??ifre onay alan?? zorunludur.",
            "password_confirmation.same" => "??ifre onay?? ve ??ifre e??le??melidir.."
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
            return redirect()->route("login")->with('success', 'Hesab?? ba??ar??l?? bir ??ekilde olu??tu.');
        } 

        return redirect()->back()->with('error', 'Hesab?? olu??tururken bir sorun olu??tu. Daha sonra tekrar deneyiniz!')->withInput();
    }
}
