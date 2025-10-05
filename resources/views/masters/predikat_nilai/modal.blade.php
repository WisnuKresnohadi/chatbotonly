<div class="modal fade" id="modal-predikat-nilai" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">

        <div class="modal-content">
            <div class="modal-header text-center d-block">
                <h5 class="modal-title">Tambah Predikat Nilai</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form class="default-form" action="{{ route('predikatnilai.store') }}" function-callback="afterAction">
                @csrf
                <div class="modal-body">                    
                    <div class="row">
                        <div class="col mb-2 form-group">
                            <label for="nama" class="form-label">Nama Predikat Nilai<span class="text-danger">*</span></label>
                            <input type="text" id="nama" name="nama" class="form-control" placeholder="Nama Predikat Nilai" />
                            <div class="invalid-feedback"></div>
                        </div>                                       
                    </div>
                    <div class="row">
                        <div class="col mb-2 form-group">
                            <label for="nilai" class="form-label">Nilai<span class="text-danger">*</span></label>
                            <input type="number" id="nilai" name="nilai" class="form-control" placeholder="Nilai" oninput="this.value = this.value.match(/^(100|[1-9][0-9]?)?$/) ? this.value : this.value.slice(0, -1); " />
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
