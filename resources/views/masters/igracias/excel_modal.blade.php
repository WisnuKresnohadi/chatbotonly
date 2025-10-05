<div class="modal fade modals" id="modal-excel" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">

        <div class="modal-content">
            <div class="text-center modal-header d-block">
                <h5 class="modal-title" id="modal-title">Import</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form class="default-form" id="" name="excel" method="POST"
                action="" enctype="multipart/form-data" function-callback="AfterActionImport">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="mb-2 col form-group">
                            <label for="id_univ" class="form-label">Universitas</label>
                            <select class="form-select select2" id="id_univ" name="id_univ" onchange="getDataSelect($(this));" data-after="id_fakultas" data-placeholder="Pilih Universitas" data-select2-id="id-univ-excel">
                                <option value="" disabled selected>Pilih Universitas</option>
                                @foreach ($universitas as $u)
                                    <option value="{{ $u->id_univ }}">{{ $u->namauniv }}</option>
                                @endforeach
                            </select>
                            <div class="invalid-feedback"></div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="mb-2 col form-group">
                            <label for="id_fakultas" class="form-label">Fakultas</label>
                            <select class="form-select select2" id="id_fakultas" name="id_fakultas" onchange="getDataSelect($(this));" data-after="id_prodi|kode_dosen_wali" data-placeholder="Pilih Fakultas" data-select2-id="id-fakultas-excel">
                                <option value="" disabled selected>Pilih Fakultas</option>
                            </select>
                            <div class="invalid-feedback"></div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="mb-2 col form-group">
                            <label for="id_prodi" class="form-label">Prodi</label>
                            <select class="form-select select2" id="id_prodi" name="id_prodi" data-placeholder="Pilih Prodi" data-select2-id="id-prodi-excel">
                                <option value="" disabled selected>Pilih Prodi</option>
                                <option value="all">All</option>
                            </select>
                            <div class="invalid-feedback"></div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="mb-2 col form-group">
                            <label for="kode_dosen_wali" class="form-label">Dosen Wali</label>
                            <select class="form-select select2" id="kode_dosen_wali" name="kode_dosen_wali" data-placeholder="Pilih Dosen Wali" data-select2-id="kode_dosen_excel">
                                <option value="" disabled selected>Pilih Prodi</option>
                            </select>
                            <div class="invalid-feedback"></div>
                        </div>
                    </div>
                    <div class="mt-3 row" id="container-template-excel">
                        <div class="col">
                            <a href="" class="btn btn-primary w-100" id="download-template">Download Template</a>
                        </div>
                    </div>
                    <div class="row">
                        <div class="mb-2 col form-group">
                            <input type="file" class="mt-3 form-control upload-excel" id="upload-file-excel"
                            name="import">
                            <div class="invalid-feedback"></div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">
                        Close
                    </button>
                    <button type="submit" id="buttonExcel" class="btn btn-success">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>
