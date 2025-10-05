<div class="col-md-3 col-6">
    <div class="d-flex align-items-center">
        <div class="badge bg-label-primary me-3 p-2">
            <i class="ti ti-files ti-sm" style="font-size: 30px !important;"></i>
        </div>
        <div class="card-info">
            <h5 class="mb-0">{{ $mitra ?? 0 }}</h5>
            <p class="mb-0" style="font-size:18px;">Mitra</p>
            <a href="{{ route('kelola_mitra') }}" class="mb-0 text-primary" style="font-size:18px;">Detail<i class="ti ti-arrow-right mb-1 ms-1"></i></a>
        </div>
    </div>
</div>
<div class="col-md-3 col-6">
    <div class="d-flex align-items-center">
        <div class="badge bg-label-warning me-3 p-2">
            <i class="ti ti-clock ti-sm" style="font-size: 30px !important;"></i>
        </div>
        <div class="card-info">
            <h5 class="mb-0">{{ $lowongan ?? 0 }}</h5>
            <p class="mb-0" style="font-size:18px;">Lowongan</p>
            <a href="{{ route('lowongan.kelola') }}" class="mb-0 text-warning" style="font-size:18px;">Detail<i class="ti ti-arrow-right mb-1 ms-1"></i></a>
        </div>
    </div>
</div>
<div class="col-md-3 col-6">
    <div class="d-flex align-items-center">
        <div class="badge bg-label-danger me-3 p-2">
            <i class="ti ti-clipboard-x ti-sm" style="font-size: 30px !important;"></i>
        </div>
        <div class="card-info">
            <h5 class="mb-0">{{ $spm ?? 0 }}</h5>
            <p class="mb-0" style="font-size:18px;">SKM</p>
            <a href="{{ route('data_mahasiswa') }}" class="mb-0 text-danger" style="font-size:18px;">Detail<i class="ti ti-arrow-right mb-1 ms-1"></i></a>
        </div>
    </div>
</div>
<div class="col-md-3 col-6">
    <div class="d-flex align-items-center">
        <div class="badge bg-label-info me-3 p-2">
            <i class="ti ti-clipboard-x ti-sm" style="font-size: 30px !important;"></i>
        </div>
        <div class="card-info">
            <h5 class="mb-0">{{ $berkas ?? 0 }}</h5>
            <p class="mb-0" style="font-size:18px;">Berkas</p>
            <a href="{{ route('berkas_akhir_magang.fakultas') }}" class="mb-0 text-info" style="font-size:18px;">Detail<i class="ti ti-arrow-right mb-1 ms-1"></i></a>
        </div>
    </div>
</div>