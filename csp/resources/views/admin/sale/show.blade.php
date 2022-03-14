@extends('layouts.app')

@section('title')
    {{ $apartment->floor->block->project->name }} için satış
@endsection

@section('content')
    <!-- start page title -->
    @include('includes.page-title-box', [
        'pageTitle' => 'Müsterin Bilgileri',
        'pageDescription' => 'Sistemde Müsterin bilgileri burada görüntülenebilir',
    ])
    <!-- end page title -->
    <div class="row">
        <div class="col-12">
            <div class="form-group">
                @if (session('errorType'))
                    <x-alert type="danger" :message="session('errorType')" />
                @endif
                @if (session('errorTitle'))
                    <x-alert type="danger" :message="session('errorTitle')" />
                @endif
                @if (session('errorNote'))
                    <x-alert type="danger" :message="session('errorNote')" />
                @endif
            </div>
        </div>
    </div>


    <div class="col-xxl-10 mx-auto">
        <div class="row mb-4">
            <div class="col-12">
                <h3 class="mb-3">{{ $apartment->floor->block->project->name }}</h3>
            </div>

            <div class="col-md-9">
                <div class="card mb-3" style="">
                    <div class="row g-0">
                        <div class="col-md-3">
                            <img src="{{ get_image($apartment->floor->block->project->photo) }}"
                                class="img-fluid rounded-start" alt="Project image">
                        </div>
                        <div class="col-md-3">
                            <div class="card-body">
                                <div class="d-flex">
                                    <h5 class="card-title">Proje : </h5>
                                    <p class="ms-2 card-text">{{ $apartment->floor->block->project->name }}</p>
                                </div>
                                <div class="d-flex">
                                    <h5 class="card-title">Blok : </h5>
                                    <p class="ms-2 card-text">{{ $apartment->floor->block->name }}</p>
                                </div>
                                <div class="d-flex">
                                    <h5 class="card-title">Kat : </h5>
                                    <p class="ms-2 card-text">{{ $apartment->floor->number . '. Kat' ?? '-' }}</p>
                                </div>
                                <div class="d-flex">
                                    <h5 class="card-title">Daire : </h5>
                                    <p class="ms-2 card-text">{{ $apartment->name }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md">
                            <div class="card-body">
                                <div class="d-flex">
                                    <h4 class="card-title">Müsteri : </h4>
                                    <p class="ms-2 card-text">{{ $sale->customer->full_name }}</p>
                                </div>
                                <div class="d-flex">
                                    <h4 class="card-title">Müsterinin dürümü : </h4>
                                    <p class="ms-2 card-text">
                                        {!! getBadgeStatus('Customer', $customer->status) !!}
                                        <a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#editStatus"
                                            class="ms-2">düzenle</a>
                                    </p>
                                </div>
                                @if ($customer->status == '0')
                                    <div class="d-flex">
                                        <h4 class="card-title">Ayrılma sebebi : </h4>
                                        <p class="ms-2 card-text">{{ $customer->motif->body }}</p>
                                    </div>
                                @endif

                                <div class="d-flex">
                                    <h4 class="card-title">Ekleyen kullanıcı : </h4>
                                    <p class="ms-2 card-text">{{ $sale->user->full_name }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card">
                    <div class="card-body bg-primary">
                        <h3 class="text-white">Fiyat</h3>
                        <h4 class="text-white rounded">{{ number_format((float) $sale->price, 2, ',', '.') }}
                            TL
                        </h4>
                        <a href="#" class="btn mt-2 btn-light float-end">
                            <i class="fas fa-edit mr-2"></i>
                            Düzenle
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('admin.customer.modals.general-info.edit-status')
@endsection

@section('script')
    <script src="{{ asset('js/customer.js') }}"></script>
@endsection
