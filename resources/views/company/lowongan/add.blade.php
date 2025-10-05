@extends('partials_admin.template')

@section('page_style')
    <link rel="stylesheet" href="../../app-assets/vendor/libs/sweetalert2/sweetalert2.css" />
    <style>

    </style>
@endsection

@section('main')
    <div class="row ">
            <div class="">
                <h4 class="fw-bold text-sm"><span class="text-muted fw-light text-xs">Lowongan Magang / </span>
                    Tambah Lowongan Magang
                </h4>
            </div>
        </div>

    <div class="row">
        <div class="col-xl">
            <div class="card mb-4">
                <div class="card-body">
                    <form>
                        <div class="mb-3">
                            <label for="select2Success" class="form-label">Tahun Ajaran
                                <span style="color: red;">*</span>
                            </label>
                            <div class="select2-success">
                                <select id="select2Success" class="select2 form-select"
                                    data-placeholder="Pilih Tahun Ajaran" multiple>
                                    <option value="1">2023/2024 - Ganjil</option>
                                    <option value="2">2023/2024 - Genap</option>
                                    <option value="3">2023/2024 - Ganjil</option>
                                    <option value="4">2023/2024 - Genap</option>
                                    <option value="3">2023/2024 - Ganjil</option>
                                    <option value="4">2023/2024 - Genap</option>
                                </select>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label" for="basic-default-company">
                                Posisi
                                <span style="color: red;">*</span>
                            </label>
                            <input type="text" class="form-control" id="basic-default-company"
                                placeholder="Masukan Posisi Pekerjaan" />
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="basic-default-company">
                                Kuota Penerimaan
                                <span style="color: red;">*</span>
                            </label>
                            <input type="text" class="form-control" id="basic-default-company"
                                placeholder="Masukkan Kuota Penerimaan" />
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="basic-default-company">
                                Industri Pekerjaan *
                                <span style="color: red;">*</span>
                            </label>
                            <input type="text" class="form-control" id="basic-default-company"
                                placeholder="Masukkan Industri Pekerjaan" />
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="basic-default-company">
                                Deskripsi Pekerjaan
                                <span style="color: red;">*</span>
                            </label>
                            <input type="text" class="form-control" id="basic-default-company"
                                placeholder="Masukkan Deskripsi Pekerjaan" />
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="basic-default-company">
                                Requirements
                                <span style="color: red;">*</span>
                            </label>
                            <input type="text" class="form-control" id="basic-default-company"
                                placeholder="Masukkan Kualifikasi Mahasiswa" />
                        </div>
                        <div class="mb-3">
                            <div class="border py-2 px-3 rounded-3">
                                <label class="form-label" for="basic-default-company">
                                    Kualifikasi Pendidikan
                                </label>
                                <div class="mb-2">
                                    <label class="form-label" for="basic-default-company">
                                        Fakultas
                                        <span style="color: red;">*</span>
                                    </label>
                                    <select id="select2basic" class="selectpicker w-100" data-style="btn-default"
                                        placeholder="Pilih Fakultas">
                                        <option>2023/2024 - Ganjil</option>
                                        <option>2023/2024 - Genap</option>
                                    </select>
                                </div>

                                <div class="mb-2 select2-success">
                                    <label class="form-label" for="basic-default-company">
                                        Program Studi
                                        <span style="color: red;">*</span>
                                    </label>
                                    <select id=" select2-success" class=" select2 form-select"
                                        data-placeholder="Pilih Program Studi" data-live-search="true" multiple>
                                        <option value="1">2023/2024 - Ganjil</option>
                                        <option value="2">2023/2024 - Genap</option>
                                        <option value="3">2023/2024 - Ganjil</option>
                                        <option value="4">2023/2024 - Genap</option>
                                        <option value="3">2023/2024 - Ganjil</option>
                                        <option value="4">2023/2024 - Genap</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="mb-3 select2-success">
                            <label for="select2-success" class="form-label">Keterampilan</label>
                            <select id="select2-success" class="select2 form-select" data-placeholder="Pilih Keterampilan"
                                multiple>
                                <option>PHP</option>
                                <option>JS</option>
                                <option>HTML</option>
                                <option>CSS</option>
                            </select>
                            <label for="" style="font-size: 13px">Jika keterampilan belum terdaftar silahkan ketik
                                manual</label>
                        </div>
                        <div class="mb-3">
                            <label class="switch switch-success">
                                <input type="checkbox" class="switch-input" />
                                <span class="switch-toggle-slider">
                                    <span class="switch-on"></span>
                                    <span class="switch-off"></span>
                                </span>
                                <span class="switch-label">Tidak Berbayar</span>
                            </label>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="multicol-first-name">Gaji DItawarkan
                                <span style="color: red;">*</span>
                            </label>
                            <div style="display: flex; justify-content: space-between; align-items: center;">

                                <div style="flex: 1;">

                                    <input type="text" id="multicol-first-name" class="form-control"
                                        placeholder="Gaji Minimum" style="width: 100%;" />
                                </div>
                                <div
                                    style="text-align: center; background-color: black; width: 14px; height: 1px; margin: 0 20px">
                                </div>
                                <div style="flex: 1;">
                                    <input type="text" id="multicol-last-name" class="form-control"
                                        placeholder="Gaji Maksimum" style="width: 100%;" />
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label" for="basic-default-message">Benefits (Addtional)</label>
                            <textarea id="basic-default-message" class="form-control" placeholder="Masukan kualifikasi mahasiswa"></textarea>
                        </div>

                        <div class="mb-3">
                            <label for="select2Success" class="form-label">Lokasi Pekerjaan</label>
                            <div class="select2-success">
                                <select id="select2success" class="select2 form-select"
                                    data-placeholder="Masukan Lokasi Pekerjaan" multiple>
                                    <option value="1">Bandung</option>
                                    <option value="2">Jakarta</option>
                                    <option value="3">Garut</option>
                                    <option value="4">Bungbulang</option>
                                </select>
                            </div>
                        </div>

                        <div class="mb-3">
                            <div style="display: flex; justify-content: space-between; align-items: center;">
                                <div style="flex: 1;">
                                    <label class="form-label" for="multicol-first-name">Tanggal Lowongan Ditayangkan
                                        <span style="color: red;">*</span>
                                    </label>
                                    <input class="form-control" type="date" placeholder="Masukan Tanggal Diturunkan"
                                        id="html5-date-input" />

                                </div>
                                <div
                                    style="text-align: center; background-color: black; width: 14px; height: 1px; margin: 0 20px">
                                </div>
                                <div style="flex: 1;">
                                    <label class="form-label" for="multicol-first-name">Tanggal Lowongan Ditayangkan
                                        <span style="color: red;">*</span>
                                    </label>
                                    <input class="form-control" type="date" placeholder="Masukan Tanggal Diturunkan"
                                        id="html5-date-input" />
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label" for="multicol-first-name">Tanggal Lowongan Ditayangkan
                                <span style="color: red;">*</span>
                            </label>
                            <div class="select2-success">
                                <select id="select2Primary" class="select2 form-select" multiple>
                                    <option value="1">1 Semester</option>
                                    <option value="2">2 Semester</option>
                                </select>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-check-label">Address Type</label>
                            <div class="col mt-2">
                                <div class="form-check form-check-inline">
                                    <input name="collapsible-address-type" class="form-check-input" type="radio"
                                        value="" id="collapsible-address-type-home" checked />
                                    <label class="form-check-label" for="collapsible-address-type-home">1</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input name="collapsible-address-type" class="form-check-input" type="radio"
                                        value="" id="collapsible-address-type-home" />
                                    <label class="form-check-label" for="collapsible-address-type-home">2</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input name="collapsible-address-type" class="form-check-input" type="radio"
                                        value="" id="collapsible-address-type-home" />
                                    <label class="form-check-label" for="collapsible-address-type-home">3</label>
                                </div>

                            </div>
                        </div>

                        <div class="mb-3 d-flex justify-content-end">
                            <button type="submit" class="btn btn-success">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('page_script')
    <script src="../../app-assets/vendor/libs/jquery-repeater/jquery-repeater.js"></script>
    <script src="../../app-assets/js/forms-extras.js"></script>
    <script>
        var jsonData = [{
                "posisi": "UI/UX Designer",
                "fakultas": "Ilmu terapan",
                "jurusan": "D3 Informatika <br> D3 Informatika",
                "tanggal": "<div class='flex'><small class='text-light fw-semibold'>Publish</small><h6>20 september 2023</h6><small class='text-light fw-semibold '>Takedown</small><h6>11 Desember 2024</h6></div>",
                "durasi_magang": "2 Semester",
                "status": "<span class='badge bg-label-danger'>Non-aktif</span>",
                "aksi": "<a class='btn-icon text-success waves-effect waves-light'><i class='ti ti-file-invoice'></i></a> <a class='btn-icon text-danger waves-effect waves-light'><i class='ti ti-trash'></i></a>",
            },
            {
                "posisi": "UI/UX Designer",
                "fakultas": "Ilmu terapan",
                "jurusan": "D3 Informatika <br> D3 Informatika",
                "tanggal": "<div class='flex'><small class='text-light fw-semibold'>Publish</small><h6>20 september 2023</h6><small class='text-light fw-semibold '>Takedown</small><h6>11 Desember 2024</h6></div>",
                "durasi_magang": "2 Semester",
                "status": "<span class='badge bg-label-success'>Aktif</span>",
                "aksi": "<a href='/edit'class='btn-icon text-warning waves-effect waves-light'><i class='ti ti-edit'></i></a><a href='/detail-lowongan' class='btn-icon text-success waves-effect waves-light'><i class='ti ti-file-invoice'></i></a> <a class='btn-icon text-danger waves-effect waves-light'><i class='ti ti-trash'></i></a>",
            },
            {
                "posisi": "UI/UX Designer   ",
                "fakultas": "Ilmu terapan",
                "jurusan": "D3 Informatika <br> D3 Informatika",
                "tanggal": "<div class='flex'><small class='text-light fw-semibold'>Publish</small><h6>20 september 2023</h6><small class='text-light fw-semibold '>Takedown</small><h6>11 Desember 2024</h6></div>",
                "durasi_magang": "2 Semester",
                "status": "<span class='badge bg-label-danger'>Non-aktif</span>",
                "aksi": "<a href='/edit'class='btn-icon text-warning waves-effect waves-light'><i class='ti ti-edit'></i></a><a href='/detail-lowongan' class='btn-icon text-success waves-effect waves-light'><i class='ti ti-file-invoice'></i></a> <a class='btn-icon text-danger waves-effect waves-light'><i class='ti ti-trash'></i></a>",
            }
        ];

        var table = $('#table-kelola-mitra1').DataTable({
            "data": jsonData,
            columns: [{
                    data: "posisi"
                },
                {
                    data: "fakultas"
                },
                {
                    data: "jurusan"
                },

                {
                    data: "tanggal"
                },
                {
                    data: "durasi_magang"
                },
                {
                    data: "status"
                },
                {
                    data: "aksi"
                }
            ]
        });
    </script>


    <script src="../../app-assets/vendor/libs/sweetalert2/sweetalert2.js"></script>
    <script src="../../app-assets/js/extended-ui-sweetalert2.js"></script>
@endsection
