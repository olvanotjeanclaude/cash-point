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
    Satışlar
@endsection

@section('content')
    <!-- start page title -->
    @include('includes.page-title-box', [
        'pageTitle' => 'Satışlar',
        'pageDescription' => 'Sistemde yapılan satışlar listeleniyor',
        'action' => 'Yeni Satış Ekle',
        'icon' => 'fas fa-plus',
        'link' => route('admin.sales.create'),
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
                                    <th>Proje</th>
                                    <th>Blok</th>
                                    <th>Kat</th>
                                    <th>Daire Numarası</th>
                                    <th>Satışı Yapılan Müşteri</th>
                                    <th>Satışı Yapan Danışman</th>
                                    <th>Fiyat</th>
                                    <th>Tarih</th>
                                    <th>İşlemler</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($sales as $sale)
                                    <tr id="row_{{ $sale->id }}">
                                        <td>{{ $sale->apartment->floor->block->project->name ?? '-' }}</td>
                                        <td>{{ $sale->apartment->floor->block->name ?? '-' }}</td>
                                        <td>{{ $sale->apartment->floor->number ?? '-' }}</td>
                                        <td>{{ $sale->apartment->number ?? '-' }}</td>
                                        <td><a
                                                href="{{ route('admin.customers.show', ['customer' => $sale->customer->id]) }}">{{ $sale->customer->name }}
                                                {{ $sale->customer->surname }}</a></td>
                                        <td>{{ $sale->user->name }} {{ $sale->user->surname }}</td>
                                        <td>{{ $sale->price }}</td>
                                        <td>@format_date( $sale->created_at)</td>
                                        <td>
                                            <a href="{{ route('admin.sales.show', $sale->id) }}"
                                                class="btn btn-sm btn-warning">
                                                <i class="fas fa-eye mr-2"></i>
                                                Görüntüle
                                            </a>
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
