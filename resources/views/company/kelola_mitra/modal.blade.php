{{-- Modal Tambah --}}
<div class="modal fade" id="modalTambahMitra" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="text-center modal-header d-block">
                <h5 class="modal-title" data-label="Tambah Mitra">Tambah Mitra</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form class="default-form" method="POST" action="{{ route('kelola_mitra.store') }}" function-callback="afterAction">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="mb-2 col-12 form-group">
                            <label for="nama" class="form-label">Nama Perusahaan</label>
                            <input type="text" id="nama" name="namaindustri"class="form-control" placeholder="Nama Perusahaan"/>
                            <div class="invalid-feedback"></div>
                        </div>
                        <div class="mb-2 col-12 form-group">
                            <label for="email" class="form-label">Email Penanggung Jawab</label>
                            <input type="text" id="email" name="email" class="form-control" placeholder="Email Penanggung Jawab"/>
                            <div class="invalid-feedback"></div>
                        </div>
                        <div class="mb-2 col-12 form-group">
                            <label for="contact_person" class="form-label">No HP Penanggung Jawab</label>
                            <input type="text" id="contact_person" name="contact_person" class="form-control" placeholder="No HP Penanggung Jawab"/>
                            <div class="invalid-feedback"></div>
                        </div>
                        <div class="mb-2 col-12 form-group">
                            <label for="penanggung_jawab" class="form-label">Nama Penanggung Jawab</label>
                            <input type="text" id="penanggung_jawab" name="penanggung_jawab" class="form-control" placeholder="Nama Penanggung Jawab"/>
                            <div class="invalid-feedback"></div>
                        </div>
                        <div class="mb-2 col-12 form-group">
                            <label for="alamat" class="form-label">Alamat</label>
                            <textarea class="form-control" name="alamat" id="alamat" cols="4"></textarea>
                            <div class="invalid-feedback"></div>
                        </div>
                        <div class="mb-2 col-12 form-group">
                            <label for="deskripsi" class="form-label">Deskripsi</label>
                            <textarea class="form-control" name="deskripsi" id="deskripsi" cols="4"></textarea>
                            <div class="invalid-feedback"></div>
                        </div>
                        <div class="mb-2 col-12 form-group">
                            <label for="kategori" class="form-label">Pilih Kategori Mitra</label>
                            <select class="form-control select2" id="kategori" name="kategori_industri" data-placeholder="Pilih Kategori Mitra">
                                <option disabled selected>Pilih Kategori Mitra</option>
                                <option value="Internal">Internal</option>
                                <option value="Eksternal">Eksternal</option>
                            </select>
                            <div class="invalid-feedback"></div>
                        </div>
                        <div class="mb-2 col-12 form-group">
                            <label for="statuskerjasama" class="form-label">Pilih Status Kerjasama</label>
                            <select class="form-control select2" id="statuskerjasama" name="statuskerjasama" data-placeholder="Pilih Status Kerjasama">
                                <option disabled selected>Pilih Status Kerjasama</option>
                                <option value="Iya">Iya</option>
                                <option value="Tidak">Tidak</option>
                            </select>
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

<div class="modal fade" id="modalreject" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="text-center modal-header">
                <h4 class="mx-auto modal-title" id="modalreject">Alasan Penolakan</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form class="default-form" action="" function-callback="afterReject">
                @csrf
                <div class="py-2 modal-body">
                    <div class="row">
                        <div class="mb-2 col form-group">
                            <label for="alasan" class="form-label">Alasan Penolakan</label>
                            <textarea class="form-control" name="alasan" id="alasan" rows="4" placeholder="Alasan Penolakan"></textarea>
                            <div class="invalid-feedback"></div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
