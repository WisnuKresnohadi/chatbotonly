<div class="row mt-4 mb-3">
    <div class="col-5 my-auto">
        <div class="user-avatar-section">
            <div class="d-flex align-items-center flex-column">
                <div class="rounded-circle text-center" style="overflow: hidden; width: 125px; height: 125px;">
                    @if ($industri->image)
                        <img src="{{ asset('storage/' . $industri->image) }}" alt="user-avatar" class="d-block" width="125" id="image_industri">
                    @else
                        <img src="{{ asset('app-assets/img/avatars/building.png') }}" alt="user-avatar" class="d-block" width="125" id="image_industri" data-default-src="{{ asset('app-assets/img/avatars/building.png') }}">
                    @endif
                </div>

                <div class="user-info text-center">
                    <h4 class="fw-bold mt-2 mb-0" id="namaindustri">{{ $industri->namaindustri }}</h4>
                    <span class="badge bg-label-primary mt-2">Mitra Perusahaan</span>
                </div>
            </div>
        </div>
    </div>
    <div class="col-7 border-start my-auto">
        <div class="mx-4">
            <div class="d-flex justify-content-start align-items-center mb-2">
                <i class="ti ti-map-pin me-2 ti-md"></i>
                <h5 class="mb-0">Alamat Perusahaan</h5>
            </div>
            @if(isset($industri->alamatindustri)) <p class="ms-5">{{ $industri->alamatindustri }}</p> @else <p class="fst-italic text-muted ms-5">-&ensp;Not Yet Set&ensp;-</p> @endif
            <div class="d-flex justify-content-start align-items-center mb-2">
                <i class="ti ti-building me-2 ti-md"></i>
                <h5 class="mb-0">Deskripsi Perusahaan</h5>
            </div>
            @if(isset($industri->description)) <p class="ms-5">{{ $industri->description }}</p> @else <p class="fst-italic text-muted ms-5">-&ensp;Not Yet Set&ensp;-</p> @endif
            <div class="d-flex justify-content-start align-items-center mb-2">
                <i class="ti ti-phone me-2 ti-md"></i>
                <h5 class="mb-0">Kontak Perusahaan</h5>
            </div>
            <div class="d-flex justify-content-start mt-3 mb-2">
                <div class="px-4 text-center">
                    <p class="fw-bolder mb-1">Email</p>
                    <small class="text-muted mb-0">{{ $industri->email }}</small>
                </div>
                <div class="px-4 text-center border-start">
                    <p class="fw-bolder mb-1">Telp</p>
                    <small class="text-muted mb-0">{{ $industri->notelpon }}</small>
                </div>
            </div>
            <div class="d-flex justify-content-start align-items-center mb-2">
                <i class="ti ti-user-circle me-2 ti-md"></i>
                <h5 class="mb-0">Penanggung Jawab</h5>
            </div>
            <div class="d-flex justify-content-start mt-3">
                <div class="px-4 text-center">
                    <p class="fw-bolder mb-1">Nama</p>
                    <small class="text-muted mb-0">{{ $penanggungJawab->namapeg }}</small>
                </div>
                <div class="px-4 text-center border-start border-end">
                    <p class="fw-bolder mb-1">Telp</p>
                    <small class="text-muted mb-0">{{ $penanggungJawab->nohppeg }}</small>
                </div>
                <div class="px-4 text-center">
                    <p class="fw-bolder mb-1">Email</p>
                    <small class="text-muted mb-0">{{ $penanggungJawab->emailpeg }}</small>
                </div>
            </div>
        </div>
    </div>
</div>