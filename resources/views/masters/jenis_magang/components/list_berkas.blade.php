<table class="table">
    @if (isset($dokumenSyarat))
    <thead>
        <th>NAMA DOKUMEN</th>
        <th style="text-align: center;">STATUS</th>
        <th style="text-align: center;">ACTION</th>
    </thead>
    <tbody>
        @foreach ($dokumenSyarat as $key => $item)
        <tr>
            <td>{{ $item->namadocument }}</td>
            <td style="text-align: center;">
                @if ($item->status == 1)
                <span class="badge rounded-pill bg-label-success">Aktif</span>
                @else
                <span class="badge rounded-pill bg-label-danger">Non-aktif</span>
                @endif
            </td>
            <td>
                <div class="d-flex justify-content-center align-items-center">
                    @if ($item->status == 1)
                    <a data-url='{{ route('jenismagang.update_status_dokumen', $item->id_document) }}' class='cursor-pointer mx-1 update-status text-danger' data-function='afterUpdateStatusDokumen'><i class='tf-icons ti ti-circle-x'></i></a>
                    @else
                    <a data-url='{{ route('jenismagang.update_status_dokumen', $item->id_document) }}' class='cursor-pointer mx-1 update-status text-primary' data-function='afterUpdateStatusDokumen'><i class='tf-icons ti ti-circle-check'></i></a>
                    @endif
                </div>
            </td>
        </tr>
        @endforeach
    </tbody>
    @elseif (isset($berkasMagang))
    <thead>
        <th>BERKAS MAGANG</th>
        <th style="text-align: center;">TEMPLATE</th>
        <th style="text-align: center;">DUE DATE</th>
        <th style="text-align: center;">WAJIB UPLOAD?</th>
        <th style="text-align: center;">ACTION</th>
    </thead>
    <tbody>
        @foreach ($berkasMagang as $key => $item)
        <tr>
            <td>{{ $item->nama_berkas }}</td>
            <td style="text-align: center">
                <a href="{{ url('storage/' . $item->template) }}" target="_blank" class="btn-icon text-primary">
                    <i class="ti ti-external-link"></i>
                </a>
            </td>
            <td>{{ \Carbon\Carbon::parse($item->due_date)->format('d F Y H:i') }}</td>
            <td style="text-align: center">
                @if ($item->status_upload == 1)
                <span class="badge rounded-pill bg-label-success">Wajib</span>
                @else
                <span class="badge rounded-pill bg-label-danger">Tidak Wajib</span>
                @endif
            </td>
            <td>
                <div class="d-flex justify-content-center align-items-center">
                    @if ($item->status_upload == 1)
                    <a data-url='{{ route('jenismagang.update_status_berkas', $item->id_berkas_magang) }}' class='cursor-pointer mx-1 update-status text-danger' data-function='afterUpdateStatusBerkas'><i class='tf-icons ti ti-circle-x'></i></a>
                    @else
                    <a data-url='{{ route('jenismagang.update_status_berkas', $item->id_berkas_magang) }}' class='cursor-pointer mx-1 update-status text-primary' data-function='afterUpdateStatusBerkas'><i class='tf-icons ti ti-circle-check'></i></a>
                    @endif
                </div>
            </td>
        </tr>
        @endforeach
    </tbody>
    @endif
    
</table>