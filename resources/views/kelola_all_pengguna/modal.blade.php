<div class="modal fade" id="modalTambahMitra" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Pengguna</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form class="default-form" function-callback="afterEdit">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12 mb-3 form-group">
                            <label for="name" class="form-label">Nama Pengguna</label>
                            <input type="text" id="name" name="name" class="form-control" placeholder="Masukkan Nama Pengguna" />
                            <div class="invalid-feedback"></div>
                        </div>
                        <div class="col-12 mb-3 form-group">
                            <label for="email" class="form-label">Email</label>
                            <input type="text" id="email" name="email" class="form-control" placeholder="Masukan Email" />
                            <div class="invalid-feedback"></div>
                        </div>
                        <div class="col-12 mb-3 form-group">
                            <label for="role" class="form-label">Role</label>
                            <select id="role" name="role" class="select2 form-select" data-placeholder="Pilih Role">
                                <option value="" disabled selected>Pilih Role</option>
                                @foreach ($roles as $item)
                                    <option value="{{ $item->uuid }}">{{ $item->name }}</option>
                                @endforeach
                            </select>
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
