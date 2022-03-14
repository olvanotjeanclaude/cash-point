@extends('layouts.app')

@section('title') Yeni Kat @endsection

@section('content')
    <!-- start page title -->
    @include('includes.page-title-box',[
    'pageTitle'=>"Kat Yönetimi",
    "pageDescription"=>"Sistemde yeni Kat burada yapılır",
    ])
    <!-- end page title -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form method="post" class="needs-validation" novalidate action="{{ route('admin.floors.store') }}"
                        autocomplete="off" enctype="multipart/form-data">
                        @csrf
                        <section>
                            <div class="form-group mb-3">
                                <label class="mb-2" for="email">Kat Numarası</label>
                                <input type="text" class="form-control" id="number" value="{{ old('number') }}"
                                    placeholder="Kat numarası" name="number" required>
                                <div class="invalid-feedback">
                                    Lütfen geçerli bir numara giriniz.
                                </div>
                            </div>
                        </section>

                        <div class="form-group d-flex justify-content-end">
                            <button type="submit" class="btn btn-primary">
                                <i class="mdi mdi-plus mr-2"></i>
                                Ekle
                            </button>
                        </div>
                        <input type="hidden" name="block_id" value="{{ $_GET['id'] }}">
                    </form>

                </div>
            </div>
        </div>


    </div>
    <!-- end row -->

@endsection
