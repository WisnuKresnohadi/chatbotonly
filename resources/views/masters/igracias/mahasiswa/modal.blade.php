<div class="modal fade modals" id="modal-mahasiswa" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">

        <div class="modal-content">
            <div class="text-center modal-header d-block">
                <h5 class="modal-title capitalize-title" id="modal-title">Tambah Mahasiswa</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form class="default-form" action="{{ route('igracias.mahasiswa.store') }}" function-callback="afterAction">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="mb-2 col form-group">
                            <label for="id_univ" class="form-label">Universitas</label>
                            <select class="form-select select2" id="id_univ" name="id_univ" onchange="getDataSelect($(this));" data-after="id_fakultas" data-placeholder="Pilih Universitas" data-select2-id="id-univ-mahasiswa">
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
                            <select class="form-select select2" id="id_fakultas" name="id_fakultas" onchange="getDataSelect($(this));" data-after="id_prodi|kode_dosen_wali" data-placeholder="Pilih Fakultas" data-select2-id="id-fakultas-mahasiswa">
                                <option value="" disabled selected>Pilih Fakultas</option>
                            </select>
                            <div class="invalid-feedback"></div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="mb-2 col form-group">
                            <label for="id_prodi" class="form-label">Prodi</label>
                            <select class="form-select select2" id="id_prodi" name="id_prodi" data-placeholder="Pilih Prodi" data-select2-id="id-prodi-mahasiswa">
                                <option value="" disabled selected>Pilih Prodi</option>
                            </select>
                            <div class="invalid-feedback"></div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="mb-2 col form-group">
                            <label for="kode_dosen_wali" class="form-label">Dosen Wali</label>
                            <select class="form-select select2" id="kode_dosen_wali" name="kode_dosen_wali" data-placeholder="Pilih Dosen Wali" data-select2-id="kode_dosen_wali">
                                <option value="" disabled selected>Pilih Dosen Wali</option>
                            </select>
                            <div class="invalid-feedback"></div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="mb-2 col form-group">
                            <label for="nim" class="form-label">NIM</label>
                            <input type="text" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');"
                                class="form-control" id="nim" name="nim" placeholder="6798374637" />
                            <div class="invalid-feedback"></div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="mb-2 col form-group">
                            <label for="tunggakan" class="form-label">Tunggakan BPP</label>
                            <div class="from-group">
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="tunggakan_bpp" id="tunggakan_bpp1" value="Iya">
                                    <label class="form-check-label" for="tunggakan_bpp1">Ya</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="tunggakan_bpp" id="tunggakan_bpp2" value="Tidak">
                                    <label class="form-check-label" for="tunggakan_bpp2">Tidak</label>
                                </div>
                            </div>
                            <div class="invalid-feedback"></div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="mb-2 col form-group">
                            <label for="ipk" class="form-label">IPK</label>
                            <input type="text" id="ipk" name="ipk" class="form-control"
                            oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1').replace(/^(\d{1,3})(\.\d{0,2})?.*/, '$1$2');"                                placeholder="3.80" />
                            <div class="invalid-feedback"></div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="mb-2 col form-group">
                            <label for="eprt" class="form-label">Eprt</label>
                            <input type="text"
                                oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');"
                                type="text" id="eprt" name="eprt" class="form-control"
                                placeholder="600" />
                            <div class="invalid-feedback"></div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="mb-2 col form-group">
                            <label for="tak" class="form-label">TAK</label>
                            <input type="text"
                                oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');"
                                type="text" id="tak" name="tak" class="form-control"
                                placeholder="600" />
                            <div class="invalid-feedback"></div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="mb-2 col form-group">
                            <label for="angkatan" class="form-label">Angkatan</label>
                            <input type="text" id="angkatan" name="angkatan" class="form-control yearpicker" placeholder="Angkatan" readonly />
                            <div class="invalid-feedback"></div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="mb-2 col form-group">
                            <label for="namamhs" class="form-label">Nama Mahasiswa</label>
                            <input type="text" id="namamhs" name="namamhs" class="form-control"
                                placeholder="Nama Mahasiswa" />
                            <div class="invalid-feedback"></div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="mb-2 col form-group">
                            <label for="nohpmhs" class="form-label">No Telepon</label>
                            <input type="text"
                                oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');"
                                type="text" id="nohpmhs" name="nohpmhs" class="form-control"
                                placeholder="No Telepon" />
                            <div class="invalid-feedback"></div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="mb-2 col form-group">
                            <label for="emailmhs" class="form-label">Email</label>
                            <input type="text" id="emailmhs" name="emailmhs" class="form-control"
                                placeholder="Email" />
                            <div class="invalid-feedback"></div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="mb-2 col form-group">
                            <label for="alamatmhs" class="form-label">Alamat</label>
                            <textarea class="form-control" name="alamatmhs" id="alamatmhs" placeholder="Alamat"></textarea>
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
