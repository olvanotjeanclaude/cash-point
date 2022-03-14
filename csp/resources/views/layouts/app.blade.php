<!doctype html>
<html lang="fr">

<head>
    <meta charset="utf-8">
    <title> @yield('title') | Cash Point</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Premium Multipurpose Admin & Dashboard Template" name="description">
    <meta content="Themesbrand" name="author">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <link rel="shortcut icon" href="{{ asset('assets/images/logo-light.png') }}" type="image/x-icon">

    @yield('css')
    <!-- App favicon -->
    {{-- <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" /> --}}

    <!-- Sweet Alert-->
    <link href="{{ asset('assets/libs/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet" type="text/css" />

    <!-- Bootstrap Css -->
    <link href="{{ asset('assets/css/bootstrap.min.css') }}" id="bootstrap-style" rel="stylesheet" type="text/css">
    <!-- Icons Css -->
    <link href="{{ asset('assets/css/icons.min.css') }}" rel="stylesheet" type="text/css">
    <!-- App Css-->
    <link href="{{ asset('assets/css/app.min.css') }}" id="app-style" rel="stylesheet" type="text/css">
    <!-- Custom Css-->
    <link rel="stylesheet" href="{{ asset('assets/css/custom.css') }}">
</head>


<body data-sidebar="dark">

    <!-- Begin page -->
    <div id="layout-wrapper">

        {{-- <div id="loading">
            <img id="loading-image" width="100" height="100" src="{{asset('assets/images/loading.gif')}}" alt="Loading..." />
        </div> --}}

        @include('includes.header')

        <!-- ========== Left Sidebar Start ========== -->
        @include('includes.left-sidebar')
        <!-- Left Sidebar End -->



        <!-- ============================================================== -->
        <!-- Start right Content here -->
        <!-- ============================================================== -->
        <div class="main-content">
            <div class="page-content">
                <div class="container-fluid">
                    @yield('content')
                </div>
            </div>
        </div>
        <!-- end main content-->

    </div>
    <!-- END layout-wrapper -->

    <!-- Right Sidebar -->
    @include('includes.right-sidebar')
    <!-- /Right-bar -->

    <!-- Right bar overlay-->
    <div class="rightbar-overlay"></div>

    <div class="position-fixed bottom-0 end-0 p-3" style="z-index: 11">
        <div id="alertToast" class="toast" role="alert" data-bs-autohide="false" aria-live="assertive"
            aria-atomic="true">
            <div class="toast-header text-white bg-danger">
                {{-- <img src="..." class="rounded me-2" alt="..."> --}}
                <strong class="me-auto" id="title">Bootstrap</strong>
                {{-- <small>11 mins ago</small> --}}
                <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
            <div class="toast-body">
                Hello, world! This is a toast message.
            </div>
        </div>
    </div>

    @include('includes.script')
    @yield('script')
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</body>

</html>
