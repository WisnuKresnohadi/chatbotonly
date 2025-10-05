<div class="modal fade modals" id="modal_logbook" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header text-center d-block">
                <h5 class="modal-title" id="modal-title">Buat Logbook Minggu Ini</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form class="default-form" action="{{ route('logbook.create') }}" function-callback="afterCreateLogbook">
                @csrf
                <input type="hidden" name="current_month">
                <div class="modal-body">
                    <div class="row">
                        <div class="col mb-2 form-group">
                            <label for="range_date" class="form-label">Hari aktif minggu ini<span class="text-danger">*</span></label>
                            <input type="text" name="range_date" id="range_date" class="form-control"/>
                            <div class="invalid-feedback"></div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" id="modal-button" class="me-0 btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>