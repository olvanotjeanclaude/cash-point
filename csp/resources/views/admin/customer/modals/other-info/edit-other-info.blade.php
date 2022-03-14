<div class="modal fade" id="editOtherInfoModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <form class="modal-dialog needs-validation" enctype="multipart/form-data" novalidate method="POST"
        action="{{ route('admin.customer.update_customer_info', ['customer_id' => $customer->id, 'action' => 'other_info']) }}">
        @csrf
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Diğer Bilgileri Düzenleniyor</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="social-media">
                    <h4 class="mb-3 text-info">Diğer Bilgileri</h4>

                    <div class="other-info">
                        <div class="form-group mb-3">
                            <label class="mb-2" for="find_us_id">Bizi nereden buldu?</label>
                            <select name="find_us_id" class="form-control" id="find_us_id" required>
                                <option value="">Seç</option>
                                @forelse ($findUsData as $item)
                                    <option value="{{ $item->id }}"
                                        @if ($customer->other_info != null && $customer->other_info->find_us_id == $item->id) selected @endif>{{ $item->name }}</option>
                                @empty
                                @endforelse
                            </select>
                            <div class="invalid-feedback">
                                Bu alanı doldurunuz.
                            </div>
                        </div>

                        <div class="form-group mb-3">
                            <label class="mb-2" for="other_info_description">Kısa Açıklama</label>
                            <textarea id="other_info_description" class="form-control" rows="7"
                                placeholder="Kısa açıklama girebilirsiniz.."
                                name="other_info_description">{{ $customer->other_info->description ?? '' }}</textarea>
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
