<div class="content">
    <div class="mb-3 content-header">
        <h4 class="mb-0">Kualifikasi Lowongan </h4>
    </div>
    <div class="row g-3">
        {{-- Kualifikasi Pendidikan --}}
        <div class="col-lg-12 col-sm-6">
            <div class="px-3 pt-2 pb-3 border rounded-3">
                <span>Kualifikasi Pendidikan</span>
                <div class="mt-2 form-group">
                    <label for="jenjang" class="form-label">Jenjang<span class="text-danger">*</span></label>
                    <select name="jenjang[]" id="jenjang" multiple="multiple" class="select2 form-select" data-placeholder="Pilih Jenjang">
                        <option value="D3">D3</option>
                        <option value="D4">D4</option>
                        <option value="S1">S1</option>
                        {{-- <option value="S2">S2</option> --}}
                    </select>
                    <div class="invalid-feedback"></div>
                </div>
            </div>
        </div>
        {{-- End Kualifikasi Pendidikan --}}

        {{-- Keterampilan --}}
        <div class="col-lg-12 col-sm-6">
            <div class="px-3 pt-2 pb-3 border rounded-3">

                {{-- keterampilan --}}
                <div class="mt-2 form-group">
                    <label for="keterampilan" class="form-label">Keterampilan/Sertifikasi<span class="text-danger">*</span></label>
                    <select name="keterampilan[]" id="keterampilan" multiple="multiple" class="select2 form-select" data-placeholder="Isi dengan Keterampilan/Sertifikasi yang di butuhkan" data-tags="true">

                    </select>
                    <div class="invalid-feedback"></div>
                </div>

                {{-- Pencapaian --}}
                <div class="mt-3 form-group">
                    <label for="pencapaian" class="form-label">Prestasi/Kejuaraan<span class="text-danger">*</span></label>
                    <select name="pencapaian[]" id="pencapaian" multiple="multiple" class="select2 form-select" data-placeholder="Isi dengan Prestasi/Kejuaraan" data-tags="true">

                    </select>
                    <div class="invalid-feedback"></div>
                </div>

                {{-- Pengalaman --}}
                <div class="mt-3 form-group">
                    <label for="pengalaman" class="form-label">Pengalaman Praktis/Proyek<span class="text-danger">*</span></label>
                    <select name="pengalaman[]" id="pengalaman" multiple="multiple" class="select2 form-select" data-placeholder="Isi dengan Prestasi/Kejuaraan" data-tags="true">

                    </select>
                    <div class="invalid-feedback"></div>
                </div>

            </div>
        </div>
        {{-- End Keterampilan --}}

        {{-- Requirement Tamban (pengganti Requirement sekarang) --}}
        <div class="persyaratan-tambahan-repeater col-lg-12 col-sm-6 form-group" data-limit="3">
            <div class="px-3 pt-2 pb-3 border rounded-3">
                <h6 class="mb-3">Pertanyaan untuk Sesi Wawancara dengan Chatbot</h6>
                <div style="background-color: #D4F4F9; color:#4499AB;"
                class="p-2 mb-3 rounded d-flex align-items-center">
                <i class="tf-icons ti ti-info-circle me-2 ps-2 pe-1"></i>
                <span>Produk talentern dilengkapi dengan fitur chatbot, anda dapat memasukkan pertanyaan anda ke dalamnya, dengan cara mengisi field input yang tersedia.</span>
                </div>
                <div class="mb-3 col-12 form-group">
                    <label for="softskill" class="form-label">Soft Skills yang akan digali lebih dalam (minimal 1 dan maksimal 3)<span style="color: red;">*</span></label>
                    <select class="form-select select2" name="softskill[]" id="softskill" data-placeholder="Pilih Soft Skills" data-tags="true" multiple>
                        <option value="Adaptasi">Adaptasi</option>
                        <option value="Komunikasi">Komunikasi</option>
                        <option value="Kepemimpinan">Kepemimpinan</option>
                        <option value="Kepercayaan Diri">Kepercayaan Diri</option>
                        <option value="Manajemen Waktu">Manajemen Waktu</option>
                        <option value="Pemecahan Masalah">Pemecahan Masalah</option>
                    </select>
                    {{-- <span class="text-danger" style="font-size: small;">*Maksimal 3 Jenis Soft Skill yang dapat dipilih</span> --}}
                    <div class="invalid-feedback"></div>
                </div>
                <div data-repeater-list="persyaratan_tambahan">
                    <div data-repeater-item data-callback="afterShown">
                        <div class="gap-3 mb-3 justify-content-between d-flex">
                            <div class="w-100">
                                <h6>Pertanyaan Tambahan</h6>
                                <label class="form-label" for="persyaratan_tambah">Pertanyaan tambahan tidak akan diproses sebagai penilaian oleh sistem chatbot, melainkan hanya dicatat dalam kategori "Keterangan Lain" dan disimpulkan.</label>
                                <input type="text" name="persyaratan_tambah" id="persyaratan_tambah" class="form-control" placeholder="Tulis Pertanyaan">
                            </div>
                                <button type="button" class="mt-4 btn btn-outline-danger" data-repeater-delete>
                                <i class="ti ti-trash"></i>
                            </button>
                        </div>

                    </div>
                </div>
                <div class="mt-4 border-top">
                    <button class="mt-4 btn btn-outline-warning " type="button" data-repeater-create>
                        <i class="ti ti-plus me-1"></i>
                        <span class="align-middle">Pertanyaan</span>
                    </button>
                </div>
            </div>
        </div>
        {{-- Requirement Tamaban (pengganti Requirement sekarang) --}}

        {{-- Pelaksanaan --}}
        <div class="form-group col-lg-12 col-sm-6">
            <label for="pelaksanaan" class="form-label">Pelaksanaan Magang<span class="text-danger">*</span></label>
            <div class="mt-2 col">
                <div class="form-check form-check-inline">
                    <input name="pelaksanaan" id="pelaksanaan_online" class="form-check-input" type="radio" value="Online" />
                    <label class="form-check-label" for="pelaksanaan_online">Online</label>
                </div>
                <div class="form-check form-check-inline">
                    <input name="pelaksanaan" id="pelaksanaan_onsite" class="form-check-input" type="radio" value="Onsite" />
                    <label class="form-check-label" for="pelaksanaan_onsite">Onsite</label>
                </div>
                <div class="form-check form-check-inline">
                    <input name="pelaksanaan" id="pelaksanaan_hybrid" class="form-check-input" type="radio" value="Hybrid" />
                    <label class="form-check-label" for="pelaksanaan_hybrid">Hybrid</label>
                </div>
            </div>
            <div class="invalid-feedback"></div>
        </div>
        {{-- End Pelaksanaan --}}

        {{-- Uang Saku (Ya/Tidak) --}}
        <div class="gap-3 col-lg-12 col-sm-6 d-flex">
            <div class="form-group">
                <label for="gaji" class="form-label d-block">Apakah Peserta Magang Diberikan Uang Saku?<span class="text-danger">*</span></label>
                <div class="mt-2 col">
                    <div class="form-check form-check-inline">
                        <input name="gaji" id="gaji_ya" class="form-check-input" type="radio" value="1" checked />
                        <label class="form-check-label" for="gaji_ya">Ya</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input name="gaji" id="gaji_tidak" class="form-check-input" type="radio" value="0" />
                        <label class="form-check-label" for="gaji_tidak">Tidak</label>
                    </div>
                </div>
                <div class="invalid-feedback"></div>
            </div>
            <div class="form-group">
                <label class="form-label" for="nominal_salary " name="nominal_salary">Nominal Uang Saku<span class="text-danger">*</span></label>
                <div class="mb-3 border rounded input-group">
                    <input type="text" class="border-0 form-control" name="nominal_salary" id="nominal_salary" onkeyup="this.value = formatRupiah(this.value);" placeholder="Masukan Nominal" />
                    <div class="border-0 input-group-append">
                        <span class="border-0 input-group-text" id="basic-addon2">IDR</span>
                    </div>
                </div>
                <div class="invalid-feedback"></div>
            </div>
        </div>
        {{-- End Uang Saku (Ya/Tidak) --}}

        {{-- Benefit --}}
        <div class="form-group col-lg-12 col-sm-6">
            <label for="benefitmagang" class="form-label">Keuntungan Lain yang Didapat (Opsional)</label>
            <textarea class="form-control" rows="2" id="benefitmagang" name="benefitmagang" placeholder="Masukan Benefits"></textarea>
            <div class="invalid-feedback"></div>
        </div>
        {{-- End Benefit --}}

        {{-- Lokasi Penempatan Magang --}}
        <div class="form-group col-lg-12 col-sm-6">
            <label for="lokasi" class="form-label">Lokasi Penempatan<span class="text-danger">*</span></label>
            <select name="lokasi[]" id="lokasi" multiple="multiple" class="select2 form-select" data-placeholder="Masukan Lokasi Pekerjaan">
                @foreach($kota as $k)
                    <option value="{{ $k->name }}">{{ $k->name }}</option>
                @endforeach
            </select>
            <div class="invalid-feedback"></div>
        </div>
        {{-- End Lokasi Penempatan Magang --}}

        {{-- Jenis Kelamin --}}
        <div class="col-lg-12 col-sm-6 form-group">
            <label class="form-label">Jenis kelamin<span class="text-danger">*</span></label>
            <div class="mt-2 col">
                <div class="form-check form-check-inline">
                    <input name="gender[]" id="laki-laki" class="form-check-input" type="checkbox" value="Laki-Laki" />
                    <label class="form-check-label" for="laki-laki">Laki-Laki</label>
                </div>
                <div class="form-check form-check-inline">
                    <input name="gender[]" id="perempuan" class="form-check-input" type="checkbox" value="Perempuan" />
                    <label class="form-check-label" for="perempuan">Perempuan</label>
                </div>
            </div>
            <div class="invalid-feedback"></div>
        </div>
        {{-- End Jenis Kelamin --}}

        <div class="mt-3 col-lg-12 col-sm-6">
            <div class="d-flex justify-content-center">
                <div class="form-group me-4" style="flex: 1;">
                    <label for="mulai" class="form-label">Tanggal Mulai Seleksi<span class="text-danger">*</span></label>
                    <input class="cursor-pointer form-control flatpickr-date" type="text" id="mulai" name="tgl_mulai" placeholder="YYYY-MM-DD" readonly="readonly">
                    <div class="invalid-feedback"></div>
                </div>
                {{-- <div class="mt-3" style="text-align: center; background-color: black; width: 14px; height: 1px; margin: 0 20px"></div> --}}
                <div class="form-group ms-4" style="flex: 1;">
                    <label for="akhir" class="form-label">Tanggal Akhir Seleksi<span class="text-danger">*</span></label>
                    <input class="cursor-pointer form-control flatpickr-date" type="text" id="akhir" name="tgl_akhir" placeholder="YYYY-MM-DD" readonly="readonly">
                    <div class="invalid-feedback"></div>
                </div>
            </div>
        </div>

        {{-- Prev/Next --}}
        <div class="col-12 d-flex justify-content-between">
            <button type="button" class="btn btn-label-secondary btn-prev">
                <i class="ti ti-arrow-left me-sm-1 me-0"></i>
                <span class="align-middle d-sm-inline-block d-none">Previous</span>
            </button>
            <button class="btn btn-success button-next" type="button" data-step="{{ Crypt::encryptString("2") }}">
                <span class="align-middle d-sm-inline-block d-none me-sm-1">Submit</span>
                <i class="ti ti-arrow-right"></i>
            </button>
        </div>
        {{-- End Prev/Next --}}
    </div>
</div>
