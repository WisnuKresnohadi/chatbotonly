<div class="modal fade" id="modal-spm" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="text-center modal-header d-block">
                <h5 class="modal-title">Upload Dokumen SKM</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form class="default-form" action="{{ route('data_mahasiswa.upload_spm') }}" function-callback="afterUpload">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="mb-3 col-12">
                            <h6 class="mb-2 fw-semibold">Daftar Mahasiswa yang diberikan SKM</h6>
                            <div class="" id="container-list-mhs"></div>
                        </div>
                        <div class="mb-3 col-12">
                            <div class="border-bottom"></div>
                        </div>
                        <div class="mb-3 col-6 form-group">
                            <label for="mulai_magang" class="form-label">Mulai Magang<span class="text-danger">*</span></label>
                            <input type="text" class="cursor-pointer form-control flatpickr-date" name="mulai_magang" id="mulai_magang">
                            <div class="invalid-feedback"></div>
                        </div>
                        <div class="mb-3 col-6 form-group">
                            <label for="selesai_magang" class="form-label">selesai Magang<span class="text-danger">*</span></label>
                            <input type="text" class="cursor-pointer form-control flatpickr-date" name="selesai_magang" id="selesai_magang">
                            <div class="invalid-feedback"></div>
                        </div>
                        <div class="mb-3 col-12 form-group">
                            <label for="dokumen" class="form-label">Dokumen SKM<span class="text-danger">*</span></label>
                            <input type="file" class="form-control" name="dokumen" id="dokumen" accept="application/pdf">
                            <small class="text-right text-muted">Tipe file harus berbentuk .pdf | Ukuran maksimal : 2MB.</small>
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
