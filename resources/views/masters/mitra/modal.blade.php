<!-- Modal -->
<div class="modal fade" id="modalTambahMitra" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">

        <div class="modal-content">
            <div class="modal-header text-center d-block">
                <h5 class="modal-title" id="modal-title">Tambah Industri</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form class="default-form" method="POST" action="{{ route('mitra.store') }}">
                @csrf

                <div class="modal-body">

            <div class="row">
                <div class="col mb-2 form-input">
                    <label for="mitra" class="form-label">Nama Mitra</label>
                    <input type="text" id="mitra" name="namaindustri" class="form-control"
                        placeholder="Nama Mitra" />
                    <div class="invalid-feedback"></div>
                </div>
            </div>
            <div class="row">
                <div class="col mb-2 form-input">
                    <label for="telp" class="form-label">No Telepon</label>
                    <input type="text" id="telp" name="notelepon" class="form-control"
                        placeholder="No Telepon" />
                    <div class="invalid-feedback"></div>
                </div>
            </div>
            <div class="row">
                <div class="col mb-2 form-input">
                    <label for="emai" class="form-label">Email</label>
                    <input type="text" id="email" name="email" class="form-control"
                        placeholder="Email" />
                    <div class="invalid-feedback"></div>
                </div>
            </div>
            <div class="row">
                <div class="col mb-2 form-input">
                    <label for="alamat" class="form-label">Alamat</label>
                    <textarea class="form-control" id="alamat" name="alamatindustri"
                    placeholder="Alamat"></textarea>
                <div class="invalid-feedback"></div>
                </div>
            </div>
            <div class="row">
                <div class="col mb-2">
                    <select class="form-select select2" id="kategori" name="kategorimitra" data-placeholder="Kategori Mitra">
                        <option disabled selected>Pilih Kategori Industri</option>
                        <option value="Internal">Internal</option>
                        <option value="Eksternal">Eksternal</option>
                    </select>
                    <div class="invalid-feedback"></div>
                </div>
            </div>
            <div class="row">
                <div class="col mb-2">
                    <select class="form-select select2" id="status" name="statuskerjasama" data-placeholder="Status Kerjasama">
                        <option disabled selected>Pilih Status Kerjasama</option>
                        <option value="Ya">Ya</option>
                        <option value="Tidak">Tidak</option>
                        <option value="Internal Telyu">Internal Telyu</option>
                    </select>
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
