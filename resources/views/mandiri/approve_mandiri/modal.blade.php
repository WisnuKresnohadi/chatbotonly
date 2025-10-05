{{-- Modal Reject --}}
<div class="modal fade" id="modalreject" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="text-center modal-header d-block">
                <h5 class="modal-title" id="modalreject">Alasan Penolakan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form class="default-form" action="" function-callback="afterReject">
                @csrf
                <div class="modal-body">
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



{{-- <div class="modal fade" id="modalapprove" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalDiterima">Persetujuan pengajuan SPM dan Pengiriman SPM</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form class="default-form" action="" method="POST"
                enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="nim" value="{{ $nim ?? '' }}">
                <div class="modal-body">
                    <div class="row">
                        <div class="mb-0 col">
                            <label for="formFile" class="form-label">Unggah Surat Pengantar Magang</label>
                            <input class="form-control @error('dokumen_spm') is-invalid @enderror" type="file"
                                id="dokumen_spm" name="dokumen_spm">
                            @error('dokumen_spm')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="mb-3 card-subtitle text-muted">Tipe File: PDF. Maximum upload file size : 2 MB.</div>
                        <small class="text-muted">Note: Ketika mengirim SPM, secara otomatis pengajuan SPM akan disetujui dan berpindah ke tab disetujui!</small>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div> --}}


<!-- Modal Penolakan -->
{{-- <div class="modal fade" id="modalpenolakan" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="" function-callback="after">
                @csrf
                <div class="pt-0 pb-0 modal-body">
                    <h4 class="text-center">Alasan Penolakan Pengajuan Magang</h4>
                    <div class="row">
                        <div class="mb-3 col">
                            <label for="nameWithTitle" class="form-label">Alasan Penolakan Pengajuan</label>
                            <textarea type="text" class="form-control" placeholder="Masukkan alasan penolakan"></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">
                        Batal
                    </button>
                    <button type="button" class="btn btn-success">Kirim</button>
                </div>
            </form>
        </div>
    </div>
</div> --}}

<!-- Modal Persetujuan SPM -->
<div class="modal fade" id="modalpersetujuanspm" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="mx-auto">Konfirmasi Persetujuan Pengajuan Magang</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form class="default-form" action="" function-callback="afterApprove">
                @csrf
                <div class="pt-0 pb-0 modal-body">
                    <p class="mb-0 fw-semibold">Apakah anda yakin menyetujui pengajuan magang berikut?</p>
                    <p>Jika disetujui, pengajuan akan langsung diteruskan ke mitra.</p>
                    <div class="list-group list-group-flush" id="container-list-mhs"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Ya, Disetujui</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- <!-- Modal Persetujuan Pengajuan Magang -->
<div class="modal fade" id="modalpersetujuanmagang" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="pt-0 pb-0 modal-body">
                <h4 class="text-center">Persetujuan Pengajuan Magang</h4>
                <p class="mb-3 text-center" style="font-size: small;">Dokumen yang diupload wajib bertanda tangan pihak terkait</p>
                <div class="row">
                    <div class="col">
                        <label class="form-label" for="berkas">Unggah Surat Pertanggungjawaban Mutlak </label>
                        <input class="form-control" type="file" id="formFile">
                        <p style="font-size: smaller; padding-top:10px;">Allowed PDF, JPG, PNG, JPEG. Max size of 1 Mb</p>
                    </div>
                </div>
                <div class="row">
                    <div class="mb-3 col">
                        <label class="form-label" for="berkas">Unggah Surat Rekomendasi </label>
                        <input class="form-control" type="file" id="formFile">
                        <p style="font-size: smaller; padding-top:10px;">Allowed PDF, JPG, PNG, JPEG. Max size of 1 Mb</p>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">
                        Batal
                    </button>
                    <button type="button" class="btn btn-success">Kirim</button>
                </div>
            </div>
        </div>
    </div>
