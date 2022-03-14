@extends('layouts.app')

@section('title')
    {{ $customer->name }}
@endsection

@section('content')
    <!-- start page title -->
    @include('includes.page-title-box',[
    'pageTitle'=>"Personel Yönetimi",
    "pageDescription"=>"Sistemde yeni personel burada yapılır"
    ])
@section('css')
    <link href="{{ asset('assets/libs/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css">
@endsection
<!-- end page title -->
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <form method="post" class="needs-validation" novalidate
                    action="{{ route('admin.customers.update', ['customer' => $customer->id]) }}" autocomplete="off"
                    enctype="multipart/form-data">
                    @csrf
                    @method("PUT")

                    @if (session('errorEmail'))
                        <x-alert type="danger" message="{{ session('errorEmail') }}" />
                    @endif

                    <h4 class="mb-3 text-info">Genel Bilgileri</h4>

                    @if (Auth::user()->permission == 1 || Auth::user()->permission == 2)
                        <div class="form-group mb-3">
                            <div class="mb-3">
                                <label class="mb-2" for="durum">Dürüm</label>
                                <select name="status" class="form-control" id="durum" required>
                                    <option value="">Seç</option>
                                    <option value="0" @if ($customer->status == 0) selected @endif>Pasif</option>
                                    <option value="1" @if ($customer->status == 1) selected @endif>Aktif</option>
                                </select>
                                <div class="invalid-feedback">
                                    Dümümü seçiniz lütfen
                                </div>
                            </div>
                        </div>
                    @endif


                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label class="mb-2" for="name">Ad</label>
                                <input type="text" class="form-control" id="name" value="{{ $customer->name }}"
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
                                    value="{{ $customer->surname }}" placeholder="Soyad" name="surname" required>
                                <div class="invalid-feedback">
                                    Lütfen geçerli soayad girin.
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="mb-3">
                                <label for="work" class="form-label">Meslek</label>
                                <input class="form-control" value="{{ $customer->work }}" type="text" name="work"
                                    id="work">
                                <div class="invalid-feedback">
                                    Lütfen geçerli meslek girin.
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group mb-3">
                                <label class="mb-2">Cinsiyet</label>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="gender" id="male" value="1"
                                        @if ($customer->gender == 1) checked @endif required>
                                    <label class="form-check-label" for="male">
                                        Erkek
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="gender" id="female" value="2"
                                        @if ($customer->gender == 2) checked @endif required>
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
                                    name="birth_date" value="{{ $customer->birth_date }}">
                                <div class="invalid-feedback">
                                    Doğum tarihi giriniz.
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group mb-3">
                                <label class="mb-2" for="phone">Telefon</label>
                                <input type="tel" class="form-control" id="phone" placeholder="Telefon" name="phone"
                                    value="{{ $customer->phone }}" required>
                                <div class="invalid-feedback">
                                    Telefon boş bırakılmaz.
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group mb-3">
                                <label class="mb-2" for="email">E-posta</label>
                                <input type="email" class="form-control" id="email" placeholder="E-posta" name="email"
                                    value="{{ $customer->email }}">
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
                                <select name="province" id="province" class="form-control">
                                    <option value="" selected disabled>İl seçiniz</option>
                                    @foreach ($provinces as $key => $value)
                                        <option @if ($value->province_key == $customer->province) selected @endif
                                            value="{{ $value->province_key }}">
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
                                <select name="district" class="form-control" id="district">
                                    <option value="" @if (!$customer->district) selected @endif disabled>Seç
                                    </option>
                                    @if ($customer->district)
                                        <option value="{{ $customer->district }}" selected>
                                            {{ $customer->get_district->district_name }}</option>
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
                                <select name="neighborhood" class="form-control" id="neighborhood">
                                    <option value="" @if (!$customer->neighborhood) selected @endif disabled>Seç
                                    </option>
                                    @if ($customer->neighborhood)
                                        <option value="{{ $customer->neighborhood }}" selected>
                                            {{ $customer->get_neighborhood->neighborhood_name }}</option>
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
                                    rows="5">{{ $customer->address }}</textarea>
                            </div>
                        </div>
                    </div>

                    <div class="form-group mb-3">
                        <label class="mb-2" for="description">Açıklama</label>
                        <textarea id="description" class="form-control" rows="7" placeholder="Açıklama giriniz.."
                            name="description">{{ $customer->description }}</textarea>
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

                    <div class="social-media">
                        <h4 class="mb-3 text-info">Sosyal Medya Bilgileri</h4>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <div class="mb-3">
                                        <label for="facebook" class="form-label">Facebook Profil Linki</label>
                                        <input class="form-control" type="url" value="{{ $customer->facebook }}"
                                            name="facebook" id="facebook">
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
                                        <input class="form-control" value="{{ $customer->instagram }}" type="url"
                                            name="instagram" id="instagram">
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
                                        <input class="form-control" type="url" value="{{ $customer->twitter }}"
                                            name="twitter" id="twitter">
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
                            <select name="find_us_id" class="form-control" id="find_us_id">
                                <option value="">Seç</option>
                                @forelse ($findUsData as $item)
                                    <option value="{{ $item->id }}"
                                        @if ($customer->other_info != null && $customer->other_info->find_us_id == $item->id) selected @endif>{{ $item->name }}</option>
                                @empty
                                @endforelse
                            </select>
                            <div class="invalid-feedback">
                                Bu alanı doldurunuz.
                            </div>
                        </div>

                        <div class="form-group mb-3">
                            <label class="mb-2" for="other_info_description">Kısa Açıklama</label>
                            <textarea id="other_info_description" class="form-control" rows="7"
                                placeholder="Kısa açıklama girebilirsiniz.."
                                name="other_info_description">{{ $customer->other_info->description ?? '' }}</textarea>
                        </div>
                    </div>


                    <div class="form-group d-flex justify-content-end px-3">
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
