<div class="col-12">
    <div class="card directory-card">
        <div class="p-3 bg-transparent card-header d-flex justify-content-between">
            <h6 class="mt-1 text-uppercase">Verilen Teklifler</h6>
            <div>
                <a class="btn btn-primary"
                    href="{{ route('admin.bids.create') }}">
                    <i class="fas fa-plus"></i>
                    Teklif Oluştur
                </a>

            </div>
        </div>

        <div class="card-body">
            <div class="row">
                <div class="col-12">
                    <div class="card mini-stat  text-white">
                        <div class="card-body">
                            <div class="table-responsive">
                              <table id="datatable-buttons"
                                  class="list-container table table-striped table-bordered dt-responsive nowrap"
                                  style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                  <thead>
                                      <tr>
                                          <th>Proje Adı</th>
                                          <th>Daire Numarası</th>
                                          <th>Fiyat</th>
                                          <th>İlgi Düzeyi</th>
                                          <th>Teklifi Veren</th>
                                          <th>Durum</th>
                                          <th>Tarih</th>
                                          <th>Yönetim</th>
                                      </tr>
                                  </thead>

                                  <tbody>
                                          @foreach($bids as $bid)
                                          <tr id="row_{{ $bid->id }}">
                                              <td><a href="{{ route('admin.projects.show', ['project' => $bid->apartment->floor->block->project->id ]) }}">{{ $bid->apartment->floor->block->project->name }}</a></td>
                                              <td>{{ $bid->apartment->floor->block->name }}</td>
                                              <td>{{ $bid->apartment->number }}</td>
                                              <td>{{ number_format($bid->price, 2, ',', '.') }}₺</td>
                                              <td>
                                                @switch($bid->level_of_interest)
                                                    @case(1)
                                                        <i style="color:#ffe900" class="fas fa-star"></i>
                                                    @break
                                                    @case(2)
                                                        <i style="color:#ffe900" class="fas fa-star"></i><i style="color:#ffe900" class="fas fa-star"></i>
                                                    @break
                                                    @case(3)
                                                        <i style="color:#ffe900" class="fas fa-star"></i><i style="color:#ffe900" class="fas fa-star"></i><i style="color:#ffe900" class="fas fa-star"></i>
                                                    @break
                                                    @case(4)
                                                      <i style="color:#ffe900" class="fas fa-star"></i><i style="color:#ffe900" class="fas fa-star"></i><i style="color:#ffe900" class="fas fa-star"></i><i style="color:#ffe900" class="fas fa-star"></i>
                                                    @break
                                                    @case(5)
                                                      <i style="color:#ffe900" class="fas fa-star"></i><i style="color:#ffe900" class="fas fa-star"></i><i style="color:#ffe900" class="fas fa-star"></i><i style="color:#ffe900" class="fas fa-star"></i>
                                                      <i style="color:#ffe900" class="fas fa-star"></i>
                                                    @break
                                                    @default
                                                        <label class="badge bg-light">Belirlenmemiş</label>
                                                @endswitch
                                              </td>
                                              <td>{{ $bid->user->name }}</td>
                                              <td>{{ $bid->BidStatus->name }}</td>
                                              <td>{{ $bid->created_at }}</td>
                                              <td><a href=""
                                                  class="btn btn-sm btn-success">
                                                  <i class="fas fa-pen"></i>
                                                  Teklifi Güncelle
                                              </a></td>

                                          </tr>
                                          @endforeach

                                  </tbody>
                              </table>

                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
