<div class="col-12">
    <div class="card directory-card">
        <div class="p-3 bg-transparent card-header d-flex justify-content-between">
            <h6 class="mt-1 text-uppercase">İLETİŞİM BİLGİLERİ</h6>
            <div>
                <button type="button" class="btn btn-sm btn-success" data-bs-toggle="modal"
                    data-bs-target="#editContactModal">
                    <i class="fas fa-edit"></i>
                    Düzenle
                </button>
            </div>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <p><b>Facebook Linki : </b><a target="_blank" href="{{ $customer->facebook }}">Tıklayın</a></p>
                    <p><b>Instagram Linki : </b><a target="_blank" href="{{ $customer->instagram }}">Tıklayın</a></p>
                    <p><b>Twitter Linki : </b><a target="_blank" href="{{ $customer->twitter }}">Tıklayın</a></p>
                </div>
                <div class="col-md-6">
                    <p><b>Telefon : </b>{{ $customer->phone }}</p>
                </div>
            </div>
        </div>
    </div>
</div>
