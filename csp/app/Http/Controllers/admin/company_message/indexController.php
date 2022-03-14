<?php

namespace App\Http\Controllers\admin\company_message;

use App\CompanyAdvertisementMessage;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class indexController extends Controller
{
  public function index()
  {
    return view('admin.company_message.index');
  }

  public function data(Request $request)
  {
    $result = DataTables::of(DB::select('select cm.id as cmID, cm.user_id, cm.advertisement_id, cm.name, cm.surname, cm.phone, cm.email, cm.text, ad.slug, ad.id from company_advertisement_messages cm left join advertisements ad on cm.advertisement_id = ad.id where cm.user_id = ?', [Auth::user()->id]))
      ->addColumn('slug', function ($query) {
        return '<a href="'.route('admin.my_advertisement.edit', ['id' => $query->id]).'">İlana Git</a>';
      })
      ->editColumn('email', function ($query) {
        return '<a href="mailto:' . $query->email . '">' . $query->email . '</a>';
      })
      ->editColumn('phone', function ($query) {
        return '<a href="tel:' . $query->phone . '">' . $query->phone . '</a>';
      })
      ->addColumn('text', function ($query) {
        return '<a id="btn_properties" class="btn btn-success btn-sm" data-toggle="modal" data-target="#exampleModal" data-id="'.$query->cmID.'">Ayrıntılar</button>';
      })
      ->rawColumns(["slug", "email", "phone", "text"])
      ->make(true);

    return $result;
  }

  public function getMessage(Request $request)
  {
    $query = $request->get('query');

    $result = CompanyAdvertisementMessage::where('id', $query)->get();
    return json_encode($result);
  }
}
