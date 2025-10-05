<!-- Modal Dipulangkan-->
<div class="modal fade" id="modalDipulangkan" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form class="default-form" action="" function-callback="afterDeleteMhs">
                @csrf
                <div class="modal-body pt-3">
                    <div class="row">
                        <div class="col-12 mb-3 form-group">
                            <label for="reason_kick" class="form-label">Alasan pemulangan mahasiswa<span class="text-danger">*</span> </label>
                            <textarea class="form-control" id="reason_kick" placeholder="Tulis komentar disini" name="reason_kick" rows="3"></textarea>
                            <div class="invalid-feedback"></div>
                        </div>
                        <div class="col-12 mb-3 form-group">
                            <label for="file" class="form-label">Bukti Memulangkan Mahasiswa<span class="text-danger">*</span></label>
                            <input class="form-control" type="file" id="file" name="file">
                            <div class="invalid-feedback"></div>
                            <small>Allowed PDF. Max size 2 MB</small>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" id="submitPemulanganMahasiswa" class="btn btn-primary">Kirim Komentar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="offcanvas offcanvas-end" tabindex="-1" id="modalSlide" aria-labelledby="offcanvasAddUserLabel">
    <div class="offcanvas-header">
        <h5 id="offcanvasAddUserLabel" class="offcanvas-title">Filter Berdasarkan</h5>
        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body mx-0 flex-grow-0 pt-0 h-100">
        <form class="pt-0" id="filter_form" onsubmit="return false;">
            <div class="col-12 mb-2">
                <div class="row">
                    <div class="mb-2">
                        <label for="posisi" class="form-label">Posisi Magang</label>
                        <input type="text" class="form-control" name="posisi" id="posisi" placeholder="Posisi Magang">
                    </div>
                    <div class="mb-2">
                        <label for="nama/nim" class="form-label">Status</label>
                        <select class="form-select select2" id="status" name="status" data-placeholder="Pilih Status">
                            <option value="">Pilih Status</option>
                            <option value="1">Aktif</option>
                            <option value="2">Non-Aktif</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="mt-3 text-end">
                <button type="reset" class="btn btn-label-danger data-reset">Reset</button>
                <button type="submit" class="btn btn-success">Terapkan</button>
            </div>
        </form>
    </div>
</div>