<style>
    .select2-container .select2-selection--multiple .select2-selection__rendered {
    display: inline-block;
    overflow: auto;
    padding-left: 8px;
    text-overflow: ellipsis;
    white-space: nowrap;
}
</style>

<div class="modal fade" id="modal-bidang-pekerjaan" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">

        <div class="modal-content">
            <div class="text-center modal-header d-block">
                <h5 class="modal-title">Tambah Bidang Pekerjaan </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form class="default-form" action="{{ route('bidangpekerjaan.store') }}" function-callback="afterAction">
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

<div class="modal fade" id="modal-mapping-mk-bidang-pekerjaan" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" style="max-width: 45%" role="document">
        <div class="modal-content">
            <div class="text-center modal-header d-block">
                <h5 class="modal-title">Konfigurasi Matakuliah - Bidang Pekerjaan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form class="default-form" action="{{ route('bidangpekerjaan.store') }}" function-callback="afterAction">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="mb-2 col form-group">
                            <label for="name" class="form-label">Nama Bidang Pekerjaan<span
                                    class="text-danger">*</span></label>
                            <input type="hidden" id="id_bidang_pekerjaan_industri" name="id_bidang_pekerjaan_industri" value="">
                            <input type="text" id="nama_bidang_pekerjaan" class="form-control"
                                placeholder="Nama Bidang Pekerjaan" disabled/>
                            <div class="invalid-feedback"></div>
                        </div>
                    </div>

                    <div class="prodi-repeater">
                        <div data-repeater-list="prodi">
                            <div data-repeater-item data-callback="afterShownProdi"
                                class="prodi-item-repeater align-items-center">
                                    <div class="p-2 px-3 mt-3 mb-4 border col" style="border-radius: 8px;">
                                        <div class="d-flex justify-content-between">
                                            <div class="mb-3 col form-group">
                                                <label for="id_prodi" class="form-label">Prodi</label>
                                                <select class="form-select select2 prodi" id="id_prodi" name="id_prodi"
                                                    data-after="id_mk" data-placeholder="Pilih Prodi"
                                                    data-select2-id="id-prodi" onchange="getDataSelect($(this));" >
                                                    <option value="" disabled selected>Pilih Prodi</option>
                                                    @foreach ($prodi as $item)
                                                        <option value="{{ $item->id_prodi }}">{{ $item->jenjang }} {{ $item->namaprodi }}</option>
                                                    @endforeach
                                                </select>
                                                <div class="invalid-feedback"></div>
                                            </div>
                                            {{-- Delete prodi repeater in here --}}
                                            <div class="col-2 form-group d-flex justify-content-end justify-items-center align-items-center" style="height: 5.4rem;">
                                                <button data-repeater-delete type="button"
                                                    class="btn btn-outline-danger btn-md delete_parent"
                                                    style="height: 2.3rem;">
                                                    <i class="ti ti-trash"></i>
                                                </button>
                                            </div>
                                        </div>

                                        <div class="matakuliah-repeater">
                                            <div data-repeater-list="matakuliah" data-callback="afterShownMk">
                                                <div data-repeater-item data-callback="afterShownMk">
                                                    <div class="d-flex me-2">
                                                        <div class="mb-3 col-6 form-group" style="padding-right: 0.1rem; width: 70% !important;">
                                                            <input type="hidden" name="id_bidang_pekerjaan_mk">
                                                            <label for="id_mk" class="form-label justify-content-between d-flex">
                                                                <span>
                                                                Mata Kuliah<span style="color: red;">*</span>
                                                                <i class="ti ti-info-circle fs-5" data-bs-toggle="tooltip" data-bs-placement="right" title="Anda dapat memilih mata kuliah yang sama di bobot yang sama."></i>
                                                                </span>
                                                            </label>
                                                            <select class="form-select select2 mata-kuliah" data-allow-clear="true" name="id_mk[]" id="id_mk" data-placeholder="Pilih Mata Kuliah" data-tags="false" multiple></select>
                                                            <div class="invalid-feedback"></div>
                                                        </div>
                                                        <div style="width: 96px !important;" class="col-4 ms-3 form-group" style="padding-right: 0.1rem">
                                                            <label class="form-label" for="bobot">Bobot
                                                                Nilai<span style="color: red;">*</span></label>
                                                            <input type="text" name="bobot" id="bobot"
                                                                class="form-control bobot-nilai"
                                                                oninput="this.value = this.value.match(/^(100|[1-9][0-9]?)?$/) ? this.value : this.value.slice(0, -1); "
                                                                placeholder="Bobot Nilai" />
                                                            <div class="invalid-feedback"></div>
                                                        </div>

                                                        <div class="col-2 form-group d-flex justify-content-center justify-items-center align-items-center" style="height: 5.4rem; padding-left: 0.2rem;">
                                                            <button data-repeater-delete type="button"
                                                                class="btn btn-outline-danger btn-md"
                                                                style="height: 2.3rem;">
                                                                <i class="ti ti-trash"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="mb-2" id="container-add-row-inner">
                                                <button class="btn btn-outline-primary" type="button" data-repeater-create>
                                                    <i class="ti ti-plus me-1"></i>
                                                    <span class="align-middle">Matakuliah</span>
                                                </button>
                                            </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="mb-0" id="container-add-row">
                            <button class="btn btn-outline-primary add_prodi" type="button" data-repeater-create>
                                <i class="ti ti-plus me-1"></i>
                                <span class="align-middle">Prodi</span>
                            </button>
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
