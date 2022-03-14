@extends('layouts.app')

@section('title') Dairenin İç Özellikleri @endsection

@section('content')
    <!-- start page title -->
    @include('includes.page-title-box',[
    'pageTitle'=>"Dairenin Dış Özellikleri",
    "pageDescription"=>"Sistemde dairelerin dış özelliklerini belirlemek için alanları doldurun.",
    ])
    <!-- end page title -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                  <div class="p-3 bg-transparent card-header d-flex justify-content-between">
                      <h6 class="mt-1 text-uppercase">Daire Genel Bilgileri</h6>
                  </div>
                    <form method="post" class="needs-validation" novalidate action="{{ route('admin.apartments.exterior.store') }}"
                        autocomplete="off" enctype="multipart/form-data">
                        @csrf
                        <section>
                          <div class="row">
                            @foreach($exteriors as $exterior)
                            <div class="col-6" style="margin-bottom: 15px;">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" @if($data->exteriorFeature->contains($exterior->id)) checked @endif value="{{ $exterior->id }}" name="exterior[]" id="{{ $exterior->id }}">
                                    <label class="form-check-label" for="{{ $exterior->id }}">
                                      {{ $exterior->name }}
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
