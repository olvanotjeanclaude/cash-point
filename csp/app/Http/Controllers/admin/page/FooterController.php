<?php

namespace App\Http\Controllers\admin\page;

use App\PageFooter;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Str;
use Yajra\DataTables\Facades\DataTables;

class FooterController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view("admin.page.footer.index");
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view("admin.page.footer.create");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $all = $request->except("_token");

        $request->validate([
            "title" => "required",
            "page_title" => "required",
            "content" => "required"
        ]);

        $array = [
            "title" => $all["title"],
            "page_title" => $all["page_title"],
            "content" => $all["content"],
            "description" => isset($all["description"]) ? $all["description"] : null,
            "slug" => Str::of($all["page_title"])->slug("-")
        ];

        $inserted = PageFooter::create($array);

        if ($inserted) {
            return redirect()->route("admin.page.footer.index")->with('success', 'Alt başlık başarılı bir şekilde eklendi. Yeni bir alt başlık ekleyebilirsiniz.');
        } else {
            return redirect()->back()->with('error', 'Alt başlık kaydı sırasında bir sorun oluştu. Daha sonra tekrar deneyiniz!')->withInput();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $footerLink = PageFooter::findOrFail($id);

        return view("admin.page.footer.edit", compact("footerLink"));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $all = $request->except("_token");
        $request->validate([
            "title" => "required",
            "page_title" => "required",
            "content" => "required"
        ]);

        $array = [
            "title" => $all["title"],
            "page_title" => $all["page_title"],
            "content" => $all["content"],
            "description" => isset($all["description"]) ? $all["description"] : null,
            "slug" => Str::of($all["page_title"])->slug("-"),
            "status" =>$all["status"]
        ];
      

        $countKurumsalLink = PageFooter::where("title", 1)->where('status', true)->count();
        $countquickLink = PageFooter::where("title", 2)->where("status", true)->count();
        //*  */dd($countquickLink);
        $error = "";
        $isErrorExist = false;

        if ($all["title"] == 1 && $countKurumsalLink > 10) {
            $error = "Sadece 10 tane kurumsal linki ekleyebilirsiniz.";
            $isErrorExist = true;
        } else if ($all["title"] == 2 && $countquickLink >= 4) {
            $error = "Sadece 4 tane hızlı bağlantıları ekleyebilirsiniz.";
            $isErrorExist = true;
        }

        if ($isErrorExist) {
            return back()->with("error", $error)->withInput();
        }

        $footerLink = PageFooter::findOrFail($id);
        $updated = $footerLink->update($array);

        if ($updated) {
            return redirect()->route("admin.page.footer.index")->with('success', 'Alt başlık başarılı bir şekilde güncellendi.');
        } else {
            return redirect()->back()->with('error', 'Alt başlık güncelleme sırasında bir sorun oluştu. Daha sonra tekrar deneyiniz!')->withInput();
        }
    }

    public function data(Request $request)
    {
        $result = DataTables::of(PageFooter::all())
            ->addColumn('status', function ($query) {
                if ($query->status == 1) {
                    return '<label class="badge badge-success">Aktif</label>';
                } else if ($query->status == 0) {
                    return '<label class="badge badge-danger">Pasif</label>';
                }
            })
            ->addColumn('title', function ($query) {
                if ($query->title == 1) {
                    return '<label class="badge badge-primary">Kurumsal</label>';
                } else if ($query->title == 2) {
                    return '<label class="badge badge-info">Bağlantılar</label>';
                }
            })
            ->addColumn('page_title', function ($query) {
                return '<a href="/front/' . $query->slug . '" target="_blank">' . $query->page_title . '</span>';
            })
            ->addColumn('edit', function ($query) {
                return '<a class="btn btn-success btn-sm" href="' . route('admin.page.footer.edit', ['id' => $query->id]) . '">Düzenle</a>';
            })
            ->addColumn('delete', function ($query) {
                return '<a class="btn btn-danger btn-sm remove-btn" style="color: #fff;"  data-url="' . route('admin.page.footer.delete', ['id' => $query->id]) . '">Sil</a>';
            })
            ->rawColumns(["status", "title", "page_title", "edit", "delete"])
            ->make(true);

        return $result;
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {
        $footerLink = PageFooter::findOrFail($id);
        $deleted = $footerLink->delete();
        if ($deleted) {
            return redirect()->route("admin.page.footer.index")->with('success', 'Alt başlık başarılı bir şekilde silindi.');
        } else {
            return redirect()->back()->with('error', 'Alt başlık silinirken sırasında bir sorun oluştu. Daha sonra tekrar deneyiniz!');
        }
    }
}
