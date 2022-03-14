@extends('layouts.app')

@section('css')
    <div>
        <link href="{{ asset('assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css') }}" rel="stylesheet"
            type="text/css">
        <link href="{{ asset('assets/libs/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css') }}" rel="stylesheet"
            type="text/css">
    </div>
@endsection

@section('title')
    Projeler
@endsection

@section('content')
    <!-- start page title -->
    @include('includes.page-title-box',[
    'pageTitle'=>"Projeler",
    "pageDescription"=>"Sistemde kayıtlı Projeler listeleniyor",
    "action"=>"Yeni Proje",
    "icon" =>"fas fa-plus",
    "link" =>route("admin.project.create")
    ])
    <!-- end page title -->

    <div class="row">
        @foreach ($projects as $project)
            <div class="col-md-4  col-lg-4 col-xl-3 project-card">
                <div class="card overflow-hidden" style="-webkit-box-shadow: 7px 5px 28px 6px rgba(0,0,0,0.41);
    box-shadow: 7px 5px 28px 6px rgba(0,0,0,0.41);">
                    <div class="bg-primary">
                        <div class="text-primary text-center p-4">
                            <h5 class="text-white font-size-20">{{ $project->name }}</h5>
                            <a href="{{ route('admin.projects.show', ['project' => $project->id]) }}"
                                class="logo logo-admin">
                                <img src="{{ get_image($project->photo) }}" height="100" alt="logo">
                            </a>
                        </div>
                    </div>

                    <div class="card-body p-4 text-center">
                        <div class="p-3">
                            <a href="{{ route('admin.blocks.index', ['id' => $project->id]) }}"
                                class="btn btn-sm btn-warning">
                                <i class="fas fa-bars"></i>
                                Bloklar
                            </a>
                            <a href="{{ route('admin.projects.show', ['project' => $project->id]) }}"
                                class="btn btn-sm btn-primary">
                                <i class="fas fa-eye mr-2"></i>
                                Görüntüle
                            </a><br><br>
                            <a href="{{ route('admin.projects.edit', ['project' => $project->id]) }}"
                                class="btn btn-sm btn-success">
                                <i class="fas fa-edit mr-2"></i>
                                Düzenle
                            </a>
                            <button data-id="{{ $project->id }}"
                                data-url="{{ route('admin.projects.destroy', ['project' => $project->id]) }}"
                                class="btn btn-sm btn-danger remove">
                                <i class="fas fa-minus mr-2"></i>
                                Sil
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
        <!-- end col -->
    </div>
@endsection

@section('script')
    <x-datatable-js-link />
@endsection
