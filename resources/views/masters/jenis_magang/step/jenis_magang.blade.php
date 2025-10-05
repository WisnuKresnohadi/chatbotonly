<div class="content active">
    <div class="content-header mb-3">
        <h6 class="mb-0">Informasi Umum Magang</h6>
    </div>
    <div class="row g-3">
        @if (!isset($jenismagang))
        <div class="col-6 form-group">
            <label class="form-label" for="namajenis">
                Jenis Magang
                <span class="text-danger">*</span> 
                <i class="tf-icons ti ti-alert-circle text-primary pb-1" data-bs-toggle="tooltip" data-bs-html="true" data-bs-placement="right" data-bs-original-title="Pilih pada list yang tersedia jika ingin menduplikasi jenis magang sebelumnya.<br>Jika ingin menambahkan jenis magang baru silahkan diketik kemudian enter" id="tooltip-filter"></i></label>
            <select name="namajenis" id="namajenis" class="form-control select2" data-placeholder="Pilih Jenis Magang" data-tags="true" data-allow-clear="true" onchange="getData();">
                <option value="" selected disabled>Pilih Jenis Magang</option>
                @foreach ($jenisMagangBefore as $item)
                <option value="{{ $item->namajenis }}" data-id-selected="{{ $item->id_jenismagang }}">{{ $item->namajenis }}</option>
                @endforeach
            </select>
            <div class="invalid-feedback"></div>
        </div>
        @else
        <div class="col-6 form-group">
            <label class="form-label" for="namajenis">Jenis Magang<span class="text-danger">*</span> <i class="ti ti-info"></i></label>
            <input type="text" name="namajenis" onkeyup="this.value = this.value.replace(/[^a-zA-Z\s]+/gi, '');" id="namajenis" class="form-control" placeholder="Masukan Jenis Magang" />
            <div class="invalid-feedback"></div>
        </div>
        @endif
        <div class="col-6 form-group">
            <label for="durasimagang" class="form-label">Durasi Magang<span class="text-danger">*</span></label>
            <select name="durasimagang" id="durasimagang" class="form-control select2" data-placeholder="Pilih Durasi Magang">
                <option value="">Pilih Durasi Magang</option>
                <option value="1 Semester">1 Semester</option>
                <option value="2 Semester">2 Semester</option>
            </select>
            <div class="invalid-feedback"></div>
        </div>
        <div class="col-12 form-group">
            <label for="id_year_akademik" class="form-label">Tahun Akademik<span class="text-danger">*</span></label>
            <select name="id_year_akademik" id="id_year_akademik" class="form-control select2" data-placeholder="Pilih Tahun Akademik">
                <option value="" selected disabled>Pilih Tahun Akademik</option>
                {!! tahunAjaranMaker() !!}
            </select>
            <div class="invalid-feedback"></div>
        </div>
        <div class="col-12 form-group">
            <label for="desc" class="form-label">Deskripsi<span class="text-danger">*</span></label>
            <textarea class="form-control" name="desc" id="desc" rows="4"></textarea>
            <div class="invalid-feedback"></div>
        </div>
        <div class="col-12 d-flex justify-content-between">
            <button type="button" class="btn btn-label-secondary" disabled>
                <i class="ti ti-arrow-left me-sm-1 me-0"></i>
                <span class="align-middle d-sm-inline-block d-none">Previous</span>
            </button>
            <button class="btn btn-primary button-next" type="button" data-step="{{ Crypt::encryptString("1") }}">
                <span class="align-middle d-sm-inline-block d-none me-sm-1">Next</span>
                <i class="ti ti-arrow-right"></i>
            </button>
        </div>
    </div>
</div>