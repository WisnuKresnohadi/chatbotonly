<div class="modal fade" id="modalTambahUser" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalTambahMitra">Tambah Pengguna</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form class="default-form" action="{{ route('kelola_pengguna.store') }}" function-callback="afterAction">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="col mb-3 form-group">
                            <label for="name" class="form-label">Nama Pengguna</label>
                            <input type="text" name="name" id="name" class="form-control" placeholder="Masukkan Nama Pengguna" />
                            <div class="invalid-feedback"></div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col mb-3 form-group">
                            <label for="email" class="form-label">Email</label>
                            <input type="text" name="email" id="email" class="form-control" placeholder="Masukan Email" />
                            <div class="invalid-feedback"></div>
                        </div>
                    </div>
                    <label for="role" class="form-label">Role</label>
                    <select id="role" name="role" class="select2 form-select" data-placeholder="Pilih Role">
                        <option value="" selected disabled>Pilih Role</option>
                    </select>
                </div>
                <div class="modal-footer">
                    <button type="submit" id="modal-button" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
