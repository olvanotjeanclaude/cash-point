<div class="col-12">
    <div class="card directory-card">
        <div class="p-3 bg-transparent card-header d-flex justify-content-between">
            <h6 class="mt-1 text-uppercase">GENEL BİLGİLERİ</h6>
            <div>
                <button type="button" class="btn btn-sm btn-success" data-bs-toggle="modal"
                    data-bs-target="#editGeneralInfoModal">
                    <i class="fas fa-edit"></i>
                    Düzenle
                </button>
            </div>
        </div>
        <div class="card-body">
            <div class="d-flex">
                <div class="flex-shrink-0">
                    <img src="{{ get_image($customer->image) }}" alt="Profil Resmi"
                        class="image-popup-vertical-fit img-fluid img-thumbnail rounded-circle avatar-lg">
                </div>
                <div class="flex-grow-1 ms-3">
                    <h5 class="text-primary font-size-18 mb-1">{{ $customer->full_name }}</h5>
                    <p class="font-size-12 mb-2">{{ $customer->work }}</p>
                    <p class="mb-0">{{ $customer->email }}</p>
                    <p>
                        @if ($customer->status == 1)
                            <label class="badge bg-success">Aktif</label>
                        @else
                            <label class="badge bg-danger">Pasif</label>
                        @endif
                        <a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#editStatus"
                            class="ms-2">düzenle</a>
                    </p>

                    @if ($customer->motif)
                        <h6 class="mt-1 text-uppercase">Pasif Alma Sebebi</h6>
                        <p>
                            {{ $customer->motif->body }}
                        </p>
                    @endif
                </div>
                <ul class="list-unstyled social-links ms-auto">
                    @if ($customer->facebook)
                        <li>
                            <a href="{{ $customer->facebook }}" target="_blank" class="btn-primary">
                                <i class="mdi mdi-facebook"></i>
                            </a>
                        </li>
                    @endif
                    @if ($customer->twitter)
                        <li>
                            <a href="{{ $customer->twitter }}" target="_blank" class="btn-info">
                                <i class="mdi mdi-twitter"></i>
                            </a>
                        </li>
                    @endif
                    @if ($customer->instagram)
                        <li>
                            <a href="{{ $customer->instagram }}" target="_blank" class="btn-warning">
                                <i class="mdi mdi-instagram"></i>
                            </a>
                        </li>
                    @endif
                </ul>
            </div>
            <hr>
            <h5><span class="me-3">Telefon :</span>{{ $customer->phone }}</h5>
            <hr>
            <div class="row">
                <div class="col-sm-6 col-md-3">
                    <h6 class="mt-1 text-uppercase">TEMEL BİLGİLERİ</h6>
                    <p class="mb-0 mt-3"><b>Cinsiyet : </b>{{ $customer->gender == 1 ? 'Erkek' : 'Kadın' }}</p>
                    <p class="mb-0"><b>Meslek : </b>{{ $customer->work ?? 'Girilmemiş' }}</p>
                </div>
                <div class="col-sm-6 col-md-3">
                    <div class="d-flex">
                        <h6 class="text-uppercase mt-1">ADRES BİLGİLERİ</h6>
                        <button type="button" class="ms-2 btn btn-sm btn-success" data-bs-toggle="modal"
                            data-bs-target="#editAddressModal">
                            <i class="fas fa-edit"></i>
                        </button>
                    </div>
                    <p class="mb-0 mt-2"><b>Adres : </b>
                        <span class="text-capitalize">
                            {{ $customer->get_neighborhood && $customer->get_neighborhood->neighborhood_name? Str::lower($customer->get_neighborhood->neighborhood_name . ', '): '' }}</span>
                        <span
                            class="text-capitalize">{{ $customer->get_district && $customer->get_district->district_name? Str::lower($customer->get_district->district_name . ' /'): '-' }}</span>
                        <span
                            class="text-uppercase">{{ $customer->get_province && $customer->get_province->province_name? $customer->get_province->province_name: '' }}</span>
                    </p>
                    <p class="mb-0 text-capitalize"><b>Açık Adres : </b>{{ $customer->address ?? 'Girilmemiş' }}</p>
                </div>
                <div class="col-sm-6 col-md-3">
                    <div class="d-flex">
                        <h6 class="text-uppercase mt-1">İLGELENDİĞİ PROJELER</h6>
                        <button type="button" class="ms-2 btn btn-sm btn-success" data-bs-toggle="modal"
                            data-bs-target="#editProject">
                            <i class="fas fa-edit"></i>
                        </button>
                    </div>
                    <p class="mt-2">
                        @if (count($customerProjects))
                            {{ join(', ', $customerProjects) }}
                        @else
                            <p class="text-warning">Herhangi bir proje bulunmamaktadır</p>
                        @endif
                    </p>
                </div>
                <div class="col-sm-6 col-md-3">
                    <div class="d-flex">
                        <h6 class="text-uppercase mt-1">DİĞER BİLGİLERİ</h6>
                        <button type="button" class="ms-2 btn btn-sm btn-success" data-bs-toggle="modal"
                            data-bs-target="#editOtherInfoModal">
                            <i class="fas fa-edit"></i>
                        </button>
                    </div>
                    <p class="mb-0 mt-2"><b>Ekleme Tarihi:</b> {{ format_date($customer->created_at) }}</p>
                    <p class="mb-0 text-capitalize"><b>Ekleyen Kullanıcı : </b>{{ $customer->user->full_name ?? '' }}
                    </p>
                </div>
            </div>
            <hr>
            <div class="row">
                <div class="col-md-4">
                    <div class="d-flex">
                        <h6 class="text-uppercase mt-1">En son görüşme</h6>
                        <a class="btn btn-primary btn-sm ms-2"
                            href="{{ route('admin.meetings.create', ['customer_id' => $customer->id]) }}">
                            <i class="fas fa-plus"></i>
                        </a>
                    </div>

                    @if (count($customerMeetings) > 0)
                        @php
                            $meet = $customerMeetings->first();
                        @endphp
                        <p class="mb-0 mt-2"><b>Tarihi ve saat : </b>@format_date($meet->date_time )</p>
                        <p><b>Not :</b> {{ $meet->description }}</p>
                        <a href="{{ route('admin.meetings.edit', ['meeting' => $meet->id]) }}"
                            class="btn btn-sm btn-success">
                            <i class="fas fa-edit mr-2"></i>
                            Düzenle
                        </a>
                    @else
                        <p class="text-warning">Görüşme bulunmamaktadır</p>
                    @endif
                </div>
                <div class="col-md-4">
                    <div class="d-flex">
                        <h6 class="text-uppercase mt-1">Diğer Bilgileri</h6>
                        <button type="button" class="btn ms-2 mb-2 btn-sm btn-success" data-bs-toggle="modal"
                            data-bs-target="#editOtherInfoModal">
                            <i class="fas fa-edit"></i>
                        </button>
                    </div>
                    <p>
                        <span><b>Bizi nereden buldunuz?</b></span>
                        <br>
                        <span>
                            {{ $customer->other_info->find_us->name ?? 'Girilmemiş' }}
                        </span>
                    </p>

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
