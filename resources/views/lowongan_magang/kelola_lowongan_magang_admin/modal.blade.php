<div class="offcanvas offcanvas-end" tabindex="-1" id="modalSlide" aria-labelledby="offcanvasAddUserLabel">
    <div class="offcanvas-header">
        <h5 id="offcanvasAddUserLabel" class="offcanvas-title" style="padding-left: 15px;">Filter Berdasarkan</h5>
        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body mx-0 flex-grow-0 pt-0 h-100">
        <form class="pt-0" id="filter_data" onsubmit="return false;">
            <div class="row">
                <div class="col-12 mb-3">
                    <label for="durasimagang" class="form-label">Durasi Magang</label>
                    <select class="form-select select2" id="durasimagang" name="durasimagang" data-placeholder="Pilih Durasi Magang">
                        <option disabled selected>Pilih Durasi Magang</option>
                        <option value="1 Semester">1 Semester</option>
                        <option value="2 Semester">2 Semester</option>
                    </select>
                </div>
                <div class="col-12 mb-3">
                    <label for="posisi" class="form-label">Posisi Lowongan Magang</label>
                    <input type="text" class="form-control" id="posisi" name="posisi" placeholder="Posisi Lowongan Magang">
                </div>
            </div>
            <div class="mt-3 text-end">
                <button type="reset" class="btn btn-label-danger">Reset</button>
                <button type="submit" class="btn btn-primary">Terapkan</button>
            </div>
        </form>
    </div>
</div>

