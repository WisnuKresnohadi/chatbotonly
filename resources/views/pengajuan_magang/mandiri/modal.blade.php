<!-- Modal Detail -->
<div class="modal fade" id="modalDetailDisetujui" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header border-bottom  p-3">
                <h5 class="modal-title" id="modalDetailDisetujui">Riwayat Pengajuan Surat Pengantar Magang</h5>
                <span class="badge bg-label-success me-3">Disetujui</span>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row text-start border-bottom">
                    <div class="col-6">
                        <ul class="list-unstyled ms-2">
                            <li class="mb-1">
                                <span class="fw-semibold me-1">Nama Perusahaan :</span>
                            </li>
                            <li class="mb-2 pt-1">
                                <span class="fw-semibold me-1">Posisi Magang :</span>
                            </li>
                            <li class="mb-2 pt-1">
                                <span class="fw-semibold me-1">Bagian/Jabatan Dituju :</span>
                            </li>
                            <li class="mb-2 pt-1">
                                <span class="fw-semibold me-1">NIM :</span>
                            </li>
                            <li class="mb-2 pt-1">
                                <span class="fw-semibold me-1">Email :</span>
                            </li>
                            <li class="mb-2 pt-1">
                                <span class="fw-semibold me-1">No. Telp:</span>
                            </li>
                            <li class="mb-2 pt-1">
                                <span class="fw-semibold me-1">Tanggal Mulai - Akhir :</span>
                            </li>
                            <li class="mb-2 pt-1">
                                <span class="fw-semibold me-1">Alamat :</span>
                            </li>
                        </ul>
                    </div>
                    <div class="col-6">
                        <ul class="list-unstyled">
                            <li class="mb-1">
                                <span id="nama_industri"></span>
                            </li>
                            <li class="mb-2 pt-1">
                                <span id="posisi_magang"></span>
                            </li>
                            <li class="mb-2 pt-1">
                                <span id="jabatan"></span>
                            </li>
                            <li class="mb-2 pt-1">
                                <span id="nim"></span>
                            </li>
                            <li class="mb-2 pt-1">
                                <span id="email"></span>
                            </li>
                            <li class="mb-2 pt-1">
                                <span id="nohp"></span>
                            </li>
                            <li class="mb-2 pt-1">
                                <span id="date"></span>
                            </li>
                            <li class="mb-2 pt-1">
                                <span id="alamat_industri"></span>
                            </li>
                        </ul>
                    </div>
                </div>
                {{-- <div class="row text-start">
                    <h4 class="ms-2 mt-2">Detail Pengajuan</h4>
                    <div class="col-6">
                        <ul class="list-unstyled ms-2">
                            <li class="mb-1">
                                <span class="fw-semibold me-1">Tanggal Pengajuan :</span>
                            </li>
                            <li class="mb-2 pt-1">
                                <span class="fw-semibold me-1">Disetujui :</span>
                            </li>
                            <li class="mb-2 pt-1">
                                <span class="fw-semibold me-1">Oleh :</span>
                            </li>
                        </ul>
                    </div>
                    <div class="col-6">
                        <ul class="list-unstyled">
                            <li class="mb-1">
                                <span>25 Juni 2023</span>
                            </li>
                            <li class="mb-2 pt-1">
                                <span>01 Juli 2023</span>
                            </li>
                            <li class="mb-2 pt-1">
                                <span>Admin 1</span>
                            </li>
                        </ul>
                    </div>
                </div> --}}
            </div>
        </div>
    </div>
</div>

<!-- Modal Detail -->
<div class="modal fade" id="modalDetailDitolak" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header border-bottom p-3">
                <h5 class="modal-title" id="modalDetailDitolak">Riwayat Pengajuan Surat Pengantar Magang</h5>

                <span class="badge bg-label-danger me-3">Ditolak</span>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row text-start border-bottom">
                    <div class="col-6">
                        <ul class="list-unstyled ms-2">
                            <li class="mb-1">
                                <span class="fw-semibold me-1">Nama Perusahaan :</span>
                            </li>
                            <li class="mb-2 pt-1">
                                <span class="fw-semibold me-1">Posisi Magang :</span>
                            </li>
                            <li class="mb-2 pt-1">
                                <span class="fw-semibold me-1">Bagian/Jabatan Dituju :</span>
                            </li>
                            <li class="mb-2 pt-1">
                                <span class="fw-semibold me-1">Program Studi :</span>
                            </li>
                            <li class="mb-2 pt-1">
                                <span class="fw-semibold me-1">Email :</span>
                            </li>
                            <li class="mb-2 pt-1">
                                <span class="fw-semibold me-1">No. Telp:</span>
                            </li>
                            <li class="mb-2 pt-1">
                                <span class="fw-semibold me-1">Tanggal Mulai - Akhir :</span>
                            </li>
                            <li class="mb-2 pt-1">
                                <span class="fw-semibold me-1">Alamat :</span>
                            </li>
                        </ul>
                    </div>
                    <div class="col-6">
                        <ul class="list-unstyled">
                            <li class="mb-1">
                                <span id="nama_industris"></span>
                            </li>
                            <li class="mb-2 pt-1">
                                <span id="posisi_magangs"></span>
                            </li>
                            <li class="mb-2 pt-1">
                                <span id="jabatans"></span>
                            </li>
                            <li class="mb-2 pt-1">
                                <span id="nims"></span>
                            </li>
                            <li class="mb-2 pt-1">
                                <span id="emails"></span>
                            </li>
                            <li class="mb-2 pt-1">
                                <span id="nohps"></span>
                            </li>
                            <li class="mb-2 pt-1">
                                <span id="dates"></span>
                            </li>
                            <li class="mb-2 pt-1">
                                <span id="alamat_industris"></span>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="border-bottom">
                    <h4 class="ms-2 mt-2">Komentar</h4>
                    <p class="ms-2 text-area" contenteditable="true" id="alasans"></p>
                </div>
                <div class="row text-start">
                    <h4 class="ms-2 mt-2">Detail Pengajuan</h4>
                    <div class="col-6">
                        <ul class="list-unstyled ms-2">
                            <li class="mb-1">
                                <span class="fw-semibold me-1">Tanggal Pengajuan :</span>
                            </li>
                        </ul>
                    </div>
                    <div class="col-6">
                        <ul class="list-unstyled">
                            <li class="mb-1">
                                <span>$item->tgl_pengajuan</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Ajukan-->
