<div class="col-12">
    <div class="d-flex justify-content-between">
        <span>Kandidat</span>
        <span class="fw-semibold" id="name_kandidat"></span>
    </div>
</div>
<div class="col-12">
    <div class="d-flex justify-content-between">
        <span>Tahap</span>
        <span class="fw-semibold">{{ $seleksi->tahap }}</span>
    </div>
</div>
<div class="col-12">
    <div class="d-flex justify-content-between">
        <span>Mulai</span>
        <span class="fw-semibold">{{ Carbon\Carbon::parse($seleksi->start_date)->format('d-m-Y H:i') }}</span>
    </div>
</div>
<div class="col-12">
    <div class="d-flex justify-content-between">
        <span>Selesai</span>
        <span class="fw-semibold">{{ Carbon\Carbon::parse($seleksi->end_date)->format('d-m-Y H:i') }}</span>
    </div>
</div>