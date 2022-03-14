<div class="modal fade" id="editProject" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <form class="modal-dialog needs-validation" enctype="multipart/form-data" novalidate method="POST"
        action="{{ route('admin.customer.projects.update') }}">
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
                            @if (count($customer->Projects) == 0)
                                <div class="col-6" style="margin-bottom: 15px;">
                                    <div class="form-check">
                                        <input class="form-check-input" value="" id="default" checked type="checkbox"
                                            name="projects[]">
                                        <label class="form-check-label" for="default">
                                            Genel
                                        </label>
                                    </div>
                                </div>
                            @endif
                            @foreach ($projects as $project)
                                <div class="col-6" style="margin-bottom: 15px;">
                                    <div class="form-check">
                                        <input class="form-check-input" value="{{ $project->id }}"
                                            @if ($customer->Projects->contains($project->id)) checked @endif type="checkbox"
                                            name="projects[]" id="{{ $project->id }}">
                                        <label class="form-check-label" for="{{ $project->id }}">
                                            {{ $project->name }}
                                        </label>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <input type="hidden" name="customer_id" value="{{ $customer->id }}">
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
