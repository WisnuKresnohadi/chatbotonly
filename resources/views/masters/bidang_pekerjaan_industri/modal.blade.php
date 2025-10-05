<div class="modal fade" id="modal-bidang-pekerjaan" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">

        <div class="modal-content">
            <div class="text-center modal-header d-block">
                <h5 class="modal-title">Tambah Bidang Pekerjaan </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form class="default-form" action="{{ route('bidangpekerjaanindustri.store') }}" function-callback="afterAction">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="mb-2 col form-group">
                            <label for="namabidangpekerjaan" class="form-label">Nama Bidang Pekerjaan<span
                                    class="text-danger">*</span></label>
                            <input type="text" id="namabidangpekerjaan" name="namabidangpekerjaan" class="form-control"
                                placeholder="Nama Bidang Pekerjaan" />
                            <div class="invalid-feedback"></div>
                        </div>                       
                    </div>
                    <div class="row">
                        <div class="mb-2 col form-group">
                            <label class="form-label" for="deskripsi">Deskripsi Bidang Pekerjaan<span
                                    class="text-danger">*</span></label>
                            <textarea class="form-control" rows="4" id="deskripsi" name="deskripsi" placeholder="Masukan Deskripsi Bidang Pekerjaan"></textarea>
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
