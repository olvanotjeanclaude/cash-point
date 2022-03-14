@extends('layouts.app')

@section('title') Teklif listesi @endsection

@section('css')
    <x-datatable-css-link />
@endsection


@section('content')

    <!-- start page title -->
    @include('includes.page-title-box',[
    'pageTitle'=>"Müsteriler",
    "pageDescription"=>"Teklif filtreleme",
    ])
    <!-- end page title -->

    <div class="row">
      @include('admin.customer.partials.search-side')
        <div class="col-10">
          <div class="card mini-stat  text-white">
              <div class="card-body">
                  <div class="table-responsive">
                    <table id="datatable-buttons"
                        class="list-container table table-striped table-bordered dt-responsive nowrap"
                        style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                        <thead>
                            <tr>
                                <th>Proje</th>
                                <th>Blok</th>
                                <th>Daire Numarası</th>
                                <th>Fiyat</th>
                                <th>Teklif Verilen Müşteri</th>
                                <th>İlgi Düzeyi</th>
                                <th>Teklifi Veren</th>
                                <th>Durum</th>
                                <th>Tarih</th>
                            </tr>
                        </thead>

                        <tbody>
                                @foreach($bids as $bid)
                                <tr id="row_{{ $bid->id }}">
                                    <td>{{ $bid->apartment->floor->block->project->name??"-" }}</td>
                                    <td>{{ $bid->apartment->floor->block->name??"-" }}</td>
                                    <td>{{ $bid->apartment->number??"-" }}</td>
                                    <td>{{ number_format($bid->price, 2, ',', '.') }}₺</td>
                                    <td><a href="{{ route('admin.customers.show', ['customer' => $bid->customer->id]) }}">{{ $bid->customer->name }}</a></td>
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
                                    <td>{{ format_date($bid->created_at) }}</td>

                                </tr>
                                @endforeach

                        </tbody>
                    </table>
                  </div>
              </div>
          </div>
        </div>
        <!-- end col -->
    </div>
    <!-- end row -->

@endsection

@section('script')
    <x-datatable-js-link />
@endsection
