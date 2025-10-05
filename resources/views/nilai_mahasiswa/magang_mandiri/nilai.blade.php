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
            <a href="{{ route('nilai_mahasiswa.mandiri') }}" type="button" class="btn btn-outline-success mb-3 waves-effect">
                <span class="ti ti-arrow-left me-2"></span>Kembali
            </a>
        </div>
        <div class="col-10">
            <h4 class="fw-bold"><span class="text-muted fw-light"> Nilai Mahasiswa / </span>Detail Nilai Jennie Ruby Jane</h4>
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
                            <th>NOMOR</th>
                            <th>ASPEK PENILAIAN</th>
                            <th style="min-width:400px;">DESKRIPSI ASPEK PENILAIAN</th>
                            <th style="min-width:100px;">BOBOT</th>
                            <th style="min-width:80px;">NILAI</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th class="text-center" colspan="4">TOTAL NILAI</th>
                            <th>50</th>
                        </tr>
                        <tr>
                            <th class="text-center" colspan="4">INDEKS NILAI</th>
                            <th>A</th>
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
                    <tfoot>
                        <tr>
                            <th class="text-center" colspan="4">TOTAL NILAI</th>
                            <th>50</th>
                        </tr>
                        <tr>
                            <th class="text-center" colspan="4">INDEKS NILAI</th>
                            <th>A</th>
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
    var jsonData = [{
            "nomor": "1",
            "aspek_penilain": "Komunikasi, Adaptasi, Kerjasama",
            "deskripsi_aspek_penilain": "Evaluasi kemampuan magang dalam menyampaikan ide, bertanya, dan menjelaskan secara jelas dan efektif.",
            "bobot": "",
            "nilai": "70"
        },
        {
            "nomor": "2",
            "aspek_penilain": "Disiplin dan Tanggung Jawab dalam pengerjaan tugas",
            "deskripsi_aspek_penilain": "Evaluasi kemampuan magang dalam menyampaikan ide, bertanya, dan menjelaskan secara jelas dan efektif.",
            "bobot": "60%",
            "nilai": "30"
        },
        {
            "nomor": "3",
            "aspek_penilain": "Kemampuan/Skill Mahasiswa Sesuai (memenuhi) posisi magang",
            "deskripsi_aspek_penilain": "Evaluasi kemampuan magang dalam menyampaikan ide, bertanya, dan menjelaskan secara jelas dan efektif.",
            "bobot": "",
            "nilai": "30"
        },
    ];
    var table = $('#table-pembimbing-lapangan').DataTable({
        "data": jsonData,
        "paging": false,
        "ordering": false,
        "info": false,
        "searching": false,
        columns: [{
                data: "nomor"
            },
            {
                data: "aspek_penilain"
            },
            {
                data: "deskripsi_aspek_penilain"
            },
            {
                data: "bobot"
            },
            {
                data: "nilai"
            }
        ],
    });

    var jsonData = [{
            "nomor": "1",
            "aspek_penilain": "Buku Laporan Akhir <li>Penulisan dan Tata Bahasa</li><li>Latar Belakang dan Tujuan</li><li>Uraian Mengenai Permasalahan dan Solusinya</li> ",
            "deskripsi_aspek_penilain": "Evaluasi kemampuan magang dalam menyampaikan ide, bertanya, dan menjelaskan secara jelas dan efektif.",
            "bobot": "40%",
            "nilai": "70"
        },
        {
            "nomor": "2",
            "aspek_penilain": "Presentasi dan Tanya Jawab <li>Mahasiswa Mempresentasikan Ruang Lingkup Pekerjaan selama Magang</li> <li>Dosen memberi nilai terkait tingkat kesulitan dan ruang lingkup magang untuk dijadikan dasar penilaian</li>",
            "deskripsi_aspek_penilain": "Evaluasi kemampuan magang dalam menyampaikan ide, bertanya, dan menjelaskan secara jelas dan efektif.",
            "bobot": "",
            "nilai": "30"
        },
    ];
    var table = $('#table-pembimbing-akademik').DataTable({
        "data": jsonData,
        "paging": false,
        "ordering": false,
        "info": false,
        "searching": false,
        columns: [{
                data: "nomor"
            },
            {
                data: "aspek_penilain"
            },
            {
                data: "deskripsi_aspek_penilain"
            },
            {
                data: "bobot"
            },
            {
                data: "nilai"
            }
        ],
    });
</script>
@endsection