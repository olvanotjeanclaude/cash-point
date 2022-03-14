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
                    <form method="post" class="needs-validation" novalidate action="{{ route('admin.meetings.update',['meeting'=>$meeting->id]) }}"
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

                        <div class="form-group mt-3">
                            <label class="mb-2" for="date_time">Tarihi Ve Saat </label>
                            <input type="dateTime-local" class="form-control" id="date_time" value="{{$meeting->date_time_input}}"
                                placeholder="Tarihi" name="date_time" required>
                            <div class="invalid-feedback">
                                Lütfen tarihi girin
                            </div>
                        </div>

                        <div class="form-group mt-3">
                            <label class="mb-2" for="description">Not</label>
                            <textarea class="form-control" name="description" id="description" cols="4" rows="5">{{ $meeting->description }}</textarea>
                            <div class="invalid-feedback">
                                Lütfen görüşmeyi seçin
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
