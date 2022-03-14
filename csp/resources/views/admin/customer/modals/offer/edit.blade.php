<div class="modal fade" id="editMeetingModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <form class="modal-dialog needs-validation" novalidate method="POST"
        action="{{ route('admin.customer.offer.update', ['customer_id' => $customer->id, 'meeting_id' => $offer->meeting_id,'offer_id'=>$offer->id]) }}">
        @csrf
        @method("put")
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Teklif Düzenleme <span
                        class="text-capitalize">[{{ $customer->full_name }}]</span>
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="content" class="mb-2">İçerik</label>
                    <textarea class="form-control" placeholder="Notlar giriniz..." name="content" id="content"
                        cols="30" rows="10" required>{{ $offer->content }}</textarea>
                    <div class="invalid-feedback">
                        Boş girilmez !
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
