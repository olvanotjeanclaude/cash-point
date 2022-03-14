@extends('layouts.app')

@section('title')
    Kayıtlı Müsteri
@endsection

@section('css')
    <x-datatable-css-link />
    <link rel="stylesheet" href="{{ asset('assets/libs/popover/jquery.webui-popover.min.css') }}">
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
                :head="['Statü','Ad Soyad','Telefon','İlgilendiği Projeler','Oluşturma Tarihi','Ekleyen Kullanıcı','Aksyon']">
                @foreach ($customers as $customer)
                    <tr id="row_{{ $customer->id }}">
                        <td>
                          {!!  getBadgeStatus('Customer', $customer->status)  !!}
                        </td>
                        <td class="text-capitalize">
                            <a id="customer{{ $customer->id }}" title="Son 10 görüşmeleri görüntele"
                                data-id="{{ $customer->id }}" href="javascript:void(0)" class="popover-customer">
                                {{ $customer->full_name }}
                            </a>
                        </td>
                        <td>{{ $customer->phone }}</td>
                        <td>
                            @foreach ($customer->Projects as $project)
                                {{ $project->name }},
                            @endforeach
                        </td>
                        <td>
                            @format_date($customer->created_at)
                        </td>
                        <td>{{ get_user_fullname($customer) }}</td>
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
    <script src="{{ asset('assets/libs/popover/jquery.webui-popover.min.js') }}"></script>
    <script>
        $(".popover-customer").on("click", function() {
            const customerId = $(this).data("id");
            const popoverId = $(this).attr("id");

            axios.get(`/admin/customer/${customerId}/meetings`)
                .then(function(response) {
                    WebuiPopovers.show(`#${popoverId}`, {
                        content: response.data,
                        title: "Son 10 Görüşmeleri",
                    })
                })
                .catch(function(error) {
                    console.log(error);
                })
        })
    </script>
@endsection
