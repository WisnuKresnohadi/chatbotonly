@extends('partials.vertical_menu')

@section('page_style')
@endsection

@section('content')
<div class="d-flex align-items-center justify-content-between mb-3">
    <div>
        <h4 class="fw-bold"><span class="text-muted fw-light">Berkas Akhir Magang / </span>Magang Mandiri Tahun Ajaran 2023/2024</h4>
    </div>
    <div class="d-none d-sm-flex">
        <select class="select2 form-select" data-placeholder="Filter Status">
            <option value="0">2022/2023 Ganjil</option>
            <option value="1">2022/2023 Genap</option>
            <option value="2">2023/2024 Ganjil</option>
            <option value="3">2023/2024 Genap</option>
        </select>
    </div>
</div>

<div class="nav-align-top mb-4">
    <ul class="nav nav-pills mb-3" role="tablist">
        <li class="nav-item">
            <button type="button" class="nav-link active" role="tab" data-bs-toggle="tab" data-bs-target="#navs-pills-top-menunggu-diverifikasi" aria-controls="navs-pills-top-menunggu-diverifikasi" aria-selected="true">
                <i class="ti ti-clock pe-1"></i> Menunggu Diverifikasi
            </button>
        </li>
        <li class="nav-item">
            <button type="button" class="nav-link" role="tab" data-bs-toggle="tab" data-bs-target="#navs-pills-top-tidak-lengkap" aria-controls="navs-pills-top-tidak-lengkap" aria-selected="false">
                <i class="ti ti-clipboard-x pe-1"></i> Tidak Lengkap
            </button>
        </li>
        <li class="nav-item">
            <button type="button" class="nav-link" role="tab" data-bs-toggle="tab" data-bs-target="#navs-pills-top-lengkap" aria-controls="navs-pills-top-lengkap" aria-selected="false">
                <i class="ti ti-clipboard-check pe-1"></i>Lengkap
            </button>
        </li>
    </ul>
    <div class="tab-content p-0">
        <div class="tab-pane fade show active" id="navs-pills-top-menunggu-diverifikasi" role="tabpanel">
            <div class="card">
                <div class="px-3 pt-3 d-flex justify-content-end">
                    <div class="col-3 mb-3">
                        <select class="select2 form-select" data-placeholder="Filter Status">
                            <option value="0" disabled selected>Pilih Program Studi</option>
                            <option value="1">D3 Sistem Informasi</option>
                            <option value="2">D3 Sistem Informasi Akuntansi</option>
                            <option value="3">D3 Rekayasa Perangkat Lunak</option>
                            <option value="4">D3 Teknik Telekomunikasi</option>
                        </select>
                    </div>
                </div>
                <div class="card-datatable table-responsive">
                    <table class="table table-menunggu-diverifikasi" id="table-menunggu-diverifikasi">
                        <thead>
                            <tr>
                                <th style="min-width: 50px;">NOMOR</th>
                                <th style="min-width: 200px;">NAMA/NIM</th>
                                <th style="min-width: 500px;">BERKAS AKHIR MAGANG</th>
                                <th style="min-width: 500px;">TIMESTAP PENGUMPULAN BERKAS AKHIR MAGANG</th>
                                <th style="min-width: 150px;">KETEPATAN WAKTU PENGUMPULAN</th>
                                <th style="min-width: 100px;">NILAI AKHIR</th>
                                <th style="min-width: 100px;">INDEKS</th>
                                <th style="min-width: 200px;">ALASAN PENGURANGAN NILAI</th>
                                <th style="min-width: 50px;">AKSI</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
        <div class="tab-pane fade" id="navs-pills-top-tidak-lengkap" role="tabpanel">
            <div class="card">
                <div class="px-3 pt-3 d-flex justify-content-end">
                    <div class="col-3 mb-3">
                        <select class="select2 form-select" data-placeholder="Filter Status">
                            <option value="0" disabled selected>Pilih Program Studi</option>
                            <option value="1">D3 Sistem Informasi</option>
                            <option value="2">D3 Sistem Informasi Akuntansi</option>
                            <option value="3">D3 Rekayasa Perangkat Lunak</option>
                            <option value="4">D3 Teknik Telekomunikasi</option>
                        </select>
                    </div>
                </div>
                <div class="card-datatable table-responsive">
                    <table class="table table-tidak-lengkap" id="table-tidak-lengkap">
                        <thead>
                            <tr>
                                <th style="min-width: 50px;">NOMOR</th>
                                <th style="min-width: 200px;">NAMA/NIM</th>
                                <th style="min-width: 500px;">BERKAS AKHIR MAGANG</th>
                                <th style="min-width: 500px;">TIMESTAP PENGUMPULAN BERKAS AKHIR MAGANG</th>
                                <th style="min-width: 150px;">KETEPATAN WAKTU PENGUMPULAN</th>
                                <th style="min-width: 100px;">NILAI AKHIR</th>
                                <th style="min-width: 100px;">INDEKS</th>
                                <th style="min-width: 200px;">ALASAN PENGURANGAN NILAI</th>
                                <th style="min-width: 50px;">AKSI</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
        <div class="tab-pane fade" id="navs-pills-top-lengkap" role="tabpanel">
            <div class="card">
                <div class="px-3 pt-3 d-flex justify-content-end">
                    <div class="col-3 mb-3">
                        <select class="select2 form-select" data-placeholder="Filter Status">
                            <option value="0" disabled selected>Pilih Program Studi</option>
                            <option value="1">D3 Sistem Informasi</option>
                            <option value="2">D3 Sistem Informasi Akuntansi</option>
                            <option value="3">D3 Rekayasa Perangkat Lunak</option>
                            <option value="4">D3 Teknik Telekomunikasi</option>
                        </select>
                    </div>
                </div>
                <div class="card-datatable table-responsive">
                    <table class="table table-lengkap" id="table-lengkap">
                        <thead>
                            <tr>
                                <th style="min-width: 50px;">NOMOR</th>
                                <th style="min-width: 200px;">NAMA/NIM</th>
                                <th style="min-width: 500px;">BERKAS AKHIR MAGANG</th>
                                <th style="min-width: 500px;">TIMESTAP PENGUMPULAN BERKAS AKHIR MAGANG</th>
                                <th style="min-width: 150px;">KETEPATAN WAKTU PENGUMPULAN</th>
                                <th style="min-width: 100px;">NILAI AKHIR</th>
                                <th style="min-width: 100px;">INDEKS</th>
                                <th style="min-width: 200px;">ALASAN PENGURANGAN NILAI</th>
                                <th style="min-width: 50px;">AKSI</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalCenter" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <h5 class="text-center mb-3" id="modalCenterTitle">Pengurangan Nilai Akhir Mahasiswa</h5>
                <div class="row">
                    <div class="col-12 mb-3">
                        <label for="nilai-akhir" class="form-label">Nilai Akhir Mahasiswa</label>
                        <input type="text" id="nilai-akhir" class="form-control" placeholder="90" disabled />
                    </div>
                    <div class="col-12 mb-3">
                        <label for="nilai" class="form-label">Pengurangan Nilai</label>
                        <input type="text" id="nilai" class="form-control" placeholder="10" />
                    </div>
                    <div class="col-12 mb-3">
                        <label for="alasan" class="form-label">Alasan Pengurangan Nilai</label>
                        <textarea type="text" id="alasan" class="form-control" placeholder="Masukkan alasan pengurangan nilai"></textarea>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-success">Simpan Perubahan</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalDetail" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalCenterTitle">Detail Jennie Ruby Jane</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body pt-2">
                <div class="row">
                    <div class="col-6"><h5>NIM:</h5></div>
                    <div class="col-6">6701213025</div>
                    <div class="col-6 mt-1"><h5>Nama:</h5></div>
                    <div class="col-6 mt-1">Jennie Ruby Jane</div>
                    <div class="col-6 mt-1"><h5>Program Studi:</h5></div>
                    <div class="col-6 mt-1">D3 Sistem Informasi</div>
                    <div class="col-6 mt-1"><h5>Nama Perusahaan:</h5></div>
                    <div class="col-6 mt-1">Techno Infinity</div>
                    <div class="col-6 mt-1"><h5>Posisi Magang:</h5></div>
                    <div class="col-6 mt-1">UI/UX Designer</div>
                    <div class="col-6 mt-1"><h5>Tanggal mulai magang:</h5></div>
                    <div class="col-6 mt-1">03 Juni 2023</div>
                    <div class="col-6 mt-1"><h5>Tanggal Akhir magang:</h5></div>
                    <div class="col-6 mt-1">03 Juli 2023</div>
                    <div class="col-6 mt-1"><h5>Pembimbing Lapangan:</h5></div>
                    <div class="col-6 mt-1">Mark Lee</div>
                    <div class="col-6 mt-1"><h5>Pembimbing Akademik:</h5></div>
                    <div class="col-6 mt-1">Lee Haechan</div>
                    <div class="col-6 mt-1"><h5>Dokumen penerimaan:</h5></div>
                    <div class="col-6 mt-1"><a href="" class="text-success">Bukti penerimaan.pdf</a></div>
                </div>
            </div>
        </div>
    </div>
