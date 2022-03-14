<div class="col-12">
    <div class="card directory-card">
        <div class="p-3 bg-transparent card-header d-flex justify-content-between">
            <h6 class="mt-1 text-uppercase">ADRES BİLGİLERİ</h6>
            <div>
                <button type="button" class="btn btn-sm btn-success" data-bs-toggle="modal"
                    data-bs-target="#editAddressModal">
                    <i class="fas fa-edit"></i>
                    Düzenle
                </button>
            </div>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-12">
                    <p><b>Adres : </b>{{ $customer->full_address }}</p>
                    <p class="text-capitalize"><b>Açık Adres : </b>{{ $customer->address }}</p>
                </div>
            </div>
        </div>
    </div>
</div>
