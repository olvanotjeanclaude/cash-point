@extends('layouts.app')

@section('title') Profile güncelle @endsection

@section('content')
    <!-- start page title -->
    @include('includes.page-title-box',[
    'pageTitle'=>"Profil düzenleniyorsunuz",
    "pageDescription"=>"Sistemde yeni kullanıcılar burada yapılır"
    ])
    <!-- end page title -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form method="post" class="needs-validation" novalidate action="{{ route('admin.profile.update') }}"
                        autocomplete="off" enctype="multipart/form-data">
                        @csrf

                        @if (session('errorEmail'))
                            <x-alert type="danger" message="{{ session('errorEmail') }}" />
                        @endif


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
                                        @if($user->gender==2) checked @endif required>
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
                                        value="{{  $user->phone }}" required>
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
                            <label class="mb-2" for="work">Meslek</label>
                            <input type="text" class="form-control" id="work" value="{{ $user->work }}"
                                placeholder="Meslek" name="work" required>
                        </div>

                        <div class="form-group mb-3">
                            <label class="mb-2" for="description">Açıklama</label>
                            <textarea id="description" class="form-control" rows="7" placeholder="Açıklama giriniz.."
                                name="description">{{ $user->description }}</textarea>
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
                                <i class="fa fa-edit"></i>
                                Düzenle
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
