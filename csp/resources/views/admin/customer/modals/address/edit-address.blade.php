<div class="modal fade" id="editAddressModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
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
                    <h4 class="mb-3 text-info">Adres Bilgileri</h4>
                  
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group mb-3">
                                <label class="mb-2" for="province">İl</label>
                                <select name="province" id="province" class="form-control" required>
                                    <option value="" selected disabled>İl seçiniz</option>
                                    @foreach ($provinces as $key => $value)
                                        <option @if ($value->province_key == $customer->province) selected @endif value="{{ $value->province_key }}">
                                            {{ $value->province_name }}</option>
                                    @endforeach
                                </select>
                                <div class="invalid-feedback">
                                    Lütfen il seçiniz.
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group mb-3">
                                <label class="mb-2" for="district">İlçe</label>
                                <select name="district" class="form-control" id="district" required>
                                    <option value="" @if (!$customer->district) selected @endif disabled>Seç</option>
                                    @if ($customer->district)
                                        <option value="{{ $customer->district }}" selected>
                                            {{ $customer->get_district->district_name }}</option>
                                    @endif
                                </select>
                                <div class="invalid-feedback">
                                    Lütfen İlçe seçiniz.
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group mb-3">
                                <label class="mb-2" for="neighborhood">Mahalle</label>
                                <select name="neighborhood" class="form-control" id="neighborhood" required>
                                    <option value="" @if (!$customer->neighborhood) selected @endif disabled>Seç</option>
                                    @if ($customer->neighborhood)
                                        <option value="{{ $customer->neighborhood }}" selected>
                                            {{ $customer->get_neighborhood->neighborhood_name }}</option>
                                    @endif
                                </select>
                                <div class="invalid-feedback">
                                    Lütfen Mahalle seçiniz.
                                </div>
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="form-group mb-3">
                                <label class="mb-2" for="address">Adres</label>
                                <textarea class="form-control" name="address" id=""
                                    rows="3">{{ $customer->address }}</textarea>
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
