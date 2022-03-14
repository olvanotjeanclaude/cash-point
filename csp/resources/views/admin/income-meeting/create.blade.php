@extends('layouts.app')

@section('title') Yeni yapılacak Görüşme @endsection

@section('css')
    <link rel="stylesheet" href="{{ asset('assets/libs/select2/css/select2.min.css') }}">
@endsection

@section('content')
    <!-- start page title -->
    @include('includes.page-title-box',[
    'pageTitle'=>"Yapılacak Görüşme Yönetimi",
    "pageDescription"=>"Sistemde yeni gelecek görüşme burada yapılır"
    ])
    <!-- end page title -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form method="post" class="needs-validation" novalidate
                        action="{{ route('admin.next-meetings.store') }}" autocomplete="off" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group mb-3">
                            <label class="mb-2" for="customer_id">Müsteriler</label>
                            @if ($customer_id)
                                <input type="hidden" name="customer_id" value="{{ $customer_id }}" id="customer_id">
                            @endif
                            <select class="form-control select2" name="customer_id" id="customer_id" @if ($customer_id) disabled @endif
                                required>
                                <option value="">Seç</option>
                                @foreach ($customers as $customer)
                                    <option value="{{ $customer->id }}" @if (old('customer_id') == $customer->id || $customer->id == $customer_id) selected @endif>
                                        {{ $customer->full_name }}</option>
                                @endforeach
                            </select>
                            <div class="invalid-feedback">
                                Lütfen müsteri seçin
                            </div>
                        </div>



                        <div class="form-group mt-3">
                            <label class="mb-2" for="date_time">Tarihi Ve Saat</label>
                            <input type="datetime-local" class="form-control" id="date" name="date_time"
                                value="{{ old('date_time') }}" required>
                            <div class="invalid-feedback">
                                Lütfen tarihi ve saat girin
                            </div>
                        </div>


                        <div class="form-group mt-3">
                            <label for="description" class="mb-2">Kısa Not</label>
                            <textarea name="description" class="form-control" cols="30" rows="5">{{ old('description') }}</textarea>
                            <div class="invalid-feedback">
                                Bu alanı doldurunuz
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
    <!-- Select2 js -->
    <script src="{{ asset('assets/libs/select2/js/select2.min.js') }}"></script>
@endsection
