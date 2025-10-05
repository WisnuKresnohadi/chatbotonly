<div class="modal fade" id="modal-adjustment-nilai" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="mx-auto">Pengurangan Nilai Akhir Mahasiswa</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="" class="default-form" function-callback="afterAction">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12 mb-3 form-group">
                            <label for="nilai_akhir_magang" class="form-label">Nilai Akhir Mahasiswa</label>
                            <input type="text" name="nilai_akhir_magang" id="nilai_akhir_magang" class="form-control" disabled />
                            <div class="invalid-feedback"></div>
                        </div>
                        <div class="col-12 mb-3 form-group">
                            <label for="nilai_adjust" class="form-label">Pengurangan Nilai</label>
                            <input type="text" name="nilai_adjust" id="nilai_adjust" class="form-control" />
                            <div class="invalid-feedback"></div>
                        </div>
                        <div class="col-12 mb-3 form-group">
                            <label for="alasan_adjust" class="form-label">Alasan Pengurangan Nilai</label>
                            <textarea type="text" name="alasan_adjust" rows="4" id="alasan_adjust" class="form-control" placeholder="Masukkan alasan pengurangan nilai"></textarea>
                            <div class="invalid-feedback"></div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary me-0">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="modalDetail" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        @include('berkas_akhir_magang/magang_fakultas/components/card_detail_mhs')
    </div>
</div>