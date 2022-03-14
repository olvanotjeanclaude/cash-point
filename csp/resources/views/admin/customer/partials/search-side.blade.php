<div class="col-lg-2 p-0 col-sm-12">
    <h5 class="bg-primary text-white p-2">Filtreleme</h5>
    <div class="accordion" id="accordionPanelsStayOpenExample">
        <div class="accordion-item">
            <h2 class="accordion-header" id="panelsStayOpen">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                    data-bs-target="#filter_proje" aria-expanded="false" aria-controls="filter_proje">
                    Proje
                </button>
            </h2>
            <div id="filter_proje" class="accordion-collapse collapse show" aria-labelledby="panelsStayOpen">
                <div class="accordion-body">
                    <form class="" action="{{ route('admin.customer.filter') }}" method="post">
                        @csrf
                        <label for="validationCustom04" class="form-label">Proje</label>
                        @php
                            use App\Models\Project;
                            $projects = Project::get()->all();
                        @endphp
                        {{-- <input type="hidden" name=""> --}}
                        @foreach ($projects as $project)
                            <div style="margin-bottom: 15px;">
                                <div class="form-check">
                                    <input class="form-check-input" value="{{ $project->id }}"
                                        @if (isset(request()->projects) && in_array($project->id, request()->projects)) checked @endif type="checkbox"
                                        name="projects[]" id="{{ $project->id }}">
                                    <label class="form-check-label" for="{{ $project->id }}">
                                        {{ $project->name }}
                                    </label>
                                </div>
                            </div>
                        @endforeach
                        <button type="submit" class="btn btn-sm btn-success">
                            <i class="fas fa-filter"></i>
                            Filtrele
                        </button>
                    </form><br>
                </div>
            </div>
        </div>

        <div class="accordion-item">
            <h2 class="accordion-header" id="panelsStayOpen-headingTwo">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                    data-bs-target="#filter_2" aria-expanded="false" aria-controls="filter_2">
                    Fiyat Aralığı
                </button>
            </h2>
            <div id="filter_2" class="accordion-collapse collapse" aria-labelledby="panelsStayOpen-headingTwo">
                <div class="accordion-body">
                    <form class="" action="{{ route('admin.customer.price.filter') }}" method="post">
                        @csrf
                        <label for="validationCustom04" class="form-label">Fiyat</label>
                        <input type="text" name="low" class="form-control" placeholder="En az"
                            value="{{ request()->post('low') }}">
                        <hr>
                        <input type="text" name="max" placeholder="En çok" class="form-control"
                            value="{{ request()->post('max') }}">
                        <br>
                        <button type="submit" class="btn btn-sm btn-success">
                            <i class="fas fa-filter"></i>
                            Filtrele
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
