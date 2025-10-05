<div class="auto-container container-p-y" style="background-color: #F8F8F8;background-repeat: no-repeat; background-size: cover; background-image: url({{asset('assets/images/background.png')}});">
    <div class="d-flex justify-content-center utilities-lowongan">
        <div class="col-lg-5 search-lowongan">
            {{-- <div class="border input-group input-group-merge">
                <span class="input-group-text" id="basic-addon-search31"><i class="ti ti-search"></i></span>
                <input type="text" id="lowongan_magang" class="form-control" placeholder="Lowongan Magang">
            </div> --}}
            <div class="border input-group input-group-merge">
                <span class="input-group-text" id="basic-addon-search31"><i class="ti ti-search"></i></span>
                <input type="text" id="lowongan_magang" class="form-control" placeholder="Lowongan Magang">
            </div>
        </div>
        <div class="col-lg-5 search-lowongan-mobile">
            {{-- <div class="border input-group input-group-merge">
                <span class="input-group-text" id="basic-addon-search31"><i class="ti ti-search"></i></span>
                <input type="text" id="lowongan_magang" class="form-control" placeholder="Lowongan Magang">
            </div> --}}
            <div class="border input-group input-group-merge">
                <span class="input-group-text" id="basic-addon-search31"><i class="ti ti-search"></i></span>
                <input type="text" id="lowongan_magang" class="form-control" placeholder="Lowongan Magang">
                <button class="btn filter" style="background-color: white;">
                    <i class="ti ti-filter"></i>
                </button>
            </div>
        </div>

        {{-- <div class="col-lg-5 search-perusahaan-mobile">
            <div class="border input-group input-group-merge">
                <span class="input-group-text" id="basic-addon-search31"><i class="ti ti-search"></i></span>
                <input type="text" id="nama_perusahaan" class="form-control" placeholder="Nama Perusahaan">
                <button class="btn filter-perusahaan" style="background-color: white;">
                    <i class="ti ti-filter"></i>
                </button>
            </div>
        </div>
        <div class="col-lg-5 search-perusahaan">
            <div class="border input-group input-group-merge">
                <span class="input-group-text" id="basic-addon-search31"><i class="ti ti-search"></i></span>
                <input type="text" id="nama_perusahaan" class="form-control" placeholder="Nama Perusahaan">
            </div>
        </div> --}}

        <div class="mx-2 col-3 lokasi-lowongan-magang">
            <div class="bg-white border input-group input-group-merge">
                <span class="input-group-text"><i class="ti ti-map-pin"></i></span>
                <select name="location" id="location" class="select2 form-select" data-placeholder="Lokasi Magang" data-allow-clear="true">
                    <option value disabled selected> Lokasi Magang </option>
                    @foreach($kota as $item)
                        <option value="{{ $item->name }}">{{ $item->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="mx-2 col-3 jenis-lowongan-magang">
            <div class="bg-white border input-group input-group-merge">
                <span class="input-group-text"><i class="ti ti-calendar-time"></i></span>
                <select name="jenis_magang" id="jenis_magang" class="select2 form-select" data-placeholder="Jenis Magang" data-allow-clear="true">
                    <option value disabled selected> Jenis Magang </option>
                    @foreach($jenisMagang as $item)
                        <option value="{{ $item->id_jenismagang }}">{{ $item->namajenis }} ({{ $item->durasimagang }})</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="col-auto cari-lowongan-magang">
            <button class="btn btn-primary h-100" id="search" type="button" onclick="filter();">Cari sekarang</button>
        </div>
    </div>
    <div class="mt-4 mb-3 row d-flex justify-content-center filter-spesific">
        <div class="ms-5 col-md-2">
            <p class="bg-transparent flatpickr-input" id="picker_range">Tanggal Posting <i class=" ti ti-chevron-down" style="font-size: 15px;"></i></p>
        </div>
        <div class="col-md-2">
            <div class="dropdown">
                <a class="cursor-pointer dropdown-toogle" data-bs-toggle="dropdown" aria-expanded="false">
                    Perusahaan
                    <i class="pb-1 ti ti-chevron-down" style="font-size: medium;"></i>
                </a>
                <ul class="pt-3 dropdown-menu form-filter" aria-labelledby="dropdownMenu1" style="min-width: 230px !important;">
                    <div style="max-height: 30rem; overflow-y: auto;">
                        @foreach ($perusahaan as $key => $item)
                        <li class="px-3 mb-2">
                            <div class="form-check" style="margin-top: 0px; margin-right:3px">
                                <input class="form-check-input" name="perusahaan[]" type="checkbox" value="{{ $item->id_industri }}" id="checkbox-{{ $key }}">
                                <label class="form-check-label" for="checkbox-{{ $key }}"> {{ $item->namaindustri }} </label>
                            </div>
                        </li>
                        @endforeach
                    </div>
                    <hr>
                    <div class="d-flex justify-content-between ms-2 me-2">
                        <button class="btn btn-sm btn-outline-danger" type="reset">Reset</button>
                        <button class="btn btn-sm btn-success" type="button">Terapkan</button>
                    </div>
                </ul>
            </div>
        </div>
        <div class="col-md-2">
            <div class="dropdown">
                <a class="cursor-pointer dropdown-toogle" data-bs-toggle="dropdown" aria-expanded="false">
                    Uang Saku
                    <i class="pb-1 ti ti-chevron-down" style="font-size: medium;"></i>
                </a>
                <ul class="pt-3 dropdown-menu form-filter" aria-labelledby="dropdownMenu1" style="min-width: 250px !important;">
                    <div class="mb-2 form-check ms-2">
                        <input name="paymentType" class="form-check-input" type="radio" value="tidakBerbayar" id="tidakBerbayarRadio">
                        <label class="form-check-label" for="tidakBerbayarRadio"> Tidak Berbayar </label>
                    </div>
                    <div class="mb-2 form-check ms-2">
                        <input name="paymentType" class="form-check-input" type="radio" value="berbayar" id="berbayarRadio">
                        <label class="form-check-label" for="berbayarRadio"> Berbayar </label>
                    </div>
                    <div class="mx-2" id="container-nominal-minimal" style="display: none;">
                        <div class="border input-group">
                            <span class="input-group-text" id="basic-addon11">IDR</span>
                            <input type="text" id="nominal_minimal" name="nominal_minimal" class="form-control ps-0" onkeyup="this.value = formatRupiah(this.value);" placeholder="Minimal nominal">
                        </div>
                    </div>
                    <hr>
                    <div class=" d-flex justify-content-between ms-2 me-2">
                        <button class="btn btn-sm btn-outline-danger" type="reset">Reset</button>
                        <button class="btn btn-sm btn-success" type="button">Terapkan</button>
                    </div>
                </ul>
            </div>
        </div>
        <div class="col-md-2">
            <div class="dropdown">
                <a class="cursor-pointer dropdown-toogle" data-bs-toggle="dropdown" aria-expanded="false">
                    Pelaksanaan
                    <i class="pb-1 ti ti-chevron-down" style="font-size: medium;"></i>
                </a>
                <ul class="pt-3 dropdown-menu form-filter" aria-labelledby="dropdownMenu1" style="min-width: 230px !important;">
                    <li class="px-3 mb-2">
                        <div class="form-check" style="margin-top: 0px; margin-right:3px">
                            <input class="form-check-input" name="pelaksanaan[]" type="checkbox" value="Onsite" id="checkbox-onsite">
                            <label class="form-check-label" for="checkbox-onsite"> Onsite  </label>
                        </div>
                    </li>
                    <li class="px-3 mb-2">
                        <div class="form-check" style="margin-top: 0px; margin-right:3px">
                            <input class="form-check-input" name="pelaksanaan[]" type="checkbox" value="Hybrid" id="checkbox-hybrid">
                            <label class="form-check-label" for="checkbox-hybrid"> Hybrid  </label>
                        </div>
                    </li>
                    <li class="px-3 mb-2">
                        <div class="form-check" style="margin-top: 0px; margin-right:3px">
                            <input class="form-check-input" name="pelaksanaan[]" type="checkbox" value="Online" id="checkbox-online">
                            <label class="form-check-label" for="checkbox-online"> Online  </label>
                        </div>
                    </li>
                    <hr>
                    <div class=" d-flex justify-content-between ms-2 me-2">
                        <button class="btn btn-sm btn-outline-danger" type="reset">Reset</button>
                        <button class="btn btn-sm btn-success" type="button">Terapkan</button>
                    </div>
                </ul>
            </div>
        </div>
    </div>
</div>