</div>




@endsection

@section('page_script')
<script>
    var jsonData = [{
            "nomor": "1",
            "nama/nim": "<div class='row'><div class='col-2 btn-icon' data-bs-toggle='modal'data-bs-target='#modalDetail' style='cursor: pointer;'><i class='tf-icons ti ti-chevron-right'></i></div> <div class='col-8 p-0'><u class='text-success' style='cursor: pointer;' data-bs-toggle='modal'data-bs-target='#modalDetail'>Jennie Ruby Jane</u><p class='mb-0'>6701250405</p></div></div>",
            "berkas_akhir": "<div class='row'><div class='col-8 mb-2 pe-0'><a href = '/laporan-magang-mahasiswa/mandiri' class = 'text-success'>Laporan Akhir Magang.pdf: </a></div> <div class = 'col-4 mb-2 p-0'><span class = 'badge bg-label-warning' > Menunggu Diverifikasi </span></div><div class = 'col-8 pe-0'><a href = '/laporan-magang-mahasiswa/mandiri' class = 'text-success'>Dokumen Implementasi Pelaksanaan.pdf:</a></div><div class = 'col-4 p-0'> <span class = 'badge bg-label-warning'> Menunggu Diverifikasi</span></div></div>",
            "timestap_pengumpulan": "<div class='row'><div class='col-8 mb-2 pe-0'><a href = '/laporan-magang-mahasiswa/mandiri' class = 'text-success'>Laporan Akhir Magang.pdf: </a></div> <div class = 'col-4 mb-2 p-0'><span> 20/02/2024  23.59 </span></div><div class = 'col-8 pe-0'><a href = '/laporan-magang-mahasiswa/mandiri' class = 'text-success'>Dokumen Implementasi Pelaksanaan.pdf:</a></div><div class = 'col-4 p-0'> <span> 20/02/2024  23.59</span></div></div>",
            "ketepatan_pengumpulan": "<span class ='badge bg-label-success'>Tepat Waktu</span>",
            "nilai_akhir": "90",
            "indeks": "A",
            "alasan_pengurangan_nilai": "Lorem Ipsum dolor sit amet",
            "aksi": "<p class='btn-icon text-warning waves-effect waves-light' data-bs-toggle='modal'data-bs-target='#modalCenter'><i class='tf-icons ti ti-file-invoice'></i></p>",
        },
        {
            "nomor": "2",
            "nama/nim": "<div class='row'><div class='col-2 btn-icon' data-bs-toggle='modal'data-bs-target='#modalDetail' style='cursor: pointer;'><i class='tf-icons ti ti-chevron-right'></i></div> <div class='col-8 p-0'><u class='text-success' style='cursor: pointer;' data-bs-toggle='modal'data-bs-target='#modalDetail'>Jennie Ruby Jane</u><p class='mb-0'>6701250405</p></div></div>",
            "berkas_akhir": "<div class='row'><div class='col-8 mb-2 pe-0'><a href = '/laporan-magang-mahasiswa/mandiri' class = 'text-success'>Laporan Akhir Magang.pdf: </a></div> <div class = 'col-4 mb-2 p-0'><span class = 'badge bg-label-warning' > Menunggu Diverifikasi </span></div><div class = 'col-8 pe-0'><a href = '/laporan-magang-mahasiswa/mandiri' class = 'text-success'>Dokumen Implementasi Pelaksanaan.pdf:</a></div><div class = 'col-4 p-0'> <span class = 'badge bg-label-warning'> Menunggu Diverifikasi</span></div></div>",
            "timestap_pengumpulan": "<div class='row'><div class='col-8 mb-2 pe-0'><a href = '/laporan-magang-mahasiswa/mandiri' class = 'text-success'>Laporan Akhir Magang.pdf: </a></div> <div class = 'col-4 mb-2 p-0'><span> 20/02/2024  23.59 </span></div><div class = 'col-8 pe-0'><a href = '/laporan-magang-mahasiswa/mandiri' class = 'text-success'>Dokumen Implementasi Pelaksanaan.pdf:</a></div><div class = 'col-4 p-0'> <span> 20/02/2024  23.59</span></div></div>",
            "ketepatan_pengumpulan": "<span class ='badge bg-label-danger' >Terlambat Diserahkan </span>",
            "nilai_akhir": "90",
            "indeks": "A",
            "alasan_pengurangan_nilai": "Lorem Ipsum dolor sit amet",
            "aksi": "<p class='btn-icon text-warning waves-effect waves-light' data-bs-toggle='modal'data-bs-target='#modalCenter'><i class='tf-icons ti ti-file-invoice'></i></p>",
        },
    ];

    var table = $('#table-menunggu-diverifikasi').DataTable({
        "data": jsonData,
        scrollX: true,
        columns: [{
                data: "nomor"
            },
            {
                data: "nama/nim"
            },
            {
                data: "berkas_akhir"
            },
            {
                data: "timestap_pengumpulan"
            },
            {
                data: "ketepatan_pengumpulan"
            },
            {
                data: "nilai_akhir"
            },
            {
                data: "indeks"
            },
            {
                data: "alasan_pengurangan_nilai"
            },
            {
                data: "aksi"
            }
        ],
        "columnDefs": [{
                "width": "50px",
                "targets": 0
            },
            {
                "width": "200px",
                "targets": 1
            },
            {
                "width": "500px",
                "targets": 2
            },
            {
                "width": "500px",
                "targets": 3
            },
            {
                "width": "150px",
                "targets": 4
            },
            {
                "width": "100px",
                "targets": 5
            },
            {
                "width": "100px",
                "targets": 6
            },
            {
                "width": "200px",
                "targets": 7
            },
            {
                "width": "50px",
                "targets": 8
            },
        ],
    });
