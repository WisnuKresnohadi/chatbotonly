<div class="modal fade" id="modal-assign" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="text-center modal-header d-block">
                <h5 class="modal-title">Assign Dosen Pembimbing Akademik</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form class="default-form" action="{{ route('mahasiswa_magang_kaprodi.assign_pem_akademik') }}" function-callback="afterAssigning">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="mb-2 col form-group">
                            <label for="dosen_pembimbing" class="form-label">Dosen Pembimbing<span class="text-danger">*</span></label>
                            <select class="form-select select2" id="dosen_pembimbing" name="dosen_pembimbing" data-placeholder="Pilih Dosen">
                                <option disabled selected>Pilih Dosen</option>
                                @foreach ($dosen as $u)
                                    <option value="{{ $u->nip }}">{{ $u->kode_dosen . ' | ' . $u->namadosen }}</option>
                                @endforeach
                            </select>
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
