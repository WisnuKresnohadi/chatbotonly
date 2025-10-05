<div class="card mt-4 border shadow-none border-secondary" style="border-color: #D3D6DB !important">
    <div class="card-body">
        <div class="d-flex flex-row align-items-center" style="gap: 1.8rem;">
            <div class="">
                <figure class="image" style="border-radius: 0%;"><img style="border-radius: 0%;" src="{{ asset('front/assets/img/icon_lowongan.png')}}" alt="admin.upload"></figure>
            </div>
            <div class="col-10 d-flex justify-content-between align-items-center">
                <div class="d-flex flex-row align-items-center justify-content-between">
                    <div style="display: grid; grid-template-columns: repeat(3, minmax(0, 1fr)); gap: 4rem;">
                            <div class="d-flex flex-column justify-content-between" style="width: max-content;">
                                <h5>{{ $data->intern_position ?? "" }}</h5>
                                <span>{{ $data->deskripsi }}</span>
                            </div>
                            <div class="d-flex align-items-center" style="width: max-content;">
                                <i class="ti ti-calendar me-2"></i>
                                <div class="d-flex flex-column">
                                    <span style="font-weight: 700;">
                                        Tanggal Ditayangkan
                                    </span>
                                    <span>{{ Carbon\Carbon::parse($data->startdate)->format('d F Y') }} - {{ Carbon\Carbon::parse($data->enddate)->format('d F Y') }}</span>
                                </div>
                            </div>
                            <div class="d-flex align-items-center" style="width: max-content;">
                                <i class="ti ti-users me-2"></i>
                                <div class="d-flex flex-column"><span style="font-weight: 700;">
                                    Kuota Penerimaan</span><span>
                                        {{ $data->kuota }}
                                    </span></div>
                            </div>
                    </div>
                </div>
            </div>
            <div class="">
                <span class="badge bg-label-success me-1 text-end">{{$data->statusapprove}}</span>
            </div>
        </div>
        <div class="row gy-3 mt-3">
            <div class="col-md-2 col-6">
                <div class="d-flex align-items-center">
                    <div class="badge rounded-pill bg-label-success me-3 p-2">
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
                    <div class="badge rounded-pill bg-label-success me-3 p-2">
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
                    <div class="badge rounded-pill bg-label-success me-3 p-2">
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
                    <div class="badge rounded-pill bg-label-success me-3 p-2">
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
                    <div class="badge rounded-pill bg-label-success me-3 p-2">
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
                    <div class="badge rounded-pill bg-label-success me-3 p-2">
                        <i class="ti ti-x ti-sm"></i>
                    </div>
                    <div class="card-info">
                        <small>Ditolak</small>
                        <h5 class="mb-0">{{ $data->rejected }}</h5>
                    </div>
                </div>
            </div>
        </div>
        <div class="rounded d-flex flex-row align-items-center p-3" style="background: rgba(0, 209, 232, 0.094);; margin-top: 1.5rem; ">
            <i class="ti ti-info-circle me-2" style="color: rgb(0, 165, 184);"></i>
            <span style="color: rgb(0, 165, 184);">Atur kriteria seleksi terlebih dahulu sebeum mengakses proses seleksi</span>
        </div>
        <hr />
        <div class="row">
            <div class="d-flex justify-content-start" style="gap: 1rem;">
                <a href="{{ route('lowongan.informasi.detail', $data->id_lowongan) }}" class="btn btn-sm" style="color: rgb(162, 162, 162); border: 2px solid rgb(162, 162, 162);">
                    <i class="ti ti-eye me-2"></i>
                    Proses Seleksi
                </a>
                <a href="{{ route('lowongan.informasi.detail', $data->id_lowongan) }}" class="btn btn-sm " style="color: rgba(78, 169, 113, 1); border: 2px solid rgba(78, 169, 113, 1);">
                    <i class="ti ti-edit me-2"></i>
                    Tanggal Batas Konfirmasi
                </a>
            </div>
        </div>
    </div>
</div>
