<div class="table-responsive border border-bottom-0 mt-4">
    <table class="table" id="table-penilaian">
        <thead>
            <tr>
                <th>No</th>
                <th>Aspek Penilaian</th>
                <th>Deskripsi Penilaian</th>
                <th>Nilai Max</th>
                <th>Nilai Magang</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($nilaiLapangan as $item)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $item->aspek_penilaian }}</td>
                <td>{{ $item->deskripsi_penilaian }}</td>
                <td>{{ $item->nilai_max }}</td>
                <td>{{ $item->nilai ?? '-' }}</td>
            </tr>
            @endforeach
            <tr>
                <th class="text-center" colspan="4">TOTAL NILAI AKHIR MAGANG</th>
                <th class=""><input type="text" class="form-control" value="{{ $nilaiAkhir }}" placeholder="-" style="max-width: 150px;" disabled /></th>
            </tr>
            <tr>
                <th class="text-center" colspan="4">PREDIKAT INDEX NILAI AKHIR MAGANG</th>
                <th class=""><input type="text" class="form-control" value="{{ $indexAkhir }}" placeholder="-" style="max-width: 150px;" disabled /></th>
            </tr>
        </tbody>
    </table>
</div>