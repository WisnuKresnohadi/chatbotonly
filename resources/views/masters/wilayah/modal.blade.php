{{-- Modal Tambah --}}
<div class="modal fade" id="modalTambahWilayah" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header text-center d-block">
                <h5 class="modal-title" data-label="Tambah Wilayah">Tambah Wilayah</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form class="default-form" method="POST" action="{{ route('wilayah.store') }}" function-callback="afterAction">
                @csrf
                <input type="hidden" name="id">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12 mb-2 form-group" id="type-col">
                            <label for="type" class="form-label">Tipe</label>
                            <select id="type" name="type" class="select2 form-select" data-placeholder="Pilih Tipe">
                                <option value="" disabled selected>Pilih Tipe</option>
                                <option value="country">Negara</option>
                                <option value="province">Provinsi</option>
                                <option value="city">Kota</option>
                            </select>
                            <div class="invalid-feedback"></div>
                        </div>
                        <div class="col-12 mb-2 form-group" id="parent-col" style="display: none;">
                            <label for="parent" id="parent-label" class="form-label">Parent</label>
                            <select id="parent-select" name="parent" class="select2 form-select" data-placeholder="Pilih Parent">
                                <option value="" disabled selected>Pilih Parent</option>
                            </select>
                            <div class="invalid-feedback"></div>
                        </div>
                        <div class="col-12 mb-2 form-group">
                            <label for="name" class="form-label">Nama</label>
                            <input type="text" id="name" name="name" class="form-control" placeholder="Nama" />
                            <div class="invalid-feedback"></div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>