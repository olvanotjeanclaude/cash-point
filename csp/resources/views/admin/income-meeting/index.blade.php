@extends('layouts.app')

@section('title') kayıtlı Görüşmeler @endsection

@section('css')
    <x-datatable-css-link />
@endsection

@section('content')
    <!-- start page title -->
    @include('includes.page-title-box',[
    'pageTitle'=>"Yapılan Görüşmeler",
    "pageDescription"=>"Sistemde kayıtlı tüm yapılacak Görüşmeler listeleniyor",
    "action"=>"Yeni",
    "icon" =>"fas fa-calendar-plus",
    "link" =>route("admin.meetings.create")
    ])
    <!-- end page title -->

    <div class="row">
        <div class="col-12">
            <div class="card mini-stat  text-white">
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="datatable-buttons"
                            class="list-container table table-striped table-bordered dt-responsive nowrap"
                            style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                            <thead>
                                <tr>
                                    <th>Müsteri</th>
                                    <th>Zaman</th>
                                    <th>Not</th>
                                    <th>Düzenle</th>
                                    <th>Sil</th>
                                </tr>
                            </thead>

                            <tbody>
                                @foreach ($incomeMeetings as $meeting)
                                    <tr id="row_{{ $meeting->id }}">
                                        <td>
                                            <a href="{{route('admin.customers.show',['customer'=>$meeting->customer_id])}}">
                                                {{ $meeting->customer->full_name }}
                                            </a>
                                        </td>
                                        <td>
                                            {{ date("d/m/Y H:i", strtotime($meeting->date_time)); }}
                                        </td>

                                        <td>{{ Str::limit($meeting->description, 60, '...') }}</td>
                                       
                                        <td class="text-center">
                                            <a href="{{ route('admin.meetings.edit', ['meeting' => $meeting->id]) }}"
                                                class="btn btn-sm btn-success">
                                                <i class="fas fa-edit mr-2"></i>
                                                Düzenle
                                            </a>
                                        </td>
                                        <td>
                                            <button data-id="{{ $meeting->id }}"
                                                data-url="{{ route('admin.meetings.destroy', ['meeting' => $meeting->id]) }}"
                                                class="btn btn-sm btn-danger remove-btn">
                                                <i class="fas fa-minus mr-2"></i>
                                                Sil
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- end row -->

@endsection

@section('script')
    <x-datatable-js-link />
    <script src="{{ asset('js/alert-meeting.js') }}"></script>
@endsection