</script>
<script>
    var jsonData = [{
            "nomor": "1",
            "nama/nim": "<div class='row'><div class='col-2 btn-icon' data-bs-toggle='modal'data-bs-target='#modalDetail' style='cursor: pointer;'><i class='tf-icons ti ti-chevron-right'></i></div> <div class='col-8 p-0'><u class='text-success' style='cursor: pointer;' data-bs-toggle='modal'data-bs-target='#modalDetail'>Jennie Ruby Jane</u><p class='mb-0'>6701250405</p></div></div>",
            "berkas_akhir": "<div class='row'><div class='col-8 mb-2 pe-0'><a href = '/laporan-magang-mahasiswa/mandiri' class = 'text-success'>Laporan Akhir Magang.pdf: </a></div> <div class = 'col-4 mb-2 p-0'><span class = 'badge bg-label-danger' > Tidak Lengkap</span></div><div class = 'col-8 pe-0'><a href = '/laporan-magang-mahasiswa/mandiri' class = 'text-success'>Dokumen Implementasi Pelaksanaan.pdf:</a></div><div class = 'col-4 p-0'> <span class = 'badge bg-label-success'> Lengkap </span></div></div>",
            "timestap_pengumpulan": "<div class='row'><div class='col-8 mb-2 pe-0'><a href = '/laporan-magang-mahasiswa/mandiri' class = 'text-success'>Laporan Akhir Magang.pdf: </a></div> <div class = 'col-4 mb-2 p-0'><span> 20/02/2024  23.59 </span></div><div class = 'col-8 pe-0'><a href = '/laporan-magang-mahasiswa/mandiri' class = 'text-success'>Dokumen Implementasi Pelaksanaan.pdf:</a></div><div class = 'col-4 p-0'> <span> 20/02/2024  23.59</span></div></div>",
            "ketepatan_pengumpulan": "<span class ='badge bg-label-danger' >Terlambat Diserahkan </span>",
            "nilai_akhir": "90",
            "indeks": "A",
            "alasan_pengurangan_nilai": "Lorem Ipsum dolor sit amet",
            "aksi": "<p class='btn-icon text-warning waves-effect waves-light' data-bs-toggle='modal'data-bs-target='#modalCenter'><i class='tf-icons ti ti-file-invoice'></i></p>",
        },
        {
            "nomor": "2",
            "nama/nim": "<div class='row'><div class='col-2 btn-icon' data-bs-toggle='modal'data-bs-target='#modalDetail' style='cursor: pointer;'><i class='tf-icons ti ti-chevron-right'></i></div> <div class='col-8 p-0'><u class='text-success' style='cursor: pointer;' data-bs-toggle='modal'data-bs-target='#modalDetail'>Jennie Ruby Jane</u><p class='mb-0'>6701250405</p></div></div>",
            "berkas_akhir": "<div class='row'><div class='col-8 mb-2 pe-0'><a href = '/laporan-magang-mahasiswa/mandiri' class = 'text-success'>Laporan Akhir Magang.pdf: </a></div> <div class = 'col-4 mb-2 p-0'><span class = 'badge bg-label-success' > Lengkap </span></div><div class = 'col-8 pe-0'><a href = '/laporan-magang-mahasiswa/mandiri' class = 'text-success'>Dokumen Implementasi Pelaksanaan.pdf:</a></div><div class = 'col-4 p-0'> <span class = 'badge bg-label-danger'> Tidak Lengkap</span></div></div>",
            "timestap_pengumpulan": "<div class='row'><div class='col-8 mb-2 pe-0'><a href = '/laporan-magang-mahasiswa/mandiri' class = 'text-success'>Laporan Akhir Magang.pdf: </a></div> <div class = 'col-4 mb-2 p-0'><span> 20/02/2024  23.59 </span></div><div class = 'col-8 pe-0'><a href = '/laporan-magang-mahasiswa/mandiri' class = 'text-success'>Dokumen Implementasi Pelaksanaan.pdf:</a></div><div class = 'col-4 p-0'> <span> 20/02/2024  23.59</span></div></div>",
            "ketepatan_pengumpulan": "<span class ='badge bg-label-danger' >Terlambat Diserahkan </span>",
            "nilai_akhir": "90",
            "indeks": "A",
            "alasan_pengurangan_nilai": "Lorem Ipsum dolor sit amet",
            "aksi": "<p class='btn-icon text-warning waves-effect waves-light' data-bs-toggle='modal'data-bs-target='#modalCenter'><i class='tf-icons ti ti-file-invoice'></i></p>",
        },
    ];

    var table = $('#table-tidak-lengkap').DataTable({
        "data": jsonData,
        scrollX: true,
        columns: [{
                data: "nomor"
            },
            {
                data: "nama/nim"
            },
            {
                data: "berkas_akhir"
            },
            {
                data: "timestap_pengumpulan"
            },
            {
                data: "ketepatan_pengumpulan"
            },
            {
                data: "nilai_akhir"
            },
            {
                data: "indeks"
            },
            {
                data: "alasan_pengurangan_nilai"
            },
            {
                data: "aksi"
            }
        ],
        "columnDefs": [{
                "width": "50px",
                "targets": 0
            },
            {
                "width": "200px",
                "targets": 1
            },
            {
                "width": "500px",
                "targets": 2
            },
            {
                "width": "500px",
                "targets": 3
            },
            {
                "width": "150px",
                "targets": 4
            },
            {
                "width": "100px",
                "targets": 5
            },
            {
                "width": "100px",
                "targets": 6
            },
            {
                "width": "200px",
                "targets": 7
            },
            {
                "width": "50px",
                "targets": 8
            },
        ],
    });
