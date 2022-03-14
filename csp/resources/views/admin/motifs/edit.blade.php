 <!-- Modal -->
 <div class="modal fade motif-edit-modal" id="editMotif_{{ $motif->id }}" data-bs-backdrop="static" data-bs-keyboard="false"
     tabindex="-1" aria-labelledby="motifLabel" aria-hidden="true">
     <form class="modal-dialog needs-validation" novalidate method="POST" action="{{ route('admin.motifs.update',$motif->id) }}">
         @csrf
         @method("put")
         <div class="modal-content">
             <div class="modal-header">
                 <h5 class="modal-title" id="motifLabel">Motif
                 </h5>
                 <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
             </div>
             <div class="modal-body">
                 <div class="form-group">
                     <label for="body" class="mb-2">Metin</label>
                     <textarea class="form-control" placeholder="Metni giriniz..." name="body" id="body" cols="30"
                         rows="10" required>{{ $motif->body }}</textarea>
                     <div class="invalid-feedback">
                         Boş girilmez !
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
