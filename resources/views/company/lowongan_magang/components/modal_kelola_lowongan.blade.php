<div class="offcanvas offcanvas-end" tabindex="-1" id="modalSlide" aria-labelledby="offcanvasAddUserLabel">
    <div class="offcanvas-header">
        <h5 id="offcanvasAddUserLabel" class="offcanvas-title" style="padding-left: 15px;">Filter Berdasarkan
        </h5>
    </div>
    <div class="flex-grow-0 pt-0 mx-0 offcanvas-body h-100">
        <form class="pt-0 add-new-user" id="filter">
            <div class="mb-2 col-12">
                <div class="row">
                    <div class="mb-2">
                        <label for="durasimagang" class="form-label" style="padding-left: 15px;">Durasi
                            Magang</label>
                        <select class="form-select select2" id="durasimagang" name="durasimagang"
                            data-placeholder="Pilih Durasi Magang">
                            <option disabled selected>Pilih Durasi Magang</option>
                            <option value="1 Semester">1 Semester</option>
                            <option value="2 Semester">2 Semester</option>
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="mb-2 col form-input">
                        <label for="posisi" class="form-label" style="padding-left: 15px;">Posisi Lowongan
                            Magang</label>
                        <select class="form-select select2" id="posisi" name="posisi"
                            data-placeholder="Pilih Fakultas">
                            <option disabled selected>Pilih Posisi Lowongan Magang</option>
                            <option value="UI/UX Designer">UI/UX Designer</option>
                            <option value="Fullstack Developer">Fullstack Developer</option>
                            <option value="Quality Assurance">Quality Assurance</option>
                            <option value="Technical Writter">Technical Writter</option>
                        </select>
                        <div class="invalid-feedback"></div>
                    </div>
                </div>
                <div class="row">
                    <div class="mb-2 col form-input">
                        <label for="status" class="form-label" style="padding-left: 15px;">Status Lowongan
                            Magang</label>
                        <select class="form-select select2" id="status" name="status"
                            data-placeholder="Pilih Status Lowongan Magang">
                            <option disabled selected>Pilih Status Lowongan Magang</option>
                            <option value="Diterima">Diterima</option>
                            <option value="Ditolak">Ditolak</option>
                            <option value="Kadaluarsa">Kadaluarsa</option>
                            <option value="Menunggu Persetujuan">Menunggu Persetujuan</option>
                        </select>
                        <div class="invalid-feedback"></div>
                    </div>
                </div>

                <div class="mt-3 text-end">
                    <button type="button" class="btn btn-label-danger">Reset</button>
                    <button type="submit" class="btn btn-success">Terapkan</button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="modal_edit_takedown" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="text-center modal-header d-block">
                <h5 class="modal-title" id="modal-title">Edit Tanggal Lowongan Diturunkan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form class="default-form" action="" function-callback="afterUpdateTakedown">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="mb-2 col-12 form-group">
                            <label for="enddate" class="form-label">Tanggal Lowongan Diturunkan<span class="text-danger">*</span></label>
                            <input class="cursor-pointer form-control flatpickr-date" type="text" id="enddate" name="enddate" placeholder="YYYY-MM-DD" readonly="readonly">
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
