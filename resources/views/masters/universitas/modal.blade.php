<div class="modal fade" id="modal-universitas" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">

        <div class="modal-content">
            <div class="modal-header text-center d-block">
                <h5 class="modal-title">Tambah Universitas</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form class="default-form" action="{{ route('universitas.store') }}" function-callback="afterAction">
                @csrf
                <div class="modal-body">

                    <div class="row">
                        <div class="col mb-2 form-group">
                            <label for="universitas" class="form-label">Nama Universitas<span class="text-danger">*</span></label>
                            <input type="text" id="namauniv" onkeyup="this.value = this.value.replace(/[^a-zA-Z\s]+/gi, '');" name="namauniv" class="form-control" placeholder="Nama Universitas" />
                            <div class="invalid-feedback"></div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col mb-2 form-group">
                            <label for="jalan" class="form-label">Alamat<span class="text-danger">*</span></label>
                            <textarea class="form-control" id="jalan" name="jalan" rows="3" placeholder="Alamat"></textarea>
                            <div class="invalid-feedback"></div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col mb-2 form-group">
                            <label for="kota" class="form-label">Kota<span class="text-danger">*</span></label>
                            <input type="text" id="kota" onkeyup="this.value = this.value.replace(/[^a-zA-Z\s]+/gi, '');" name="kota" class="form-control" placeholder="Kota" />
                            <div class="invalid-feedback"></div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col mb-2 form-group">
                            <label for="telp" class="form-label">Telp</label>
                            <input type="text" id="telp" name="telp" class="form-control" placeholder="telp" />
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