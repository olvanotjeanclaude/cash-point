@extends('layouts.app')

@section('title') {{ $customer->full_name }} | Teklifler @endsection


@section('content')
    <!-- start page title -->
    <div class="page-title-box">
        <div class="row align-items-center">
            <div class="col-md-8">
                <h6 class="page-title">Teklifler</h6>
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item active">Sistemde <b>{{ $customer->full_name }}</b> için
                        {{ format_date($meeting->date) }} saat {{ $meeting->time }}'da yapılan görüşmeler tüm teklifler
                        listeleniyor
                    </li>
                </ol>
            </div>


            <div class="col-md-4">
                <div class="float-end d-none d-md-block">
                    <a href="{{ route('admin.customer.offer.create', ['customer_id' => $customer->id, 'meeting_id' => $meeting->id]) }}"
                        class="btn btn-info">
                        <i class="{{ $icon ?? 'fas fa-plus-circle' }}"></i>
                        Yeni Teklif
                    </a>
                </div>
            </div>

        </div>
    </div>

    <!-- end page title -->

    <div class="row">
        @if (count($offers) > 0)
            @foreach ($offers as $offer)

                <div class="col-sm-6 col-md-4 col-lg-3" id="row_{{ $offer->id }}">
                    <div class="card border-1">
                        <div class="card-body ">
                            <div class="card-title-desc d-flex align-items-center justify-content-between">
                                <h6 class="">
                                    <span>{{ format_date($meeting->date) }}</span>
                                    <span class="mx-2">{{ $meeting->time }}</span>
                                </h6>
                                <div class="d-flex">
                                    <a href="javascript:void(0)" class="show-item-btn mx-1 font-size-18 text-success"
                                        data-result="#getEditMeetingResult" data-target="#editMeetingModal"
                                        data-url="{{ route('admin.customer.offer.show', ['customer_id' => $customer->id,'meeting_id'=>$meeting->id, 'offer_id' => $offer->id]) }}">
                                        <i class="fa fa-eye"></i>
                                    </a>
                                    <a href="javascript:void(0)" data-id="{{ $offer->id }}"
                                        data-url="{{ route('admin.customer.offer.delete', ['customer_id' => $customer->id,'meeting_id'=>$meeting->id, 'offer_id' => $offer->id]) }}"
                                        class="delete-item-btn mx-1 font-size-18 text-danger">
                                        <i class="fa fa-trash"></i>
                                    </a>
                                </div>
                            </div>

                            <div>

                            </div>
                            <p class="card-text note-card">{{ Str::limit($offer->content, 130, '...') }}</p>

                        </div>

                        <div class="card-footer bg-transparent">
                            <div class="text-muted blockquote-footer">{{ $offer->user->full_name }}</div>
                        </div>
                    </div>
                </div>
            @endforeach
        @else
            <div class="card">
                <div class="card-body">
                    <div class="text-danger">
                        Herhangi bir teklif yok!
                    </div>
                </div>
            </div>
        @endif
    </div>
    <!-- end row -->

    {{-- Display modal single offer --}}
    <div id="getEditMeetingResult"></div>


@endsection
