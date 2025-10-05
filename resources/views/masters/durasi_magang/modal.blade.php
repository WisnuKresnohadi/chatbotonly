<div class="modal fade" id="modal-durasi-magang" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">

        <div class="modal-content">
            <div class="modal-header text-center d-block">
                <h5 class="modal-title">Tambah Durasi Magang</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form class="default-form" action="{{ route('durasimagang.store') }}" function-callback="afterAction">
                @csrf
                <div class="modal-body">                    
                    <div class="row">
                        <div class="col mb-2 form-group">
                            <label for="name" class="form-label">Nama Durasi Magang<span class="text-danger">*</span></label>
                            <input type="text" id="name" name="name" class="form-control" placeholder="Nama Durasi Magang" />
                            <div class="invalid-feedback"></div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">
                        Close
                    </button>
                    <button type="submit" id="modal-button" class="btn btn-primary">Simpan</button>
                </div>
            </form>

        </div>
    </div>
</div>
