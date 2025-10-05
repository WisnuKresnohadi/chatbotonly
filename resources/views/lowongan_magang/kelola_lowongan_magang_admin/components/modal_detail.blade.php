<div class="modal fade" id="modalapprove" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header text-center">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                <h5 class="modal-title">
                    {{ $isMappedMk ? 'Apakah Anda Yakin Menyetujui Lowongan' : 'Mapping Bidang Pekerjaan dan MK' }}
                </h5>
            </div>
            <form class="default-form"
                action="{{ route('lowongan.kelola.approved', ['id' => $lowongan->id_lowongan]) }}"
                function-callback="afterApprove">
                @csrf
                <div class="modal-body py-3">
                    @if ($isMappedMk)
                        <div class="row">
                            <div class="form-group col-12 mb-3">
                                <label for="tahun_ajaran">Tahun Ajaran<span class="text-danger">*</span></label>
                                <select class="form-select select2" name="tahun_ajaran" id="tahun_ajaran"
                                    data-placeholder="Pilih Tahun Ajaran">
                                    <option value="" disabled selected>Pilih Tahun Ajaran</option>
                                    @if ($tahunAjaran->count() > 1)
                                        @foreach ($tahunAjaran as $item)
                                            <option value="{{ $item->id_year_akademik }}">{{ $item->tahun }}
                                                [{{ $item->semester }}]</option>
                                        @endforeach
                                    @else
                                        {{-- karena hanya boleh satu tahun akademik yang aktif pada master data --}}
                                        @php($item = $tahunAjaran->first())
                                        <option selected value="{{ $item->id_year_akademik }}">{{ $item->tahun }}
                                            [{{ $item->semester }}]</option>
                                    @endif
                                </select>
                                <div class="invalid-feedback"></div>
                            </div>
                            <div class="form-group col-6">
                                <label for="mulai_magang">Mulai Magang<span class="text-danger">*</span></label>
                                <input type="text" name="mulai_magang" id="mulai_magang"
                                    class="form-control flatpickr-date cursor-pointer">
                                <div class="invalid-feedback"></div>
                            </div>
                            <div class="form-group col-6">
                                <label for="selesai_magang">Akhir Magang<span class="text-danger">*</span></label>
                                <input type="text" name="selesai_magang" id="selesai_magang"
                                    class="form-control flatpickr-date cursor-pointer">
                                <div class="invalid-feedback"></div>
                            </div>
                            <div class="mt-3"></div>
                            @foreach ($lowongan->jenjang_pendidikan as $key => $item)
                                <div class="form-group col-12 mb-3">
                                    <label for="prodi-{{ $item }}" class="form-label">Masukkan Program Studi
                                        relevan - {{ $item }}<span class="text-danger">*</span></label>
                                    <select class="form-select select2" id="prodi-{{ $item }}"
                                        name="prodi_{{ $item }}[]" multiple="multiple"
                                        data-placeholder="Pilih Prodi">
                                        @foreach ($prodi->where('jenjang', $item) as $p)
                                            <option value="{{ $p->id_prodi }}">{{ $p->namaprodi }}</option>
                                        @endforeach
                                    </select>
                                    <div class="invalid-feedback"></div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div style="background-color: #FF9F4329; color:#FF9F43;"
                            class="p-2 rounded  d-flex align-items-center">
                            <i class="tf-icons ti ti-info-circle me-2 ps-2 pe-1"></i>
                            <span>Bidang Pekerjaan belum di Mapping dengan MK Per Prodi, Silahkan Mapping Telebih
                                Dahulu.</span>
                        </div>
                    @endif
                </div>
                <div class="modal-footer">
                    @if ($isMappedMk)
                        <button type="submit" class="btn btn-primary mx-0">Approve Lowongan</button>
                    @else
                        <a href="{{ route('perusahaan.bidangpekerjaanperusahaan', $lowongan->id_industri) }}">
                            <button type="button" class="btn btn-primary mx-0">Lanjut Mapping MK</button>
                        </a>
                    @endif
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="modalreject" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header text-center">
                <h5 class="modal-title" id="modalreject">Alasan Penolakan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form class="default-form"
                action="{{ route('lowongan.kelola.rejected', ['id' => $lowongan->id_lowongan]) }}"
                function-callback="afterReject">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="col form-group mb-2">
                            <label for="alasan" class="form-label">Alasan Penolakan</label>
                            <textarea class="form-control" name="alasan" rows="3" id="alasan" placeholder="Alasan Penolakan"></textarea>
                            <div class="invalid-feedback"></div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" id="rejected-confirm-button" class="btn btn-primary">Kirim</button>
                </div>
        </div>
        </form>
    </div>
</div>
