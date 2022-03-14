<div class="modal fade" id="editContactModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <form class="modal-dialog needs-validation" enctype="multipart/form-data" novalidate method="POST"
        action="{{ route('admin.customer.update_customer_info', ['customer_id' => $customer->id]) }}">
        @csrf
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">İletişim Bilgileri Düzenleniyor</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="social-media">
                    <h4 class="mb-3 text-info">Sosyal Medya Bilgileri</h4>
                    <div class="row">
                        <div class="form-group">
                            <div class="mb-3">
                                <label for="facebook" class="form-label">Facebook Profil Linki</label>
                                <input class="form-control" type="url" name="facebook" id="facebook" value="{{$customer->facebook}}" required>
                                <div class="invalid-feedback">
                                    Lütfen geçerli linki giriniz.
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="mb-3">
                                <label for="instagram" class="form-label">Instagram Profil Linki</label>
                                <input class="form-control" type="url" name="instagram" id="instagram"  value="{{$customer->instagram}}" required>
                                <div class="invalid-feedback">
                                    Lütfen geçerli linki giriniz.
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="mb-3">
                                <label for="twitter" class="form-label">Twitter Profil Linki</label>
                                <input class="form-control" type="url" name="twitter" id="twitter"  value="{{$customer->twitter}}" required>
                                <div class="invalid-feedback">
                                    Lütfen geçerli linki giriniz.
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="mb-3">
                                <label for="phone" class="form-label">Telefon</label>
                                <input class="form-control" type="tel" name="phone" id="phone"  value="{{$customer->phone}}" required>
                                <div class="invalid-feedback">
                                    Lütfen geçerli telefon giriniz.
                                </div>
                            </div>
                        </div>
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