<div class="modal fade" id="modalAjukan" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalAjukan">Pengajuan Surat Pengantar Magang</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <form class="default-form" action="{{ url('pengajuan/surat/store') }}" method="POST">
                @csrf
                <input type="hidden" name="nim" value="{{ $nim ?? '' }}">
                <div class="modal-body">
                    <div class="row">
                        <div class="col mb-3">
                            <label for="tanggalmulai" class="form-label">Tanggal Pengajuan</label>
                            <input type="text" class="form-control  flatpickr-date" id="tglpeng_" name="tglpeng"
                                placeholder="YYYY-MM-DD" readonly="readonly">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col mb-3">
                            <label for="namaperusahaan" class="form-label">Nama Perusahaan</label>
                            <input type="text" id="nama_industri_" name="nama_industri" class="form-control"
                                placeholder="Masukkan Nama Perusahaan" />
                        </div>
                    </div>
                    <div class="row">
                        <div class="col mb-3">
                            <label for="namaposisi" class="form-label">Nama Posisi Magang</label>
                            <input type="text" id="posisi_magang_" name="posisi_magang" class="form-control"
                                placeholder="Masukkan Nama Posisi Magang" />
                        </div>
                    </div>
                    <div class="row">
                        <div class="col mb-3">
                            <label for="namaposisi" class="form-label">Bagian/Jabatan yang Dituju</label>
                            <input type="text" id="jabatan_" name="jabatan" class="form-control"
                                placeholder="Masukkan Bagian/Jabatan yang Dituju" />
                        </div>
                    </div>
                    <div class="row">
                        <div class="col mb-3">
                            <label for="namaposisi" class="form-label">Alamat Perusahaan</label>
                            <input type="text" id="alamat_industri_" name="alamat_industri" class="form-control"
                                placeholder="Masukkan Alamat Perusahaan" />
                        </div>
                    </div>
                    <div class="row">
                        <div class="col mb-3">
                            <label for="namaposisi" class="form-label">No.Telp Perusahaan</label>
                            <input type="text" id="nohp_" name="nohp" class="form-control"
                                placeholder="083xxxxxxx" onkeypress="return hanyaAngka(event)"/>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col mb-3">
                            <label for="namaposisi" class="form-label">Email Perusahaan</label>
                            <input type="email" class="form-control" id="email_" name="email"
                                placeholder="name@example.com">
                        </div>
                    </div>
                    <div class="row g-2 mb-3">
                        <div class="col mb-0">
                            <label for="tanggalmulai" class="form-label">Tanggal Mulai<span
                                    style="color: red;">*</span></label>
                            <input type="text" class="form-control  flatpickr-date" id="startdate_"
                                name="startdate" placeholder="YYYY-MM-DD" readonly="readonly">
                        </div>
                        <div class="mt-5"
                            style="text-align: center; background-color: black; width: 14px; height: 1px; margin: 0 20px">
                        </div>
                        <div class="col mb-0">
                            <label for="tanggalakhir" class="form-label">Tanggal Akhir<span
                                    style="color: red;">*</span></label>
                            <input type="text" class="form-control  flatpickr-date" id="enddate_" name="enddate"
                                placeholder="YYYY-MM-DD" readonly="readonly">
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

