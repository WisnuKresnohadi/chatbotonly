<!-- Modal -->
<div class="modal fade" id="modalTambahPegawai" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">

        <div class="modal-content">
            <div class="modal-header text-center d-block">
                <h5 class="modal-title" id="modal-title">Tambah Pegawai Industri</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form class="default-form" action="{{ route('pegawaiindustri.store') }}" function-callback="afterAction">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12 form-group mb-2">
                            <label for="namapeg" class="form-label">Nama Pegawai</label>
                            <input type="text" id="namapegawai" name="namapeg" class="form-control" placeholder="Nama Pegawai" />
                            <div class="invalid-feedback"></div>
                        </div>
                        <div class="col-12 form-group mb-2">
                            <label for="telp" class="form-label">No Telepon</label>
                            <input type="text" id="telp" name="nohppeg" class="form-control" placeholder="No Telepon" />
                            <div class="invalid-feedback"></div>
                        </div>
                        <div class="col-12 form-group mb-2">
                            <label for="email" class="form-label">Email</label>
                            <input type="text" id="email" name="emailpeg" class="form-control" placeholder="Email" />
                            <div class="invalid-feedback"></div>
                        </div>
                        <div class="col-12 form-group mb-2">
                            <label for="jabatan" class="form-label">Jabatan</label>
                            <input type="text" id="jabatan" name="jabatan" class="form-control" placeholder="Jabatan" />
                            <div class="invalid-feedback"></div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" id="modal-button" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
