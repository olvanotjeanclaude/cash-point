<?php

namespace App\Http\Controllers\front\subscriber;

use App\Http\Controllers\Controller;
use App\Models\Subscribe;
use App\Models\Subscriber;
use Illuminate\Http\Request;

class SubscriberController extends Controller
{
    public function store(Request $request){
        $all= $request->except("_token");

        $inserted = Subscriber::updateOrCreate(
            [
                "email" =>$all["email"]
            ],
            [
                "email" =>$all["email"]
            ]
        );
        
        if ($inserted) {
            return back()->with('success', 'Abone olduğunuz için teşekkür ederiz.');
        } 

        return redirect()->back()->with('error', 'Bir sorun oluştu. Daha sonra tekrar deneyiniz!')->withInput();
    }
}
