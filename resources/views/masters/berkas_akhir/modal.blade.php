<!-- modal tambah-->
<div class="modal fade" id="modalTambah" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header text-center d-block">
                <h5 class="modal-title" id="modal-title">Tambah Master Laporan Akhir Magang</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form class="default-form" method="POST" action="{{ route('laporan-akhir.store') }}">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="mb-3 col-12 mb-0 form-input">
                            <label for="jenis" class="form-label">Jenis Magang<span style="color: red;">*</span></label>
                            <select name="jenismagang" id="jenismagang" class="form-select select2" data-placeholder="Pilih Jenis Magang">
                                <option value="">Pilih Jenis Magang</option>
                                @foreach($jenis as $data)
                                <option value="{{ $data->id_jenismagang }}">{{ $data->namajenis}}</option>
                                @endforeach
                            </select>
                            <div class="invalid-feedback"></div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="mb-3 col-12 mb-0 form-input">
                            <label for="durasi" class="form-label">Durasi Magang<span style="color: red;">*</span></label>
                            <select name="durasimagang" id="durasimagang" class="form-select select2" data-placeholder="Pilih Durasi Magang">
                                <option value="">Durasi Magang</option>
                                <option value="1 Semester">1 Semester</option>
                                <option value="2 Semester">2 Semester</option>
                            </select>
                            <div class="invalid-feedback"></div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="mb-3 col-12 mb-0 form-input">
                            <label for="berkas_magang" class="form-label"> Berkas Magang<span style="color: red;">*</span></label>

                            <div class="select2-success">
                                <select name="berkas[]" id="berkas_magang" class="select2 form-select" multiple="multiple">

                                </select>
                            </div>

                            <!-- <input type="text" id="berkas_magang" name="berkas" placeholder=" " class="form-control"> -->

                            <small class="form-text text-muted">*Pisahkan kata kunci dengan Enter</small>
                            <div class="invalid-feedback"></div>

                        </div>
                    </div>
                    <div class="row">
                        <div class="mb-3 col-12 mb-0 form-input">
                            <label for="flatpickr-datetime" class="form-label">Tenggat Pengumpulan Berkas Magang<span style="color: red;">*</span></label>
                            <input type="text" class="form-control flatpickr-input" data-date-format="d M Y" name="pengumpulan" placeholder="YYYY-MM-DD HH:MM" id="flatpickr-datetime" readonly="readonly">
                            <div class="invalid-feedback"></div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="mb-3 col-12 mb-0 form-input">
                            <label for="flatpickr-datetime2" class="form-label">Tenggat Penilaian Berkas Magang<span style="color: red;">*</span></label>
                            <input type="text" class="form-control flatpickr-input" data-date-format="d M Y" name="penilaian" placeholder="YYYY-MM-DD HH:MM" id="flatpickr-datetime2" readonly="readonly">
                            <div class="invalid-feedback"></div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" id="modal-button" class="btn btn-success">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>