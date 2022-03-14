  <!-- Modal -->
  <div class="modal fade" id="editStatus" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
      aria-labelledby="editStatusLabel" aria-hidden="true">
      <form class="modal-dialog needs-validation" enctype="multipart/form-data" novalidate method="POST"
          action="{{ route('admin.customer.updateStatus', $customer->id) }}">
          @csrf
          @method("put")
          <div class="modal-content modal-lg">
              <div class="modal-header">
                  <h5 class="modal-title" id="editStatusLabel">Müsterinin dürümü Düzenleniyor</h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body">
                  <div class="form-group mb-3">
                      <div class="mb-3">
                          <label class="mb-2" for="durum">Dürüm</label>
                          <select name="status" class="form-control" id="customerStatus" required>
                              <option value="">Seç</option>
                              @foreach (\App\Models\Customer::STATUS as $index => $status)
                                  <option value="{{ $index }}" @if ($customer->status == $index) selected @endif>
                                      {{ $status }}
                                  </option>
                              @endforeach
                          </select>
                          <div class="invalid-feedback">
                              Dürümü seçiniz lütfen
                          </div>
                      </div>
                  </div>


                  <div class="form-group mb-3">
                      <div class="mb-3">
                          <label class="mb-2" for="durum">Sebep</label>
                          <select name="motif" class="form-control motifs" id="durum"
                              @if ($customer->status == 1) disabled @endif required>
                              <option value="">Seç</option>
                              @foreach (\App\Models\Motif::all() as $motif)
                                  <option value="{{ $motif->id }}">{{ $motif->body }}</option>
                              @endforeach
                              <option value="other">Diğer</option>
                          </select>
                          <div class="invalid-feedback">
                              Sebebi seçiniz lütfen
                          </div>
                      </div>
                  </div>

                  <div class="form-group d-none mb-3" id="otherMotif">
                      <div class="mb-3">
                          <label class="mb-2" for="durum">Diğer Sebep</label>
                          <textarea id="body" class="form-control" placeholder="Sebep giriniz.."
                              name="body"></textarea>
                          <div class="invalid-feedback">
                              Sebebi giriniz lütfen
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
  </div>
