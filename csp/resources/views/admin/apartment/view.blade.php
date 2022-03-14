@extends('layouts.app')

@section('title')  @endsection

@section('css')
     <!-- Lightbox css -->
     <link href="{{asset('assets/libs/magnific-popup/magnific-popup.css')}}" rel="stylesheet" type="text/css" />
     <script src="https://www.gstatic.com/charts/loader.js"></script>
@endsection

@section('content')

    <!-- start page title -->
    @include('includes.page-title-box',[
    'pageTitle'=>"Dairenin Bilgileri",
    "pageDescription"=>"Sistemde dairenin bilgileri burada görüntülenebilir"
    ])
    <!-- end page title -->

    <div class="row">
      <div class="col-12">
          <div class="card directory-card">
              <div class="p-3 bg-transparent card-header d-flex justify-content-between">
                  <h6 class="mt-1 text-uppercase">Daire Genel Bilgileri</h6>

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
    <div class="row">
      <div class="col-12">
          <div class="card directory-card">
              <div class="p-3 bg-transparent card-header d-flex justify-content-between">
                  <h6 class="mt-1 text-uppercase">Daire İç Özellikleri</h6>
              </div>
              <div class="card-body">
                  <div class="row">
                    @foreach($exteriors as $exterior)
                    <div class="col-md-3">
                        @if($apartment->exteriorFeature->contains($exterior->id)) <p><b>{{ $exterior->name }} :</b>  <i style="color:green;" class="fas fa-check-circle"></i></p>@endif
                    </div>
                    @endforeach

                  </div>
              </div>
          </div>
      </div>
    </div>

    <div class="row">
      <div class="col-12">
          <div class="card directory-card">
              <div class="p-3 bg-transparent card-header d-flex justify-content-between">
                  <h6 class="mt-1 text-uppercase">Daire Dış Özellikleri</h6>
              </div>
              <div class="card-body">
                  <div class="row">
                    @foreach($interiors as $interior)
                    <div class="col-md-3">
                        @if($apartment->interiorFeature->contains($interior->id)) <p><b>{{ $interior->name }} :</b>  <i style="color:green;" class="fas fa-check-circle"></i> </p>@endif
                    </div>
                    @endforeach

                  </div>
              </div>
          </div>
      </div>
    </div>

    <div class="row">
      <div class="col-12">
          <div class="card directory-card">
              <div class="p-3 bg-transparent card-header d-flex justify-content-between">
                  <h6 class="mt-1 text-uppercase">Daireye Verilen Fiyat Teklifleri</h6>
              </div>
              <div style="margin-left:10px;">
                  <a class="btn btn-primary"
                      href="{{ route('admin.create.offer', ['id' => $apartment->id]) }}">
                      <i class="fas fa-plus"></i>
                      Teklif Oluştur
                  </a>
              </div>
              <div class="card-body">
                  <div class="row">
                    <table id="datatable-buttons"
                        class="list-container table table-striped table-bordered dt-responsive nowrap"
                        style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                        <thead>
                            <tr>
                                <th>Proje Adı</th>
                                <th>Blok</th>
                                <th>Daire Numarası</th>
                                <th>Fiyat</th>
                                <th>Teklif Verilen Müşteri</th>
                                <th>İlgi Düzeyi</th>
                                <th>Teklifi Veren</th>
                                <th>Durum</th>
                                <th>Tarih</th>
                                <th>Yönetim</th>
                            </tr>
                        </thead>

                        <tbody>
                                @foreach($bids as $bid)
                                <tr id="row_{{ $bid->id }}">
                                    <td><a href="{{ route('admin.projects.show', ['project' => $bid->apartment->floor->block->project->id ]) }}">{{ $bid->apartment->floor->block->project->name }}</a></td>
                                    <td>{{ $bid->apartment->floor->block->name }}</td>
                                    <td>{{ $bid->apartment->number }}</td>
                                    <td>{{ number_format($bid->price, 2, ',', '.') }}₺</td>
                                    <td><a href="{{ route('admin.customers.show', ['customer' => $bid->customer->id]) }}">{{ $bid->customer->name }} {{ $bid->customer->surname }}</a></td>
                                    <td>
                                      @switch($bid->level_of_interest)
                                          @case(1)
                                              <i style="color:#ffe900" class="fas fa-star"></i>
                                          @break
                                          @case(2)
                                              <i style="color:#ffe900" class="fas fa-star"></i><i style="color:#ffe900" class="fas fa-star"></i>
                                          @break
                                          @case(3)
                                              <i style="color:#ffe900" class="fas fa-star"></i><i style="color:#ffe900" class="fas fa-star"></i><i style="color:#ffe900" class="fas fa-star"></i>
                                          @break
                                          @case(4)
                                            <i style="color:#ffe900" class="fas fa-star"></i><i style="color:#ffe900" class="fas fa-star"></i><i style="color:#ffe900" class="fas fa-star"></i><i style="color:#ffe900" class="fas fa-star"></i>
                                          @break
                                          @case(5)
                                            <i style="color:#ffe900" class="fas fa-star"></i><i style="color:#ffe900" class="fas fa-star"></i><i style="color:#ffe900" class="fas fa-star"></i><i style="color:#ffe900" class="fas fa-star"></i>
                                            <i style="color:#ffe900" class="fas fa-star"></i>
                                          @break
                                          @default
                                              <label class="badge bg-light">Belirlenmemiş</label>
                                      @endswitch
                                    </td>
                                    <td>{{ $bid->user->name }}</td>
                                    <td>{{ $bid->BidStatus->name??"-" }}</td>
                                    <td>{{ $bid->created_at }}</td>
                                    <td><a href="{{ route('admin.create.offer', ['id' => $apartment->id]) }}"
                                        class="btn btn-sm btn-success">
                                        <i class="fas fa-pen"></i>
                                        Teklifi Güncelle
                                    </a></td>
                                </tr>
                                @endforeach

                        </tbody>
                    </table>
                  </div>
              </div>
          </div>
      </div>
    </div>

    <div class="row">
      <div class="col-12">
          <div class="card directory-card">
              <div class="p-3 bg-transparent card-header d-flex justify-content-between">
                  <h6 class="mt-1 text-uppercase">Dairenin Fiyat Geçmişi</h6>
              </div>
              <div class="card-body">
                  <div class="row">
                    <div id="myChart" style="width:100%;height:500px;"></div>


                  </div>
              </div>
          </div>
      </div>
    </div>

    <div class="row">
      <div class="col-12 text-center">
          <div class="card directory-card">
              <div class="p-3 bg-transparent card-header d-flex justify-content-between">
                  <h6 class="mt-1 text-uppercase">Dairenin Fiyat Geçmişi (Tablo)</h6>
              </div>
              <div class="card-body">
                  <div class="row">
                    <table id="datatable-buttons"
                        class="list-container table table-striped table-bordered dt-responsive nowrap"
                        style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                        <thead>
                            <tr>
                                <th>Fiyat</th>
                                <th>Tarih</th>
                            </tr>
                        </thead>
                        <tbody>
                                @foreach($apartment->ApartmentPriceHistory as $history)
                                <tr id="row_{{ $history->id }}">
                                    <td>{{ number_format($history->price, 2, ',', '.') }}₺</td>
                                    <td>{{ $history->created_at }}</td>
                                </tr>
                                @endforeach
                        </tbody>
                    </table>
                  </div>
              </div>
          </div>
      </div>
    </div>

    <!-- end row -->
@endsection

@section('script')
    <!-- Magnific Popup-->
    <script src="{{asset('assets/libs/magnific-popup/jquery.magnific-popup.min.js')}}"></script>

    <!-- Tour init js-->
    <script src="{{asset('assets/js/pages/lightbox.init.js')}}"></script>
    <script>
      google.charts.load('current',{packages:['corechart']});
      google.charts.setOnLoadCallback(drawChart);

      function drawChart() {
      // Set Data
      var data = google.visualization.arrayToDataTable([
        ['Fiyat', 'Tarih'],
        @foreach($apartment->ApartmentPriceHistory as $history)
        ["{{ $history->created_at}}",{{ $history->price }}],
        @endforeach


      ]);
      // Set Options
      var options = {
        title: 'Daire Fiyat Geçmişi',
        hAxis: {title: 'Tarih'},
        vAxis: {title: 'Fiyat'},
        legend: 'none'
      };
      // Draw
      var chart = new google.visualization.LineChart(document.getElementById('myChart'));
      chart.draw(data, options);
      }
      </script>
@endsection
