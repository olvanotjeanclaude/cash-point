<div class="col-12">
    <div class="card directory-card">
        <div class="p-3 bg-transparent card-header d-flex justify-content-between">
            <h6 class="mt-1 text-uppercase">DİĞER BİLGİLERİ</h6>
            <div>
                <button type="button" class="btn btn-sm btn-success" data-bs-toggle="modal"
                    data-bs-target="#editOtherInfoModal">
                    <i class="fas fa-edit"></i>
                    Düzenle
                </button>
            </div>
        </div>

        <div class="card-body">
            <div class="row">
                <div class="col-md-12">
                    <p>
                        <span><b>Bizi nereden buldunuz?</b></span>
                        <br>
                        <span>
                            {{ $customer->other_info->find_us->name ?? 'Girilmemiş' }}
                        </span>
                    </p>

                </div>

                <div class="col-md-6">
                    <p>
                        <b>Kısa Açıklama : </b>
                        <br>
                        <span> {{ $customer->other_info->description ?? 'Girilmemiş' }}</span>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
