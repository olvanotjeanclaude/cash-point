@extends('layouts.app')

@section('css')
    <div>
        <link href="{{ asset('assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css') }}" rel="stylesheet"
            type="text/css">
        <link href="{{ asset('assets/libs/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css') }}" rel="stylesheet"
            type="text/css">
    </div>

@endsection

@section('title') {{ $staff->full_name }} Şübeleri @endsection

@section('content')

    <!-- start page title -->
    @include('includes.page-title-box',[
    'pageTitle'=>"$staff->full_name Şübeleri",
    "pageDescription"=>"Sistemde bu personelin Şübeleri listeleniyor",
    "action"=> count($staff->branchs)==0?"Yeni Şübe":"Güncelle" ,
    "icon" => count($staff->branchs)==0?"fas fa-plus":"fas fa-edit",
    "link" =>route('admin.user.create_branch',['user_type' =>"staff","id" =>$staff->id]),
    ])
    <!-- end page title -->

    <x-branch.user-branch :branchs="$staff->branchs" />

@endsection

@section('script')
    <x-datatable-js-link />
@endsection
