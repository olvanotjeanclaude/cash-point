@extends('layouts.app')

@section('title')
    Yeni Sözleşme
@endsection

@section('content')
    <!-- start page title -->
    @include('includes.page-title-box', [
        'pageTitle' => 'Sözleşme Yönetimi',
        'pageDescription' => 'Sistemde yeni eklemek için yapılır',
    ])
    <!-- end page title -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form method="post" class="needs-validation" novalidate action="{{ route('admin.contracts.store') }}"
                        autocomplete="off" enctype="multipart/form-data">
                        @csrf
                        <section>
                            <div class="row">
                                <div class="col-sm-8">
                                    <div class="form-group mb-3">
                                        <label class="mb-2" for="title">Başlık</label>
                                        <input type="text" class="form-control" id="title" value="{{ old('title') }}"
                                            placeholder="Başlık" name="title" required>
                                        <div class="invalid-feedback">
                                            Lütfen geçerli bir isim giriniz.
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group mb-3">
                                        <label class="mb-2" for="project_id">Proje</label>
                                        <select type="text" class="form-control" id="project_id"
                                            value="{{ old('project_id') }}" name="project_id" required>
                                            <option value="">Seçiniz</option>
                                            @foreach ($projects as $project)
                                                <option value="{{ $project->id }}">{{ $project->name }}</option>
                                            @endforeach
                                        </select>
                                        <div class="invalid-feedback">
                                            Lütfen geçerli bir isim giriniz.
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group mb-3">
                                <label class="mb-2" for="body">Metin</label>
                                <textarea type="text" class="form-control" id="body" placeholder="Başlık" name="body"
                                    required>{{ old('body') }}</textarea>
                                <div class="invalid-feedback">
                                    Lütfen geçerli bir isim giriniz.
                                </div>
                            </div>
                        </section>

                        <div class="form-group d-flex justify-content-end">
                            <button type="submit" class="btn btn-primary">
                                <i class="mdi mdi-plus mr-2"></i>
                                Ekle
                            </button>
                        </div>
                    </form>

                </div>
            </div>
        </div>


    </div>
    <!-- end row -->
@endsection

@section('script')
    <script src="https://cdn.tiny.cloud/1/9u3v7hits4bsnde0wfll95hrlmguq1ai0dj4st4ufa8syejj/tinymce/5/tinymce.min.js"
        referrerpolicy="origin"></script>
    <script>
        load_tinymce("textarea");

        // tinymce.init({
        //     selector: 'textarea',
        //     plugins: 'advlist autolink lists link image charmap print preview hr anchor pagebreak',
        //     toolbar_mode: 'floating',
        // });
    </script>
@endsection
