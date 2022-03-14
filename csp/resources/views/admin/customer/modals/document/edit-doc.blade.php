<div class="modal fade" id="editDocModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <form class="modal-dialog needs-validation" enctype="multipart/form-data" novalidate method="POST"
        action="{{ route('admin.customer.documents.update', ['customer_id' => $customer_id, 'doc_id' => $customerDocument->id]) }}">
        @csrf
        @method("put")
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Doküman Düzenleme</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="form-group mt-3">
                    <label for="type" class="mb-2">Tür</label>
                    <select class="form-control" name="type" id="type" required>
                        <option value="">Seç</option>
                        <option value="1" @if ($customerDocument->type == 1) selected @endif>Kimlik</option>
                        <option value="2" @if ($customerDocument->type == 2) selected @endif>Sözleşme</option>
                        <option value="3" @if ($customerDocument->type == 3) selected @endif>Diğer</option>
                    </select>
                    <div class="invalid-feedback">
                        Boş girilmez !
                    </div>
                </div>
                <div class="form-group mt-3">
                    <label for="title" class="mb-2">Başlık</label>
                    <input class="form-control" type="text" name="title" id="title"
                        value="{{ $customerDocument->docTitle }}" placeholder="Başlık giriniz..." required />
                    <div class="invalid-feedback">
                        Boş girilmez !
                    </div>
                </div>


                <div class="form-group mt-3">
                    <label for="documentFile" class="mb-2">Dosya</label>
                    <input type="file" class="form-control" name="documentFile" id="documentFile" required />
                    <div class="invalid-feedback">
                        Lütfen dosya girin !
                    </div>
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Kapat</button>
                <button type="submit" class="btn btn-success">
                    <i class="fas fa-save mr-2"></i>
                    Düzenle
                </button>
            </div>
        </div>
        <!-- /.modal-content -->
    </form>
    <!-- /.modal-dialog -->
</div>
