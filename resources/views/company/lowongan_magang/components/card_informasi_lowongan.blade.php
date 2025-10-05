<div class="mt-4 border shadow-none card border-secondary" style="border-color: #D3D6DB !important">
    <div class="card-body">
        <div class="row">
            <div class="col-auto">
                @if ($data->image)
                <img class="img-thumbnail mb-3" src="{{ asset('storage/' . $data->image) }}" style="max-height: 80px;" alt="admin.upload">
                @else
                <img class="img-thumbnail mb-3" src="{{ asset('app-assets/img/avatars/building.png') }}" style="max-height: 80px;" alt="admin.upload">
                @endif
            </div>
            <div class="col d-flex justify-content-between">
                <div>
                    <h4 class="mb-1 fw-semibold fs-5">{{ $data->intern_position }}</h4>
                    <p>{{ $data->deskripsi }}</p>
                </div>


                <div class="d-flex align-items-center">
                    <i class="ti ti-calendar me-2 ti-xl mt-n3"></i>
                    <div class="">
                        <h4 class="mb-1 fs-6">Tanggal Ditayangkan</h4>
                        <h5 class="fw-normal fs-6">{{ Carbon\Carbon::parse($data->startdate)->format('d F Y') }} - {{ Carbon\Carbon::parse($data->enddate)->format('d F Y') }}</h5>
                    </div>
                </div>
                <div class="d-flex align-items-center">
                    <i class="ti ti-users me-2 ti-xl mt-n3"></i>
                    <div class="">
                        <h4 class="mb-1 fs-6">Kuota Penerimaan</h4>
                        <h5 class="fw-normal fs-6">{{ $data->kuota }}</h5>
                    </div>
                </div>

                <div class="d-flex align-items-center">
                    <h5 class="badge bg-label-success me-1 text-end fs-6">Aktif</h5>
                </div>
            </div>
        </div>
        <div class="mt-3 row gy-3">
            <div class="col-md-2 col-6">
                <div class="d-flex align-items-center">
                    <div class="p-2 badge rounded-pill bg-label-success me-3">
                        <i class="ti ti-users ti-sm"></i>
                    </div>
                    <div class="card-info">
                        <small>Total Pelamar</small>
                        <h5 class="mb-0 total_pelamar">{{ $data->total_pelamar }}</h5>
                    </div>
                </div>
            </div>
            <div class="col-md-2 col-6">
                <div class="d-flex align-items-center">
                    <div class="p-2 badge rounded-pill bg-label-success me-3">
                        <i class="ti ti-files ti-sm"></i>
                    </div>
                    <div class="card-info">
                        <small>Screening</small>
                        <h5 class="mb-0">{{ $data->screening }}</h5>
                    </div>
                </div>
            </div>
            <div class="col-md-2 col-6">
                <div class="d-flex align-items-center">
                    <div class="p-2 badge rounded-pill bg-label-success me-3">
                        <i class="ti ti-speakerphone ti-sm"></i>
                    </div>
                    <div class="card-info">
                        <small>Proses Seleksi</small>
                        <h5 class="mb-0">{{ $data->proses_seleksi }}</h5>
                    </div>
                </div>
            </div>
            <div class="col-md-2 col-6">
                <div class="d-flex align-items-center">
                    <div class="p-2 badge rounded-pill bg-label-success me-3">
                        <i class="ti ti-file-report ti-sm"></i>
                    </div>
                    <div class="card-info">
                        <small>Penawaran</small>
                        <h5 class="mb-0">{{ $data->penawaran }}</h5>
                    </div>
                </div>
            </div>
            <div class="col-md-2 col-6">
                <div class="d-flex align-items-center">
                    <div class="p-2 badge rounded-pill bg-label-success me-3">
                        <i class="ti ti-check ti-sm"></i>
                    </div>
                    <div class="card-info">
                        <small>Diterima</small>
                        <h5 class="mb-0">{{ $data->approved }}</h5>
                    </div>
                </div>
            </div>
            <div class="col-md-2 col-6">
                <div class="d-flex align-items-center">
                    <div class="p-2 badge rounded-pill bg-label-success me-3">
                        <i class="ti ti-x ti-sm"></i>
                    </div>
                    <div class="card-info">
                        <small>Ditolak</small>
                        <h5 class="mb-0">{{ $data->rejected }}</h5>
                    </div>
                </div>
            </div>
        </div>
        <hr />
        <div class="flex-row mt-2 d-flex justify-content-between">
            <div class="gap-3 d-flex justify-content-end">
                <a href="{{ route('kelola_lowongan.pengaturan_kriteria.show', $data->id_lowongan) }}" class="items-center py-2 btn btn-sm btn-outline-dark">
                {{-- <a href="{{ route('lowongan.informasi.bobotan_kandidat.bobotan', $data->id_lowongan) }}" class="items-center py-2 btn btn-sm btn-outline-dark"> --}}
                    <i class="ti ti-file-analytics me-2"></i>
                    Pengaturan Kriteria Seleksi
                </a>
                <button type="button" class="py-2 btn btn-sm btn-outline-primary" onclick="setDateConfirm($(this));" data-id="{{ $data->id_lowongan }}">
                    <i class="ti ti-edit me-2"></i>
                    Batas Konfirmasi
                </button>
                <a href="{{ route('informasi_lowongan.detail', $data->id_lowongan) }}" class="btn btn-sm btn-outline-warning btn-detail">
                    <i class="ti ti-eye me-2"></i>
                    Lihat Kandidat
                </a>
            </div>
        </div>
    </div>
</div>
