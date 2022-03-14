@extends('layouts.app')

@section('title') Profilim @endsection

@section('content')

    <div class="card">
        <div class="mt-2 card-header bg-transparent d-flex justify-content-end">
            <a href="{{ route('admin.profile.edit') }}" class="btn btn-sm btn-success">
                <i class="fa fa-edit"></i>
                Güncelle
            </a>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-4 col-lg-3">
                    <div class="profile-image">
                        <img class="img img-fluid" src="{{ get_image($user->image) }}" alt="Profile Image">
                    </div>
                    <p class="text-center mt-3">
                        @switch($user->permission)
                            @case(1)
                                <label class="badge bg-light">Admin </label>
                            @break
                            @case(2)
                                <label class="badge bg-primary">Yönetici</label>
                            @break
                            @case(3)
                                <label class="badge bg-warning">Personel</label>
                            @break
                            @case(4)
                                <label class="badge bg-info">Müsteri</label>
                            @break
                            @default
                                <label class="badge bg-light">Belirlenmemiş</label>
                        @endswitch
                    </p>
                    <div class="mt-2">
                        <h6>İŞ</h6>
                        <p class="text-muted">{{ $user->work ?? 'Girilmemiş' }}</p>
                    </div>
                    <hr>
                    <div class="mt-2">
                        <h6>Oluşturma Tarihi</h6>
                        <p class="text-muted">
                            @format_date($user->created_at)
                        </p>
                    </div>

                    @if ($user->permission == 3 && !$user->is_ilimited)
                        <div class="mt-2">
                            <h6>Başlangıç Tarihi</h6>
                            <p class="text-muted">
                                {{ format_date($user->started_at) }} - {{ format_date($user->finished_at) }}
                            </p>
                        </div>
                    @endif
                </div>

                <div class="col-md-8 col-lg-9">
                    <section>
                        <h4 class="text-capitalize">
                            {{ $user->full_name }}
                            <span class="ml-2 font-size-12">
                                <i class="fas fa-map-marker-alt"></i>
                                {{ $user->get_district->district_name }}, {{ $user->get_province->province_name }}
                            </span>
                        </h4>
                        <p class="text-muted small">
                            {{ $user->description }}
                        </p>
                    </section>

                    <hr>

                    <section>
                        <div class="row my-2">
                            <h6 class="text-muted">İLETİŞİM BİLGİLERİ</h6>
                        </div>
                        <div class="row">
                            <div class="col-4">
                                <h6>Telefon : </h6>
                            </div>
                            <div class="col-8">
                                <p>
                                    <a href="{{ $user->phone }}">{{ $user->phone }}</a>
                                </p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-4">
                                <h6>Adres : </h6>
                            </div>
                            <div class="col-8">
                                <p>{{ $user->full_address }}</p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-4">
                                <h6>E-posta : </h6>
                            </div>
                            <div class="col-8">
                                <p>{{ $user->email }}</p>
                            </div>
                        </div>
                    </section>

                    <hr>

                    <section>
                        <div class="row my-2">
                            <h6 class="text-muted">TEMEL BİLGİLERİ</h6>
                        </div>
                        <div class="row">
                            <div class="col-4">
                                <h6>Doğum Tarihi : </h6>
                            </div>
                            <div class="col-8">
                                <p>{{ format_date($user->birth_date) }}</p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-4">
                                <h6>cinsyet : </h6>
                            </div>
                            <div class="col-8">
                                <P>
                                    @switch($user->gender)
                                        @case(1)
                                            Erkek
                                        @break
                                        @case(2)
                                            Kadın
                                        @break
                                        @default
                                            Belirlenmemiş
                                    @endswitch
                                    </h6>
                            </div>
                        </div>
                    </section>

                    <hr>

                    @if ($user->facebook || $user->instagram || $user->twitter)
                        <section>
                            <div class="row my-2">
                                <h6 class="text-muted">SOSYAL MEDYA</h6>
                            </div>
                            @if ($user->facebook)
                                <div class="row">
                                    <div class="col-4">
                                        <h6>Facebook : </h6>
                                    </div>
                                    <div class="col-8">
                                        <a href="{{ $user->facebook }}">Tıklayın</a>
                                    </div>
                                </div>
                            @endif
                            @if ($user->instagram)
                                <div class="row">
                                    <div class="col-4">
                                        <h6>Instagram : </h6>
                                    </div>
                                    <div class="col-8">
                                        <a href="{{ $user->instagram }}">Tıklayın</a>
                                    </div>
                                </div>
                            @endif
                            @if ($user->twitter)
                                <div class="row">
                                    <div class="col-4">
                                        <h6>Twitter : </h6>
                                    </div>
                                    <div class="col-8">
                                        <a href="{{ $user->twitter }}">Tıklayın</a>
                                    </div>
                                </div>
                            @endif
                        </section>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
