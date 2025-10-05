<div class="content active">
    <div class="mb-3 content-header">
        <h4 class="mb-0">Detail Lowongan</h4>
    </div>
    <div class="row g-3">

        {{-- Jenis & Durasi Magang --}}
        <div class="col-lg-12 col-sm-6 form-group">
            <label class="form-label" for="id_jenismagang">Jenis Magang<span class="text-danger">*</span></label>
            <select name="id_jenismagang" id="id_jenismagang" class="select2 form-select" data-placeholder="Jenis Magang" onchange="durasiMagang($(this).find(':selected').data('durasi'))">
                <option value="" disabled selected>Jenis Magang</option>
                @foreach ($jenismagang as $j)
                <option value="{{ $j->id_jenismagang }}" data-durasi="{{ $j->durasimagang }}">{{ $j->namajenis }} ({{ $j->durasimagang }})</option>
                @endforeach
            </select>
            <div class="invalid-feedback"></div>
        </div>
        <input type="hidden" name="durasimagang[]" id="durasimagang">
        {{-- End Jenis & Durasi Magang --}}

        {{-- Start Bidang Pekerjaan --}}
        <div class="col-lg-12 col-sm-6 form-group">
            <label for="intern_position" class="form-label">Bidang Pekerjaan<span class="text-danger">*</span></label>
            <select name="intern_position" id="intern_position" class="select2 form-select" data-tags="true">
                <option value="Pengalaman Praktis" disabled> Gunakan kolom di atas menambahkan manual, atau mencari dari bidang yang sudah di sediakan</option>
                @foreach ($dataBidangPekerjaan as $bidangPekerjaan)
                <option value="{{ $bidangPekerjaan->default ? $bidangPekerjaan->namabidangpekerjaan : $bidangPekerjaan->id_bidang_pekerjaan_industri }}"  data-desk="{{ $bidangPekerjaan->deskripsi }}">{{ $bidangPekerjaan->namabidangpekerjaan }}</option>
                @endforeach
            </select>
            <div class="invalid-feedback"></div>
        </div>
        {{-- End Bidang Pekerjaan --}}

        {{-- Kuota Penerimaan --}}
        <div class="col-lg-12 col-sm-6 form-group">
            <label class="form-label" for="kuota">Kuota Penerimaan<span class="text-danger">*</span></label>
            <input type="number" name="kuota" id="kuota" class="form-control" placeholder="Masukan Kuota Penerimaan" />
            <div class="invalid-feedback"></div>
        </div>
        {{-- End Kuota Penerimaan --}}

        {{-- Deskripsi Pekerjaan --}}
        <div class="col-lg-12 col-sm-6 form-group">
            <label class="form-label" for="deskripsi">Deskripsi Pekerjaan<span class="text-danger">*</span></label>
            <textarea class="form-control" rows="4" id="deskripsi" name="deskripsi" placeholder="Masukan Deskripsi Pekerjaan"></textarea>
            <div class="invalid-feedback"></div>
        </div>
        {{-- End Deskripsi Pekerjaan --}}

        {{-- Tanggal Lowongan --}}
        <div class="col-lg-12 col-sm-6">
            <div class="d-flex justify-content-center">
                <div class="form-group me-4" style="flex: 1;">
                    <label for="startdate" class="form-label">Tanggal Lowongan Ditayangkan<span class="text-danger">*</span></label>
                    <input class="cursor-pointer form-control flatpickr-date" type="text" id="startdate" name="startdate" placeholder="YYYY-MM-DD" readonly="readonly">
                    <div class="invalid-feedback"></div>
                </div>
                {{-- <div class="mt-3" style="text-align: center; background-color: black; width: 14px; height: 1px; margin: 0 20px"></div> --}}
                <div class="form-group ms-4" style="flex: 1;">
                    <label for="enddate" class="form-label">Tanggal Lowongan Diturunkan<span class="text-danger">*</span></label>
                    <input class="cursor-pointer form-control flatpickr-date" type="text" id="enddate" name="enddate" placeholder="YYYY-MM-DD" readonly="readonly">
                    <div class="invalid-feedback"></div>
                </div>
            </div>
        </div>
        {{-- End Tanggal Lowongan --}}

        {{-- Prev/Next --}}
        <div class="col-12 d-flex justify-content-end">
            <button class="btn btn-primary button-next" type="button" data-step="{{ Crypt::encryptString("1") }}">
                <span class="align-middle d-sm-inline-block d-none me-sm-1">Next</span>
                <i class="ti ti-arrow-right"></i>
            </button>
        </div>
        {{-- End Prev/Next --}}

    </div>
</div>
