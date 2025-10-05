<div class="offcanvas offcanvas-end" tabindex="-1" id="modalSlide" aria-labelledby="offcanvasAddUserLabel">
    <div class="offcanvas-header">
        <h5 id="offcanvasAddUserLabel" class="offcanvas-title">Filter Berdasarkan</h5>
        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body mx-0 flex-grow-0 pt-0 h-100">
        <form class="pt-0" id="filter">
            <div class="col-12 mb-2">
                <div class="row">
                    <div class="col mb-2 form-input">
                        <label for="posisi" class="form-label">Posisi Lowongan Magang</label>
                        <input type="text" class="form-control" name="posisi" id="posisi" placeholder="Posisi Lowongan Magang">
                        <div class="invalid-feedback"></div>
                    </div>
                </div>
                <div class="row">
                    <div class="col mb-2 form-input">
                        <label for="id_prodi" class="form-label">Program Studi</label>
                        <select class="form-select select2" id="id_prodi" name="id_prodi"
                            data-placeholder="Pilih Program Studi">
                            <option disabled selected value="">Pilih Program Studi</option>
                            @foreach ($prodi as $item)
                                <option value="{{ $item->id_prodi }}">{{ $item->namaprodi }}</option>
                            @endforeach
                        </select>
                        <div class="invalid-feedback"></div>
                    </div>
                </div>

                <div class="mt-3 text-end">
                    <button type="reset" class="btn btn-label-danger" id="data-reset">Reset</button>
                    <button type="submit" class="btn btn-success">Terapkan</button>
                </div>
            </div>
        </form>
    </div>
</div>