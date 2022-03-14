@extends('layouts.app')

@section('css')
<div>
    <link href="{{ asset('assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css') }}" rel="stylesheet"
        type="text/css">
    <link href="{{ asset('assets/libs/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css') }}" rel="stylesheet"
        type="text/css">
</div>

@endsection

@section('title') Kayıtlı Katlar @endsection

@section('content')

    <!-- start page title -->
    @include('includes.page-title-box',[
    'pageTitle'=>"Katlar",
    "pageDescription"=>"Sistemde kayıtlı Katlar listeleniyor",
    "action"=>"Yeni Kat",
    "icon" =>"fas fa-plus",
    "link" =>route("admin.floors.create", ['id' => $_GET['id']])
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
                                    <th>Blok Adı</th>
                                    <th>Kat Numarası</th>
                                    <th class="text-center">Kat Daireleri</th>
                                    <th>Düzenle</th>
                                    <th>Sil</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($floors as $floor)
                                      <tr id="row_{{ $floor->id }}">
                                        <td>{{ $floor->block->name }}</td>
                                        <td>{{ $floor->number }} Kat</td>
                                        <td class="text-center">
                                          <a href="{{ route('admin.apartments.index', ['id' => $floor->id]) }}"
                                              class="btn btn-sm btn-info">
                                              <i class="fas fa-bars"></i>
                                              Daireler
                                          </a>
                                        </td>
                                        <td class="text-center">
                                            <a href="{{ route('admin.floors.edit', ['floor' => $floor->id]) }}"
                                                class="btn btn-sm btn-success">
                                                <i class="fas fa-edit mr-2"></i>
                                                Düzenle
                                            </a>
                                        </td>
                                        <td>
                                            <button data-id="{{ $floor->id }}"
                                                data-url="{{ route('admin.floors.destroy', ['floor' => $floor->id]) }}"
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
