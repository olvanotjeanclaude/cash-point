@extends('layouts.app')

@section('title') Yeni Durum @endsection

@section('content')
    <!-- start page title -->
    @include('includes.page-title-box',[
    'pageTitle'=>"Teklif Oluştur",
    "pageDescription"=>"Sistemde yeni blok burada yapılır",
    ])

    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.1/css/font-awesome.min.css" rel="stylesheet" />
    <style media="screen">
    select {
font-family: 'FontAwesome';
}
    </style>


    <div class="row">
      <div class="col-12">
          <div class="card directory-card">
              <div class="p-3 bg-transparent card-header d-flex justify-content-between">
                  <h6 class="mt-1 text-uppercase">Daire Genel Bilgileri</h6>
                  <div>
                      <button type="button" class="btn btn-sm btn-success" onclick="history.back()">
                          <i class="fas fa-arrow-left"></i>
                          Geri Dön
                      </button>
                  </div>
              </div>
              <div class="card-body">
                  <p><b>Daire Adı: </b>{{ $apartment->name }}</p>
                  <p><b>Daire Numarası :</b> {{ $apartment->number }}</p>
                  <hr>
                  <div class="row">
                      <div class="col-md-6">
                          <p><b>Oda Sayısı :</b> {{ $apartment->room->type }}</p>

                          <p><b>Açıklama :  </b>{{ $apartment->description }}</p>
                          <p><b>Kat : </b>{{ $apartment->floor->number }}. Kat</p>
                          <p><b>Daire Türü: </b> {{ $apartment->type->name }} </p>
                          <p><b>Cephe : </b> {{ $apartment->facade->name }} </p>
                      </div>

                      <div class="col-md-6">
                          <h5><b>Fiyat : </b>{{ number_format($apartment->price, 2, ',', '.') }}₺</h5>
                          <p><b>Brüt m2 : </b> {{ $apartment->gross_square }} </p>
                          <p><b>Net m2 : </b> {{ $apartment->square }} </p>
                          <p style="color:green;"><b>Durumu : </b> {{ $apartment->status->name }} </p>
                      </div>
                  </div>
              </div>
          </div>
      </div>
    </div>


    <!-- end page title -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form method="post" class="needs-validation" novalidate action="{{ route('admin.bids.store') }}"
                        autocomplete="off" enctype="multipart/form-data">
                        @csrf
                        <section>
                            <div class="form-group mb-3">
                              <label class="col-sm-2 col-form-label">Müşteri Seçimi</label>

                              <select class="js-example-basic-single" style="width:100%;" name="customer_id">
                                @foreach($customers as $customer)
                                <option value="{{ $customer->id }}">{{ $customer->name }}</option>
                                @endforeach
                              </select>
                            </div>
                            <div class="form-group mb-3">
                                <label class="mb-2" for="email">Fiyat</label>
                                <input  type="text" class="form-control" id="name" value="{{ old('price') }}"
                                    placeholder="Fiyat" name="price" required>
                                <div class="invalid-feedback">
                                    Lütfen geçerli bir isim giriniz.
                                </div>
                            </div>
                            <div class=" form-group mb-3">
                                <label class="col-sm-2 col-form-label">İlgi Düzeyi</label>
                                <div class="col-sm-12">
                                    <select class="form-select" name="level_of_interest" aria-label="">
                                        <option selected="">Seçiniz</option>
                                        <option style="color:#c9db00" value="1">&#xf005;</option>
                                        <option style="color:#c9db00" value="2">&#xf005;&#xf005;</option>
                                        <option style="color:#c9db00" value="3">&#xf005;&#xf005;&#xf005;</option>
                                        <option style="color:#c9db00" value="4">&#xf005;&#xf005;&#xf005;&#xf005;</option>
                                        <option style="color:#c9db00" value="5">&#xf005;&#xf005;&#xf005;&#xf005;&#xf005;</option>
                                      </select>
                                </div>
                            </div>
                            <div class=" form-group mb-3">
                                <label class="col-sm-2 col-form-label">Teklif Durumu</label>
                                <div class="col-sm-12">
                                    <select class="form-select" name="bid_status_id" aria-label="">
                                        <option selected="">Seçiniz</option>
                                        @foreach($bidStatuses as $bidStatus)
                                        <option value="{{ $bidStatus->id }}">{{ $bidStatus->name }}</option>
                                        @endforeach
                                      </select>
                                </div>
                            </div>
                        </section>

                        <input type="hidden" name="apartment_id" value="{{ $apartment->id }}">
                        <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">

                        <div class="form-group d-flex justify-content-end">
                            <button type="submit" class="btn btn-primary">
                                <i class="mdi mdi-plus mr-2"></i>
                                Ekle
                            </button>
                        </div>
                    </form>

                </div>
            </div>
        </div>


    </div>
    <!-- end row -->

@section('script')
  <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
  <script>
    $(document).ready(function() {
        $('.js-example-basic-single').select2();
    });
  </script>
@endsection

@endsection
