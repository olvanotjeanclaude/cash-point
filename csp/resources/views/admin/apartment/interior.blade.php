@extends('layouts.app')

@section('title') Dairenin İç Özellikleri @endsection

@section('content')
    <!-- start page title -->
    @include('includes.page-title-box',[
    'pageTitle'=>"Dairenin İç Özellikleri",
    "pageDescription"=>"Sistemde dairelerin iç özelliklerini belirlemek için alanları doldurun.",
    ])
    <!-- end page title -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                  <div class="p-3 bg-transparent card-header d-flex justify-content-between">
                      <h6 class="mt-1 text-uppercase">Daire Genel Bilgileri</h6>
                      <div>
                          <button type="button" class="btn btn-sm btn-success" onclick="history.back()">
                              <i class="fas fa-arrow-left"></i>
                              Geri Dön
                          </button>
                      </div>
                  </div>
                    <form method="post" class="needs-validation" novalidate action="{{ route('admin.apartments.interior.store') }}"
                        autocomplete="off" enctype="multipart/form-data">
                        @csrf
                        <section>
                          <div class="row">
                            @foreach($interiors as $interior)
                            <div class="col-6" style="margin-bottom: 15px;">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" @if($data->InteriorFeature->contains($interior->id)) checked @endif value="{{ $interior->id }}" name="interior[]" id="{{ $interior->id }}">
                                    <label class="form-check-label" for="{{ $interior->id }}">
                                      {{ $interior->name }}
                                    </label>
                                </div>
                            </div>
                            @endforeach


                            </div>

                        </section>
                        <div class="form-group d-flex justify-content-end">
                            <button type="submit" class="btn btn-success">
                                <i class="mdi mdi-plus mr-2"></i>
                                Güncelle
                            </button>
                        </div>
                        <input type="hidden" name="apartment_id" value="{{ $data->id }}">
                    </form>
                </div>
            </div>
        </div>


    </div>
    <!-- end row -->

@endsection
