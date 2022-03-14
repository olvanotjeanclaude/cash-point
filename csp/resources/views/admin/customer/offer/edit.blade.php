@extends('layouts.app')

@section('title') {{ $meeting->customer->full_name }} @endsection

@section('css')
    <link rel="stylesheet" href="{{ asset('assets/libs/select2/css/select2.min.css') }}">
@endsection

@section('content')
    <!-- start page title -->
    @include('includes.page-title-box',[
    'pageTitle'=>"Görüşme Düzenleme",
    "pageDescription"=>"Sistemde  görüşmenin güncelemesi burada yapılır"
    ])
    <!-- end page title -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form method="post" class="needs-validation" novalidate 
                    action="{{ route('admin.customer.offer.store',['customer_id'=>$customer->id,"meeting_id"=>$meeting->id]) }}"
                        autocomplete="off" enctype="multipart/form-data">
                        @method("put")
                        @csrf
                        <div class="form-group mb-3">
                            <label class="mb-2" for="customer_id">Müsteriler</label>
                            <select class="form-control select2" name="customer_id" id="customer_id" required>
                                <option value="">Seç</option>
                                @foreach ($customers as $customer)
                                    <option value="{{ $customer->id }}" @if ($meeting->customer->id == $customer->id) selected @endif>
                                        {{ $customer->full_name }}</option>
                                @endforeach
                            </select>
                            <div class="invalid-feedback">
                                Lütfen müsteri seçin
                            </div>
                        </div>

                        <div class="row mt-3">
                            <div class="col-md-6">
                                <label class="mb-2" for="date">Tarihi</label>
                                <input type="date" class="form-control" id="date" value="{{ $meeting->date }}"
                                    placeholder="Tarihi" name="date" required>
                                <div class="invalid-feedback">
                                    Lütfen tarihi girin
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="mb-2" for="time">Saat</label>
                                <input type="time" class="form-control" id="time"
                                    placeholder="Saat" name="time" required>
                                <div class="invalid-feedback">
                                    Lütfen geçerli saat girin
                                </div>
                            </div>
                        </div>

                        <div class="form-group mt-3">
                            <label class="mb-2" for="phone">Telefon</label>
                            <input type="phone" class="form-control" id="phone" value="{{ $meeting->phone }}"
                                placeholder="Telefon" name="phone" required>
                            <div class="invalid-feedback">
                                Lütfen telefon seçin
                            </div>
                        </div>

                        <div class="form-group mt-3 d-flex justify-content-end">
                            <button type="submit" class="btn btn-primary">
                                <i class="mdi mdi-calendar-edit"></i>
                                Düzenle
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
    <script src="{{ asset('assets/libs/select2/js/select2.min.js') }}"></script>
@endsection
