<div class="modal fade" id="modal-detail-file" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="text-center mb-1">Alasan Penolakan Laporan Akhir Magang</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ $url }}" class="default-form" function-callback="afterReject">
                @csrf
                <input type="hidden" name="status" value="reject">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12 mb-3 form-group">
                            <label for="reason" class="form-label">Alasan Penolakan</label>
                            <textarea type="text" name="reason" id="reason" class="form-control" rows="4" placeholder="Masukkan alasan penolakan"></textarea>
                            <div class="invalid-feedback"></div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary me-0">Kirim</button>
                </div>
            </form>
        </div>
    </div>
</div>