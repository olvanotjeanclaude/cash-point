@extends('layouts.app')

@section('title')
    Kayıtlı Müsteri
@endsection

@section('css')
    <x-datatable-css-link />
@endsection


@section('content')

    <!-- start page title -->
    @include('includes.page-title-box', [
        'pageTitle' => 'Müsteriler',
        'pageDescription' => 'Sistemde kayıtlı müsteriler listeleniyor',
        'action' => 'Yeni Müşteri',
        'icon' => 'fas fa-plus',
        'link' => route('admin.customers.create'),
    ])
    <!-- end page title -->

    <div class="row">
        @include('admin.customer.partials.search-side')
        <div class="col-lg-10">
            <x-loading-component
                :head="['Statü','Ad','Soyad','Telefon','İlgilendiği Projeler','Oluşturma Tarihi','Aksyon']">
                @foreach ($customers as $customer)
                    <tr id="row_{{ $customer->id }}">
                        @if ($customer->status == 1)
                            <td> <label class="badge bg-success">Aktif</label></td>
                        @else
                            <td> <label class="badge bg-danger">Pasif</label></td>
                        @endif
                        <td class="text-capitalize">{{ Str::lower($customer->name) }}</td>
                        <td class="text-capitalize">{{ Str::lower($customer->surname) }}</td>
                        <td>{{ $customer->phone }}</td>
                        <td>
                            @foreach ($customer->Projects as $project)
                                {{ $project->name }},
                            @endforeach
                        </td>
                        <td>
                            @format_date($customer->created_at)
                        </td>
                        <td class="text-center d-flex justify-content-start">
                            <a href="{{ route('admin.customers.show', ['customer' => $customer->id]) }}"
                                class="btn btn-sm ms-1 btn-warning">
                                <i class="fas fa-eye"></i>
                                Görüntüle
                            </a>
                            <a href="{{ route('admin.customers.edit', ['customer' => $customer->id]) }}"
                                class="btn ms-1 btn-sm btn-success">
                                <i class="fas fa-user-edit mr-2"></i>
                                Düzenle
                            </a>
                            <button data-id="{{ $customer->id }}"
                                data-url="{{ route('admin.customers.destroy', ['customer' => $customer->id]) }}"
                                class="btn ms-1 btn-sm btn-danger remove-btn">
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
    <!-- end row -->

@endsection

@section('script')
    <x-datatable-js-link />
@endsection
