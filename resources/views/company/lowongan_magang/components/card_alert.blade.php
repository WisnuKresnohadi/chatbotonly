@if ($kuota_penawaran_full)
<div class="alert alert-warning alert-dismissible" role="alert">
    <h6 class="alert-heading mb-1">Penawaran mencapai batas kuota!</h5>
    <small class="mb-0">
        Jumlah kandidat yg anda beri penawaran sudah mencapai batas kuota, maksimal {{ $kuota }} kandidat. Jika ada mahasiswa yang menolak tawaran, anda baru bisa menawarkan kembali ke kandidat lainnya.
    </small>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif