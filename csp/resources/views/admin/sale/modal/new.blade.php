<div class="modal fade" id="newSale" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <form class="modal-dialog needs-validation" enctype="multipart/form-data" novalidate method="POST"
        action="">
        @csrf
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">İlgilendiği proje bilgileri düzenleniyor</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="social-media">
                    <h4 class="mb-3 text-info">Projeler</h4>
                    @php
                    use App\Models\Project;
                    $projects = Project::get()->all();
                    @endphp
                    <div class="other-info">
                      <div class="form-group mb-2">
                          <label class="mb-3" for="branch">İlgilendiği Projeler</label>
                          <div class="col-6" style="margin-bottom: 15px;">
                              <div class="form-check">
                                  <input class="form-check-input" value="1" type="checkbox" name="projects[]" id="1">
                                  <label class="form-check-label" for="1">
                                    Genel
                                  </label>
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
                    Ekle
                </button>
            </div>
        </div>
        <!-- /.modal-content -->
    </form>
    <!-- /.modal-dialog -->
</div>
