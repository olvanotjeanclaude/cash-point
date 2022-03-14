@extends('layouts.app')

@section('title') {{ $staff->name }} @endsection

@section('content')
    <!-- start page title -->
    @include('includes.page-title-box',[
    'pageTitle'=>"Personelin Bilgileri",
    "pageDescription"=>"Sistemde personelin bilgileri burada görüntülenebilir"
    ])
    <!-- end page title -->

    <div class="row">
        <div class="col-12">
            <div class="card directory-card">
                <div class="p-2 card-header text-white bg-info d-flex justify-content-between">
                    <h6 class="mt-1">Genel Bilgileri</h6>
                    <div>
                        <a class="btn btn-light btn-sm" href="{{ route('admin.staffs.edit', ['staff' => $staff->id]) }}">
                            <i class="fas fa-user-edit"></i>
                            Düzenle
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="d-flex">
                        <div class="flex-shrink-0">
                            <img src="{{ get_image($staff->image) }}" alt="Profil Resmi"
                                class="img-fluid img-thumbnail rounded-circle avatar-lg">
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h5 class="text-primary font-size-18 mb-1">{{ $staff->full_name }}</h5>
                            <p class="font-size-12 mb-2">{{ $staff->work }}</p>
                            <p class="mb-0">{{ $staff->email }}</p>
                            <p>
                                @if ($staff->status == 1)
                                    <label class="badge bg-success">Aktif</label>
                                @else
                                    <label class="badge bg-danger">Pasif</label>
                                @endif
                            </p>
                        </div>
                        <ul class="list-unstyled social-links ms-auto">
                            @if ($staff->facebook)
                                <li>
                                    <a href="{{ $staff->$staff->facebook }}" class="btn-primary">
                                        <i class="mdi mdi-facebook"></i>
                                    </a>
                                </li>
                            @endif
                            @if ($staff->twitter)
                                <li>
                                    <a href="{{ $staff->$staff->twitter }}" class="btn-info">
                                        <i class="mdi mdi-twitter"></i>
                                    </a>
                                </li>
                            @endif
                            @if ($staff->instagram)
                                <li>
                                    <a href="{{ $staff->$staff->instagram }}" class="btn-secondary">
                                        <i class="mdi mdi-instagram"></i>
                                    </a>
                                </li>
                            @endif
                        </ul>
                    </div>
                    <hr>

                    <p><b>Hakkında : </b>{{ $staff->description }}</p>
                    <hr>
                    <div class="row">
                        <div class="col-md-6">
                            <p><b>Cinsiyet : </b>{{ $staff->gender == 1 ? 'Erkek' : 'Kadın' }}</p>
                            <p><b>Doğum Tarihi : </b>{{ format_date($staff->birth_date) }}</p>
                            <p><b>Meslek : </b>{{ $staff->work }}</p>
                            <p><b>Sisteme ekleme tarihi:</b> {{ format_date($staff->created_at) }}</p>
                        </div>

                        <div class="col-md-6">
                            <p><b>Oluşturma Tarihi : </b>{{ format_date($staff->created_date) }}</p>
                            <p><b>İşe Başlama Tarihi : </b> {{ format_date($staff->started_at) }} </p>
                            <p><b>Limitsiz mi? : </b>{{ $staff->is_ilimited ? 'Evet' : 'Hayır' }}</p>
                            @if (!$staff->is_ilimited)
                                <p><b>Bitiş Tarihi : </b>{{ format_date($staff->finished_at) }}</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12">
            <div class="card directory-card">
                <div class="p-2 card-header text-white bg-primary d-flex justify-content-between">
                    <h6 class="mt-1"> İletişim Bilgileri</h6>
                    <div>
                        <a class="btn btn-light btn-sm" href="{{ route('admin.staffs.edit', ['staff' => $staff->id]) }}">
                            <i class="fas fa-user-edit"></i>
                            Düzenle
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4">
                            <p><b>Telefon : </b>{{ $staff->phone }}</p>
                            <p><b>Adres : </b>{{ $staff->full_address }}</p>
                            <p class="text-capitalize"><b>Açık Adres : </b>{{ $staff->address }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        
        <div class="col-12">
            <div class="card directory-card">
                <div class="p-2 card-header text-white bg-warning d-flex justify-content-between">
                    <h6 class="mt-1">Şübe Bilgileri</h6>
                    <div>

                        <a class="btn btn-light btn-sm" href="{{ route('admin.user.create_branch', ['user_type'=>'staff', 'id' => $staff->id]) }}">
                            <i class="fas fa-edit"></i>
                            Düzenle
                        </a>
                    </div>
                </div>
                <div class="card-body">
                   <x-branch.user-branch :branchs="$staff->branchs" />
                </div>
            </div>
        </div>
    </div>

    <!-- end row -->

@endsection
