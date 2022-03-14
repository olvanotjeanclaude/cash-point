@extends('layouts.app')

@section('title')
    {{ $project->name }}
@endsection

@section('css')
    <!-- Lightbox css -->
    <link href="{{ asset('assets/libs/magnific-popup/magnific-popup.css') }}" rel="stylesheet" type="text/css" />
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endsection

@section('content')
    <!-- start page title -->
    @include('includes.page-title-box',[
    'pageTitle'=>"Proje Bilgileri",
    "pageDescription"=>"Sistemde projenin tüm bilgileri burada görüntülenebilir"
    ])
    <!-- end page title -->

    <div class="row">
        <div class="col-xl-3 col-md-6">
            <div class="card mini-stat text-dark" style="background-color:#0081a7;">
                <div class="card-body">
                    <div class="mb-4">
                        <div class="float-start mini-stat-img me-4">
                            <img src="{{ asset('assets/images/services-icon/01.png') }}" alt="">
                        </div>
                        <h5 class="font-size-16 text-uppercase text-dark-50">Blok Sayısı</h5>
                        <h4 class="fw-medium font-size-24">{{ count($project->blocks) }}</h4>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card mini-stat text-dark" style="background-color:#00afb9;">
                <div class="card-body">
                    <div class="mb-4">
                        <div class="float-start mini-stat-img me-4">
                            <img src="{{ asset('assets/images/services-icon/01.png') }}" alt="">
                        </div>
                        <h5 class="font-size-16 text-uppercase text-dark-50">Daire Sayısı</h5>
                        <h4 class="fw-medium font-size-24">{{ count($project->blocks) }}</h4>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card mini-stat text-dark" style="background-color:#fed9b7;">
                <div class="card-body">
                    <div class="mb-4">
                        <div class="float-start mini-stat-img me-4">
                            <img src="{{ asset('assets/images/services-icon/01.png') }}" alt="">
                        </div>
                        <h5 class="font-size-16 text-uppercase text-dark-50">Dükkan Sayısı</h5>
                        <h4 class="fw-medium font-size-24">{{ count($project->blocks) }}</h4>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card mini-stat text-dark" style="background-color:#f07167;">
                <div class="card-body">
                    <div class="mb-4">
                        <div class="float-start mini-stat-img me-4">
                            <img src="{{ asset('assets/images/services-icon/01.png') }}" alt="">
                        </div>
                        <h5 class="font-size-16 text-uppercase text-dark-50">Satışı Tamamlanmış</h5>
                        <h4 class="fw-medium font-size-24">{{ count($project->blocks) }}</h4>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12">
            <h3 class="font-weight-bold text-capitalize text-center">{{ $project->name }}</h3>
        </div>

        <hr>
    </div>
    <div class="row">
        <div class="col-lg-2 col-sm-12">
            <h5>Filtreler</h5>
            <form action="{{ route('admin.project.filter') }}" method="post">
                @csrf
                <label for="form2" class="form-label">Durum</label>
                <select class="form-select" name="status" id="form2">
                    <option selected="" disabled="" value="">Seçiniz</option>
                    @foreach ($status as $status)
                        <option value="{{ $status->id }}">{{ $status->name }}</option>
                    @endforeach
                </select><br>

                <label for="form3" class="form-label">Cephe</label>
                <select class="form-select" name="facade" id="form3">
                    <option selected="" disabled="" value="">Seçiniz</option>
                    @foreach ($facades as $facade)
                        <option value="{{ $facade->id }}">{{ $facade->name }}</option>
                    @endforeach
                </select><br>

                <label for="label1" class="form-label">Oda Sayısı</label>
                <select class="form-select" name="room" id="label1">
                    <option selected="" disabled="" value="">Seçiniz</option>
                    @foreach ($rooms as $room)
                        <option value="{{ $room->id }}">{{ $room->type }}</option>
                    @endforeach
                </select><br>

                <label for="label2" class="form-label">Tipi</label>
                <select class="form-select" name="type" id="label2">
                    <option selected="" disabled="" value="">Seçiniz</option>
                    @foreach ($types as $type)
                        <option value="{{ $type->id }}">{{ $type->name }}</option>
                    @endforeach
                </select><br>

                <label for="block" class="form-label">Blok</label>
                <select class="form-select" name="block" id="block">
                    <option selected="" disabled="" value="">Seçiniz</option>
                    @foreach ($blocks as $block)
                        <option data-id="{{ $block->id }}" value="{{ $block->id }}">{{ $block->name }}</option>
                    @endforeach
                </select><br>

                <label for="floor" class="form-label">Kat</label>
                <select class="form-select" name="floor" id="floor">
                    <option selected="" disabled="" value="">Seçiniz</option>
                    @foreach ($floors as $floor)
                        <option data-id="{{ $floor->id }}" value="{{ $floor->id }}">{{ $floor->number }}. Kat
                        </option>
                    @endforeach
                </select><br>

                <button type="submit" class="btn btn-sm btn-success">
                    <i class="fas fa-filter"></i>
                    Filtrele
                </button>
            </form>

        </div>
        <div class="col-lg-10 col-sm-12">
            <div class="card mini-stat  text-dark">
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="datatable-buttons"
                            class="list-container table table-striped table-bordered dt-responsive nowrap"
                            style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                            <thead>
                                <tr>
                                    <th>Durumu</th>
                                    <th>Blok</th>
                                    <th>Kat</th>
                                    <th>Daire Numarası</th>
                                    <th>Daire Tipi</th>
                                    <th>Cephesi</th>
                                    <th>Güncel Fiyatı</th>
                                    <th class="text-center">Görüntüle</th>
                                    <th class="text-center">Teklif Oluştur</th>
                                </tr>
                            </thead>

                            <tbody>
                                @foreach ($project->blocks as $block)
                                    @foreach ($block->floors as $floor)
                                        @foreach ($floor->apartments as $apartment)
                                            <tr id="row_{{ $apartment->id }}">
                                                <td>
                                                    @switch($apartment->status->id)
                                                        @case(1)
                                                            <label class="badge bg-info">Satılık </label>
                                                        @break

                                                        @case(2)
                                                            <label class="badge bg-warning">Kiralık</label>
                                                        @break

                                                        @case(3)
                                                            <label class="badge bg-danger">Satılmış</label>
                                                        @break

                                                        @case(4)
                                                            <label class="badge bg-danger">Kiralanmış</label>
                                                        @break

                                                        @default
                                                            <label class="badge bg-light">Belirlenmemiş</label>
                                                    @endswitch
                                                </td>
                                                <td>{{ $apartment->floor->block->name }}</td>
                                                <td>{{ $apartment->floor->number }}. Kat</td>
                                                <td>{{ $apartment->number }}</td>
                                                <td>{{ $apartment->type->name }}</td>
                                                <td>{{ $apartment->facade->name }}</td>
                                                <td>{{ number_format($apartment->price, 2, ',', '.') }}₺</td>
                                                <td class="text-center"><a
                                                        href="{{ route('admin.apartments.view', ['id' => $apartment->id]) }}"
                                                        class="btn btn-sm btn-primary">
                                                        <i class="fas fa-eye"></i>
                                                        Görüntüle
                                                    </a></td>
                                                <td class="text-center">
                                                    <a type="button"
                                                        href="{{ route('admin.create.offer', ['id' => $apartment->id]) }}"
                                                        class="btn btn-sm btn-success">
                                                        <i class="fas fa-edit"></i>
                                                        Teklif Oluştur
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @endforeach
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <!-- end col -->
        </div>

    </div>


    <!-- end row -->
@endsection



@section('script')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="{{ asset('assets/libs/bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}"></script>
    <script src="{{ asset('assets/libs/spectrum-colorpicker2/spectrum.min.js') }}"></script>
    <script src="{{ asset('assets/libs/bootstrap-touchspin/jquery.bootstrap-touchspin.min.js') }}"></script>
    <script src="{{ asset('assets/libs/admin-resources/bootstrap-filestyle/bootstrap-filestyle.min.js') }}"></script>
    <script src="{{ asset('assets/libs/bootstrap-maxlength/bootstrap-maxlength.min.js') }}"></script>

    <script src="{{ asset('assets/js/pages/form-advanced.init.js') }}"></script>
    <!-- Magnific Popup-->
    <script src="{{ asset('assets/libs/magnific-popup/jquery.magnific-popup.min.js') }}"></script>

    <!-- Tour init js-->
    <script src="{{ asset('assets/js/pages/lightbox.init.js') }}"></script>

    <script>
        $(document).ready(function() {
            $('.js-example-basic-single').select2({
                dropdownParent: $('#editAddressModal')
            });
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
