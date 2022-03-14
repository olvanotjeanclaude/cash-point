@extends('layouts.app')

@section('title')
    Yeni Müşteri
@endsection

@section('content')
    <!-- start page title -->
    @include('includes.page-title-box',[
    'pageTitle'=>"Müşteri Yönetimi",
    "pageDescription"=>"Sistemde yeni müşteri burada yapılır"
    ])

@section('css')
    <link href="{{ asset('assets/libs/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css">
@endsection
<!-- end page title -->
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <form method="post" class="needs-validation" novalidate action="{{ route('admin.customers.store') }}"
                    autocomplete="off" enctype="multipart/form-data">
                    @csrf

                    @if (session('errorEmail'))
                        <x-alert type="danger" message="{{ session('errorEmail') }}" />
                    @endif

                    <div class="generalInfo">
                        <h4 class="mb-3 text-info">Genel Bilgileri</h4>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label class="mb-2" for="name">Ad</label>
                                    <input type="text" class="form-control" id="name" value="{{ old('name') }}"
                                        placeholder="Ad" name="name" required>
                                    <div class="invalid-feedback">
                                        Lütfen geçerli ad girin.
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label class="mb-2" for="surname">Soyad</label>
                                    <input type="text" class="form-control" id="surname"
                                        value="{{ old('surname') }}" placeholder="Soyad" name="surname" required>
                                    <div class="invalid-feedback">
                                        Lütfen geçerli soayad girin.
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label for="work" class="form-label">Meslek</label>
                                    <input class="form-control" type="text" name="work" id="work">
                                    <div class="invalid-feedback">
                                        Lütfen geçerli meslek girin.
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group mb-3">
                                    <label class="mb-2">Cinsiyet</label>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="gender" id="male" value="1">
                                        <label class="form-check-label" for="male">
                                            Erkek
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="gender" id="female"
                                            value="2">
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
                                        name="birth_date" value="{{ old('birth_date') }}">
                                    <div class="invalid-feedback">
                                        Doğum tarihi giriniz.
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group mb-3">
                                    <label class="mb-2" for="phone">Telefon</label>
                                    <input type="tel" class="form-control" id="phone" placeholder="Telefon"
                                        name="phone" value="{{ old('phone') }}" required>
                                    <div class="invalid-feedback">
                                        Telefon boş bırakılmaz.
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group mb-3">
                                    <label class="mb-2" for="email">E-posta</label>
                                    <input type="email" class="form-control" id="email" placeholder="E-posta"
                                        name="email" value="{{ old('email') }}">
                                    <div class="invalid-feedback">
                                        Lütfen geçerli e-posta girin.
                                    </div>
                                </div>
                            </div>
                        </div>

                        <x-form.address />

                        <div class="form-group mb-3">
                            <label class="mb-2" for="description">Açıklama</label>
                            <textarea id="description" class="form-control" rows="7" placeholder="Açıklama giriniz.."
                                name="description">{{ old('description') }}</textarea>
                        </div>

                        <div class="form-group">
                            <div class="mb-3">
                                <label for="profileImage" class="form-label">Profile Resmi</label>
                                <input class="form-control" type="file" name="image" id="profileImage"
                                    accept="image/*">
                                <div class="invalid-feedback">
                                    Lütfen geçerli resmi girin.
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="social-media">
                        <h4 class="mb-3 text-info">Sosyal Medya Bilgileri</h4>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <div class="mb-3">
                                        <label for="facebook" class="form-label">Facebook Profil Linki</label>
                                        <input class="form-control" type="url" name="facebook" id="facebook">
                                        <div class="invalid-feedback">
                                            Lütfen geçerli linki giriniz.
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <div class="mb-3">
                                        <label for="instagram" class="form-label">Instagram Profil Linki</label>
                                        <input class="form-control" type="url" name="instagram" id="instagram">
                                        <div class="invalid-feedback">
                                            Lütfen geçerli linki giriniz.
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <div class="mb-3">
                                        <label for="twitter" class="form-label">Twitter Profil Linki</label>
                                        <input class="form-control" type="url" name="twitter" id="twitter">
                                        <div class="invalid-feedback">
                                            Lütfen geçerli linki giriniz.
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="other-info">
                        <h4 class="mb-3 text-info">Diğer Bilgileri</h4>

                        <div class="form-group mb-3">
                            <label class="mb-2" for="find_us_id">Bizi nereden buldu?</label>
                            <select name="otherInfo[find_us_id]" class="form-control" id="find_us_id">
                                <option value="">Seç</option>
                                @forelse ($foundUs as $item)
                                    <option value="{{ $item->id }}"
                                        @if (old('find_us_id') == $item->id) selected @endif>
                                        {{ $item->name }}
                                    </option>
                                @empty
                                @endforelse
                            </select>
                            <div class="invalid-feedback">
                                Bu alanı doldurunuz.
                            </div>
                        </div>


                        <div class="form-group mb-3">
                            <label class="mb-2" for="description">Kısa Açıklama</label>
                            <textarea id="description" class="form-control" rows="7"
                                placeholder="Kısa açıklama girebilirsiniz.."
                                name="otherInfo[description]">{{ old('description') }}</textarea>
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

<script>
    $(document).ready(function() {
        $("#is_ilimited").change(function() {
            let is_ilimited = $(this).val();

            if (is_ilimited == "1") {
                $("#finished_at").attr("disabled", false);
            } else {
                $("#finished_at").attr("disabled", true);
            }
        })
    })
</script>
@endsection
