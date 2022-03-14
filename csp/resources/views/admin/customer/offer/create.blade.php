@extends('layouts.app')

@section('title') Yeni Teklif @endsection

@section('content')
    <!-- start page title -->
    @include('includes.page-title-box',[
    'pageTitle'=>"Görüşme Yönetimi",
    "pageDescription"=>"Sistemde yeni görüşme burada yapılır"
    ])
    <!-- end page title -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form method="post" class="repeater needs-validation" novalidate 
                    action="{{ route('admin.customer.offer.store',['customer_id'=>$customer->id,"meeting_id"=>$meeting->id]) }}"
                    autocomplete="off" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group mb-3">
                            <label class="mb-2" for="customer_id">Müsteriler</label>
                            <select class="form-control select2" name="customer_id" id="customer_id" disabled>
                                <option value="">Seç</option>
                                <option value="{{ $customer->id }}" selected>{{ $customer->full_name }}</option>
                            </select>
                            <div class="invalid-feedback">
                                Lütfen müsteri seçin
                            </div>
                        </div>

                        <div class="row mt-3">
                            <div class="col-md-6">
                                <label class="mb-2" for="date">Tarihi</label>
                                <input type="date" class="form-control" id="date" value="{{ $meeting->date }}"
                                    placeholder="Tarihi" name="date" disabled required>
                                <div class="invalid-feedback">
                                    Lütfen tarihi girin
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="mb-2" for="time">Saat</label>
                                <input type="time" class="form-control" id="time" value="{{ $meeting->time }}"
                                    placeholder="Saat" name="time" disabled required>
                                <div class="invalid-feedback">
                                    Lütfen saat girin
                                </div>
                            </div>
                        </div>

                        <div class="form-group mt-3">
                            <div class="inner-repeater ">
                                <div data-repeater-list="inner-group" class="inner mb-3">
                                    <label class="form-label">Teklifler :</label>
                                    <div data-repeater-item class="inner mb-3 row">
                                        <div class="col-12">
                                            <textarea name="offer" class="form-control inner" cols="30" rows="3"
                                                required></textarea>
                                            <div class="invalid-feedback">
                                                Bu alanı doldurunuz
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="d-flex justify-content-end mt-2">
                                                <input data-repeater-delete type="button"
                                                    class="btn btn-danger btn-sm inner mt-2 mt-sm-0" value="Delete" />
                                            </div>
                                        </div>

                                    </div>
                                </div>
                                <button data-repeater-create type="button" class="btn btn-sm btn-success inner">
                                    <i class="fas fa-plus"></i>
                                    Yeni Teklif
                                </button>

                            </div>
                        </div>

                        <div class="form-group mt-3 d-flex justify-content-end">
                            <button type="submit" class="btn btn-primary">
                                <i class="mdi mdi-calendar"></i>
                                Ekle
                            </button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
        <!-- end col -->
    </div>
    <!-- end row -->

@endsection

@section('script')
    <!-- form repeater js -->
    <script src="{{ asset('assets/libs/jquery.repeater/jquery.repeater.min.js') }}"></script>
    <script src="{{ asset('assets/js/pages/form-repeater.int.js') }}"></script>
@endsection
