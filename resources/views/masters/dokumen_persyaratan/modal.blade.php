<div class="modal fade" id="modal-dokumen" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">

        <div class="modal-content">
            <div class="modal-header text-center d-block">
                <h5 class="modal-title" id="modal-title">Tambah Dokumen</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form class="default-form" action="{{ route('doc-syarat.store') }}" function-callback="afterAction">
                @csrf
                <div class="modal-body">

                    <div class="row">
                        <div class="col mb-2 form-input">
                            <label for="jenis" class="form-label">Jenis Magang</label>
                            <select class="form-select select2" id="jenis" name="namajenis" data-placeholder="Jenis Magang">
                                <option value="">Pilih Jenis Magang</option>
                                @foreach($jenis as $data)
                                <option value="{{ $data->id_jenismagang }}">{{ $data->namajenis}}</option>
                                @endforeach
                            </select>
                            <div class="invalid-feedback"></div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col mb-2 form-input">
                            <label for="namadokumen" class="form-label">Nama Dokumen</label>
                            <input type="text" id="namadokumen" onkeyup="this.value = this.value.replace(/[^a-zA-Z\s]+/gi, '');" name="namadoc" class="form-control" placeholder="Nama Dokumen" />
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