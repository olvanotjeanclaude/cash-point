@extends('layouts.front')
@section('title')
    Kaydol
@endsection
@section('content')
    <!-- LISTING LIST -->
    <section>
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <!-- Form Register -->

                    <div class="card mx-auto" style="max-width:520px;">
                        <div class="card-body">
                            <h4 class="card-title mb-4">Kaydol</h4>
                            <form action="{{ route('register') }}" method="POST">
                                @csrf
                                <div class="form-group">
                                    @if ($errors->any())
                                        <div class="alert alert-danger">
                                            <ul>
                                                @foreach ($errors->all() as $error)
                                                    <li>{{ $error }}</li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    @endif
                                </div>

                                <div class="form-row">
                                    <div class="col form-group">
                                        <label>Ad</label>
                                        <input name="name" type="text" class="form-control" value="{{old('name')}}" placeholder="">
                                    </div>
                                    <div class="col form-group">
                                        <label>Soyad</label>
                                        <input type="text" name="surname" class="form-control" value="{{old('surname')}}" placeholder="">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label>Telefon</label>
                                    <input type="tel" class="form-control" name="phone" value="{{old('phone')}}" placeholder="">
                                </div>
                                <div class="form-group">
                                    <label>E-posta</label>
                                    <input type="email" class="form-control" name="email" value="{{old('email')}}" placeholder="">
                                    <small class="form-text text-muted">E-postanızı asla başkalarıyla
                                        paylaşmayacağız.</small>
                                </div>
                                <div class="form-group">
                                    <label class="custom-control custom-radio custom-control-inline">
                                        <input class="custom-control-input"  value="1" @if(old('gender')==1) checked @endif type="radio" name="gender">
                                        <span class="custom-control-label"> Erkek </span>
                                    </label>
                                    <label class="custom-control custom-radio custom-control-inline">
                                        <input class="custom-control-input" type="radio" name="gender" value="2" @if(old('gender')==2) checked @endif>
                                        <span class="custom-control-label"> Kadın </span>
                                    </label>
                                </div>
                                <div class="form-row">
                                    <div class="form-group col-lg-6">
                                        <label>İl</label>
                                        <select class="form-control" name="provinces">
                                            <option value=""> Seç...</option>
                                            <option>Uzbekistan</option>
                                            <option>Russia</option>
                                            <option>Bursa</option>
                                            <option>India</option>
                                            <option>Afganistan</option>
                                        </select>
                                    </div>
                                    <div class="form-group col-lg-6">
                                        <label>İlçe</label>
                                        <select class=" form-control" name="districts">
                                            <option value=""> Seç...</option>
                                            <option>Uzbekistan</option>
                                            <option>Russia</option>
                                            <option>United States</option>
                                            <option>India</option>
                                            <option>Afganistan</option>
                                        </select>
                                    </div>
                                </div> <!-- form-row.// -->
                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <label>Yeni Şifre oluştur</label>
                                        <input class="form-control" name="password" type="password">
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label>Şifreyi tekrar girin</label>
                                        <input class="form-control" name="password_confirmation" type="password">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary btn-block"> Kaydol </button>
                                </div>

                                <div class="form-group">
                                    <label class="custom-control custom-checkbox"> <input type="checkbox"
                                            name="is_term_accepted" class="custom-control-input" checked="">
                                        <span class="custom-control-label">
                                            Kaydol düğmesine tıklayarak, <a href="#">Koşullarımızı ve Veri İlkemizi</a>
                                            İlkemizi
                                            kabul etmiş olursun.
                                        </span>
                                    </label>
                                </div>
                            </form>
                        </div><!-- card-body.// -->
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- END LISTING LIST -->
@endsection
