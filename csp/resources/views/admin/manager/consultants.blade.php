@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('assets/libs/select2/css/select2.min.css') }}">
    <x-datatable-css-link />
@endsection

@section('title') Kayıtlı danışmanlarım @endsection

@section('content')

    <!-- start page title -->
    <div class="page-title-box">
        <div class="row align-items-center">
            <div class="col-md-8">
                <h6 class="page-title">Danışmanlarım</h6>
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item active">
                        Sistemde kayıtlı danışmanlarım listeleniyor
                    </li>
                </ol>
            </div>

            <div class="col-md-4">
                <div class="float-end d-none d-md-block">
                    <button type="button" class="btn btn-sm btn-success" data-bs-toggle="modal"
                        data-bs-target="#addConsultantModal">
                        <i class="fas fa-plus"></i>
                        Yeni Danışman
                    </button>
                </div>
            </div>
        </div>
    </div>
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
                                    <th>Statü</th>
                                    <th>Ad</th>
                                    <th>Soyad</th>
                                    <th>E-posta</th>
                                    <th>Oluşturma Tarihi</th>
                                    <th>Düzenle</th>
                                    <th>Sil</th>
                                </tr>
                            </thead>

                            <tbody>
                                @foreach ($consultants as $consultant)
                                    <tr id="row_{{ $consultant->id }}">
                                        @if ($consultant->status == 1)
                                            <td> <label class="badge bg-success">Aktif</label></td>
                                        @else
                                            <td> <label class="badge bg-danger">Pasif</label></td>
                                        @endif
                                       
                                        <td>{{ $consultant->name }} </td>
                                        <td>{{ $consultant->surname }}</td>
                                        <td>{{ $consultant->email }}</td>
                                        <td>
                                            @format_date($consultant->created_at)
                                        </td>
                                        <td class="text-center">
                                            <a href="{{ route('admin.staffs.edit', ['staff' => $consultant->id]) }}"
                                                class="btn btn-sm btn-success">
                                                <i class="fas fa-user-edit mr-2"></i>
                                                Düzenle
                                            </a>
                                        </td>
                                        <td>
                                            <button data-id="{{ $consultant->id }}"
                                                data-url="{{ route('admin.consultants.destroy', ['consultant' => $consultant->id]) }}"
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

    {{-- Add Consultant Modal --}}
    <div class="modal fade" id="addConsultantModal" data-bs-backdrop="static" data-bs-keyboard="false"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <form class="modal-dialog  needs-validation" novalidate method="POST" action="{{route('admin.consultants.store')}}">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">
                        Danışman Ekleme
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="form-group mb-2">
                        <label class="mb-3" for="branch">Danışman</label>
                        <select name="staff_id[]" id="staffs" class="select2" style="width: 100%" multiple required>
                           @foreach ($staffs as $staff)
                           <option value="{{$staff->id}}">{{ $staff->full_name }}</option>
                           @endforeach
                        </select>
                        <div class="invalid-feedback">
                            Lütfen danışmanları seçin
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Kapat</button>
                    <button type="submit" class="btn btn-success">
                        <i class="fas fa-save mr-2"></i>
                        Ekle
                    </button>
                </div>
            </div>
            <!-- /.modal-content -->
        </form>
        <!-- /.modal-dialog -->
    </div>

@endsection

@section('script')

    <script src="{{ asset('assets/libs/select2/js/select2.min.js') }}"></script>
    <x-datatable-js-link />
    <script>
        $(document).ready(function() {
            $("#staffs").select2({
                dropdownParent: $("#addConsultantModal")
            });
        });
    </script>
@endsection
