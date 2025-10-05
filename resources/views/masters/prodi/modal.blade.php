<div class="modal fade container-outer" id="modalTambahProdi" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header text-center d-block">
                <h5 class="modal-title" id="modal-title">Tambah Prodi</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form class="default-form" action="{{ route('prodi.store') }}" function-callback="afterAction">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12 my-1 form-group">
                            <label for="id_univ" class="form-label">Universitas</label>
                            <select class="form-select select2" id="id_univ" name="id_univ" onchange="getDataSelect($(this));" data-after="id_fakultas" data-placeholder="Pilih Universitas"  data-select2-id="id_univ_form">
                                <option disabled selected>Pilih Universitas</option>
                                @foreach ($universitas as $u)
                                    <option value="{{ $u->id_univ }}">{{ $u->namauniv }}</option>
                                @endforeach
                            </select>
                            <div class="invalid-feedback"></div>
                        </div>
                        <div class="col-12 my-1 form-group">
                            <label for="id_fakultas" class="form-label">Fakultas</label>
                            <select class="form-select select2" id="id_fakultas" name="id_fakultas" data-placeholder="Pilih Fakultas" data-select2-id="id_fakultas_form">
                                <option disabled selected>Pilih Fakultas</option>
                            </select>
                            <div class="invalid-feedback"></div>
                        </div>
                        <div class="col-12 my-1 form-group">
                            <label for="jenjang" class="form-label">Jenjang</label>
                            <select class="form-select select2" id="jenjang" name="jenjang" data-placeholder="Pilih Jenjang">
                                <option disabled selected>Pilih Jenjang</option>
                                <option value="D3">D3</option>
                                <option value="D4">D4</option>
                                <option value="S1">S1</option>
                                <option value="S2">S2</option>
                            </select>
                            <div class="invalid-feedback"></div>
                        </div>
                        <div class="col-12 my-1 form-group">
                            <label for="namaprodi" class="form-label">Nama Prodi</label>
                            <input type="text" name="namaprodi" id="namaprodi" class="form-control" placeholder="Nama Prodi" />
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

{{-- Modal PopUp --}}
<div class="offcanvas offcanvas-end container-outer" tabindex="-1" id="modalSlide" aria-labelledby="offcanvasAddUserLabel">
    <div class="offcanvas-header">
        <h5 id="offcanvasAddUserLabel" class="offcanvas-title">Filter Berdasarkan</h5>
        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body mx-0 flex-grow-0 pt-0 h-100">
        <form class="add-new-user pt-0" id="filter_form">
            <div class="col-12 mb-2">
                <div class="row">
                    <div class="col mb-2">
                        <label for="univ" class="form-label">Universitas</label>
                        <select class="form-select select2" data-after="id_fakultas" id="univ" name="univ" onchange="getDataSelect($(this))" data-placeholder="Pilih Universitas">
                            <option disabled selected value="">Pilih Universitas</option>
                            @foreach ($universitas as $u)
                                <option value="{{ $u->id_univ }}">{{ $u->namauniv }}</option>
                            @endforeach
                        </select>
                        <div class="invalid-feedback"></div>
                    </div>
                </div>
                <div class="row">
                    <div class="mb-2">
                        <label for="id_fakultas" class="form-label">Fakultas</label>
                        <select class="form-select select2" data-after="id_prodi" id="id_fakultas" name="id_fakultas" onchange="getDataSelect($(this))" data-placeholder="Pilih Fakultas">
                            <option disabled selected value="">Pilih Fakultas</option>
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="col mb-2">
                        <label for="id_prodi" class="form-label">Prodi</label>
                        <select class="form-select select2" id="id_prodi" name="id_prodi" data-placeholder="Pilih Prodi">
                            <option disabled selected value="">Pilih Prodi</option>
                        </select>
                        <div class="invalid-feedback"></div>
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
