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
                                <th>Merkez mi?</th>
                                <th>İl</th>
                                <th>Adı</th>
                                <th>E-posta</th>
                                <th>Telefon</th>
                                <th>Oluşturma Tarihi</th>
                                @can('view', 'App\Models\Branch')
                                    <th>Düzenle</th>
                                    <th>Sil</th>
                                @endcan
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($branchs as $branch)
                                <tr id="row_{{ $branch->id }}">
                                    @if ($branch->type == 1)
                                        <td> <label class="badge bg-success">Evet</label></td>
                                    @else
                                        <td> <label class="badge bg-warning">Hayır</label></td>
                                    @endif
                                    <td>{{ $branch->get_province->province_name }}</td>
                                    <td>{{ $branch->name }}</td>
                                    <td>{{ $branch->email }}</td>
                                    <td>{{ $branch->phone }}</td>
                                    <td>
                                        @format_date($branch->created_at)
                                    </td>
                                    @can('view', 'App\Models\Branch')
                                        <td class="text-center">
                                            <a href="{{ route('admin.branchs.edit', ['branch' => $branch->id]) }}"
                                                class="btn btn-sm btn-success">
                                                <i class="fas fa-edit mr-2"></i>
                                                Düzenle
                                            </a>
                                        </td>
                                        <td>
                                            <button data-id="{{ $branch->id }}"
                                                data-url="{{ route('admin.branchs.destroy', ['branch' => $branch->id]) }}"
                                                class="btn btn-sm btn-danger remove-btn">
                                                <i class="fas fa-minus mr-2"></i>
                                                Sil
                                            </button>
                                        </td>
                                    @endcan
                                </tr>
                            @endforeach

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
