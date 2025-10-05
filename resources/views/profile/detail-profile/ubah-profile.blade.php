<div class="modal fade modals" id="largeModal">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="largeModalLabel">Ubah Data Profile</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form class="default-form" action="{{ route('profile_detail.update_data') }}" function-callback="afterAction">
                @csrf
                    @if (auth()->user()->hasAnyRole(['Dosen', 'Kaprodi', 'Koordinator Magang']))
                    <div class="modal-body">
                        <h5 class="mb-1">Informasi Pribadi</h5>
                        <div class="row">
                            <div class="my-2 col-6 form-group">
                                <label for="id_univ" class="">Universitas</label>
                                <select class="form-select select2" disabled name="id_univ">
                                </select>
                                <div class="invalid-feedback"></div>
                            </div>
                            <div class="my-2 col-6 form-group">
                                <label for="id_fakultas" class="">Fakultas</label>
                                <select class="form-select select2" disabled name="id_fakultas">
                                </select>
                                <div class="invalid-feedback"></div>
                            </div>
                            <div class="my-2 col-6 form-group">
                                <label for="id_prodi" class="">Program Studi</label>
                                <select class="form-select select2" disabled name="id_prodi">
                                </select>
                                <div class="invalid-feedback"></div>
                            </div>
                            <div class="my-2 col-6 form-group">
                                <label for="nip">NIP
                                    <span class="text-danger">*</span>
                                </label>
                                <input class="form-control" type="text" name="nip" id="nip"
                                    placeholder="Masukkan Nama Dosen">
                                <div class="invalid-feedback"></div>
                            </div>
                            <div class="my-2 col-6 form-group">
                                <label for="kode_dosen">Kode Dosen
                                    <span class="text-danger">*</span>
                                </label>
                                <input class="form-control" type="text" name="kode_dosen" id="kode_dosen"
                                    placeholder="Masukkan Nama Dosen">
                                <div class="invalid-feedback"></div>
                            </div>
                            <div class="my-2 col-6 form-group">
                                <label for="name">Nama Dosen
                                    <span class="text-danger">*</span>
                                </label>
                                <input class="form-control" type="text" name="name" id="name"
                                    placeholder="Masukkan Nama Dosen">
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>
                        <h5 class="mt-3 mb-1">Kontak</h5>
                        <div class="row">
                            <div class="col-6 form-group">
                                <label for="nohp">No Telp
                                    <span class="text-danger">*</span>
                                </label>
                                <input type="text" name="nohp" id="nohp" placeholder="Masukkan No Telp"
                                    class="form-control">
                                <div class="invalid-feedback"></div>
                            </div>
                            <div class="col-6 form-group">
                                <label for="email">Email
                                    <span class="text-danger">*</span>
                                </label>
                                <input type="text" class="form-control" name="email" id="email"
                                    placeholder="Masukkan Email">
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>
                    </div>
                    @elseif (auth()->user()->hasAnyRole(['Mitra', 'Pembimbing Lapangan']))
                    <div class="modal-body">
                        <div class="row">
                            <div class="my-2 col-6 form-group">
                                <label for="name">Nama Pegawai
                                    <span class="text-danger">*</span>
                                </label>
                                <input type="text" class="form-control" name="name" id="name" placeholder="Masukkan Nama Pegawai">
                                <div class="invalid-feedback"></div>
                            </div>
                            <div class="my-2 col-6 form-group">
                                <label for="nohp">
                                    No Telp
                                    <span class="text-danger">*</span>
                                </label>
                                <input type="text" class="form-control" name="nohp" id="nohp" placeholder="Masukan No Telp">
                                <div class="invalid-feedback"></div>
                            </div>
                            <div class="my-2 col-6 form-group">
                                <label for="email">Email
                                    <span class="text-danger">*</span>
                                </label>
                                <input type="text" class="form-control" name="email" id="email" placeholder="Masukkan Email">
                                <div class="invalid-feedback"></div>
                            </div>
                            <div class="my-2 col-6 form-group">
                                <label for="jabatan">Jabatan
                                    <span class="text-danger">*</span>
                                </label>
                                <input type="text" class="form-control" name="jabatan" id="jabatan" placeholder="Masukkan Jabatan" disabled>
                            </div>
                        </div>
                    </div>
                    @elseif (auth()->user()->hasAnyRole(['LKM', 'Super Admin']))
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-6 form-group">
                                <label for="email">Email
                                    <span class="text-danger">*</span>
                                </label>
                                <input type="text" class="form-control" name="email"id="email" placeholder="Masukkan Email">
                                <div class="invalid-feedback"></div>
                            </div>
                            <div class="col-6 form-group">
                                <label for="name">
                                    Nama
                                    <span class="text-danger">*</span>
                                </label>
                                <input type="text" class="form-control" name="name" id="name" placeholder="Masukan Nama">
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>
                    </div>
                    @endif
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
