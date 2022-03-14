@extends('layouts.app')

@section('title') Kayıtlı personel @endsection

@section('css')
    <x-datatable-css-link />
@endsection


@section('content')

    <!-- start page title -->
    @include('includes.page-title-box',[
    'pageTitle'=>"Personeler",
    "pageDescription"=>"Sistemde kayıtlı personeler listeleniyor",
    "action"=>"Yeni personel",
    "icon" =>"fas fa-user-plus",
    "link" =>route("admin.staffs.create")
    ])
    <!-- end page title -->

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="datatable-buttons"
                            class="list-container table table-striped table-bordered dt-responsive nowrap"
                            style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                            <thead>
                                <tr>
                                    <th>Statü</th>
                                    <th>Ad</th>
                                    <th>Soyad</th>
                                    <th>E-posta</th>
                                    <th>Oluşturma Tarihi</th>
                                    <th>Görüntüle</th>
                                    <th>Düzenle</th>
                                    <th>Sil</th>
                                </tr>
                            </thead>

                            <tbody>
                                @foreach ($staffs as $staff)
                                    <tr id="row_{{ $staff->id }}">
                                        @if ($staff->status == 1)
                                            <td> <label class="badge bg-success">Aktif</label></td>
                                        @else
                                            <td> <label class="badge bg-danger">Pasif</label></td>
                                        @endif
                                        <td>{{ $staff->name }}</td>
                                        <td>{{ $staff->surname }}</td>
                                        <td>{{ $staff->email }}</td>
                                        <td>
                                            @format_date($staff->created_at)
                                        </td>
                                        <td class="text-center">
                                            <a href="{{ route('admin.staffs.show', ['staff' => $staff->id]) }}"
                                                class="btn btn-sm btn-warning">
                                                <i class="fas fa-eye"></i>
                                                Görüntüle
                                            </a>
                                        </td>
                                        <td class="text-center">
                                            <a href="{{ route('admin.staffs.edit', ['staff' => $staff->id]) }}"
                                                class="btn btn-sm btn-success">
                                                <i class="fas fa-user-edit mr-2"></i>
                                                Düzenle
                                            </a>
                                        </td>
                                        <td>
                                            <button data-id="{{ $staff->id }}"
                                                data-url="{{ route('admin.staffs.destroy', ['staff' => $staff->id]) }}"
                                                class="btn btn-sm btn-danger remove-btn">
                                                <i class="fas fa-user-minus mr-2"></i>
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
    <!-- end row -->

@endsection

@section('script')
    <x-datatable-js-link />
@endsection
