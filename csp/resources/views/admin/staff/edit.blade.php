@extends('layouts.app')

@section('title') {{ $staff->name }} @endsection

@section('content')
    <!-- start page title -->
    @include('includes.page-title-box',[
    'pageTitle'=>"Personel Yönetimi",
    "pageDescription"=>"Sistemde yeni personel burada yapılır"
    ])
    <!-- end page title -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form method="post" class="needs-validation" novalidate action="{{ route('admin.staffs.update',['staff'=>$staff->id]) }}"
                        autocomplete="off" enctype="multipart/form-data">
                        @csrf
                        @method("PUT")

                        @if (session('errorEmail'))
                            <x-alert type="danger" message="{{ session('errorEmail') }}" />
                        @endif

                        <h4 class="mb-3 text-info">Genel Bilgileri</h4>

                        <div class="form-group mb-3">
                            <div class="mb-3">
                                <label class="mb-2" for="durum">Dürüm</label>
                                <select name="status" class="form-control" id="durum" required>
                                    <option value="">Seç</option>
                                    <option value="0" @if ($staff->status == 0) selected @endif>Pasif</option>
                                    <option value="1" @if ($staff->status == 1) selected @endif>Aktif</option>
                                </select>
                                <div class="invalid-feedback">
                                    Dümümü seçiniz lütfen
                                </div>  
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group mb-3">
                                    <div class="mb-3">
                                        <label class="mb-2" for="created_date">Oluşturma Tarihi </label>
                                        <input type="date" class="form-control" id="created_date"
                                            value="{{ $staff->created_date }}" name="created_date" required>
                                        <div class="invalid-feedback">
                                            Lütfen oluşturma tarihi kotrol ediniz
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group mb-3">
                                    <div class="mb-3">
                                        <label class="mb-2" for="started_at">İşe Başlama Tarihi</label>
                                        <input type="date" class="form-control" id="started_at"
                                            value="{{ $staff->started_at }}" name="started_at"
                                            required>
                                        <div class="invalid-feedback">
                                            Lütfen işe başlama kotrol ediniz
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group mb-3">
                                    <div class="mb-3">
                                        <label class="mb-2" for="finished_at">Kullanma Zamanı Süresiz Mi?</label>
                                        <select  class="form-control" id="is_ilimited" required>
                                            <option value="">Seç</option>
                                            <option value="0" @if ($staff->is_ilimited == 0) selected @endif>Hayır</option>
                                            <option value="1" @if ($staff->is_ilimited == 1) selected @endif>Evet</option>
                                        </select>
                                        <div class="invalid-feedback">
                                            Lütfen Yetki Süresi girin
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group mb-3">
                                    <div class="mb-3">
                                        <label class="mb-2" for="finished_at">Bitiş Tarihi</label>
                                        <input @if ($staff->is_ilimited == 1) disabled @endif type="date" class="form-control" id="finished_at"
                                            value="{{ $staff->finished_at }}"
                                            name="finished_at" required>
                                        <div class="invalid-feedback">
                                            Lütfen bitiş tarihi kotrol ediniz
                                        </div>
                                    </div>
                                </div>
                            </div>


                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label class="mb-2" for="name">Ad</label>
                                    <input type="text" class="form-control" id="name" value="{{ $staff->name }}"
                                        placeholder="Ad" name="name" required>
                                    <div class="invalid-feedback">
                                        Lütfen geçerli ad girin.
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label class="mb-2" for="surname">Soyad</label>
                                    <input type="text" class="form-control" id="surname" value="{{ $staff->surname }}"
                                        placeholder="Soyad" name="surname" required>
                                    <div class="invalid-feedback">
                                        Lütfen geçerli soayad girin.
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label for="work" class="form-label">Meslek</label>
                                    <input class="form-control" value="{{ $staff->work }}" type="text" name="work"
                                        id="work" required>
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
                                            @if ($staff->gender == 1) checked @endif required>
                                        <label class="form-check-label" for="male">
                                            Erkek
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="gender" id="female" value="2"
                                            @if ($staff->gender == 2) checked @endif required>
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
                                        name="birth_date" value="{{ $staff->birth_date }}" required>
                                    <div class="invalid-feedback">
                                        Doğum tarihi giriniz.
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group mb-3">
                                    <label class="mb-2" for="phone">Telefon</label>
                                    <input type="tel" class="form-control" id="phone" placeholder="Telefon" name="phone"
                                        value="{{ $staff->phone }}" required>
                                    <div class="invalid-feedback">
                                        Telefon boş bırakılmaz.
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group mb-3">
                                    <label class="mb-2" for="email">E-posta</label>
                                    <input type="email" class="form-control" id="email" placeholder="E-posta" name="email"
                                        value="{{ $staff->email }}" required>
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
                                            <option @if ($value->province_key == $staff->province) selected @endif value="{{ $value->province_key }}">
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
                                        <option value="" @if (!$staff->district) selected @endif disabled>Seç</option>
                                        @if ($staff->district)
                                            <option value="{{ $staff->district }}" selected>
                                                {{ $staff->get_district->district_name }}</option>
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
                                        <option value="" @if (!$staff->neighborhood) selected @endif disabled>Seç</option>
                                        @if ($staff->neighborhood)
                                            <option value="{{ $staff->neighborhood }}" selected>
                                                {{ $staff->get_neighborhood->neighborhood_name }}</option>
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
                                        rows="5">{{ $staff->address }}</textarea>
                                </div>
                            </div>
                        </div>

                        <div class="form-group mb-3">
                            <label class="mb-2" for="description">Açıklama</label>
                            <textarea id="description" class="form-control" rows="7" placeholder="Açıklama giriniz.."
                                name="description">{{ $staff->description }}</textarea>
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
    <script>
        $(document).ready(function() {
            $("#is_ilimited").change(function() {
                let is_ilimited = $(this).val();

                if (is_ilimited == "0") {
                    $("#finished_at").attr("disabled", false);
                } else {
                    $("#finished_at").attr("disabled", true);
                }
            })
        })
    </script>
@endsection
