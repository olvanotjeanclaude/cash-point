@extends('layouts.app')

@section('css')
    <div>
        <link href="{{ asset('assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css') }}" rel="stylesheet"
            type="text/css">
        <link href="{{ asset('assets/libs/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css') }}" rel="stylesheet"
            type="text/css">
    </div>

@endsection

@section('title') Şübelerim @endsection

@section('content')

    <!-- start page title -->
    @include('includes.page-title-box',[
    'pageTitle'=>"Şübelerim",
    "pageDescription"=>"Sistemde kayıtlı Şübelerim listeleniyor",
    "action"=>"Yeni Şübe",
    "icon" =>"fas fa-plus",
    "link" =>route("admin.branchs.create")
    ])
    <!-- end page title -->

    <x-branch.user-branch :branchs="$branchs" />

@endsection

@section('script')
    <x-datatable-js-link />
@endsection
