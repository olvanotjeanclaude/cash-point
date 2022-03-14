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
    Kayıtlı yönetici
@endsection

@section('content')
    <!-- start page title -->
    @include('includes.page-title-box', [
        'pageTitle' => 'Yöneticiler',
        'pageDescription' => 'Sistemde kayıtlı yönetici listeleniyor',
        'action' => 'Yeni Yönetici',
        'icon' => 'fas fa-user-plus',
        'link' => route('admin.managers.create'),
    ])
    <!-- end page title -->

    <div class="row">
        <div class="col-12">
            <x-loading-component :head="['Statü','Ad','Soyad','E-posta','Oluşturma Tarihi','Düzenle','Sil']">
                @foreach ($managers as $manager)
                    <tr id="row_{{ $manager->id }}">
                        @if ($manager->status == 1)
                            <td> <label class="badge bg-success">Aktif</label></td>
                        @else
                            <td> <label class="badge bg-danger">Pasif</label></td>
                        @endif
                        <td>{{ $manager->name }}</td>
                        <td>{{ $manager->surname }}</td>
                        <td>{{ $manager->email }}</td>
                        <td>
                            @format_date($manager->created_at)
                        </td>
                        <td class="text-center">
                            <a href="{{ route('admin.managers.edit', ['manager' => $manager->id]) }}"
                                class="btn btn-sm btn-success">
                                <i class="fas fa-user-edit mr-2"></i>
                                Düzenle
                            </a>
                        </td>
                        <td>
                            <button data-id="{{ $manager->id }}"
                                data-url="{{ route('admin.managers.destroy', ['manager' => $manager->id]) }}"
                                class="btn btn-sm btn-danger remove-btn">
                                <i class="fas fa-user-minus mr-2"></i>
                                Sil
                            </button>
                        </td>
                    </tr>
                @endforeach
            </x-loading-component>
        </div>
        <!-- end col -->
    </div>
@endsection

@section('script')
    <x-datatable-js-link />
@endsection
