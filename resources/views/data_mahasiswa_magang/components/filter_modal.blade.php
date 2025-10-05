<div class="offcanvas offcanvas-end modals" tabindex="-1" id="modalSlide" aria-labelledby="offcanvasAddUserLabel">
    <div class="offcanvas-header">
        <h5 id="offcanvasAddUserLabel" class="offcanvas-title" style="padding-left: 15px;">Filter Berdasarkan
        </h5>
    </div>
    <div class="offcanvas-body h-100 mx-0 flex-grow-0 pt-0">
        <form class="add-new-user pt-0" id="filter">

            {{-- Dropdown Jenis Magang --}}
            <div class="col-12 mb-2">
                <label for="jenis_magang" class="form-label">Jenis Magang</label>
                <select class="select2 form-select" id="jenis_magang" name="jenis_magang"
                    onchange="getDataSelect($(this))" data-after="jenjang" data-placeholder="Pilih Jenis Magang">
                    <option disabled selected>Pilih Jenis Magang</option>
                    @foreach ($jenis_magang as $item)
                        <option value="{{ $item->id_jenismagang }}">{{ $item->namajenis }}</option>
                    @endforeach
                </select>
                <div class="invalid-feedback"></div>
            </div>

            {{-- Dropdown Jenjang --}}
            <div class="col-12 mb-2">
                <label for="jenjang" class="form-label">Jenjang</label>
                <select class="select2 form-select" id="jenjang" name="jenjang" onchange="getDataSelect($(this))"
                    data-after="program_studi" data-placeholder="Pilih Jenjang">
                    <option disabled selected>Pilih Jenjang</option>
                </select>
                <div class="invalid-feedback"></div>
            </div>

            {{-- Dropdown Program Studi --}}
            <div class="col-12 mb-2">
                <label for="program_studi" class="form-label">Program Studi</label>
                <select class="select2 form-select" id="program_studi" name="program_studi"
                    onchange="getDataSelect($(this))" data-after="nama_perusahaan" data-prev="jenjang"
                    data-placeholder="Pilih Program Studi">
                    <option disabled selected>Pilih Program Studi</option>
                </select>
                <div class="invalid-feedback"></div>
            </div>

            {{-- Dropdown Nama Perusahaan --}}
            <div class="col-12 mb-2">
                <label for="nama_perusahaan" class="form-label">Nama Perusahaan</label>
                <select class="select2 form-select" id="nama_perusahaan" name="nama_perusahaan"
                    onchange="getDataSelect($(this))" data-after="posisi_magang"
                    data-placeholder="Pilih Nama Perusahaan">
                    <option disabled selected>Pilih Nama Perusahaan</option>
                </select>
                <div class="invalid-feedback"></div>
            </div>

            {{-- Dropdown Posisi Magang --}}
            <div class="col-12 mb-2">
                <label for="posisi_magang" class="form-label">Posisi Magang</label>
                <select class="select2 form-select" id="posisi_magang" name="posisi_magang"
                    data-placeholder="Pilih Posisi Magang">
                    <option disabled selected>Pilih Posisi Magang</option>
                </select>
                <div class="invalid-feedback"></div>
            </div>

            <div class="mt-3 text-end">
                <button type="button" class="btn btn-label-danger data-reset">Reset</button>
                <button type="submit" class="btn btn-success">Terapkan</button>
            </div>

        </form>
    </div>
</div>
</div>
