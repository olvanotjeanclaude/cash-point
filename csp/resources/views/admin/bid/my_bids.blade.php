@extends('layouts.app')

@section('css')
<div>
    <link href="{{ asset('assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css') }}" rel="stylesheet"
        type="text/css">
    <link href="{{ asset('assets/libs/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css') }}" rel="stylesheet"
        type="text/css">
</div>

@endsection

@section('title') Bloklar @endsection

@section('content')

    <!-- start page title -->
    @include('includes.page-title-box',[
    'pageTitle'=>"Tekliflerim",
    "pageDescription"=>"Sistemde verdiğiniz teklifler listeleniyor",
    ])
    <!-- end page title -->

    <div class="row">
        <div class="col-12">
            <div class="card mini-stat  text-white">
                <div class="card-body">
                    <div class="table-responsive">
                      <table id="datatable-buttons"
                          class="list-container table table-striped table-bordered dt-responsive nowrap"
                          style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                          <thead>
                              <tr>
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
                                      <td>{{ $bid->apartment->floor->block->name }}</td>
                                      <td>{{ $bid->apartment->number }}</td>
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
                                      <td>{{format_date( $bid->created_at) }}</td>

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

@endsection

@section('script')
    <x-datatable-js-link />
@endsection
