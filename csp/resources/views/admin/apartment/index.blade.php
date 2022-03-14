@extends('layouts.app')

@section('css')
<div>
    <link href="{{ asset('assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css') }}" rel="stylesheet"
        type="text/css">
    <link href="{{ asset('assets/libs/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css') }}" rel="stylesheet"
        type="text/css">
</div>

@endsection

@section('title') Kayıtlı Daireler @endsection

@section('content')

    <!-- start page title -->
    @include('includes.page-title-box',[
    'pageTitle'=>"Daireler",
    "pageDescription"=>"Sistemde kayıtlı Daireler listeleniyor",
    "action"=>"Yeni Daire",
    "icon" =>"fas fa-plus",
    "link" =>route("admin.apartments.create", ['id' => $_GET['id']]),
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
                                    <th>Daire Adı</th>
                                    <th>Oda Sayısı</th>
                                    <th>Fiyat</th>
                                    <th>Durum</th>
                                    <th class="text-center">İç Özellikler</th>
                                    <th class="text-center">Dış Özellikler</th>
                                    <th>Oluşturulma Tarihi</th>
                                    <th>Görüntüle</th>
                                    <th>Düzenle</th>
                                    <th>Sil</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($apartments as $apartment)
                                      <tr id="row_{{ $apartment->id }}">
                                        <td>{{ $apartment->name }}</td>
                                        <td>{{ $apartment->room->type }}</td>
                                        <td>{{ number_format($apartment->price, 2, ',', '.') }}₺</td>
                                        <td><label class="badge bg-primary">{{ $apartment->status->name }}</label></td>
                                        <td class="text-center"><a href="{{ route('admin.int.features.index', ['id' => $apartment->id]) }}"
                                            class="btn btn-sm btn-info">
                                            <i class="fas fa-bars"></i>
                                            İç Özellikler
                                        </a></td>
                                        <td class="text-center"><a href="{{ route('admin.ext.features.index', ['id' => $apartment->id]) }}"
                                            class="btn btn-sm btn-warning">
                                            <i class="fas fa-bars"></i>
                                            Dış Özellikler
                                        </a></td>
                                        <td>
                                            @format_date($apartment->created_at)
                                        </td>
                                        <td class="text-center">
                                            <a href="{{ route('admin.apartments.view', ['id' => $apartment->id]) }}"
                                                class="btn btn-sm btn-primary">
                                                <i class="fas fa-eye"></i>
                                                Görüntüle
                                            </a>
                                        </td>
                                        <td class="text-center">
                                            <a href="{{ route('admin.apartments.edit', ['apartment' => $apartment->id]) }}"
                                                class="btn btn-sm btn-success">
                                                <i class="fas fa-edit mr-2"></i>
                                                Düzenle
                                            </a>
                                        </td>
                                        <td>
                                            <button data-id="{{ $apartment->id }}"
                                                data-url="{{ route('admin.apartments.destroy', ['apartment' => $apartment->id]) }}"
                                                class="btn btn-sm btn-danger remove-btn">
                                                <i class="fas fa-minus mr-2"></i>
                                                Sil
                                            </button>
                                        </td>
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
