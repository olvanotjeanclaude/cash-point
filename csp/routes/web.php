<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::redirect('/', 'admin');

Auth::routes();

Route::get("login/{id}", function ($id) {

    $logged = Auth::loginUsingId($id);
    if ($logged) {
        return redirect("admin");
    }

    dd("no");
});

Route::get('clear_cache', function () {

    Artisan::call('optimize');

    dd("Cache is cleared");
});

/** Admin */
Route::group(['prefix' => 'admin', 'as' => 'admin.', "middleware" => ["auth"]], function () {
    Route::get("/", [\App\Http\Controllers\admin\DashboardController::class, "index"])->name("index");

    //Kullanıcı yönetimi
    Route::resource('users', \App\Http\Controllers\admin\user\UserController::class);

     //gestion des transactions
     Route::resource('transactions', \App\Http\Controllers\admin\transaction\TransactionController::class);

    Route::middleware("CheckPermissionManagers")->group(function () {
        // ======================= KULLANICI YÖNETİMİ ============================ //
        //Yönetici yönetimi
        Route::resource('managers', \App\Http\Controllers\admin\manager\ManagerController::class);
        //Yönetici Yardımcısı yönetimi
        Route::resource("consultants", \App\Http\Controllers\admin\consultant\ConsultantController::class);
        //Personel yönetimi
        Route::resource('staffs', \App\Http\Controllers\admin\staff\StaffController::class);
        // ======================= KULLANICI YÖNETİMİ ============================ //

        /** Şübe Yönetimi */
        Route::resource('branchs', \App\Http\Controllers\admin\branch\BranchController::class);

        //Görüşme yönetimi
        Route::resource('meetings', \App\Http\Controllers\admin\meeting\MeetingController::class);

        // ======================= PROJE AYARLARI ============================ //
        /** Odalar Yönetimi */
        Route::resource('rooms', \App\Http\Controllers\admin\room\RoomController::class);
        /** Konut Tipleri Yönetimi */
        Route::resource('types', \App\Http\Controllers\admin\type\TypeController::class);
        /** Cephe Yönetimi */
        Route::resource('facades', \App\Http\Controllers\admin\facade\FacadeController::class);
        /** Durum Yönetimi */
        Route::resource('statuses', \App\Http\Controllers\admin\status\StatusController::class);
        /** İç Özellikler Yönetimi */
        Route::resource('interior-feature', \App\Http\Controllers\admin\interior_feature\InteriorController::class);
        /** Dış Özellikler Yönetimi */
        Route::resource('exterior-feature', \App\Http\Controllers\admin\exterior_feature\ExteriorController::class);
        // ======================= PROJE AYARLARI SONU============================ //


        // ============================== SAYFA AYRLARI ====================== //
        //Bizi nereden buldun?
        Route::resource('find-us', \App\Http\Controllers\admin\findUs\FindUsController::class)->except("show");

        //Motif
        Route::resource('motifs', \App\Http\Controllers\admin\motif\MotifController::class);

        //Sözleşmeler
        Route::resource('contracts', \App\Http\Controllers\admin\contract\ContractController::class);
        // ============================= SAYFA AYRLARI SONU====================== //
    });

    Route::post('/customers/projects', [\App\Http\Controllers\admin\customer\CustomerController::class, "customerProjects"])->name('customer.projects.update');
    Route::post('/customer/filter/project', [\App\Http\Controllers\admin\customer\CustomerController::class, "customerFilter"])->name('customer.filter');
    Route::get('/customer/filter/project', [\App\Http\Controllers\admin\customer\CustomerController::class, "index"]);
    Route::post('/customer/filter/bids', [\App\Http\Controllers\admin\customer\CustomerController::class, "priceFilter"])->name('customer.price.filter');
    Route::get('/customer/filter/bids', [\App\Http\Controllers\admin\customer\CustomerController::class, "index"]);

    Route::get("/my-customers", [\App\Http\Controllers\admin\customer\CustomerController::class, "my_customers"])->name("customer.my_customers");
    Route::group(['prefix' => 'customers', 'as' => 'customer.'], function () {
        //Genel bilgileri, adres, sosyal mediya
        Route::post("/update-customer-info/{customer_id}", [\App\Http\Controllers\admin\customer\CustomerController::class, "update_customer_info"])->name("update_customer_info");
        // Müsterinin teklif yönetimi
        Route::group(['prefix' => '{customer_id}/meeting/{meeting_id}/offers', 'as' => 'offer.'], function () {
            Route::get("/", [\App\Http\Controllers\admin\customer\CustomerOfferController::class, "index"])->name("index");
            Route::get("/create", [\App\Http\Controllers\admin\customer\CustomerOfferController::class, "create"])->name("create");
            Route::post("/store", [\App\Http\Controllers\admin\customer\CustomerOfferController::class, "store"])->name("store");
            Route::get("/{offer_id}", [\App\Http\Controllers\admin\customer\CustomerOfferController::class, "show"])->name("show");
            Route::put("/{offer_id}/update", [\App\Http\Controllers\admin\customer\CustomerOfferController::class, "update"])->name("update");
            Route::delete("/{offer_id}", [\App\Http\Controllers\admin\customer\CustomerOfferController::class, "delete"])->name("delete");
        });

        //Müsterinin notu yönetimi
        Route::group(['prefix' => '{customer_id}/notes', 'as' => 'notes.'], function () {
            Route::post("/store", [\App\Http\Controllers\admin\customer\CustomerNoteController::class, "store"])->name("store");
            Route::get("/{note_id}", [\App\Http\Controllers\admin\customer\CustomerNoteController::class, "show"])->name("show");
            Route::put("/{note_id}/update", [\App\Http\Controllers\admin\customer\CustomerNoteController::class, "update"])->name("update");
            Route::delete("/{note_id}", [\App\Http\Controllers\admin\customer\CustomerNoteController::class, "delete"])->name("delete");
        });

        // Doküman yönetimi
        Route::group(['prefix' => '{customer_id}/documents', 'as' => 'documents.'], function () {
            Route::post("/store", [\App\Http\Controllers\admin\customer\CustomerDocumentController::class, "store"])->name("store");
            Route::get("/{doc_id}", [\App\Http\Controllers\admin\customer\CustomerDocumentController::class, "show"])->name("show");
            Route::put("/{doc_id}/update", [\App\Http\Controllers\admin\customer\CustomerDocumentController::class, "update"])->name("update");
            Route::delete("/{doc_id}", [\App\Http\Controllers\admin\customer\CustomerDocumentController::class, "delete"])->name("delete");
            Route::get("/{doc_id}/download", [\App\Http\Controllers\admin\customer\CustomerDocumentController::class, "download"])->name("download");
        });
    });


    Route::get('/get-projects/{id}', [\App\Http\Controllers\admin\sale\SaleController::class, "get_project"])->name('get_project');
    Route::get('/get-floors/{id}', [\App\Http\Controllers\admin\sale\SaleController::class, "get_floor"])->name('get_floor');
    Route::get('/get-apartments/{id}', [\App\Http\Controllers\admin\sale\SaleController::class, "get_apartments"])->name('get_apartments');

    Route::get('/get-district-list', [App\Http\Controllers\admin\address\AddressController::class, "getDistrictList"])->name('getDistrictList');
    Route::get('/get-neighborhood-list', [App\Http\Controllers\admin\address\AddressController::class, "getNeighborhoodList"])->name('getNeighborhoodList');

    Route::get("/my-branchs", [\App\Http\Controllers\admin\branch\BranchController::class, "my_branchs"])->name("branchs.my_branchs");


    Route::get('get-floor/{id}', [\App\Http\Controllers\admin\block\BlockController::class, "get_floors"])->name('get_floors');
    Route::get('/block/create', [\App\Http\Controllers\admin\block\BlockController::class, "create"])->name('block.create');


    //==================== PROJE ========================//
    /** Projeler Yönetimi */
    Route::resource('projects', \App\Http\Controllers\admin\project\ProjectController::class);
    //Proje
    Route::get('/project/create', [\App\Http\Controllers\admin\project\ProjectController::class, "create"])->name('project.create');
    Route::post('/project/search', [\App\Http\Controllers\admin\project\ProjectController::class, "projectFilter"])->name('project.filter');
    Route::get('/project/search', [\App\Http\Controllers\admin\project\ProjectController::class, "projectFilter"])->name("get_projectFilter");
    /** Blok Yönetimi */
    Route::resource('blocks', \App\Http\Controllers\admin\block\BlockController::class);
    // Kat Yönetimi
    Route::resource('floors', \App\Http\Controllers\admin\floor\FloorController::class);
    //Apartman
    Route::resource('apartments', \App\Http\Controllers\admin\apartment\ApartmentController::class);
    //==================== PROJE ========================//


    //Facade yönetimi
    Route::get('/facades/create', [\App\Http\Controllers\admin\facade\FacadeController::class, "create"])->name('facade.create');

    // Dürüm yönetimi
    Route::get('/statuses/create', [\App\Http\Controllers\admin\status\StatusController::class, "create"])->name('status.create');

    /** Odalar Yönetimi */
    Route::get('/rooms/create', [\App\Http\Controllers\admin\room\RoomController::class, "create"])->name('room.create');

    //==================== TEKLIF YÖNETİMİ ========================//
    /** Teklif Yönetimi */
    Route::resource('bids', \App\Http\Controllers\admin\bid\BidController::class);
    Route::get('/bids/create/{id}', [\App\Http\Controllers\admin\bid\BidController::class, "create_offer"])->name('create.offer');
    Route::get('my-bids', [\App\Http\Controllers\admin\bid\BidController::class, "my_bids"])->name('bids.my_bids');
    //==================== TEKLIF YÖNETİMİ SONU =====================//


    //==================== PROJE AYARLARI ========================//
    /** Dış Özellikler Yönetimi */
    Route::get('/exterior-feature/create', [\App\Http\Controllers\admin\exterior_feature\ExteriorController::class, "create"])->name('exterior-feature.create');
    /** Konut Tipleri Yönetimi */
    Route::get('/types/create', [\App\Http\Controllers\admin\type\TypeController::class, "create"])->name('type.create');
    /** İç Özellikler Yönetimi */
    Route::get('/interior-feature/create', [\App\Http\Controllers\admin\interior_feature\InteriorController::class, "create"])->name('interior-feature.create');
    //==================== PROJE AYARLARI SONU========================//


    //==================== APARTMAN =============================//
    Route::get('/apartment/interior-features/{id}', [\App\Http\Controllers\admin\apartment\ApartmentController::class, "interior"])->name('int.features.index');
    Route::post('/apartment/interior-features', [\App\Http\Controllers\admin\apartment\ApartmentController::class, "interiorPost"])->name('apartments.interior.store');
    Route::get('/apartment/exterior-features/{id}', [\App\Http\Controllers\admin\apartment\ApartmentController::class, "exterior"])->name('ext.features.index');
    Route::post('/apartment/exterior-features', [\App\Http\Controllers\admin\apartment\ApartmentController::class, "exteriorPost"])->name('apartments.exterior.store');
    Route::get('apartment/view/{id}', [\App\Http\Controllers\admin\apartment\ApartmentController::class, "view"])->name('apartments.view');
    /** Kat Yönetimi */
    Route::get('/floor/create', [\App\Http\Controllers\admin\floor\FloorController::class, "create"])->name('floor.create');
    //==================== APARTMAN SONU========================//

    //Kullanıncın şübleri
    Route::group(['prefix' => '/{user_type}/{id}', 'as' => 'user.', "middleware" => ["CheckBranch"]], function () {
        Route::get("/branchs", [\App\Http\Controllers\admin\branch\UserBranchController::class, "get_branch"])->name("get_branch");
        Route::get("/create-branch", [\App\Http\Controllers\admin\branch\UserBranchController::class, "create_branch"])->name("create_branch");
        Route::get("edit-branch", [\App\Http\Controllers\admin\branch\UserBranchController::class, "edit_branch"])->name("edit_branch");
        Route::post("sync-to-branch", [\App\Http\Controllers\admin\branch\UserBranchController::class, "sync_to_branch"])->name("sync_to_branch");
        Route::post("delete-branch", [\App\Http\Controllers\admin\branch\UserBranchController::class, "delete_branch"])->name("delete_branch");
    });

    //Görüşme yönetimi
    Route::get("/my-meetings", [\App\Http\Controllers\admin\meeting\MeetingController::class, "my_meetings"])->name("meetings.my_meetings");
    Route::resource('meetings', \App\Http\Controllers\admin\meeting\MeetingController::class);

    // Müsterinin sonraki görüşme yönetimi
    Route::resource('next-meetings', \App\Http\Controllers\admin\customer\IncomeMeetingController::class)->parameters([
        "next-meetings" => "meeting_id"
    ])->only("index");

    //Müsteri yönetimi
    Route::resource('customers', \App\Http\Controllers\admin\customer\CustomerController::class);
    Route::get("customer/{id}/meetings", [\App\Http\Controllers\admin\customer\CustomerController::class, "loadMeeting"])->name("customer.loadMeeting");
    Route::put("customer/{id}/update-status", [\App\Http\Controllers\admin\customer\CustomerController::class, "updateStatus"])->name("customer.updateStatus");

    //Satışlar
    Route::resource('sales', \App\Http\Controllers\admin\sale\SaleController::class);

    /** Profil Bilgilerimi Düzenle */
    Route::group(['namespace' => 'profile', 'prefix' => 'profile', 'as' => 'profile.'], function () {
        Route::get('/{id}', [\App\Http\Controllers\admin\profile\ProfileController::class, "index"])->name('index');
        Route::post('/{id}', [\App\Http\Controllers\admin\profile\ProfileController::class, "update"])->name('update');
    });

    // Notification
    Route::get("/notifications/{type?}", [\App\Http\Controllers\admin\notification\NotificationController::class, "index"]);
});

/** Şifremi Unuttum */
Route::group(['namespace' => 'forgot_password', 'prefix' => 'forgot_password', 'as' => 'forgot_password.'], function () {
    /*Route::get('/index', 'indexController@index')->name('index')->name("showForm");
    Route::post('/create', 'indexController@create')->name('create');
    Route::get('/reset_password/{email}', 'indexController@resetPassword')->name('resetPassword');
    Route::post('/rest_password/{email}', 'indexController@updatePassword')->name('updatePassword');*/
});

//Api
Route::post('api/count-items', [App\Http\Controllers\api\ApiController::class, "count_items"])->name('count_items');
Route::post('api/check-usage-date-for-staff', [App\Http\Controllers\api\ApiController::class, "check_staff_usage_date"])->name('check_staff_usage_date');
