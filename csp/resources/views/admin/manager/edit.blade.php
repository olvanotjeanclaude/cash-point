@extends('layouts.app')

@section('title') {{ $user->name }} @endsection

@section('css')
    <link href="{{ asset('assets/libs/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css">
@endsection

@section('content')
    <!-- start page title -->
    @include('includes.page-title-box',[
    'pageTitle'=>"Kullanıcı Yönetimi",
    "pageDescription"=>"Sistemde yeni kullanıcılar burada yapılır"
    ])
    <!-- end page title -->
    <p>
        {{ session('error') }}
    </p>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form method="post" class="needs-validation" novalidate
                        action="{{ route('admin.managers.update', ['manager' => $user->id]) }}" autocomplete="off"
                        enctype="multipart/form-data">
                        @method("PUT")
                        @csrf

                        @if (session('errorEmail'))
                            <x-alert type="danger" message="{{ session('errorEmail') }}" />
                        @endif

                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group mb-3">
                                    <label class="mb-2" for="status">Statü</label>
                                    <select class="form-control" name="status" required>
                                        <option value="">Seç</option>
                                        <option value="0" @if ($user->status == 0) selected @endif>Pasif</option>
                                        <option value="1" @if ($user->status == 1) selected @endif>Aktif</option>
                                    </select>
                                    <div class="invalid-feedback">
                                        Lütfen statü girin.
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label class="mb-2" for="name">Ad</label>
                                    <input type="text" class="form-control" id="name" value="{{ $user->name }}"
                                        placeholder="Ad" name="name" required>
                                    <div class="invalid-feedback">
                                        Lütfen geçerli ad girin.
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label class="mb-2" for="surname">Soyad</label>
                                    <input type="text" class="form-control" id="surname" value="{{ $user->surname }}"
                                        placeholder="Soyad" name="surname" required>
                                    <div class="invalid-feedback">
                                        Lütfen geçerli soayad girin.
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="form-group mb-3">
                                    <label class="mb-2">Cinsiyet</label>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="gender" id="male" value="1"
                                            @if ($user->gender == 1) checked @endif required>
                                        <label class="form-check-label" for="male">
                                            Erkek
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="gender" id="female" value="2"
                                            @if ($user->gender == 2) checked @endif required>
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
                                        name="birth_date" value="{{ $user->birth_date }}" required>
                                    <div class="invalid-feedback">
                                        Doğum tarihi giriniz.
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group mb-3">
                                    <label class="mb-2" for="phone">Telefon</label>
                                    <input type="tel" class="form-control" id="phone" placeholder="Telefon" name="phone"
                                        value="{{ $user->phone }}" required>
                                    <div class="invalid-feedback">
                                        Telefon boş bırakılmaz.
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group mb-3">
                                    <label class="mb-2" for="email">E-posta</label>
                                    <input type="email" class="form-control" id="email" placeholder="E-posta" name="email"
                                        value="{{ $user->email }}" required>
                                    <div class="invalid-feedback">
                                        Lütfen geçerli e-posta girin.
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group mb-3">
                                    <label class="mb-2" for="province">İl</label>
                                    <select name="province" id="province" class="form-control" required>
                                        <option value="" selected disabled>İl seçiniz</option>
                                        @foreach ($provinces as $key => $value)
                                            <option @if ($value->province_key == $user->province) selected @endif value="{{ $value->province_key }}">
                                                {{ $value->province_name }}</option>
                                        @endforeach
                                    </select>
                                    <div class="invalid-feedback">
                                        Lütfen il seçiniz.
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group mb-3">
                                    <label class="mb-2" for="district">İlçe</label>
                                    <select name="district" class="form-control" id="district" required>
                                        <option value="" @if (!$user->district) selected @endif disabled>Seç</option>
                                        @if ($user->district)
                                            <option value="{{ $user->district }}" selected>
                                                {{ $user->get_district->district_name }}</option>
                                        @endif
                                    </select>
                                    <div class="invalid-feedback">
                                        Lütfen İlçe seçiniz.
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group mb-3">
                                    <label class="mb-2" for="neighborhood">Mahalle</label>
                                    <select name="neighborhood" class="form-control" id="neighborhood" required>
                                        <option value="" @if (!$user->neighborhood) selected @endif disabled>Seç</option>
                                        @if ($user->neighborhood)
                                            <option value="{{ $user->neighborhood }}" selected>
                                                {{ $user->get_neighborhood->neighborhood_name }}</option>
                                        @endif
                                    </select>
                                    <div class="invalid-feedback">
                                        Lütfen Mahalle seçiniz.
                                    </div>
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="form-group mb-3">
                                    <label class="mb-2" for="address">Adres</label>
                                    <textarea class="form-control" name="address" id=""
                                        rows="5">{{ $user->address }}</textarea>
                                </div>
                            </div>
                        </div>

                        <div class="form-group mb-3">
                            <label class="mb-2" for="description">Açıklama</label>
                            <textarea id="description" class="form-control" rows="7" placeholder="Açıklama giriniz.."
                                name="description">{{ $user->description }}</textarea>
                        </div>

                        <div class="form-group mb-2">
                            <label class="mb-3" for="staff">Danışmanlar</label>
                            <select name="staff_id[]" class="select2 form-control" multiple="multiple"
                                data-placeholder="Seç ...">
                                <option value="">Seç</option>
                                @foreach ($staffs as $staff)
                                    <option value="{{ $staff->id }}" @if (in_array($staff->id, $selectedStaffs)) selected @endif>{{ $staff->full_name }}
                                    </option>
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
                                <i class="mdi mdi-account-edit-outline"></i>
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
    <script src="{{ asset('assets/libs/select2/js/select2.min.js') }}"></script>
@endsection