@extends('layouts.app')

@section('css')
    <link href="{{ asset('assets/libs/chartist/chartist.min.css') }}" rel="stylesheet">
@endsection

@section('title')
    Page d'accueil
@endsection

@section('content')
    <!-- start page title -->
    @include('includes.page-title-box', [
        'pageTitle' => " Page d'accueil",
        'pageDescription' => 'Bienvenue !',
    ])
    <!-- end page title -->

    @if (Auth::user()->permission == 1 || Auth::user()->permission == 2)
        @include('admin.partials.admin')
    @endif

    @if (Auth::user()->permission == 3)
        @include('admin.partials.staff')
    @endif

    @if (Auth::user()->permission == 4)
        @include('admin.partials.customer')
    @endif
@endsection