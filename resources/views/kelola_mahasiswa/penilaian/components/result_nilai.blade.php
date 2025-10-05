@if (isset($presentaseNilai))
<table class="table">
    <thead>
        <tr>
            <th style="width:300px;">Nilai</th>
            <th>Presentase Maksimum (%)</th>
            <th style="width: 200px;text-align:center;">Hasil</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>{{ $nilai }}</td>
            <td>{{ $presentaseNilai }}</td>
            <td style="text-align:center;">{{ $hasil }}</td>
        </tr>
    </tbody>
</table>
@else
<table class="table">
    <thead>
        <tr>
            <th>Komponen Perhitungan</th>
            <th style="width: 200px;text-align:center;">Hasil</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>Nilai Pembimbing Lapangan + Nilai Pembimbing Akademik</td>
            <td class="fw-bolder" style="text-align:center;font-size:12pt;">{!! $hasil !!}</td>
        </tr>
    </tbody>
</table>
@endif