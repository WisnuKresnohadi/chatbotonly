<!-- Modal -->
<div class="modal fade" id="modalAssignPembimbing" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">

        <div class="modal-content">
            <div class="modal-header text-center d-block">
                <h5 class="modal-title" id="modal-assign-title">Assign Pembimbing Lapangan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form class="default-form" action="{{ route('assign_pembimbing.assign_pem_lapangan') }}" function-callback="afterAssigning">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12 form-group mb-2">
                            <label for="namapeg" class="form-label">Nama Pembimbing Lapangan <span style="color: red;">*</span></label>
                            <select class="select2 form-select" data-placeholder="Pilih Pembimbing Lapangan" name="id_peg_industri">
                                <option value="" disabled selected>Pilih Pembimbing Lapangan</option>
                                @foreach($pegawai as $p)
                                    <option value="{{ $p->id_peg_industri }}">{{ $p->namapeg }}</option>
                                @endforeach
                            </select>
                            <div class="invalid-feedback"></div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" id="modal-button" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
