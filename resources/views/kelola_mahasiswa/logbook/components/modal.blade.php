<!-- Modal Ditolak-->
<div class="modal fade" id="modalDitolak" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header border-bottom">
                <h5 class="modal-title"></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form class="default-form" action="" function-callback="afterApprovalLogbook">
                @csrf
                <input type="hidden" name="status">
                <input type="hidden" name="week">
                <input type="hidden" name="selected_month">
                <div class="modal-body pt-3">
                    <div class="row">
                        <div class="col mb-0 form-group">
                            <label for="reason" class="form-label pb-1">Komentar <span class="text-danger">*</span> </label>
                            <textarea class="form-control" name="rejected_reason" id="reason" rows="4" placeholder="Tulis komentar disini"></textarea>
                            <div class="invalid-feedback">
                                Komentar penolakan harus diisi
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Kirim Komentar</button>
                </div>
            </form>
        </div>
    </div>
</div>