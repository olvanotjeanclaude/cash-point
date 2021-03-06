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
                                    <small class="form-text text-muted">E-postan??z?? asla ba??kalar??yla
                                        payla??mayaca????z.</small>
                                </div>
                                <div class="form-group">
                                    <label class="custom-control custom-radio custom-control-inline">
                                        <input class="custom-control-input"  value="1" @if(old('gender')==1) checked @endif type="radio" name="gender">
                                        <span class="custom-control-label"> Erkek </span>
                                    </label>
                                    <label class="custom-control custom-radio custom-control-inline">
                                        <input class="custom-control-input" type="radio" name="gender" value="2" @if(old('gender')==2) checked @endif>
                                        <span class="custom-control-label"> Kad??n </span>
                                    </label>
                                </div>
                                <div class="form-row">
                                    <div class="form-group col-lg-6">
                                        <label>??l</label>
                                        <select class="form-control" name="provinces">
                                            <option value=""> Se??...</option>
                                            <option>Uzbekistan</option>
                                            <option>Russia</option>
                                            <option>Bursa</option>
                                            <option>India</option>
                                            <option>Afganistan</option>
                                        </select>
                                    </div>
                                    <div class="form-group col-lg-6">
                                        <label>??l??e</label>
                                        <select class=" form-control" name="districts">
                                            <option value=""> Se??...</option>
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
                                        <label>Yeni ??ifre olu??tur</label>
                                        <input class="form-control" name="password" type="password">
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label>??ifreyi tekrar girin</label>
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
                                            Kaydol d????mesine t??klayarak, <a href="#">Ko??ullar??m??z?? ve Veri ??lkemizi</a>
                                            ??lkemizi
                                            kabul etmi?? olursun.
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
