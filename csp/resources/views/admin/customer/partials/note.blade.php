<div class="col-12">
    <div class="card directory-card">
        <div class="p-3 bg-transparent card-header d-flex justify-content-between">
            <h6 class="mt-1 text-uppercase">Notlar</h6>
            <div>
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addNotModal">
                    <i class="fas fa-plus"></i>
                    Ekle
                </button>

            </div>
        </div>
        <div class="card-body">
            <div class="row">
                @if (count($customerNotes) > 0)
                    @foreach ($customerNotes as $note)
                        <div class="col-sm-6 col-md-4 col-lg-3" id="row_{{ $note->id }}">
                            <div class="card  border-1">
                                <div class="card-body">
                                    <div class="card-title-desc d-flex justify-content-between">
                                        <h6>
                                            @format_date($note->created_at)
                                        </h6>
                                        <div class="d-flex">
                                            <a href="javascript:void(0)"
                                                class="show-item-btn mx-1 font-size-18 text-success"
                                                data-result="#getEditNoteResult" data-target="#editNotModal"
                                                data-url="{{ route('admin.customer.notes.show', ['customer_id' => $customer->id, 'note_id' => $note->id]) }}">
                                                <i class="fa fa-eye"></i>
                                            </a>
                                            <a href="javascript:void(0)" data-id="{{ $note->id }}"
                                                data-url="{{ route('admin.customer.notes.delete', ['customer_id' => $customer->id, 'note_id' => $note->id]) }}"
                                                class="delete-item-btn mx-1 font-size-18 text-danger">
                                                <i class="fa fa-trash"></i>
                                            </a>
                                        </div>
                                    </div>

                                    <p class="card-text note-card">{{ Str::limit($note->content, 130, '...') }}</p>

                                </div>

                                @userPermission("2")
                                    <div class="card-footer bg-transparent">
                                        <div class="text-muted blockquote-footer">{{ $note->user->full_name }}</div>
                                    </div>
                                @enduserPermission
                            </div>
                        </div>

                    @endforeach
                @else
                    <p class="text-danger">Not bulunmamaktadır</p>
                @endif

            </div>
        </div>
    </div>
</div>
<div id="getEditNoteResult"></div>
