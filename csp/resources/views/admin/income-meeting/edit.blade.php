@extends('layouts.app')

@section('title') Yapılan görüşmeler @endsection

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
                        action="{{ route('admin.next-meetings.update',['meeting_id'=>$incomeMeeting->id]) }}" autocomplete="off" enctype="multipart/form-data">
                        @csrf
                        @method("put")
                        <div class="form-group mb-3">
                            <label class="mb-2" for="customer_id">Müsteriler</label>
                            <select class="form-control select2" name="customer_id" id="customer_id"
                                required>
                                <option value="">Seç</option>
                                @foreach ($customers as $customer)
                                    <option value="{{ $customer->id }}" @if (old('customer_id') == $customer->id || $customer->id == $incomeMeeting->customer->id) selected @endif>
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
                                value="{{$incomeMeeting->date}}T{{$incomeMeeting->time}}" required>
                            <div class="invalid-feedback">
                                Lütfen tarihi ve saat girin
                            </div>
                        </div>


                        <div class="form-group mt-3">
                            <label for="description" class="mb-2">Kısa Not</label>
                            <textarea name="description" class="form-control" cols="30" rows="5">{{ $incomeMeeting->description }}</textarea>
                            <div class="invalid-feedback">
                                Bu alanı doldurunuz
                            </div>
                        </div>

                        <div class="form-group mt-3 d-flex justify-content-end">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i>
                                Güncelle
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
