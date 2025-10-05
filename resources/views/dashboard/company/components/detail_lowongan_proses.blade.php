<div class="col-12">
    <div class="d-flex justify-content-between align-items-center py-2">
        <div class="d-flex justify-content-start align-items-center">
            <div class="badge bg-label-primary me-1 p-2">
                <i class="ti ti-users ti-sm"></i>
            </div>
            <span style="margin-top: 10px;">Total Kandidat</span>
        </div>
        <h5 class="mb-0">{{ $total }} Mahasiswa</h5>
    </div>
    <div class="d-flex justify-content-between align-items-center py-2">
        <div class="d-flex justify-content-start align-items-center">
            <div class="badge bg-label-secondary me-1 p-2">
                <i class="ti ti-clipboard-list ti-sm"></i>
            </div>
            <span style="margin-top: 10px;">Screening</span>
        </div>
        <h5 class="mb-0">{{ $screening }} Mahasiswa</h5>
    </div>
    @for ($i = 1; $i <= $tahapan_seleksi; $i++)
    <div class="d-flex justify-content-between align-items-center py-2">
        <div class="d-flex justify-content-start align-items-center">
            <div class="badge bg-label-warning me-1 p-2">
                <i class="ti ti-files ti-sm"></i>
            </div>
            <span style="margin-top: 10px;">Seleksi Tahap {{ $i }}</span>
        </div>
        <h5 class="mb-0">{{ ${'seleksi_' . $i} }} Mahasiswa</h5>
    </div>
    @endfor
    <div class="d-flex justify-content-between align-items-center py-2">
        <div class="d-flex justify-content-start align-items-center">
            <div class="badge bg-label-info me-1 p-2">
                <i class="ti ti-speakerphone ti-sm"></i>
            </div>
            <span style="margin-top: 10px;">Penawaran</span>
        </div>
        <h5 class="mb-0">{{ $penawaran }} Mahasiswa</h5>
    </div>
    <div class="d-flex justify-content-between align-items-center py-2">
        <div class="d-flex justify-content-start align-items-center">
            <div class="badge bg-label-danger me-1 p-2">
                <i class="ti ti-user-x ti-sm"></i>
            </div>
            <span style="margin-top: 10px;">Ditolak</span>
        </div>
        <h5 class="mb-0">{{ $ditolak }} Mahasiswa</h5>
    </div>
    <div class="d-flex justify-content-between align-items-center py-2">
        <div class="d-flex justify-content-start align-items-center">
            <div class="badge bg-label-primary me-1 p-2">
                <i class="ti ti-user-check ti-sm"></i>
            </div>
            <span style="margin-top: 10px;">Diterima</span>
        </div>
        <h5 class="mb-0">{{ $diterima }} Mahasiswa</h5>
    </div>
</div>