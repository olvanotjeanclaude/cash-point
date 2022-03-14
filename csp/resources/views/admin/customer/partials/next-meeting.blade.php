<div class="col-12">
    <div class="card directory-card">
        <div class="p-3 bg-transparent card-header d-flex justify-content-between">
            <h6 class="mt-1 text-uppercase">YAKLAŞAN GÖRÜŞMELER</h6>
            <div>
                <a class="btn btn-primary"
                    href="{{ route('admin.meetings.create', ['customer_id' => $customer->id]) }}">
                    <i class="fas fa-plus"></i>
                    Ekle
                </a>

            </div>
        </div>

        <div class="card-body">
            @if(count($nextMeetings)>0)
            <div class="row">
                <div class="col-12">
                    <div class="card mini-stat  text-white">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="datatable-buttons"
                                    class="list-container table-sm table table-striped table-bordered dt-responsive nowrap"
                                    style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                    <thead>
                                        <tr>
                                            @userPermission("2")
                                            <th>Kim Eklemiş</th>
                                            @enduserPermission
                                            <th>Tarihi</th>
                                            <th>Saat</th>
                                            <th>Not</th>
                                            <th class="text-center">Aksyon</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        @foreach ($nextMeetings as $meeting)
                                            <tr id="row_{{ $meeting->id }}">
                                                @userPermission("2")
                                                <td>{{ $meeting->user->full_name }}</td>
                                                @enduserPermission
                                                <td>
                                                    {{ $meeting->date }}
                                                </td>
                                                <td>{{ $meeting->time }}</td>
                                                <td class=""> {{Str::limit($meeting->description,20)}} </td>

                                                <td class="d-flex justify-content-center">
                                                    <a href="{{ route('admin.meetings.edit', ['meeting' => $meeting->id]) }}"
                                                        class="btn mx-2 btn-sm btn-success">
                                                        <i class="fas fa-edit mr-2"></i>
                                                        Düzenle
                                                    </a>
                                                    <button data-id="{{ $meeting->id }}"
                                                        data-url="{{ route('admin.meetings.destroy', ['meeting' => $meeting->id]) }}"
                                                        class="btn mx-2 btn-sm btn-danger remove-btn">
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
            @else
                <p class="text-danger">Herhangi bir yaklaşan görüşme bulunmamaktadır.</p>
            @endif
        </div>
    </div>
</div>
