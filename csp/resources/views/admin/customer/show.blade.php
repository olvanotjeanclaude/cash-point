@extends('layouts.app')

@section('title')
    {{ $customer->full_name }}
@endsection

@section('css')
    <!-- Lightbox css -->
    <link href="{{ asset('assets/libs/magnific-popup/magnific-popup.css') }}" rel="stylesheet" type="text/css" />
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

    <section>
        @include('admin.customer.partials.general-info')
    </section>

    <section>
        <nav>
            <div class="nav nav-tabs" role="tablist">
                <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#nav-teklif-tab" type="button"
                    role="tab" aria-controls="nav-teklif-tab" aria-selected="true">
                    Teklifler
                </button>
                <button class="nav-link" data-bs-toggle="tab" data-bs-target="#nav-doc-tab" type="button" role="tab"
                    aria-controls="nav-doc-tab" aria-selected="false">
                    Dokuman
                </button>
                <button class="nav-link" data-bs-toggle="tab" data-bs-target="#nav-note-tab" type="button" role="tab"
                    aria-controls="nav-note-tab" aria-selected="false">
                    Not
                </button>
            </div>
        </nav>
        <div class="tab-content">
            {{-- Teklifler --}}
            <div class="tab-pane fade show active" id="nav-teklif-tab" role="tabpanel" aria-labelledby="teklif">
                @include('admin.customer.partials.bids')
            </div>
            {{-- Doküman --}}
            <div class="tab-pane fade" id="nav-doc-tab" role="tabpanel" aria-labelledby="nav-doc-tab">
                @include('admin.customer.partials.document')
            </div>
            {{-- Note --}}
            <div class="tab-pane fade" id="nav-note-tab" role="tabpanel" aria-labelledby="nav-note-tab">
                @include('admin.customer.partials.note')
            </div>
        </div>
    </section>
    <hr>
    <section>
        <div class="nav nav-tabs" role="tablist">
            <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#nav-meeting-tab" type="button" role="tab"
                aria-controls="nav-meeting-tab" aria-selected="true">
                Görüşmeler
            </button>
            <button class="nav-link" data-bs-toggle="tab" data-bs-target="#nav-nextMeeting-tab" type="button"
                role="tab" aria-controls="nav-nextMeeting-tab" aria-selected="false">
                Yaklaşan Görüşmeler
            </button>
        </div>

        <div class="tab-content" id="nav-tabContent">
            {{-- Görüşme Bilgileri --}}
            <div class="tab-pane fade show active" id="nav-meeting-tab" role="tabpanel" aria-labelledby="meeting">
                @include('admin.customer.partials.meeting', [
                    'meetings' => $customerMeetings,
                ])
            </div>

            {{-- Yaklaşan görüşmeler --}}
            <div class="tab-pane fade" id="nav-nextMeeting-tab" role="tabpanel" aria-labelledby="nav-nextMeeting-tab">
                @include('admin.customer.partials.next-meeting')
            </div>
        </div>
    </section>

    @include(
        'admin.customer.modals.general-info.edit-general-info'
    )
    @include('admin.customer.modals.general-info.edit-status')
    @include('admin.customer.modals.contact.edit-contact')
    @include('admin.customer.modals.projects.edit-project')
    @include('admin.customer.modals.address.edit-address')
    @include('admin.customer.modals.other-info.edit-other-info')


    {{-- Doküman --}}
    @include('admin.customer.modals.document.add-doc')
    {{-- Note --}}
    @include('admin.customer.modals.note.add-note')
@endsection

@section('script')
    <!-- Magnific Popup-->
    <script src="{{ asset('assets/libs/magnific-popup/jquery.magnific-popup.min.js') }}"></script>

    <!-- Tour init js-->
    <script src="{{ asset('assets/js/pages/lightbox.init.js') }}"></script>

    <script src="{{asset('js/customer.js')}}"></script>
@endsection
