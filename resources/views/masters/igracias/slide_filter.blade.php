{{-- Modal PopUp --}}
<div class="offcanvas offcanvas-end modals" tabindex="-1" id="modalSlide" aria-labelledby="offcanvasAddUserLabel">
    <div class="offcanvas-header">
        <h5 id="offcanvasAddUserLabel" class="offcanvas-title">Filter Berdasarkan</h5>
    </div>
    <div class="offcanvas-body mx-0 flex-grow-0 pt-0 h-100">
        <form class="add-new-user pt-0" id="filter">
            <div class="col-12 mb-2">

                <div class="row">
                    <div class="col mb-2 form-group">
                        <label for="id_univ" class="form-label">Universitas</label>
                        <select class="form-select select2" id="id_univ" name="id_univ" onchange="getDataSelect($(this));" data-after="id_fakultas" data-placeholder="Pilih Universitas" data-select2-id="id-univ-dosen-filter">
                            <option value="" disabled selected>Pilih Universitas</option>
                            @foreach ($universitas as $u)
                                <option value="{{ $u->id_univ }}">{{ $u->namauniv }}</option>
                            @endforeach
                        </select>
                        <div class="invalid-feedback"></div>
                    </div>
                </div>
                <div class="row">
                    <div class="col mb-2 form-group">
                        <label for="id_fakultas" class="form-label">Fakultas</label>
                        <select class="form-select select2" id="id_fakultas" name="id_fakultas" onchange="getDataSelect($(this));" data-after="id_prodi" data-placeholder="Pilih Fakultas" data-select2-id="id-fakultas-dosen-filter">
                            <option value="" disabled selected>Pilih Fakultas</option>
                        </select>
                        <div class="invalid-feedback"></div>
                    </div>
                </div>
                <div class="row">
                    <div class="col mb-2 form-group">
                        <label for="id_prodi" class="form-label">Prodi</label>
                        <select class="form-select select2" id="id_prodi" name="id_prodi" data-placeholder="Pilih Prodi" data-select2-id="id-prodi-dosen-filter">
                            <option value="" disabled selected>Pilih Prodi</option>
                        </select>
                        <div class="invalid-feedback"></div>
                    </div>
                </div>
            </div>
            <div class="mt-3 text-end">
                <button type="reset" class="btn btn-label-danger data-reset" onclick="resetFilter()">Reset</button>
                <button type="submit" class="btn btn-success">Terapkan</button>
            </div>
        </form>
    </div>
</div>