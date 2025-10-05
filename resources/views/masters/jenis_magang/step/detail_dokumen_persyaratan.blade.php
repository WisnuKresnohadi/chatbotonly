<!-- Berkas Magang -->
<div class="content">
    <div class="content-header">
        <h6 class="mb-0">Dokumen Persyaratan</h6>
    </div>
    <div class="row g-3 form-repeater">
        <div data-repeater-list="dokumen_persyaratan">
            @if (isset($jenismagang) && count($jenismagang->dokumen_persyaratan) > 0)
            @foreach ($jenismagang->dokumen_persyaratan as $key => $item)
            <div class="border-bottom" data-repeater-item data-callback="afterShown">
                <input type="hidden" class="id_document" name="dokumen_persyaratan[][id_document]" value="{{ $item->id_document }}">
                <div class="row my-1">
                    <div class="mb-3 col form-group">
                        <label class="form-label" for="namadocument{{ $key }}">Nama Dokumen<span class="text-danger">*</span></label>
                        <input type="text" name="dokumen_persyaratan[][namadocument]" id="namadocument{{ $key }}" class="form-control" placeholder="Masukan Nama Berkas" value="{{ $item->namadocument }}" />
                        <div class="invalid-feedback"></div>
                    </div>
                    <div class="col-auto my-auto pt-2">
                        <button type="button" class="btn btn-icon ms-3 btn-outline-danger" data-repeater-delete>
                            <i class="ti ti-trash ti-xs"></i>
                        </button>
                    </div>
                </div>
            </div>
            @endforeach
            @else
            <div class="border-bottom" data-repeater-item data-callback="afterShown">
                <div class="row my-1">
                    <div class="mb-3 col form-group">
                        <label class="form-label" for="namadocument">Nama Dokumen<span class="text-danger">*</span></label>
                        <input type="text" name="namadocument" id="namadocument" class="form-control" placeholder="Masukan Nama Berkas" />
                        <div class="invalid-feedback"></div>
                    </div>
                    <div class="col-auto my-auto pt-2">
                        <button type="button" class="btn btn-icon ms-3 btn-outline-danger" data-repeater-delete>
                            <i class="ti ti-trash ti-xs"></i>
                        </button>
                    </div>
                </div>
            </div>
            @endif
        </div>
        <div class="d-flex justify-content-start mt-3">
            <button type="button" class="btn btn-outline-primary" data-repeater-create>
                <span class="align-middle">Tambah</span>
            </button>
        </div>
        <div class="col-12 d-flex justify-content-between mt-5">
            <button type="button" class="btn btn-label-secondary btn-prev">
                <i class="ti ti-arrow-left me-sm-1 me-0"></i>
                <span class="align-middle d-sm-inline-block d-none">Previous</span>
            </button>
            <button class="btn btn-primary button-next" type="button" data-step="{{ Crypt::encryptString("2") }}">
                <span class="align-middle d-sm-inline-block d-none me-sm-1">Next</span>
                <i class="ti ti-arrow-right"></i>
            </button>
        </div>
    </div>
</div>