@if($berkas->status_berkas == 'pending')
        <a href="#" onclick="approve()" class="btn btn-primary w-100 mb-2">Lengkap</a>
        <a href="#" onclick="reject()" class="btn btn-danger w-100">Tidak Lengkap</a>
@elseif($berkas->status_berkas == 'approved')
    <div class="alert alert-success d-flex align-items-center" role="alert">
        <i class="ti ti-check ti-xs me-2"></i>
        <span> Berkas Telah Disetujui!</span>
    </div>
@else
    <div class="alert alert-danger d-flex align-items-center" role="alert">
        <i class="ti ti-x ti-xs me-2"></i>
        <span> Berkas Tidak Disetujui!</span>
    </div>
    <div class="alert alert-danger d-flex align-items-center" role="alert">
            <span> Alasan Penolakan Berkas : {{ $berkas->rejected_reason }}</span>
    </div>
@endif