@if (isset($data))
<div class="modal-content">
    <div class="modal-header">
        <h5 class="modal-title">Detail {{ $data->namamhs }}</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
    </div>
    <div class="modal-body pt-4">
        <div class="row">
            <div class="col-6"><h6 class="mb-1">NIM:</h6></div>
            <div class="col-6">{{ $data->nim ?? '-' }}</div>
            <div class="col-6 mt-1"><h6 class="mb-1">Nama:</h6></div>
            <div class="col-6 mt-1">{{ $data->namamhs ?? '-' }}</div>
            <div class="col-6 mt-1"><h6 class="mb-1">Program Studi:</h6></div>
            <div class="col-6 mt-1">{{ $data->namaprodi ?? '-' }}</div>
            <div class="col-6 mt-1"><h6 class="mb-1">Nama Perusahaan:</h6></div>
            <div class="col-6 mt-1">{{ $data->namaindustri ?? '-' }}</div>
            <div class="col-6 mt-1"><h6 class="mb-1">Posisi Magang:</h6></div>
            <div class="col-6 mt-1">{{ $data->intern_position ?? '-' }}</div>
            <div class="col-6 mt-1"><h6 class="mb-1">Tanggal mulai magang:</h6></div>
            <div class="col-6 mt-1">{{ $data->startdate_magang ?? '-' }}</div>
            <div class="col-6 mt-1"><h6 class="mb-1">Tanggal Akhir magang:</h6></div>
            <div class="col-6 mt-1">{{ $data->enddate_magang ?? '-' }}</div>
            <div class="col-6 mt-1"><h6 class="mb-1">Pembimbing Lapangan:</h6></div>
            <div class="col-6 mt-1">{{ $data->namapeg ?? '-' }}</div>
            <div class="col-6 mt-1"><h6 class="mb-1">Pembimbing Akademik:</h6></div>
            <div class="col-6 mt-1">{{ $data->namadosen ?? '-' }}</div>
            <div class="col-6 mt-1"><h6 class="mb-1">Dokumen penerimaan:</h6></div>
            @if ($data->file_document_mitra)
            <div class="col-6 mt-1"><a href="{{ url('storage/' . $data->file_document_mitra) }}" class="text-success">Bukti penerimaan.pdf</a></div>
            @endif
        </div>
    </div>
</div>
@else
<div class="modal-content">
    <div class="modal-header">
        <h5 class="modal-title">Detail</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
    </div>
    <div class="modal-body pt-4">
        <div class="row">
            <div class="col-6"><h6 class="mb-1">NIM:</h6></div>
            <div class="col-6"></div>
            <div class="col-6 mt-1"><h6 class="mb-1">Nama:</h6></div>
            <div class="col-6 mt-1"></div>
            <div class="col-6 mt-1"><h6 class="mb-1">Program Studi:</h6></div>
            <div class="col-6 mt-1"></div>
            <div class="col-6 mt-1"><h6 class="mb-1">Nama Perusahaan:</h6></div>
            <div class="col-6 mt-1"></div>
            <div class="col-6 mt-1"><h6 class="mb-1">Posisi Magang:</h6></div>
            <div class="col-6 mt-1"></div>
            <div class="col-6 mt-1"><h6 class="mb-1">Tanggal mulai magang:</h6></div>
            <div class="col-6 mt-1"></div>
            <div class="col-6 mt-1"><h6 class="mb-1">Tanggal Akhir magang:</h6></div>
            <div class="col-6 mt-1"></div>
            <div class="col-6 mt-1"><h6 class="mb-1">Pembimbing Lapangan:</h6></div>
            <div class="col-6 mt-1"></div>
            <div class="col-6 mt-1"><h6 class="mb-1">Pembimbing Akademik:</h6></div>
            <div class="col-6 mt-1"></div>
            <div class="col-6 mt-1"><h6 class="mb-1">Dokumen penerimaan:</h6></div>
            <div class="col-6 mt-1"></div>
        </div>
    </div>
</div>
@endif