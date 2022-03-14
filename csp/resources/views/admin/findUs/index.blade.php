@extends('layouts.app')

@section('css')
    <div>
        <link href="{{ asset('assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css') }}" rel="stylesheet"
            type="text/css">
        <link href="{{ asset('assets/libs/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css') }}" rel="stylesheet"
            type="text/css">
    </div>
@endsection

@section('title')
    Bizi nereden buldunuz?
@endsection

@section('content')
    <!-- start page title -->
    @include('includes.page-title-box',[
    'pageTitle'=>"Bizi nereden buldunuz",
    "pageDescription"=>"Listeleniyor",
    "action"=>"Yeni",
    "icon" =>"fas fa-plus",
    "link" =>route("admin.find-us.create")
    ])
    <!-- end page title -->

    <div class="row">
        <div class="col-12">
            <div class="card mini-stat  text-white">
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="datatable-buttons"
                            class="list-container table table-sm table-striped table-bordered dt-responsive nowrap"
                            style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                            <thead>
                                <tr>
                                    <th>Adı</th>
                                    <th>Oluşturma Tarihi</th>
                                    <th>Aksyon</th>
                                </tr>
                            </thead>

                            <tbody>
                                @foreach ($findUs as $data)
                                    <tr id="row_{{ $data->id }}">

                                        <td class="align-middle">{{ $data->name }}</td>
                                        <td class="align-middle">
                                            @format_date($data->created_at)
                                        </td>
                                        <td class="align-middle">
                                            <a href="{{ route('admin.find-us.edit', $data->id) }}"
                                                class="btn btn-sm btn-success">
                                                <i class="fas fa-edit mr-2"></i>
                                                Düzenle
                                            </a>
                                            <button data-id="{{ $data->id }}"
                                                data-url="{{ route('admin.find-us.destroy', $data->id) }}"
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