</div> --}}

<div class="offcanvas offcanvas-end" tabindex="-1" id="modalSlide" aria-labelledby="offcanvasAddUserLabel">
    <div class="offcanvas-header">
        <h5 id="offcanvasAddUserLabel" class="offcanvas-title">Filter Berdasarkan</h5>
        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="flex-grow-0 pt-0 mx-0 offcanvas-body h-100">
        <form class="pt-0 add-new-user" onsubmit="return false;" id="filter_form">
            <div class="mb-2 col-12">
                <div class="row">
                    <div class="mb-2">
                        <label for="prodi_filter" class="form-label">Program Studi</label>
                        <select class="form-select select2" id="prodi_filter" name="prodi" data-placeholder="Pilih Program Studi">
                            <option value="">Pilih Program Studi</option>
                            @foreach ($prodi as $index =>$item)
                                <option value="{{$item->id_prodi}}">{{$item->namaprodi}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="mb-2">
                        <label for="jenis_magang_filter" class="form-label">Jenis Magang</label>
                        <select class="form-select select2" id="jenis_magang_filter" name="prodi" data-placeholder="Pilih Jenis Magang">
                            <option value="">Pilih Jenis Magang</option>
                            @foreach ($jenis_magang as $index =>$item)
                                <option value="{{$item->id_jenismagang}}">{{$item->namajenis}} - {{ $item->durasimagang}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="mb-2">
                        <label for="label_penawaran_filter" class="form-label">Status Penawaran</label>
                        <select class="form-select select2" id="label_penawaran_filter" name="label_penawaran" data-placeholder="Pilih Jenis Magang">
                            <option value="">Pilih Status Penawaran</option>
                            @foreach($label_penawaran as $status => $info)
                                <option value="{{$status}}">
                                    {{ $info['title'] }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
            <div class="mt-3 text-end">
                <button type="reset" class="btn btn-label-danger">Reset</button>
                <button type="submit" class="btn btn-primary" id="filter-form">Terapkan</button>
            </div>
        </form>
    </div>
</div>

<div class="modal fade" id="modal-sr" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="text-center modal-header d-block">
                <h5 class="modal-title">Upload Surat</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form class="default-form" action="{{ route('pengajuan_magang.upload_sr') }}" method="POST"
                function-callback="afterActionSR">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="mb-3 col-12">
                            <h6 class="mb-2 fw-semibold">Daftar Mahasiswa yang diberikan Surat</h6>
                            <div class="" id="container-list-mhs"></div>
                            <input type="hidden" name="type" id="type" value="upload">
                        </div>
                        <div class="mb-3 col-12">
                            <div class="border-bottom"></div>
                        </div>
                        <div class="mb-3 col-12 form-group">
                            <label for="type_file" class="form-label">Tipe Surat<span class="text-danger">*</span></label>
                            <select class="form-select select2" name="type_file" id="type_file" data-placeholder="Pilih Tipe Surat">
                                <option value="" selected disabled>Pilih Tipe Surat</option>
                                <option value="surat_rekomendasi">Surat Rekomendasi</option>
                                <option value="surat_pengantar_magang">Surat Pengantar Magang</option>
                            </select>
                            <div class="invalid-feedback"></div>
                        </div>
                        <div class="mb-3 col-12 form-group">
                            <label for="dokumen" class="form-label">Surat<span class="text-danger">*</span></label>
                            <input type="file" class="form-control" name="dokumen" id="dokumen" accept="application/pdf" >
                            <small class="text-right text-muted">Tipe file harus berbentuk .pdf | Ukuran maksimal : 2MB.</small>
                            <div class="invalid-feedback"></div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" id="batal-button" onclick="batalSR($(this))" class="btn btn-danger">Batalkan Surat</button>
                    <button type="submit" id="upload-button" class="btn btn-primary">Upload</button>
                </div>
            </form>
        </div>
    </div>
</div>
