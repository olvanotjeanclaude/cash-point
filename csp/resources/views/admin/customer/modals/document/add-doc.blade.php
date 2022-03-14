<div class="modal fade" id="addDocModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <form enctype="multipart/form-data" class="modal-dialog needs-validation" novalidate method="POST"
        action="{{ route('admin.customer.documents.store', ['customer_id' => $customer->id]) }}">
        @csrf
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Doküman Ekleme <span
                        class="text-capitalize">[{{ $customer->full_name }}]</span>
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="form-group mt-3">
                    <label for="type"  class="mb-2">Tür</label>
                    <select class="form-control" name="type" id="type" required>
                        <option value="">Seç</option>
                        <option value="1">Kimlik</option>
                        <option value="2">Sözleşme</option>
                        <option value="3">Diğer</option>
                    </select>
                    <div class="invalid-feedback">
                        Boş girilmez !
                    </div>
                </div>
                <div class="form-group mt-3">
                    <label for="title" class="mb-2">Başlık</label>
                    <input class="form-control" type="text" name="title" id="title" placeholder="Başlık giriniz..."
                        required />
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
                    Ekle
                </button>
            </div>
        </div>
        <!-- /.modal-content -->
    </form>

</div>
