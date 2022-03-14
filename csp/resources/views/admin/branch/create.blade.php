@extends('layouts.app')

@section('title') Yeni Şübe @endsection

@section('content')
    <!-- start page title -->
    @include('includes.page-title-box',[
    'pageTitle'=>"Şübe Yönetimi",
    "pageDescription"=>"Sistemde yeni şübe burada yapılır",
    ])
    <!-- end page title -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form method="post" class="needs-validation" novalidate action="{{ route('admin.branchs.store') }}"
                        autocomplete="off" enctype="multipart/form-data">
                        @csrf

                        <div class="row">
                            <div class="col-md-6">
                                <label class="mb-2" for="type">Merkez mi ?</label>
                                <select name="type" class="form-control" id="type">
                                    <option value="">Şeç</option>
                                    <option value="0">Hayır</option>
                                    <option value="1">Evet</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label class="mb-2" for="name">Adı</label>
                                    <input type="text" class="form-control" id="name" value="{{ old('name') }}"
                                        placeholder="Şübenin adı" name="name" required>
                                    <div class="invalid-feedback">
                                        E-posta giriniz lütfen
                                    </div>
                                </div>
                            </div>
                        </div>

                        <section>
                            <h5 class="card-title text-info">Adres</h5>
                            <x-form.address />
                        </section>

                        <section>
                            <h5 class="card-title text-info">İletişim Bilgileri</h5>

                            <div class="form-group mb-3">
                                <label class="mb-2" for="email">E-posta</label>
                                <input type="email" class="form-control" id="email" value="{{ old('email') }}"
                                    placeholder="E-posta" name="email" required>
                                <div class="invalid-feedback">
                                    E-posta giriniz lütfen
                                </div>
                            </div>

                            <div class="form-group mb-3">
                                <label class="mb-2" for="phone">Telefon</label>
                                <input type="tel" class="form-control" id="phone" value="{{ old('phone') }}"
                                    placeholder="Telefon" name="phone" required>
                                <div class="invalid-feedback">
                                    Telefon giriniz lütfen
                                </div>
                            </div>
                        </section>


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

@endsection
