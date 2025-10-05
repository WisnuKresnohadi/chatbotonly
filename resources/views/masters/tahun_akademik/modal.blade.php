<div class="modal fade" id="modal-thn-akademik" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">

        <div class="modal-content">
            <div class="modal-header text-center d-block">
                <h5 class="modal-title" id="modal-title">Tambah Tahun Akademik</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form class="default-form" action="{{ route('thn-akademik.store') }}" function-callback="afterAction">
                @csrf
                <div class="modal-body">
                    <div class="row g-2">
                        <div class="col-12 form-group">
                            <label for="tahun" class="form-label">Tahun Ajaran<span class="text-danger">*</span></label>
                            <input type="text" id="tahun" class="form-control" name="tahun" placeholder="{{ now()->format('Y') }}/{{ now()->addYear()->format('Y') }}" value="{{ now()->format('Y') }}/{{ now()->addYear()->format('Y') }}">
                            <div class="invalid-feedback"></div>
                        </div>
                        <div class="col-12 form-group">
                            <label for="semester" class="form-label">Semester<span class="text-danger">*</span></label>
                            <select class="form-control select2" id="semester" name="semester" data-placeholder="Pilih Semester">
                                <option value="" disabled selected>Pilih Semester</option>
                                <option value="Ganjil">Ganjil</option>
                                <option value="Genap">Genap</option>
                            </select>
                            <div class="invalid-feedback"></div>
                        </div>
                        <div class="col-12 d-flex justify-content-between">
                            <div class="form-group">
                                <label for="startdate_daftar" class="form-label">Tanggal Mulai Pendaftaran Magang<span style="color: red;">*</span></label>
                                <input type="text" class="form-control flatpickr-date" id="startdate_daftar" name="startdate_daftar" placeholder="YYYY-MM-DD" readonly="readonly">
                                <div class="invalid-feedback"></div>
                            </div>
                            <div class="mt-5" style="text-align: center; background-color: black; width: 14px; height: 1px; margin: 0 20px"></div>
                            <div class="form-group">
                                <label for="enddate_daftar" class="form-label">Tanggal Akhir Pendaftaran Magang<span style="color: red;">*</span></label>
                                <input type="text" class="form-control flatpickr-date" id="enddate_daftar" name="enddate_daftar" placeholder="YYYY-MM-DD" readonly="readonly">
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" id="modal-button" class="btn btn-primary me-0">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
