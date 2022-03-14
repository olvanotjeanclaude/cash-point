@extends('layouts.app')

@section('title')
    Yeni Durum
@endsection

@section('css')
    <link rel="stylesheet" href="{{ asset('assets/libs/select2/css/select2.min.css') }}">
@endsection

@section('content')
    <!-- start page title -->
    @include('includes.page-title-box', [
        'pageTitle' => 'Teklif Oluştur',
        'pageDescription' => 'Sistemde yeni blok burada yapılır',
    ])

    <!-- end page title -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form method="post" class="needs-validation" novalidate action="{{ route('admin.bids.store') }}"
                        autocomplete="off" enctype="multipart/form-data">
                        @csrf
                        <section>
                            <div class="form-group mb-3">
                                <label class="col-sm-2 col-form-label">Müşteri Seçimi</label>
                                <select class="js-example-basic-single form-control" style="width:100%;" name="customer_id">
                                    @foreach ($customers as $customer)
                                        <option value="{{ $customer->id }}">{{ $customer->full_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group mb-3">
                                <label class="col-sm-2 col-form-label">Proje</label>
                                <select class="js-example-basic-single form-control" style="width:100%;" name="">
                                    @foreach ($projects as $project)
                                        <option value="{{ $project->id }}">{{ $project->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group mb-3">
                                <label class="col-sm-2 col-form-label">Blok</label>
                                <select class="js-example-basic-single form-control" style="width:100%;" name="">
                                    @foreach ($blocks as $block)
                                        <option value="{{ $project->id }}">{{ $block->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group mb-3">
                                <label class="col-sm-2 col-form-label">Kat</label>
                                <select class="js-example-basic-single form-control" style="width:100%;" name="">
                                    @foreach ($floors as $floor)
                                        <option value="{{ $floor->id }}">{{ $floor->number }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group mb-3">
                                <label class="col-sm-2 col-form-label">Daire</label>
                                <select class="js-example-basic-single form-control" style="width:100%;" name="apartment_id">
                                    @foreach ($apartments as $apartment)
                                        <option value="{{ $apartment->id }}">{{ $apartment->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group mb-3">
                                <label class="mb-2" for="email">Fiyat</label>
                                <input type="text" class="form-control" id="name" value="{{ old('price') }}"
                                    placeholder="Fiyat" name="price" required>
                                <div class="invalid-feedback">
                                    Lütfen geçerli bir isim giriniz.
                                </div>
                            </div>
                            <div class=" form-group mb-3">
                                <label class="col-sm-2 col-form-label">İlgi Düzeyi</label>
                                <div class="col-sm-12">
                                    <select class="form-select" name="level_of_interest" aria-label="">
                                        <option selected="">Seçiniz</option>
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                        <option value="4">4</option>
                                        <option value="5">5</option>
                                    </select>
                                </div>
                            </div>
                            <div class=" form-group mb-3">
                                <label class="col-sm-2 col-form-label">Teklif Durumu</label>
                                <div class="col-sm-12">
                                    <select class="form-select" name="bid_status_id" aria-label="">
                                        <option selected="">Seçiniz</option>
                                        @foreach ($bidStatuses as $bidStatus)
                                            <option value="{{ $bidStatus->id }}">{{ $bidStatus->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </section>

                        <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">

                        <div class="form-group d-flex justify-content-end">
                            <button type="submit" class="btn btn-primary">
                                <i class="mdi mdi-plus mr-2"></i>
                                Ekle
                            </button>
                        </div>
                    </form>

                </div>
            </div>
        </div>


    </div>
    <!-- end row -->

@section('script')
<script  src="{{ asset('assets/libs/select2/js/select2.min.js') }}"></script>

    <script>
        $(document).ready(function() {
            $('select').select2();
        });
    </script>

    <script>
        $(document).ready(function() {
            var block = $('#block')
            $('#block').change(function() {
                var blockID = $(this).val();
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: '/admin/get-floor/' + blockID,
                    method: 'get',
                    success: function(result) {
                        if (result) {
                            $('#floor').empty()
                            $('#floor').append('<option disabled>Kat Seçiniz</option>')
                            $.each(result, function(key, floor) {
                                $('#floor').append('<option value="' + floor.id +
                                    '">' + floor.number + '</option>')
                            })
                        } else {
                            $('#floor').empty()
                        }
                    }
                })
            })
        });
    </script>
@endsection



@endsection
