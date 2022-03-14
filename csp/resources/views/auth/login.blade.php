<!doctype html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <title>Giriş yap</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Premium Multipurpose Admin & Dashboard Template" name="description">
    <meta content="Themesbrand" name="author">
    <!-- App favicon -->
    <link rel="shortcut icon" href="{{ asset('assets/images/favicon.ico') }}">

    <!-- Bootstrap Css -->
    <link href="{{ asset('assets/css/bootstrap.min.css') }}" id="bootstrap-style" rel="stylesheet" type="text/css">
    <!-- Icons Css -->
    <link href="{{ asset('assets/css/icons.min.css') }}" rel="stylesheet" type="text/css">
    <!-- App Css-->
    <link href="{{ asset('assets/css/app.min.css') }}" id="app-style" rel="stylesheet" type="text/css">

</head>

<body class="account-pages">
    <!-- Begin page -->
    <div class="accountbg"
        style="background: url({{ asset('assets/images/bg.jpg') }});background-size: cover;background-position: center;">
    </div>

    <div class="wrapper-page account-page-full">

        <div class="card shadow-none">
            <div class="card-block">

                <div class="account-box">

                    <div class="card-box shadow-none p-4">
                        <div class="p-2">
                            <div class="text-center mt-4">
                                <a href="index.html"><img src="assets/images/logo-dark.png" height="110" alt="logo"></a>
                            </div>

                            <h4 class="font-size-18 mt-5 text-center">Tekrardan Hoş Geldiniz!</h4>
                            <p class="text-muted text-center">Devam etmek için oturum açın.</p>

                            <form class="mt-4" action="{{ route('login') }}" method="POST">
                                @csrf
                                @error('errorLogin')
                                    <div class="form-group my-1">
                                        <div class="text-danger">{{ $message }}</div>
                                    </div>
                                @enderror
                                <div class="mb-3">
                                    <label class="form-label" for="email">E-posta</label>
                                    <input type="text" name="email"
                                        class="form-control  @error('email') email @enderror" id="email"
                                        placeholder="E-postanız">
                                    @error('email')
                                        <div class="text-danger my-1">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label class="form-label" for="password">Şifre</label>
                                    <input type="password" name="password" class="form-control" id="password"
                                        placeholder="Şifreniz">
                                    @error('password')
                                        <div class="text-danger my-1">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <div class="mb-3 row">
                                    <div class="col-sm-6">
                                        <div class="form-check">
                                            <input type="checkbox" name="remember_token" class="form-check-input"
                                                id="customControlInline">
                                            <label class="form-check-label" for="customControlInline">
                                                Beni hatırla</label>
                                        </div>
                                    </div>
                                    <div class="col-sm-6 text-end">
                                        <button class="btn btn-primary w-md waves-effect waves-light"
                                            type="submit">Giriş Yap</button>
                                    </div>
                                </div>

                                <div class="mb-3 mt-2 mb-0 row">
                                    <div class="col-12 mt-3">
                                        <a href="#"><i class="mdi mdi-lock"></i>Şifreni mi
                                            Unuttun?</a>
                                    </div>
                                </div>

                            </form>

                            <div class="mt-5 pt-4 text-center">
                                <p>
                                    © {{ date('Y') }} Designed by
                                    <a href="https://www.suaresoft.com/" target="_blank">
                                        <i class="mdi mdi-heart text-danger"></i>
                                        Suaresoft
                                    </a>
                                </p>
                            </div>

                        </div>
                    </div>
                </div>

            </div>
        </div>

    </div>

    <!-- JAVASCRIPT -->
    <script src="{{ asset('assets/libs/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/libs/metismenu/metisMenu.min.js') }}"></script>
    <script src="{{ asset('assets/libs/simplebar/simplebar.min.js') }}"></script>
    <script src="{{ asset('assets/libs/node-waves/waves.min.js') }}"></script>


    <script src="{{ asset('assets/js/app.js') }}"></script>

</body>

</html>