<!-- Modal Edit-->
{{-- <div class="modal fade" id="modalEdit" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalAjukan">Pengajuan Surat Pengantar Magang</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <form class="default-form" action="{{ url('pengajuan/surat/edit') }}" method="POST">
                @csrf
                <input type="hidden" name="nim" value="{{ $nim ?? '' }}">
                <div class="modal-body">
                    <div class="row">
                        <div class="col mb-3">
                            <label for="tanggalmulai" class="form-label">Tanggal Pengajuan</label>
                            <input type="text" class="form-control  flatpickr-date" id="tglpeng" name="tglpeng"
                                placeholder="YYYY-MM-DD" readonly="readonly">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col mb-3">
                            <label for="namaperusahaan" class="form-label">Nama Perusahaan</label>
                            <input type="text" id="nama_industris" name="nama_industri" class="form-control"
                                placeholder="Masukkan Nama Perusahaan" />
                        </div>
                    </div>
                    <div class="row">
                        <div class="col mb-3">
                            <label for="namaposisi" class="form-label">Nama Posisi Magang</label>
                            <input type="text" id="posisi_magangs" name="posisi_magang" class="form-control"
                                placeholder="Masukkan Nama Posisi Magang" />
                        </div>
                    </div>
                    <div class="row">
                        <div class="col mb-3">
                            <label for="namaposisi" class="form-label">Bagian/Jabatan yang Dituju</label>
                            <input type="text" id="jabatans" name="jabatan" class="form-control"
                                placeholder="Masukkan Bagian/Jabatan yang Dituju" />
                        </div>
                    </div>
                    <div class="row">
                        <div class="col mb-3">
                            <label for="namaposisi" class="form-label">Alamat Perusahaan</label>
                            <input type="text" id="alamat_industris" name="alamat_industri" class="form-control"
                                placeholder="Masukkan Alamat Perusahaan" />
                        </div>
                    </div>
                    <div class="row">
                        <div class="col mb-3">
                            <label for="namaposisi" class="form-label">No.Telp Perusahaan</label>
                            <input type="text" id="nohp" name="nohp" class="form-control"
                                placeholder="083xxxxxxx" />
                        </div>
                    </div>
                    <div class="row">
                        <div class="col mb-3">
                            <label for="namaposisi" class="form-label">Email Perusahaan</label>
                            <input type="email" class="form-control" id="email" name="email"
                                placeholder="name@example.com">
                        </div>
                    </div>
                    <div class="row g-2 mb-3">
                        <div class="col mb-0">
                            <label for="tanggalmulai" class="form-label">Tanggal Mulai<span
                                    style="color: red;">*</span></label>
                            <input type="text" class="form-control  flatpickr-date" id="startdate"
                                name="startdate" placeholder="YYYY-MM-DD" readonly="readonly">
                        </div>
                        <div class="mt-5"
                            style="text-align: center; background-color: black; width: 14px; height: 1px; margin: 0 20px">
                        </div>
                        <div class="col mb-0">
                            <label for="tanggalakhir" class="form-label">Tanggal Akhir<span
                                    style="color: red;">*</span></label>
                            <input type="text" class="form-control  flatpickr-date" id="enddate" name="enddate"
                                placeholder="YYYY-MM-DD" readonly="readonly">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div> --}}

<!-- Modal Ditolak-->
<div class="modal fade" id="modalDitolak" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalDitolak">Konfirmasi Penolakan Magang Mandiri</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col mb-0">
                        <label for="formFile" class="form-label">Bukti Penolakan Magang</label>
                        <input class="form-control" type="file" id="formFile">
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-success">Simpan</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Diterima-->
<div class="modal fade" id="modalDiterima" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalDiterima">Konfirmasi Penerimaan Magang Mandiri</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col mb-3">
                        <label for="namaperusahaan" class="form-label">Nama Perusahaan</label>
                        <input type="text" id="namaperusahaan" class="form-control"
                            placeholder="Masukkan Nama Perusahaan" />
                    </div>
                </div>
                <div class="row">
                    <div class="col mb-3">
                        <label for="namaposisi" class="form-label">Nama Posisi Magang</label>
                        <input type="text" id="namaperusahaan" class="form-control"
                            placeholder="Masukkan Nama Posisi Magang" />
                    </div>
                </div>
                <div class="row g-2 mb-3">
                    <div class="col mb-0">
                        <label for="tanggalmulai" class="form-label">Tanggal Mulai<span
                                style="color: red;">*</span></label>
                        <input type="text" class="form-control  flatpickr-date" id="tanggalmulai"
                            placeholder="YYYY-MM-DD" readonly="readonly">
                    </div>
                    <div class="mt-5"
                        style="text-align: center; background-color: black; width: 14px; height: 1px; margin: 0 20px">
                    </div>
                    <div class="col mb-0">
                        <label for="tanggalakhir" class="form-label">Tanggal Akhir<span
                                style="color: red;">*</span></label>
                        <input type="text" class="form-control  flatpickr-date" id="tanggalakhir"
                            placeholder="YYYY-MM-DD" readonly="readonly">
                    </div>
                </div>
                <div class="row">
                    <div class="col mb-0">
                        <label for="formFile" class="form-label">Bukti Penolakan Magang</label>
                        <input class="form-control" type="file" id="formFile">
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-success">Simpan</button>
            </div>
        </div>
    </div>
</div>
