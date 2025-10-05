<div class="content">
    <div class="content-header mb-3">
        <h4 class="mb-0">Proses Seleksi</h4>
    </div>
    <div class="row g-3">
        @for ($i = 0; $i < ($tahap + 1); $i++)
            <div class="{{ ($i == 0 && $i < $tahap) ? 'border-bottom' : ''  }}">
                <div class="mb-4">
                    <input type="hidden" name="proses_seleksi[{{ $i }}][tahap]" value="{{ Crypt::encryptString(($i+1)) }}">
                    <div class="form-group col-lg-12 col-sm-6">
                        <label for="seleksi_tahap_{{ $i }}" class="form-label">Jenis Seleksi Tahap Lanjut<span class="text-danger">*</span></label>
                        <select id="seleksi_tahap_{{ $i }}" class="select2 form-select" disabled>
                            <option value="" selected>Seleksi Tahap {{ ($i+1) }}</option>
                        </select>
                    </div>
                    <div class="form-group col-lg-12 mt-3">
                        <label for="deskripsiseleksi{{ $i }}" class="form-label">Deskripsi Seleksi<span class="text-danger">*</span></label>
                        <textarea class="form-control" rows="2" id="deskripsiseleksi{{ $i }}" name="proses_seleksi[{{ $i }}][deskripsi]" placeholder="Masukan Deskripsi Tahapan"></textarea>
                        <div class="invalid-feedback"></div>
                    </div>
                    <div class="col-lg-12 col-sm-6 mt-3">
                        <div class="d-flex justify-content-center">
                            <div class="form-group me-4" style="flex: 1;">
                                <label for="mulai{{ $i }}" class="form-label">Tanggal Mulai Pelaksanaan<span class="text-danger">*</span></label>
                                <input class="form-control flatpickr-date cursor-pointer" type="text" id="mulai{{ $i }}" name="proses_seleksi[{{ $i }}][tgl_mulai]" placeholder="YYYY-MM-DD" readonly="readonly">
                                <div class="invalid-feedback"></div>
                            </div>
                            <div class="mt-3" style="text-align: center; background-color: black; width: 14px; height: 1px; margin: 0 20px"></div>
                            <div class="form-group ms-4" style="flex: 1;">
                                <label for="akhir{{ $i }}" class="form-label">Tanggal Akhir Pelaksanaan<span class="text-danger">*</span></label>
                                <input class="form-control flatpickr-date cursor-pointer" type="text" id="akhir{{ $i }}" name="proses_seleksi[{{ $i }}][tgl_akhir]" placeholder="YYYY-MM-DD" readonly="readonly">
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endfor

        <div class="col-12 d-flex justify-content-between">
            <button type="button" class="btn btn-label-secondary btn-prev">
                <i class="ti ti-arrow-left me-sm-1 me-0"></i>
                <span class="align-middle d-sm-inline-block d-none">Previous</span>
            </button>
            <button type="submit" class="btn btn-success button-next" data-step="{{ Crypt::encryptString("3") }}">Submit</button>
        </div>
    </div>
</div>
