<!-- Modal Diterima-->
<div class="modal fade" id="modalDiterima" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title mx-auto">Pakta Integritas</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form class="default-form" action="" function-callback="afterAction">
                @csrf
                <div class="modal-body">
                    <div class="row g-2 mb-3">
                        <div class="col-12">
                            <p>Mahasiswa Bersedia dan Siap Untuk Mengikuti dan Berperan Aktif Pada Proses Kegiatan Magang Dari Awal Hingga Akhir.</p>
                            <p>Apabila Mahasiswa Berhenti Secara Sepihak atau Berperilaku Negatif Di Mata Akademik, Universitas, Keluarga, Negara dan Agama Selama Proses Magang Maka Mahasiswa Bersedia Diberi Sanksi</p>
                        </div>
                    </div>
                    <div class="form-check mt-3">
                        <input class="form-check-input" name="onehundredagree" type="checkbox" value="ayayaycaptain" id="onehundredagree">
                        <label class="form-check-label fs-6" for="onehundredagree">Ya, Saya Bersedia.</label>
                      </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary disabled">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Mulai Magang fakulats-->
<div class="modal fade" id="modalMulai" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header text-center d-block">
                <h5 class="modal-title" id="title">Konfirmasi Penerimaan Magang</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form class="default-form" action="" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="modal-body">
                    <div class="row">
                        <div class="col-12 mb-3">
                            <label for="jenis" class="form-label">Jenis Magang</label>
                            <select class="form-select select2" id="jenis" name="namajenis" data-placeholder="Pilih Jenis Magang">
                                <option value="">Pilih Jenis Magang</option>
                            </select>
                        </div>

                        <div class="col-12 mb-3">
                            <label for="namaperusahaan" class="form-label">Nama Perusahaan</label>
                            <input type="text" disabled name="nama_industri" id="nama_industri" class="form-control" placeholder="Masukkan Nama Perusahaan" />
                        </div>

                        <div class="co-12 mb-3">
                            <label for="namaposisi" class="form-label">Nama Posisi Magang</label>
                            <input type="text" disabled name="posisi_magang" id="posisi_magang" class="form-control" placeholder="Masukkan Nama Posisi Magang" />
                        </div>
                    </div>
                    <div class="row g-2 mb-3">
                        <div class="col mb-0 form-input">
                            <label for="mulai" class="form-label">Tanggal Mulai<span style="color: red;">*</span></label>
                            <input type="datetime" name="mulai" data-date-format="d M Y" class="form-control flatpickr-date flatpickr-input" placeholder="DD-MM-YYYY" id="mulai" readonly="readonly">
                            <div class="invalid-feedback"></div>
                        </div>
                        <div class="mt-5" style="text-align: center; background-color: black; width: 14px; height: 1px; margin: 0 20px">
                        </div>
                        <div class="col mb-0 form-input">
                            <label for="akhir" class="form-label">Tanggal Akhir<span style="color: red;">*</span></label>
                            <input type="datetime" name="akhir" data-date-format="d M Y" class="form-control flatpickr-date flatpickr-input" placeholder="DD-MM-YYYY" id="akhir" readonly="readonly">
                            <div class="invalid-feedback"></div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col mb-0 form-input">
                            <label for="formFile" class="form-label">Bukti Penerimaan Magang<span style="color: red;">*</span></label>
                            <input class="form-control" type="file" id="bukti_doc" name="bukti_doc" multiple="">
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

<!-- modal alert -->
<div class="modal fade" id="modalDitolak" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body pt-0">
                <div class="text-center">
                    <img src="{{ asset('app-assets/img/alert.png')}}" alt="">
                    <h5>Apakah anda yakin ingin menolak tawaran magang?</h5>
                    <p>Anda tidak akan dapat melakukan konfirmasi magang jika memilih "Ya,Yakin"</p>
                    <button type="button" class="btn btn-success" data-bs-dismiss="modal">
                        Ya, Yakin
                    </button>
                    <button type="button" class="btn btn-danger">Batal</button>
                </div>
            </div>
        </div>
    </div>
</div>