<!-- Modal Tambah-->
<div class="modal fade" id="modalTambahJadwal" tabindex="-1" aria-hidden="true" style="display: none">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title mx-auto" id="modal-title">Buat Jadwal Seleksi</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form class="default-form" method="POST" action="{{ $urlSetJadwal }}" function-callback="afterSetJadwal">
                @csrf
                <input type="hidden" name="tahapan_seleksi">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12 mb-3 form-group">
                            <label for="tahapan_seleksi" class="form-label">Jenis Tahap</label>
                            <select class="form-select select2 disable" id="tahapan_seleksi" data-placeholder="Pilih Jenis Tahap" disabled>
                                <option value="" disabled selected>Pilih Jenis Tahap</option>
                                @for ($i = 1; $i <= ($lowongan->tahapan_seleksi+1); $i++)
                                <option value="{{ $i }}">Tahap {{ $i }}</option>
                                @endfor
                            </select>
                            <div class="invalid-feedback"></div>
                        </div>
                        <div class="col-6 mb-3 form-group">
                            <label for="mulai_date" class="form-label">Mulai</label>
                            <input type="text" class="form-control flatpickr-date-custom cursor-pointer" name="mulai_date" placeholder="Mulai" id="mulai_date" />
                            <div class="invalid-feedback"></div>
                        </div>
                        <div class="col-6 mb-3 form-group">
                            <label for="selesai_date" class="form-label">Selesai</label>
                            <input type="text" class="form-control flatpickr-date-custom cursor-pointer" name="selesai_date" placeholder="Selesai" id="selesai_date" />
                            <div class="invalid-feedback"></div>
                        </div>
                        <div class="col-12 mb-3 form-group">
                            <label for="seleksi" class="form-label">Subjek Email</label>
                            <select class="form-select select2" id="subjek" name="subjek" data-placeholder="Pilih Subjek Email" disabled>
                                <option disabled selected class="text-danger mt-1">Pilih Subjek Email!</option>
                            </select>
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

<div class="modal fade" id="modalRejectLamaran" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title mx-auto">Penolakan Pendaftaran Magang</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form class="default-form" action="" function-callback="afterActionRejected">
                <div class="modal-body">
                    @csrf
                    <div class="row">
                        <div class="col-12 form-group">
                            <label for="date" class="form-label">Berkas<span class="text-danger">*</span></label>
                            <input type="file" class="form-control" name="file" id="file">
                            <div class="invalid-feedback"></div>
                        </div>
                        <div class="col-12 form-group mt-3">
                            <label for="reason">Alasan penolakan pendaftaran magang (Opsional)</label>
                            <textarea class="form-control" name="reason" id="reason" rows="4"></textarea>
                            <div class="invalid-feedback"></div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="reset" class="btn btn-danger">Batal</button>
                    <button type="submit" class="btn btn-primary me-0">Kirim</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Tambah-->
<div class="modal fade" id="modal-upload-file" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title mx-auto">Berkas Penerimaan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form class="default-form" action="" function-callback="afterUploadBerkas">
                @csrf
                <div class="modal-body pt-2">
                    <div class="row">
                        <div class="col form-group">
                            <label for="date" class="form-label">Berkas<span class="text-danger">*</span></label>
                            <input type="file" class="form-control" name="file" id="file">
                            <div class="invalid-feedback"></div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer pt-0">
                    <button type="submit" class="btn btn-primary me-0">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>