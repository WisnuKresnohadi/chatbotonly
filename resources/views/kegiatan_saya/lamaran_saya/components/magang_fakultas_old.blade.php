<ul class="nav nav-pills mb-3 " role="tablist">
    <li class="nav-item">
        <button type="button" id="fakultas" class="nav-link active" role="tab" data-bs-toggle="tab" data-bs-target="#navs-pills-justified-pending" aria-controls="navs-pills-justified-pending" aria-selected="false">
            <i class="ti ti-presentation-analytics"></i>
            Proses Seleksi
        </button>
    </li>
    <li class="nav-item">
        <button type="button" class="nav-link" role="tab" data-bs-toggle="tab" data-bs-target="#navs-pills-justified-penawaran" aria-controls="navs-pills-justified-penawaran" aria-selected="false">
            <i class="ti ti-speakerphone"></i>
            Penawaran
        </button>
    </li>
    <li class="nav-item">
        <button type="button" class="nav-link" role="tab" data-bs-toggle="tab" data-bs-target="#navs-pills-justified-terima" aria-controls="navs-pills-justified-terima" aria-selected="false">
            <i class="ti ti-clipboard-check"></i>
            Diterima
        </button>
    </li>
    <li class="nav-item">
        <button type="button" class="nav-link" role="tab" data-bs-toggle="tab" data-bs-target="#navs-pills-justified-tolak" aria-controls="navs-pills-justified-tolak" aria-selected="false">
            <i class="ti ti-clipboard-x"></i>
            Ditolak
        </button>
    </li>
</ul>
<div class="tab-content bg-transparent p-0">
    <div class="tab-pane fade show active" id="navs-pills-justified-pending" role="tabpanel">
        <div class="d-flex justify-content-end mb-3">
            <div class="col-3">
                <select class="select2 form-select" name="filter_lowongan" id="filter_lowongan" data-allow-clear="true" data-placeholder="Filter Status Lowongan">
                    <option value="" disabled selected>Filter Status Lowongan</option>
                    <option value="Pending">Pending</option>
                    <option value="Screening">Screening</option>
                    <option value="Tahap 1">Tahap 1</option>
                    <option value="Tahap 2">Tahap 2</option>
                    <option value="Tahap 3">Tahap 3</option>
                    <option value="Ditolak">Ditolak</option>
                </select>
            </div>
        </div>
        <div id="container-proses-seleksi">
            @include('kegiatan_saya.lamaran_saya.components.proses_seleksi')
        </div>
    </div>
    <div class="tab-pane fade" id="navs-pills-justified-penawaran" role="tabpanel">
        <div id="container-penawaran">
            @include('kegiatan_saya.lamaran_saya.components.penawaran')
        </div>
    </div>
    <div class="tab-pane fade" id="navs-pills-justified-terima" role="tabpanel">
        <div id="container-diterima">
            @include('kegiatan_saya.lamaran_saya.components.diterima')
        </div>
    </div>
    <div class="tab-pane fade" id="navs-pills-justified-tolak" role="tabpanel">
        <div id="container-ditolak">
            @include('kegiatan_saya.lamaran_saya.components.ditolak')
        </div>
    </div>
</div>