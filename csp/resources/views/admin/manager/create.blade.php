@extends('layouts.app')

@section('title') Yeni Yönetici @endsection

@section('css')
    <link href="{{ asset('assets/libs/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css">
@endsection

@section('content')
    <!-- start page title -->
    @include('includes.page-title-box',[
    'pageTitle'=>"Yönetici Yönetimi",
    "pageDescription"=>"Sistemde yeni yönetic burada yapılır"
    ])
    <!-- end page title -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form method="post" class="needs-validation" novalidate action="{{ route('admin.managers.store') }}"
                        autocomplete="off" enctype="multipart/form-data">
                        @csrf

                        @if (session('errorEmail'))
                            <x-alert type="danger" message="{{ session('errorEmail') }}" />
                        @endif


                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group mb-3">
                                    <label class="mb-2" for="name">Ad</label>
                                    <input type="text" class="form-control" id="name" value="{{ old('name') }}"
                                        placeholder="Ad" name="name" required>
                                    <div class="invalid-feedback">
                                        Lütfen geçerli ad girin.
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group mb-3">
                                    <label class="mb-2" for="surname">Soyad</label>
                                    <input type="text" class="form-control" id="surname" value="{{ old('surname') }}"
                                        placeholder="Soyad" name="surname" required>
                                    <div class="invalid-feedback">
                                        Lütfen geçerli soayad girin.
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group mb-3">
                                    <label class="mb-2" for="password">Şifre</label>
                                    <input type="password" value="{{ old('password') }}" class="form-control"
                                        id="password" placeholder="Şifre" name="password" required>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group mb-3">
                                    <label class="mb-2">Cinsiyet</label>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="gender" id="male" value="1"
                                            required>
                                        <label class="form-check-label" for="male">
                                            Erkek
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="gender" id="female" value="2"
                                            required>
                                        <label class="form-check-label" for="female">
                                            Kadın
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group mb-3">
                                    <label class="mb-2" for="birth_date">Doğum Tarihi</label>
                                    <input type="date" class="form-control" id="birth_date" placeholder="Doğum tarihi"
                                        name="birth_date" value="{{ old('birth_date') }}" required>
                                    <div class="invalid-feedback">
                                        Doğum tarihi giriniz.
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group mb-3">
                                    <label class="mb-2" for="phone">Telefon</label>
                                    <input type="tel" class="form-control" id="phone" placeholder="Telefon" name="phone"
                                        value="{{ old('phone') }}" required>
                                    <div class="invalid-feedback">
                                        Telefon boş bırakılmaz.
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group mb-3">
                                    <label class="mb-2" for="email">E-posta</label>
                                    <input type="email" class="form-control" id="email" placeholder="E-posta" name="email"
                                        value="{{ old('email') }}" required>
                                    <div class="invalid-feedback">
                                        Lütfen geçerli e-posta girin.
                                    </div>
                                </div>
                            </div>
                        </div>

                        <x-form.address />


                        <div class="form-group mb-3">
                            <label class="mb-2" for="description">Açıklama</label>
                            <textarea id="description" class="form-control" rows="5" placeholder="Açıklama giriniz.."
                                name="description">{{ old('description') }}</textarea>
                        </div>

                        <div class="form-group mb-2">
                            <label class="mb-3" for="branch">Danışmanlar</label>
                            <select name="staff_id[]" class="select2 form-control" multiple="multiple"
                                data-placeholder="Seç ...">
                                <option value="">Seç</option>
                                @foreach ($staffs as $staff)
                                    <option value="{{ $staff->id }}">{{ $staff->full_name }}</option>
                                @endforeach
                            </select>
                            <div class="invalid-feedback">
                                Lütfen danışmanları seçin
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="mb-3">
                                <label for="profileImage" class="form-label">Profile Resmi</label>
                                <input class="form-control" type="file" name="image" id="profileImage">
                                <div class="invalid-feedback">
                                    Lütfen geçerli resmi girin.
                                </div>
                            </div>
                        </div>


                        <div class="form-group d-flex justify-content-end">
                            <button type="submit" class="btn btn-primary">
                                <i class="mdi mdi-account-plus-outline"></i>
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
    <script src="{{ asset('assets/libs/select2/js/select2.min.js') }}"></script>
@endsection
