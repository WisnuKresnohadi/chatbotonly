@extends('partials.vertical_menu')

@section('page_style')
<style>
    .select2-container--default .select2-selection--multiple .select2-selection__choice {
        color: #4EA971;
    }

    .light-style .tagify__tag .tagify__tag-text {
        color: #4EA971 !important;
    }
</style>
@endsection

@section('content')
<div class="row pe-2 ps-2">
    <div class="row">
        <div class="">
            <a href="{{ route('nilai_mahasiswa.fakultas') }}" type="button" class="btn btn-outline-primary mb-3 waves-effect">
                <span class="ti ti-arrow-left me-2"></span>Kembali
            </a>
        </div>
        <div class="col-10">
            <h4 class="fw-bold"><span class="text-muted fw-light"> Nilai Mahasiswa / </span>Detail Nilai {{ $pemagang->namamhs }}</h4>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <h4 class="mb-0">Penilaian Magang oleh Pembimbing Lapangan</h4>
        </div>
        <div class="card-body">
            <div class="card-datatable table-responsive pb-0">
                <table class="table border rounded mb-0" id="table-pembimbing-lapangan">
                    <thead>
                        <tr>
                            <th class="text-center">NOMOR</th>
                            <th>ASPEK PENILAIAN</th>
                            <th>DESKRIPSI ASPEK PENILAIAN</th>
                            <th class="text-center">NILAI MAX</th>
                            <th class="text-center">NILAI</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($komponen_penilaian_akademik as $item)
                        <tr>
                            <td class="text-center">{{ $loop->iteration }}</td>
                            <td>{{ $item->aspek_penilaian_filled ?? $item->aspek_penilaian }}</td>
                            <td>{{ $item->deskripsi_penilaian_filled ?? $item->deskripsi_penilaian }}</td>
                            <td class="text-center">{{ $item->nilai_max_filled ?? $item->nilai_max }}</td>
                            <td class="text-center">{{ $item->nilai_filled ?? '-' }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <th class="text-center" colspan="4">TOTAL NILAI</th>
                            <th>{{ $pemagang->nilai_akademik ?? '-' }}</th>
                        </tr>
                        <tr>
                            <th class="text-center" colspan="4">INDEKS NILAI</th>
                            <th>{{ $pemagang->indeks_nilai_akademik ?? '-' }}</th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>

    <div class="card mt-5">
        <div class="card-header">
            <h4 class="mb-0">Penilaian Magang oleh Pembimbing Akademik</h4>
        </div>
        <div class="card-body">
            <div class="card-datatable table-responsive pb-0">
                <table class="table border rounded mb-0" id="table-pembimbing-akademik">
                    <thead>
                        <tr>
                            <th>NOMOR</th>
                            <th>ASPEK PENILAIAN</th>
                            <th style="min-width:300px;">DESKRIPSI ASPEK PENILAIAN</th>
                            <th style="min-width:100px;">BOBOT</th>
                            <th style="min-width:80px;">NILAI</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($komponen_penilaian_lapangan as $item)
                        <tr>
                            <td class="text-center">{{ $loop->iteration }}</td>
                            <td>{{ $item->aspek_penilaian_filled ?? $item->aspek_penilaian }}</td>
                            <td>{{ $item->deskripsi_penilaian_filled ?? $item->deskripsi_penilaian }}</td>
                            <td class="text-center">{{ $item->nilai_max_filled ?? $item->nilai_max }}</td>
                            <td class="text-center">{{ $item->nilai_filled ?? '-' }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <th class="text-center" colspan="4">TOTAL NILAI</th>
                            <th>{{ $pemagang->nilai_lap ?? '-' }}</th>
                        </tr>
                        <tr>
                            <th class="text-center" colspan="4">INDEKS NILAI</th>
                            <th>{{ $pemagang->indeks_nilai_lap ?? '-' }}</th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@section('page_script')
<script>
</script>
@endsection