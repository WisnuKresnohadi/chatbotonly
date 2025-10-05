<!-- Modal Tambah-->
<div class="modal fade" id="modalEditProfile" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header d-block">
                <h5 class="modal-title" id="modal-title">Edit Summary Profile</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <!-- Account -->
            <form action="{{ route('profile_company.update', ['id' => $industri->id_industri]) }}" class="default-form" function-callback="afterAction">
                @csrf
                <div class="modal-body">
                    <div class="d-flex align-items-start align-items-sm-center gap-4 mb-4">
                        <div class="rounded-circle w-px-100 h-px-100 text-center" style="overflow: hidden;">
                            <img src="" alt="user-avatar" class="d-block w-100" id="imgPreview2" default-src="">
                        </div>
                        <div class="d-flex flex-column">
                            <div class="d-flex justify-content-start">
                                <label for="changePicture" class="btn btn-primary mx-2" id="btn-change-picture">
                                    <i class="ti ti-upload d-block pe-2"></i>
                                    <span class="d-none d-sm-block">Unggah Baru Logo Perusahaan</span>
                                    <input type="file" id="changePicture" name="image" class="account-file-input" hidden accept="image/png, image/jpeg">
                                </label>
                                <button type="button" class="btn btn-white mx-2 text-danger account-image-reset" onclick="removeImage()">
                                    <i class="ti ti-refresh-dot d-block d-sm-none"></i>
                                    <span class="d-none d-sm-block">Remove</span>
                                </button>
                            </div>
                            <small class="text-muted mx-2 mt-2">Format FIle JPG, JPEG atau PNG. Ukuran Maksimal 2MB</small>
                        </div>
                    </div>
                    <div class="border-top">
                        <div class="row mt-4">
                            <div class="mb-3 col-md-12 form-group">
                                <label for="namaindustri" class="form-label">Nama Perusahaan <span class="text-danger">*</span></label>
                                <input class="form-control" type="text" id="namaindustri" name="namaindustri" placeholder="Nama Perusahaan" autofocus="">
                                <div class="invalid-feedback"></div>
                            </div>
                            <div class="mb-3 col-md-12 form-group">
                                <label for="alamatindustri" class="form-label">Alamat Perusahaan <span class="text-danger">*</span></label>
                                <textarea class="form-control" rows="2" placeholder="Masukan Alamat Perusahaan" id="alamatindustri" name="alamatindustri"></textarea>
                                <div class="invalid-feedback"></div>
                            </div>
                            <div class="mb-3 col-md-12 form-group">
                                <label for="description" class="form-label">Deskripsi Perusahaan <span class="text-danger">*</span></label>
                                <textarea class="form-control" rows="2" placeholder="Masukan Deskripsi Perusahaan" id="description" name="description"></textarea>
                                <div class="invalid-feedback"></div>
                            </div>
                            <div class="mb-3 col-md-12">
                                <div class="border rounded p-3">
                                    <label class="form-label">Kontak Perusahaan</label>
                                    <div class="mb-3 col-md-12 form-group">
                                        <label for="notelpon" class="form-label">No. Telepon Perusahaan <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="notelpon" name="notelpon" placeholder="Masukan Nomor Telepon">
                                        <div class="invalid-feedback"></div>
                                    </div>
                                    <div class="mb-3 col-md-12 form-group">
                                        <label for="email" class="form-label">E-mail Perusahaan <span class="text-danger">*</span></label>
                                        <input type="text" id="email" name="email" class="form-control" placeholder="Masukan E-mail Perusahaan">
                                        <div class="invalid-feedback"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success me-2">Simpan</button>
                    </div>
                </div>
            </form>
        </div>

    </div>
    <!-- /Account -->
</div>
</div>
