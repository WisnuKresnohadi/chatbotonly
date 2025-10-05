<div class="modal fade modals" id="modal-dosen" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">

        <div class="modal-content">
            <div class="text-center modal-header d-block">
                <h5 class="modal-title capitalize-title" id="modal-title">Tambah Dosen</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form class="default-form" action="{{ route('igracias.dosen.store') }}" function-callback="afterAction">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="mb-2 col form-group">
                            <label for="id_univ" class="form-label">Universitas</label>
                            <select class="form-select select2" id="id_univ" name="id_univ" onchange="getDataSelect($(this));" data-after="id_fakultas" data-placeholder="Pilih Universitas" data-select2-id="id-univ-dosen">
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
                            <select class="form-select select2" id="id_fakultas" name="id_fakultas" onchange="getDataSelect($(this));" data-after="id_prodi" data-placeholder="Pilih Fakultas" data-select2-id="id-fakultas-dosen">
                                <option value="" disabled selected>Pilih Fakultas</option>
                            </select>
                            <div class="invalid-feedback"></div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="mb-2 col form-group">
                            <label for="id_prodi" class="form-label">Prodi</label>
                            <select class="form-select select2" id="id_prodi" name="id_prodi" data-placeholder="Pilih Prodi" data-select2-id="id-prodi-dosen">
                                <option value="" disabled selected>Pilih Prodi</option>
                            </select>
                            <div class="invalid-feedback"></div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="mb-2 col form-group">
                            <label for="nip" class="form-label">NIP</label>
                            <input type="text" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');" class="form-control" id="nip" name="nip" placeholder="NIP" />
                            <div class="invalid-feedback"></div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="mb-2 col form-group">
                            <label for="kode_dosen" class="form-label">Kode Dosen</label>
                            <input type="text" id="kode_dosen" name="kode_dosen" class="form-control" placeholder="Kode Dosen" />
                            <div class="invalid-feedback"></div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="mb-2 col form-group">
                            <label for="namadosen" class="form-label">Nama Dosen</label>
                            <input type="text" id="namadosen" name="namadosen" class="form-control" placeholder="Nama Dosen" />
                            <div class="invalid-feedback"></div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="mb-2 col form-group">
                            <label for="nohpdosen" class="form-label">No Telepon</label>
                            <input input type="text"
                                oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');"
                                id="nohpdosen" name="nohpdosen" class="form-control" placeholder="No Telepon" />
                            <div class="invalid-feedback"></div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="mb-2 col form-group">
                            <label for="emaildosen" class="form-label">Email</label>
                            <input type="text" id="emaildosen" name="emaildosen" class="form-control"
                                placeholder="Email" />
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

