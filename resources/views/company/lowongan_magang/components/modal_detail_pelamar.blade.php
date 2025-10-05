<style>
    span.select2-dropdown.select2-dropdown--below {
        width: auto !important;
        max-width: 200px !important;
        position: relative !important;
    }

    #table-sent-email {
        width: 100%;
        border: 2px solid #f0f0f0;
    }

    #table-sent-email th {
        background-color: #f0f0f0;
        border: 2px solid #f0f0f0;
    }

    #table-sent-email td {
        border: 2px solid #f0f0f0;
    }

    .position-relative {
        padding: 0px !important;
    }
</style>
<div class="offcanvas offcanvas-end" tabindex="-1" id="detail_pelamar_offcanvas" style="width: 45%;">
    <div class="offcanvas-header">
        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        <div class="d-flex justify-content-end w-100">
            <a class="btn btn-sm btn-primary" type="button" id="btn_unduh_cv" href="" target="_blank">
                <i class="tf-icons ti ti-file-symlink me-2"></i>
                Unduh Format CV
            </a>
        </div>
    </div>
    <div class="flex-grow-0 pt-1 offcanvas-body h-100" id="container_detail_pelamar"></div>
</div>

<!-- Modal Tambah-->
<div class="modal fade" id="modal-upload-file" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="mx-auto modal-title">Berkas Penerimaan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form class="default-form" action="{{ route('informasi_lowongan.update_status') }}" function-callback="afterUploadBerkas">
                @csrf                
                <div class="pt-2 modal-body">
                    <div class="row">
                        <div class="mb-3 col-12" style="display: none;">
                            <h6 class="mb-2 fw-semibold">Daftar Mahasiswa</h6>
                            <div class="" id="container-list-mhs"></div>
                        </div>
                        <div class="col form-group">
                            <label for="date" class="form-label">Berkas<span class="text-danger">*</span></label>
                            <input type="file" class="form-control" name="file" id="file" accept="application/pdf">
                            <small class="text-right text-muted">Tipe file harus berbentuk .pdf | Ukuran maksimal : 2MB.</small>
                            <div class="invalid-feedback"></div>
                        </div>
                    </div>
                </div>
                <div class="pt-0 modal-footer">
                    <button type="submit" class="btn btn-primary me-0">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>


<div class="offcanvas offcanvas-end" tabindex="-1" id="filter" aria-labelledby="offcanvasAddUserLabel">
    <div class="offcanvas-header">
        <h5 id="offcanvasAddUserLabel" class="offcanvas-title" style="padding-left: 15px;">Filter Berdasarkan
        </h5>
    </div>
    <div class="flex-grow-0 pt-0 mx-0 offcanvas-body h-100">
        <form class="pt-0 add-new-user" id="filter">
            <div class="mb-2 col-12">
                <div class="row">
                    <div class="mb-2 col form-input">
                        <label for="univ" class="form-label" style="padding-left: 15px;">Universitas</label>
                        <select class="form-select select2" id="univ" name="univ" data-placeholder="Pilih Universitas">
                            <option disabled selected>Pilih Universitas</option>
                        </select>
                        <div class="invalid-feedback"></div>
                    </div>
                </div>
                <div class="row">
                    <div class="mb-2">
                        <label for="fakultas" class="form-label" style="padding-left: 15px;">Fakultas</label>
                        <select class="form-select select2" id="fakultas" name="fakultas" data-placeholder="Pilih Fakultas">
                            <option disabled selected>Pilih Fakultas</option>
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="mb-2 col form-input">
                        <label for="univ" class="form-label" style="padding-left: 15px;">Prodi</label>
                        <select class="form-select select2" id="prodi" name="prodi" data-placeholder="Pilih Prodi">
                            <option disabled selected>Pilih Prodi</option>
                        </select>
                        <div class="invalid-feedback"></div>
                    </div>
                </div>
                <div class="row cnt">
                    <div id="div1" class="targetDiv">
                        <div class="mb-2 col form-input">
                            <label for="univ" class="form-label" style="padding-left: 15px;">Status
                                Kandidat</label>
                            <select class="form-select select2" id="status" name="status" data-placeholder="Status Kandidat">
                                <option disabled selected>Pilih Status Kandidat</option>
                            </select>
                            <div class="invalid-feedback"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="mt-3 text-end">
                <button type="button" class="btn btn-label-danger">Reset</button>
                <button type="submit" class="btn btn-success">Terapkan</button>
            </div>
        </form>
    </div>
</div>

<div class="modal fade" id="modal-send-email" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="mx-auto modal-title" id="modal-title">Buat Jadwal Seleksi</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form class="default-form" method="POST" action="{{ route('informasi_lowongan.set_jadwal', $lowongan->id_lowongan) }}" function-callback="afterSetJadwal">
                @csrf
                <input type="hidden" name="tahapan_seleksi">
                <div class="modal-body">
                    <div class="row">
                        <div class="mb-3 col-12 form-group">
                            <label for="tahapan_seleksi" class="form-label">Tahap Seleksi</label>
                            <select class="form-select select2 disable" name="tahapan_seleksi" id="tahapan_seleksi" data-placeholder="Pilih Jenis Tahap" onchange="getKandidat($(this))">
                                <option disabled selected class="mt-1 text-danger">Pilih Jenis Tahap</option>
                                @foreach($tahapValid as $d)
                                    <option value="{{ $loop->iteration }}" data-status="{{ $d['table'] }}">{{ $d['label'] }}</option>
                                @endforeach
                            </select>
                            <div class="invalid-feedback"></div>
                        </div>
                        <div class="mb-3 col-6 form-group">
                            <label for="mulai_date" class="form-label">Mulai</label>
                            <input type="text" class="cursor-pointer form-control flatpickr-date-custom" name="mulai_date" placeholder="Mulai" id="mulai_date" />
                            <div class="invalid-feedback"></div>
                        </div>
                        <div class="mb-3 col-6 form-group">
                            <label for="selesai_date" class="form-label">Selesai</label>
                            <input type="text" class="cursor-pointer form-control flatpickr-date-custom" name="selesai_date" placeholder="Selesai" id="selesai_date" />
                            <div class="invalid-feedback"></div>
                        </div>
                        <div class="mb-3 col-12 form-group">
                            <label for="seleksi" class="form-label">Kandidat</label>
                            <select name="kandidat[]" id="kandidat" multiple="multiple" class="select2 form-select" data-placeholder="Pilih Kandidat" data-tags="true" disabled>
                                <option disabled selected class="mt-1 text-danger">Pilih Kandidat</option>
                            </select>
                            <div class="mt-1 form-check form-check-inline" style="display: none;">
                                <input class="form-check-input" type="checkbox" id="pilih-semua" value="" />
                                <label class="form-check-label small text-secondary" for="pilih-semua">Semua Kandidat <span id="pilih-semua-label"></span></label>
                            </div>
                            <div class="invalid-feedback"></div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="modal-sent-email" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Detail Email Terkirim</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="table-responsive">
                    <table class="table" id="table-sent-email">
                        <thead class="table-light">
                            <tr>
                                <th style="text-align: center;">No</th>
                                <th>Subjek Email</th>
                            </tr>
                        </thead>
                        <tbody id="container-list-sent-email">

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
