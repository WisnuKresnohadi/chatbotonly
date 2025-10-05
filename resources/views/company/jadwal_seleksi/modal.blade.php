<!-- Modal Slide-->
<div class="offcanvas offcanvas-end" tabindex="-1" id="modalSlide" aria-labelledby="offcanvasAddUserLabel">
    <div class="offcanvas-header">
        <h5 id="offcanvasAddUserLabel" class="offcanvas-title">Filter Berdasarkan</h5>
    </div>
    <div class="offcanvas-body mx-0 flex-grow-0 pt-0 h-100">
        <form class="add-new-user pt-0" id="filter">
            <div class="col-12 mb-2">
                <div class="row">
                    <div class="mb-2">
                        <label for="mulai" class="form-label">Tanggal Seleksi Mulai</label>
                        <input type="text" class="form-control flatpickr-input" placeholder="YYYY-MM-DD" id="flatpickr-date" readonly="readonly">
                    </div>
                </div>
                <div class="row">
                    <div class="mb-2">
                        <label for="seleksi" class="form-label">Progress Seleksi</label>
                        <select class="form-select select2" id="progressfilter" name="progress" data-placeholder="Pilih Status Seleksi">
                            <option disabled selected>Pilih Progress Seleksi</option>
                            <option value="Belum Seleksi">Belum Seleksi</option>
                            <option value="Sudah Seleksi">Sudah Seleksi</option>
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="mb-2">
                        <label for="seleksi" class="form-label">Status Seleksi</label>
                        <select class="form-select select2" id="seleksifilter" name="seleksi" data-placeholder="Pilih Status Seleksi">
                            <option disabled selected>Pilih Status Seleksi</option>
                            <option value="Diterima">Diterima</option>
                            <option value="Ditolak">Ditolak</option>
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