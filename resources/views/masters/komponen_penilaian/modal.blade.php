<!-- modal tambah -->
<div class="modal fade" id="modal-komponen-nilai" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document" style="max-width:1000px;">

        <div class="modal-content">
            <div class="modal-header text-center d-block">
                <h5 class="modal-title" id="modal-title">Tambah Komponen Penilaian</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="col-12">
                <div class="card">
                    <div class="card-body" id="container-form">
                        <form class="default-form" method="POST" action="{{ route('komponen-penilaian.store') }}" function-callback="afterAction">
                            @csrf
                            <div class="row">
                                <div class="mb-3 col-12 form-group">
                                    <label for="id_jenismagang" class="form-label">Jenis Magang<span style="color: red;">*</span></label>
                                    <select name="id_jenismagang" class="form-select select2" data-placeholder="Jenis Magang" id="id_jenismagang">
                                        <option value="">Jenis Magang</option>
                                        @foreach ($id_jenismagang as $u)
                                            <option value="{{ $u->id_jenismagang }}">{{ $u->namajenis }} ({{ $u->durasimagang }})</option>
                                        @endforeach
                                    </select>
                                    <div class="invalid-feedback"></div>
                                </div>
                            </div>
                            <hr />
                            <div class="form-repeater">
                                <div data-repeater-list="komponen">
                                    <div data-repeater-item data-callback="afterShown">
                                        <div class="row">
                                            <div class="mb-3 form-group col-xl-4 mb-0">
                                                <label class="form-label" for="aspek_penilaian">Aspek Penilaian<span style="color: red;">*</span></label>
                                                <textarea name="aspek_penilaian" id="aspek_penilaian" class="form-control" rows="4" placeholder="Buku Laporan Akhir&#10; - Penulisan dan Tata Bahasa &#10; - Latar Belakang dan Tujuan"></textarea>
                                                <div class="invalid-feedback"></div>
                                            </div>
                                            <div class="mb-3 form-group col-xl-4 mb-0">
                                                <label class="form-label" for="deskripsi_penilaian">Deskripsi Aspek Penilaian<span style="color: red;">*</span></label>
                                                <textarea name="deskripsi_penilaian" id="deskripsi_penilaian" rows="4" class="form-control" placeholder="Evaluasi kemampuan magang dalam menyampaikan ide, bertanya, dan menjelaskan secara jelas dan efektif."></textarea>
                                                <div class="invalid-feedback"></div>
                                            </div>
                                            <div class="mb-3 form-group col-xl-4 mb-0">
                                                <label class="form-label" for="scored_by">Dinilai Oleh</label>
                                                <select name="scored_by" id="scored_by" class="form-select select2" data-placeholder="Dinilai Oleh">
                                                    <option value="">Dinilai Oleh</option>
                                                    <option value="1">Pembimbing Akademik</option>
                                                    <option value="2">Pembimbing Lapangan</option>
                                                </select>
                                                <div class="invalid-feedback"></div>
                                            </div>
                                            <div class="mb-3 form-group col-xl-4 mb-0">
                                                <label class="form-label" for="nilai_max">Nilai Maksimal<span style="color: red;">*</span></label>
                                                <input type="text" name="nilai_max" id="nilai_max" class="form-control" placeholder="30" />
                                                <div class="invalid-feedback"></div>
                                            </div>
                                            <div class="mb-3 col-lg-12 col-xl-1 col-12 mb-0 p-0">
                                                <button type="button" class="btn btn-label-danger mt-4" data-repeater-delete>
                                                    <i class="ti ti-trash"></i>
                                                </button>
                                            </div>
                                        </div>
                                        <hr />
                                    </div>
                                </div>
                                <div class="mb-0" id="container-add-row">
                                    <button class="btn btn-outline-primary" type="button" data-repeater-create>
                                        <i class="ti ti-plus me-1"></i>
                                        <span class="align-middle">Data</span>
                                    </button>
                                </div>
                            </div>
                            <div class="modal-footer px-0">
                                <button type="submit" id="modal-button" class="btn btn-primary mx-0">Simpan</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

