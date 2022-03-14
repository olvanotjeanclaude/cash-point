@extends('layouts.app')

@section('title') Yeni Durum @endsection

@section('content')
    <!-- start page title -->
    @include('includes.page-title-box',[
    'pageTitle'=>"Satış Oluştur",
    "pageDescription"=>"Sistemde yeni satış burada yapılır",
    ])

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form method="post" class="needs-validation" novalidate action="{{ route('admin.sales.store') }}"
                        autocomplete="off" enctype="multipart/form-data">
                        @csrf
                        <section>
                          <div class=" form-group mb-3">
                              <label class="col-sm-2 col-form-label">Proje</label>
                              <div class="col-sm-12">
                                  <select id="project" class="form-select" aria-label="">
                                      <option selected="">Proje Seçiniz</option>
                                      @foreach($projects as $project)
                                      <option data-id="{{ $project->id }}" value="{{ $project->id }}">{{ $project->name }}</option>
                                      @endforeach
                                    </select>
                              </div>
                          </div>
                          <div class=" form-group mb-3">
                              <label class="col-sm-2 col-form-label">Blok</label>
                              <div class="col-sm-12">
                                  <select id="block" class="form-select" aria-label="">
                                      <option selected="">Seçiniz</option>
                                    </select>
                              </div>
                          </div>
                          <div class=" form-group mb-3">
                              <label class="col-sm-2 col-form-label">Kat</label>
                              <div class="col-sm-12">
                                  <select id="floor" class="form-select" aria-label="">
                                      <option selected="">Seçiniz</option>
                                    </select>
                              </div>
                          </div>
                          <div class=" form-group mb-3">
                              <label class="col-sm-2 col-form-label">Daire Numarası</label>
                              <div class="col-sm-12">
                                  <select id="apartment" class="form-select" name="apartment_id" aria-label="">
                                      <option selected="">Seçiniz</option>
                                    </select>
                              </div>
                          </div>
                            <div class="form-group mb-3">
                              <label class="col-sm-2 col-form-label">Müşteri Seçimi</label>
                              <select class="js-example-basic-single" style="width:100%;" name="customer_id">
                                @foreach($customers as $customer)
                                <option value="{{ $customer->id }}">{{ $customer->name }} {{ $customer->surname }}</option>
                                @endforeach
                              </select>
                            </div>
                            <div class="form-group mb-3">
                                <label class="mb-2" for="email">Fiyat</label>
                                <input  type="text" class="form-control" id="name" value="{{ old('price') }}"
                                    placeholder="Fiyat" name="price" required>
                                <div class="invalid-feedback">
                                    Lütfen geçerli bir isim giriniz.
                                </div>
                            </div>
                        </section>

                        <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">

                        <div class="form-group d-flex justify-content-end">
                            <button type="submit" class="btn btn-primary">
                                <i class="mdi mdi-plus mr-2"></i>
                                Satışı Gerçekleştir
                            </button>
                        </div>
                    </form>

                </div>
            </div>
        </div>


    </div>
    <!-- end row -->

@section('script')
  <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
  <script>
    $(document).ready(function() {
        $('.js-example-basic-single').select2();
    });
  </script>

  <script>
    $(document).ready(function () {
      var project = $('#project')
      $('#project').change(function(){
        var projectID = $(this).val();
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: '/admin/get-projects/' + projectID,
            method: 'get',
            success: function (result) {
              if (result) {
                  $('#block').empty()
                  $('#block').append('<option >Blok Seçiniz</option>')
                  $.each(result, function (key, block) {
                      $('#block').append('<option data-id="' + block.id +'" value="' + block.id +'">' + block.name + '</option>')
                  })
                  var block = $('#block')
                  $('#block').change(function(){
                    var blockID = $(this).val();
                    $.ajax({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        url: '/admin/get-floors/' + blockID,
                        method: 'get',
                        success: function (result) {
                          if (result) {
                              $('#floor').empty()
                              $('#floor').append('<option >Kat Seçiniz</option>')
                              $.each(result, function (key, floor) {
                                  $('#floor').append('<option  data-id="' + floor.id +'" value="' + floor.id +
                                      '">' + floor.number + '</option>')
                              })
                          } else {
                              $('#floor').empty()
                          }
                        }
                      })
                    })
                    var floor = $('#floor')
                    $('#floor').change(function(){
                      var floorID = $(this).val();
                      $.ajax({
                          headers: {
                              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                          },
                          url: '/admin/get-apartments/' + floorID,
                          method: 'get',
                          success: function (result) {
                            if (result) {
                                $('#apartment').empty()
                                $('#apartment').append('<option >Daire Seçiniz</option>')
                                $.each(result, function (key, apartment) {
                                    $('#apartment').append('<option  data-id="' + apartment.id +'" value="' + apartment.id +
                                        '">' + apartment.name +  ' - No:' + apartment.number + '</option>')
                                })
                            } else {
                                $('#apartment').empty()
                            }
                          }
                        })
                      })
              } else {
                  $('#block').empty()
              }
            }
          })
        })
      });
  </script>

@endsection

@endsection
