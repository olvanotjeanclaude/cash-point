@extends('layouts.app')

@section('title') {{ $staff->full_name }} - Şübe ekleme @endsection

@section('css')
    <link href="{{ asset('assets/libs/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css">
@endsection

@section('content')
    <!-- start page title -->
    @include('includes.page-title-box',[
    'pageTitle'=> $staff->full_name,
    "pageDescription"=>"Sistemde personelin şübeleri burada eklenir",
    ])
    <!-- end page title -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form method="post" class="needs-validation" novalidate
                        action="{{ route('admin.user.sync_to_branch', ['user_type' => 'staff', 'id' => $staff->id]) }}"
                        autocomplete="off" enctype="multipart/form-data">
                        @csrf

                        <div class="form-group mb-2">
                            <label class="mb-3" for="branch">Şübeler</label>
                                <select name="branch_id[]" class="select2 form-control" multiple="multiple"
                                    data-placeholder="Seç ..." required>
                                    <option value="">Seç</option>
                                    @foreach ($branchs as $branch)
                                        <option value="{{ $branch->id }}" @if(in_array($branch->id,$selectedBranchs)) selected @endif >{{ $branch->name }}</option>
                                    @endforeach
                                </select>
                                <div class="invalid-feedback">
                                    Lütfen şübeleri seçin
                                </div>
                        </div>


                        <div class="mb-2 form-group d-flex justify-content-end">
                            <button type="submit" class="btn btn-primary">
                                <i class="mdi mdi-plus mr-2"></i>
                                Ekle
                            </button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
        <!-- end col -->
    </div>
    <!-- end row -->

@endsection


@section('script')
    <script src="{{ asset('assets/libs/select2/js/select2.min.js') }}"></script>
@endsection
