<div class="modal fade modals" id="modal-mata-kuliah" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">

        <div class="modal-content">
            <div class="modal-header text-center d-block">
                <h5 class="modal-title capitalize-title" id="modal-title">Tambah Mata Kuliah</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form class="default-form" action="{{ route('igracias.matakuliah.store') }}" function-callback="afterAction">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="col mb-2 form-group">
                            <label for="kode_mk" class="form-label">Kode Mata Kuliah</label>
                            <input type="text" id="kode_mk" name="kode_mk" class="form-control" placeholder="Kode Mata Kuliah" />
                            <div class="invalid-feedback"></div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col mb-2 form-group">
                            <label for="namamk" class="form-label">Nama Mata Kuliah</label>
                            <input type="text" id="namamk" name="namamk" class="form-control" placeholder="Nama Mata Kuliah" />
                            <div class="invalid-feedback"></div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col mb-2 form-group">
                            <label for="id_univ" class="form-label">Universitas</label>
                            <select class="form-select select2" id="id_univ" name="id_univ" onchange="getDataSelect($(this));" data-after="id_fakultas" data-placeholder="Pilih Universitas" data-select2-id="id-univ-mata-kuliah">
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
                            <select class="form-select select2" id="id_fakultas" name="id_fakultas" onchange="getDataSelect($(this));" data-after="id_prodi" data-placeholder="Pilih Fakultas" data-select2-id="id-fakultas-mata-kuliah">
                                <option value="" disabled selected>Pilih Fakultas</option>
                            </select>
                            <div class="invalid-feedback"></div>
                        </div>
                    </div>    
                    <div class="row">
                        <div class="col mb-2 form-group">
                            <label for="id_prodi" class="form-label">Prodi</label>
                            <select class="form-select select2" id="id_prodi" name="id_prodi" data-placeholder="Pilih Prodi" data-select2-id="id-prodi-mata-kuliah">
                                <option value="" disabled selected>Pilih Prodi</option>
                            </select>
                            <div class="invalid-feedback"></div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col mb-2 form-group">
                            <label for="sks" class="form-label">Total SKS</label>
                            <input type="number" oninput="this.value = Math.max(Math.min(this.value, 20), 0);" class="form-control" id="sks" name="sks" placeholder="Masukkan SKS" min="1" max="20" />
                            <div class="invalid-feedback"></div>
                        </div>
                    </div>      
                </div>                                                                                      
                <div class="modal-footer">
                    <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">
                        Close
                    </button>
                    <button type="submit" id="modal-button" class="btn btn-success">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade modals" id="modal-mata-kuliah-import" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">

        <div class="modal-content">
            <div class="modal-header text-center d-block">
                <h5 class="modal-title" id="modal-title">Import</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form class="default-form" id="" name="import" method="POST"
                action="{{ route('igracias.matakuliah.import') }}" enctype="multipart/form-data" function-callback="AfterActionImport">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="col mb-2 form-group">
                            <label for="id_univ" class="form-label">Universitas</label>
                            <select class="form-select select2" id="id_univ" name="id_univ" onchange="getDataSelect($(this));" data-after="id_fakultas" data-placeholder="Pilih Universitas" data-select2-id="id-univ-mata-kuliah-import">
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
                            <select class="form-select select2" id="id_fakultas" name="id_fakultas" onchange="getDataSelect($(this));" data-after="id_prodi" data-placeholder="Pilih Fakultas" data-select2-id="id-fakultas-mata-kuliah-import">
                                <option value="" disabled selected>Pilih Fakultas</option>
                            </select>
                            <div class="invalid-feedback"></div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col mb-2 form-group">
                            <label for="id_prodi" class="form-label">Prodi</label>
                            <select class="form-select select2" id="id_prodi" name="id_prodi" data-placeholder="Pilih Prodi" data-select2-id="id-prodi-mata-kuliah-import">
                                <option value="" disabled selected>Pilih Prodi</option>
                            </select>
                            <div class="invalid-feedback"></div>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col">
                            <a href="{{ asset('template-excel/Template_Import_Matakuliah.xlsx') }}" class="btn btn-primary w-100" id="download-template">Download Template</a>
                        </div>
                    </div>          
                    <input type="file" class="form-control mt-3" id="basic-default-upload-file" required=""
                        name="import">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">
                        Close
                    </button>
                    <button type="submit" id="buttonImport" class="btn btn-success">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>
