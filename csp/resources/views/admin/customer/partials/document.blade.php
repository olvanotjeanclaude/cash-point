<div class="col-12">
    <div class="card directory-card">
        <div class="p-3 bg-transparent card-header d-flex justify-content-between">
            <h6 class="mt-1 text-uppercase">Dokümanlar</h6>
            <div>
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addDocModal">
                    <i class="fas fa-plus"></i>
                    Ekle
                </button>

            </div>
        </div>
        <div class="card-body">
            <div class="row">

                @if (count($customerDocuments) > 0)
                    @foreach ($customerDocuments as $document)
                        <div class="col-sm-6 col-md-4 col-lg-3" id="row_{{ $document->id }}">
                            <div class="card border-1">
                                <div class="card-body">
                                    <div class="card-title-desc d-flex justify-content-between">
                                        <h6>
                                            @switch($document->type)
                                                @case(1)
                                                    Kimlik
                                                @break
                                                @case(2)
                                                    Sözleşme
                                                @break
                                                @case(3)
                                                    Diğer
                                                @break
                                                @default
                                                    Belirlenmemiş
                                            @endswitch
                                        </h6>
                                        <div class="d-flex">
                                            <a class="mx-1 font-size-18"
                                                href="{{ route('admin.customer.documents.download', ['customer_id' => $customer->id, 'doc_id' => $document->id]) }}">
                                                <i class="fa fa-download"></i>
                                            </a>
                                            <a href="javascript:void(0)"
                                                class="show-item-btn mx-1 font-size-18 text-success"
                                                data-result="#getEditDocumentResult" data-target="#editDocModal"
                                                data-url="{{ route('admin.customer.documents.show', ['customer_id' => $customer->id, 'doc_id' => $document->id]) }}">
                                                <i class="fa fa-edit"></i>
                                            </a>
                                            <a href="javascript:void(0)" data-id="{{ $document->id }}"
                                                data-url="{{ route('admin.customer.documents.delete', ['customer_id' => $customer->id, 'doc_id' => $document->id]) }}"
                                                class="delete-item-btn mx-1 font-size-18 text-danger">
                                                <i class="fa fa-trash"></i>
                                            </a>
                                        </div>
                                    </div>

                                    <p class="card-text document-card">
                                        {{ $document->docTitle }}
                                    </p>

                                    <p>
                                        <a class="image-popup-vertical-fit"
                                            href="{{ get_image($document->docFileUrl) }}"
                                            title="{{ $document->docTitle }}">
                                            <img class="avatar-lg" alt="{{ $document->docTitle }}"
                                                src="{{ get_image($document->docFileUrl) }}">
                                        </a>

                                    </p>

                                    <p>
                                        @format_date($document->created_at) tarihinde eklendi.
                                    </p>
                                </div>
                                @userPermission("2")
                                    <div class="card-footer bg-transparent">
                                        <div class="text-muted text-capitalize blockquote-footer">
                                            {{ $document->user->full_name }}</div>
                                    </div>
                                @enduserPermission
                            </div>
                        </div>

                    @endforeach
                @else
                    <p class="text-danger">Doküman bulunmamaktadır</p>
                @endif

            </div>
        </div>
    </div>
</div>
<div id="getEditDocumentResult"></div>
