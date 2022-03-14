@extends('layouts.app')

@section('css')
    <link href="{{ asset('assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css') }}" rel="stylesheet"
        type="text/css">
    <link href="{{ asset('assets/libs/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css') }}" rel="stylesheet"
        type="text/css">
    <link rel="stylesheet" href="{{ asset('assets/libs/popover/jquery.webui-popover.min.css') }}">
@endsection

@section('title')
   Pasif Alma Sebepler
@endsection

@section('content')
    <!-- start page title -->
    @include('includes.page-title-box', [
        'pageTitle' => 'Pasif Alma Sebepler',
        'pageDescription' => 'Listeleniyor',
        'target' => 'motif',
    ])
    <!-- end page title -->

    <div class="row">
        <div class="col-12">
            <div class="card mini-stat  text-white">
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="datatable-buttons"
                            class="list-container table table-sm table-striped table-bordered dt-responsive nowrap"
                            style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                            <thead>
                                <tr>
                                    <th>Sebepler</th>
                                    <th>Oluşturma Tarihi</th>
                                    <th>Ekeyen Kullanıcı</th>
                                    <th>Aksyon</th>
                                </tr>
                            </thead>

                            <tbody>
                                @foreach ($motifs as $data)
                                    <tr id="row_{{ $data->id }}">
                                        <td class="align-middle">
                                            <a class="motif" id="motif_{{ $data->id }}"
                                                data-id="{{ $data->id }}"
                                                href="javascript:void(0)">{{ Str::limit($data->body, 70) }}
                                            </a>
                                        </td>
                                        <td class="align-middle">
                                            @format_date($data->created_at)
                                        </td>
                                        <td>{{ $data->user->full_name }}</td>
                                        <td class="align-middle">
                                            <a data-url="{{ route('admin.motifs.edit', $data->id) }}" href="javascript:void(0)"
                                                class="btn btn-sm editMotif btn-success">
                                                <i class="fas fa-edit mr-2"></i>
                                                Düzenle
                                            </a>
                                            <button data-id="{{ $data->id }}"
                                                data-url="{{ route('admin.motifs.destroy', $data->id) }}"
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
        <!-- end col -->
    </div>

    <!-- Modal -->
    <div class="editModalContainer">
    </div>
    <div class="modal fade" id="motif" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="motifLabel" aria-hidden="true">
        <form class="modal-dialog needs-validation" novalidate method="POST" action="{{ route('admin.motifs.store') }}">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="motifLabel">Yeni Sebep
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="body" class="mb-2">Metin</label>
                        <textarea class="form-control" placeholder="Metni giriniz..." name="body" id="body" cols="30"
                            rows="10" required></textarea>
                        <div class="invalid-feedback">
                            Boş girilmez !
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Kapat</button>
                    <button type="submit" class="btn btn-success">
                        <i class="fas fa-save mr-2"></i>
                        Ekle
                    </button>
                </div>
            </div>
            <!-- /.modal-content -->
        </form>
    </div>
@endsection

@section('script')
    <x-datatable-js-link />
    <script src="{{ asset('assets/libs/popover/jquery.webui-popover.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            $(".motif").on("click", function() {
                const motif_id = $(this).data("id");
                axios.get(`/admin/motifs/${motif_id}`).then(function(response) {
                        WebuiPopovers.show(`#motif_${motif_id}`, {
                            content: response.data.body,
                            width: 400,
                            title: "Motif",
                        })
                    })
                    .catch(function(error) {
                        console.log(error);
                    })
            });

            $(".editMotif").on("click", function() {
                const url = $(this).data("url");
                axios.get(url)
                    .then(function(response) {
                        $(".editModalContainer").html(response.data);
                        $(".motif-edit-modal").modal("show");
                    })
                    .catch(function(error) {
                        console.log(error);
                    })
            });
        })
    </script>
@endsection