</script>
<script>
    var jsonData = [{
            "nomor": "1",
            "nama/nim": "<div class='row'><div class='col-2 btn-icon' data-bs-toggle='modal'data-bs-target='#modalDetail' style='cursor: pointer;'><i class='tf-icons ti ti-chevron-right'></i></div> <div class='col-8 p-0'><u class='text-success' style='cursor: pointer;' data-bs-toggle='modal'data-bs-target='#modalDetail'>Jennie Ruby Jane</u><p class='mb-0'>6701250405</p></div></div>",
            "berkas_akhir": "<div class='row'><div class='col-8 mb-2 pe-0'><a href = '/laporan-magang-mahasiswa/mandiri' class = 'text-success'>Laporan Akhir Magang.pdf: </a></div> <div class = 'col-4 mb-2 p-0'><span class = 'badge bg-label-success' > Tepat Waktu</span></div><div class = 'col-8 pe-0'><a href = '/laporan-magang-mahasiswa/mandiri' class = 'text-success'>Dokumen Implementasi Pelaksanaan.pdf:</a></div><div class = 'col-4 p-0'> <span class = 'badge bg-label-success'> Tepat Waktu </span></div></div>",
            "timestap_pengumpulan": "<div class='row'><div class='col-8 mb-2 pe-0'><a href = '/laporan-magang-mahasiswa/mandiri' class = 'text-success'>Laporan Akhir Magang.pdf: </a></div> <div class = 'col-4 mb-2 p-0'><span> 20/02/2024  23.59 </span></div><div class = 'col-8 pe-0'><a href = '/laporan-magang-mahasiswa/mandiri' class = 'text-success'>Dokumen Implementasi Pelaksanaan.pdf:</a></div><div class = 'col-4 p-0'> <span> 20/02/2024  23.59</span></div></div>",
            "ketepatan_pengumpulan": "<span class ='badge bg-label-success'>Tepat Waktu</span>",
            "nilai_akhir": "90",
            "indeks": "A",
            "alasan_pengurangan_nilai": "-",
            "aksi": "<p class='btn-icon text-warning waves-effect waves-light' data-bs-toggle='modal'data-bs-target='#modalCenter'><i class='tf-icons ti ti-file-invoice'></i></p>",
        },
        {
            "nomor": "2",
            "nama/nim": "<div class='row'><div class='col-2 btn-icon' data-bs-toggle='modal'data-bs-target='#modalDetail' style='cursor: pointer;'><i class='tf-icons ti ti-chevron-right'></i></div> <div class='col-8 p-0'><u class='text-success' style='cursor: pointer;' data-bs-toggle='modal'data-bs-target='#modalDetail'>Jennie Ruby Jane</u><p class='mb-0'>6701250405</p></div></div>",
            "berkas_akhir": "<div class='row'><div class='col-8 mb-2 pe-0'><a href = '/laporan-magang-mahasiswa/mandiri' class = 'text-success'>Laporan Akhir Magang.pdf: </a></div> <div class = 'col-4 mb-2 p-0'><span class = 'badge bg-label-success' > Tepat Waktu</span></div><div class = 'col-8 pe-0'><a href = '/laporan-magang-mahasiswa/mandiri' class = 'text-success'>Dokumen Implementasi Pelaksanaan.pdf:</a></div><div class = 'col-4 p-0'> <span class = 'badge bg-label-success'> Tepat Waktu </span></div></div>",
            "timestap_pengumpulan": "<div class='row'><div class='col-8 mb-2 pe-0'><a href = '/laporan-magang-mahasiswa/mandiri' class = 'text-success'>Laporan Akhir Magang.pdf: </a></div> <div class = 'col-4 mb-2 p-0'><span> 20/02/2024  23.59 </span></div><div class = 'col-8 pe-0'><a href = '/laporan-magang-mahasiswa/mandiri' class = 'text-success'>Dokumen Implementasi Pelaksanaan.pdf:</a></div><div class = 'col-4 p-0'> <span> 20/02/2024  23.59</span></div></div>",
            "ketepatan_pengumpulan": "<span class ='badge bg-label-success'>Tepat Waktu</span>",
            "nilai_akhir": "90",
            "indeks": "A",
            "alasan_pengurangan_nilai": "-",
            "aksi": "<p class='btn-icon text-warning waves-effect waves-light' data-bs-toggle='modal'data-bs-target='#modalCenter'><i class='tf-icons ti ti-file-invoice'></i></p>",
        },
    ];

    var table = $('#table-lengkap').DataTable({
        "data": jsonData,
        scrollX: true,
        columns: [{
                data: "nomor"
            },
            {
                data: "nama/nim"
            },
            {
                data: "berkas_akhir"
            },
            {
                data: "timestap_pengumpulan"
            },
            {
                data: "ketepatan_pengumpulan"
            },
            {
                data: "nilai_akhir"
            },
            {
                data: "indeks"
            },
            {
                data: "alasan_pengurangan_nilai"
            },
            {
                data: "aksi"
            }
        ],
        "columnDefs": [{
                "width": "50px",
                "targets": 0
            },
            {
                "width": "200px",
                "targets": 1
            },
            {
                "width": "500px",
                "targets": 2
            },
            {
                "width": "500px",
                "targets": 3
            },
            {
                "width": "150px",
                "targets": 4
            },
            {
                "width": "100px",
                "targets": 5
            },
            {
                "width": "100px",
                "targets": 6
            },
            {
                "width": "200px",
                "targets": 7
            },
            {
                "width": "50px",
                "targets": 8
            },
        ],
    });
</script>
@endsection