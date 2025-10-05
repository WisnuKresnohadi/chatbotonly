<div class="offcanvas offcanvas-end" tabindex="-1" id="modalSlide" aria-labelledby="offcanvasAddUserLabel">
    <div class="offcanvas-header">
        <h5 id="offcanvasAddUserLabel" class="offcanvas-title">Filter Berdasarkan</h5>
    </div>
    <div class="offcanvas-body mx-0 flex-grow-0 pt-0 h-100">
        <form class="add-new-user pt-0" id="filter">
            <div class="col-12 mb-2">
                <div class="row">
                    {{-- <div class="mb-2">
                        <label for="posisi" class="form-label">Posisi Magang</label>
                        <select class="form-select select2" id="posisi" name="posisi" data-placeholder="Pilih Posisi Magang">
                            <option value="">Pilih Posisi Magang</option>
                        </select>
                    </div> --}}
                    <div class="mb-2">
                        <label for="status" class="form-label">Status</label>
                        <select class="form-select select2" id="status" name="status" data-placeholder="Pilih Status">
                            <option value="">Pilih Status</option>
                            <option value="1">Aktif</option>
                            <option value="0">Non-Aktif</option>
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