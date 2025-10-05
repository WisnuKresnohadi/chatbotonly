<div class="modal fade" id="modal-nilai-mutu" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header text-center d-block">
                <h5 class="modal-title" id="modal-title">Tambah Nilai Mutu</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form class="default-form" action="{{ route('nilai-mutu.store') }}" function-callback="afterAction">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="col mb-2 form-group">
                            <label for="minimal" class="form-label">Nilai Minimal</label>
                            <input type="text" id="minimal" class="form-control" name="nilaimin" placeholder="Nilai Minimal" />
                            <div class="invalid-feedback"></div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col mb-2 form-group">
                            <label for="maksimal" class="form-label">Nilai Maksimal</label>
                            <input type="text" id="maksimal" class="form-control" name="nilaimax" placeholder="Nilai Maksimal" />
                            <div class="invalid-feedback"></div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col mb-2 form-group">
                            <label for="mutu" class="form-label">Nilai Mutu</label>
                            <input type="text" id="mutu" class="form-control" onkeyup="this.value = this.value.replace(/[^a-zA-Z\s]+/gi, '').toUpperCase();" name="nilaimutu" placeholder="Nilai Mutu" />
                            <div class="invalid-feedback"></div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col mb-2 form-group">
                            <label for="bobot" class="form-label">Bobot</label>
                            <input type="text" id="bobot" class="form-control" name="bobot" placeholder="Nilai Bobot" />
                            <div class="invalid-feedback"></div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <!-- <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">
                        Close
                    </button> -->
                    <button type="submit" id="modal-button" class="btn btn-success">Simpan</button>
                </div>
            </form>

        </div>
    </div>
</div>