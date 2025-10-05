<div class="modal fade" id="modal-nilai-akhir" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header text-center d-block">
                <h5 class="modal-title">Tambah Presentase Nilai Akhir</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form class="default-form" action="{{ route('nilai_akhir.store') }}" function-callback="afterAction">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="col mb-2 form-group">
                            <label for="id_prodi" class="form-label">Program Studi<span class="text-danger">*</span></label>
                            <select class="form-select select2" name="id_prodi" id="id_prodi" data-placeholder="Pilih Program Studi">
                                <option value="" selected disabled>Pilih Program Studi</option>
                                @foreach ($prodi as $item)
                                    <option value="{{ $item->id_prodi }}">{{ $item->namaprodi }}</option>
                                @endforeach
                            </select>
                            <div class="invalid-feedback"></div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col mb-2 form-group">
                            <label for="nilai_pemb_lap" class="form-label">Presentase Nilai Pembimbing Lapangan (%)<span class="text-danger">*</span></label>
                            <input type="text" id="nilai_pemb_lap" class="form-control" name="nilai_pemb_lap" placeholder="Presentase Nilai Pembimbing Lapangan" />
                            <div class="invalid-feedback"></div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col mb-2 form-group">
                            <label for="nilai_pemb_akademik" class="form-label">Presentase Nilai Pembimbing Akademis (%)<span class="text-danger">*</span></label>
                            <input type="text" id="nilai_pemb_akademik" class="form-control" name="nilai_pemb_akademik" placeholder="Presentase Nilai Pembimbing Akademis" />
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