<div class="modal fade" id="modalRejectLamaran" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title mx-auto">Alasan penolakan data pendaftaran mahasiswa</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form class="default-form" action="" function-callback="afterActionRejected">
                <div class="modal-body">
                    @csrf
                    <div class="row">
                        <div class="col-12 form-group">
                            <label for="reason">Alasan penolakan data pendaftaran mahasiswa <span class="text-danger">*</span></label>
                            <textarea class="form-control" name="reason" id="reason" rows="4"></textarea>
                            <div class="invalid-feedback"></div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="reset" class="btn btn-danger">Batal</button>
                    <button type="submit" class="btn btn-primary me-0">Kirim</button>
                </div>
            </form>
        </div>
    </div>
</div>