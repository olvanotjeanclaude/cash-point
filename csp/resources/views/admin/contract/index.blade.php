@extends('layouts.app')

@section('css')
    <link href="{{ asset('assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css') }}" rel="stylesheet"
        type="text/css">
    <link href="{{ asset('assets/libs/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css') }}" rel="stylesheet"
        type="text/css">
    <link rel="stylesheet" href="{{ asset('assets/libs/popover/jquery.webui-popover.min.css') }}">
@endsection

@section('title')
    Sözleşmeler
@endsection

@section('content')
    <!-- start page title -->
    @include('includes.page-title-box', [
        'pageTitle' => 'Sözleşmeler',
        'pageDescription' => 'Listeleniyor',
        'action' => 'Yeni Sözleşme',
        'icon' => 'fas fa-plus',
        'link' => route('admin.contracts.create'),
    ])
    <!-- end page title -->

    <div class="row">
        <div class="col-12">
            <x-loading-component :head="['Sözleşme','Proje','Oluşturma Tarihi','Ekeyen Kullanıcı','Aksyon']">
                @foreach ($contracts as $data)
                    <tr id="row_{{ $data->id }}">
                        <td class="align-middle">
                            <a class="contract text-capitalize" id="contract_{{ $data->id }}"
                                data-id="{{ $data->id }}" href="javascript:void(0)">{{ Str::limit($data->title, 70) }}
                            </a>
                        </td>
                        <td class="text-uppercase">{{ $data->project->name }}</td>
                        <td class="align-middle">
                            @format_date($data->created_at)
                        </td>
                        <td>{{ $data->user->full_name }}</td>
                        <td class="align-middle">
                            <a class="contract btn btn-sm btn-warning text-capitalize" id="contract_{{ $data->id }}"
                                data-id="{{ $data->id }}" href="javascript:void(0)">
                                <i class="fas fa-show mr-2"></i>
                                Görüntüle
                            </a>
                            <a href="{{ route('admin.contracts.edit', $data->id) }}"
                                class="btn btn-sm editcontract btn-success">
                                <i class="fas fa-edit mr-2"></i>
                                Düzenle
                            </a>
                            <button data-id="{{ $data->id }}"
                                data-url="{{ route('admin.contracts.destroy', $data->id) }}"
                                class="btn btn-sm btn-danger remove-btn">
                                <i class="fas fa-minus mr-2"></i>
                                Sil
                            </button>
                        </td>
                    </tr>
                @endforeach
            </x-loading-component>
        </div>
        <!-- end col -->
    </div>

    <!-- Modal -->
    <div class="modalContainer">
    </div>
@endsection

@section('script')
    <x-datatable-js-link />
    <script src="{{ asset('assets/libs/popover/jquery.webui-popover.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            $(".contract").on("click", function() {
                const id = $(this).data("id");

                axios.get(`/admin/contracts/${id}`)
                    .then(function(response) {
                        $(".modalContainer").html(response.data);
                        $("#contractModal").modal("show");
                    })
                    .catch(function(error) {
                        console.log(error);
                    })
            });
        })
    </script>
@endsection
