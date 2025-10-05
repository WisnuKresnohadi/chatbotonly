@if (count($dokumenPendukung) > 0)
    @foreach ($dokumenPendukung->take(2) as $key => $item)
        <div class="mb-3 pb-3 {{ count($dokumenPendukung) != $key + 1 ? 'border-bottom' : '' }}">
            <div class="d-flex justify-content-between mb-1">
                <h5 class="fw-bolder mb-0">{{ $item->nama_sertif }}</h5>
                <div class="d-flex justify-content-end">
                    <a class="cursor-pointer mx-1 text-warning" onclick="editData($(this))"
                        data-target-modal="modalTambahDokumen" data-id="{{ $item->id_sertif }}">
                        <i class="ti ti-edit"></i>
                    </a>
                    <a class="cursor-pointer mx-1 text-danger" onclick="deleteData($(this))"
                        data-function="afterDeleteDokumen"
                        data-url="{{ route('profile.delete_dokumen', ['id' => $item->id_sertif]) }}">
                        <i class="ti ti-trash"></i>
                    </a>
                </div>
            </div>
            <p class="mb-1" style="font-size: small">{{ $item->penerbit }}</p>
            @if ($item->enddate == null)
                <p class="mb-1">{{ Carbon\Carbon::parse($item->startdate)->format('F Y') }}&ensp;-&ensp;Sekarang</p>
            @else
                <p class="mb-1">
                    {{ Carbon\Carbon::parse($item->startdate)->format('F Y') }}&ensp;-&ensp;{{ Carbon\Carbon::parse($item->enddate)->format('F Y') }}
                </p>
            @endif
            <p class="mb-0 text-justify">
                <span id="headline" class="headliner">{{ \Illuminate\Support\Str::limit($item->deskripsi ?? '-', 100) }}</span>

                @if (strlen($item->deskripsi) > 100)
                <u class="show-btn link-success cursor-pointer" 
                data-deskripsi="{{ $item->deskripsi ?? '-' }}" 
                onclick="showMore(this)">
                Show More
                </u>
                @endif
            </p>      
            <div class="d-flex justfiy-content-start align-items-center">
                <a href="{{ url('storage/' . $item->file_sertif) }}" target="_blank" class="d-flex align-items-center text-decoration-underline">
                    @php
                        $image = url('storage/' . $item->file_sertif);
                        $fileInfo = pathinfo($image);
                        if (isset($fileInfo['extension']) && strtolower($fileInfo['extension']) === 'pdf') {
                            $image = asset('app-assets/img/icons/misc/pdf2.png');
                        }
                    @endphp
                    <img class="me-2" src="{{ $image }}" width="150" height="auto" alt="img">
                    <p class="mb-0">{{ $item->nama_sertif . '.' . ($fileInfo['extension'] ?? 'pdf')}}</p>
                </a>                
            </div>
        </div>               
    @endforeach
    <div id="collapseDokumenPendukung" class="accordion-collapse collapse" aria-labelledby="headingOne"
            data-bs-parent="#accordionDokumenPendukung">
            <div class="mb-3">
                @foreach ($dokumenPendukung->skip(2) as $key => $item)
                    <div class="mb-3 pb-3 {{ count($dokumenPendukung) != $key + 1 ? 'border-bottom' : '' }}">
                        <div class="d-flex justify-content-between mb-1">
                            <h5 class="fw-bolder mb-0">{{ $item->nama_sertif }}</h5>
                            <div class="d-flex justify-content-end">
                                <a class="cursor-pointer mx-1 text-warning" onclick="editData($(this))"
                                    data-target-modal="modalTambahDokumen" data-id="{{ $item->id_sertif }}">
                                    <i class="ti ti-edit"></i>
                                </a>
                                <a class="cursor-pointer mx-1 text-danger" onclick="deleteData($(this))"
                                    data-function="afterDeleteDokumen"
                                    data-url="{{ route('profile.delete_dokumen', ['id' => $item->id_sertif]) }}">
                                    <i class="ti ti-trash"></i>
                                </a>
                            </div>
                        </div>
                        <p class="mb-1" style="font-size: small">{{ $item->penerbit }}</p>
                        @if ($item->enddate == null)
                            <p class="mb-1">
                                {{ Carbon\Carbon::parse($item->startdate)->format('F Y') }}&ensp;-&ensp;Sekarang</p>
                        @else
                            <p class="mb-1">
                                {{ Carbon\Carbon::parse($item->startdate)->format('F Y') }}&ensp;-&ensp;{{ Carbon\Carbon::parse($item->enddate)->format('F Y') }}
                            </p>
                        @endif
                        <p class="mb-0 text-justify">
                            <span id="headline" class="headliner">{{ \Illuminate\Support\Str::limit($item->deskripsi ?? '-', 100) }}</span>
            
                            @if (strlen($item->deskripsi) > 100)
                            <u class="show-btn link-success cursor-pointer" 
                            data-deskripsi="{{ $item->deskripsi ?? '-' }}" 
                            onclick="showMore(this)">
                            Show More
                            </u>
                            @endif
                        </p>      
                        <div class="d-flex justfiy-content-start align-items-center">
                            <a href="{{ url('storage/' . $item->file_sertif) }}" target="_blank" class="d-flex align-items-center text-decoration-underline">
                                @php
                                    $image = url('storage/' . $item->file_sertif);
                                    $fileInfo = pathinfo($image);
                                    if (isset($fileInfo['extension']) && strtolower($fileInfo['extension']) === 'pdf') {
                                        $image = asset('app-assets/img/icons/misc/pdf2.png');
                                    }
                                @endphp
                                <img class="me-2" src="{{ $image }}" width="150" height="auto" alt="img">
                                <p class="mb-0">{{ $item->nama_sertif . '.' . ($fileInfo['extension'] ?? 'pdf')}}</p>
                            </a>            
                        </div>
                    </div>
                @endforeach
            </div>
        </div> 
    @if (count($dokumenPendukung) > 2)
            <button class="btn btn-outline-primary w-100 btn-collapse" type="button" data-bs-toggle="collapse"
                data-bs-target="#collapseDokumenPendukung" aria-expanded="false" aria-controls="collapseDokumenPendukung">
                Selengkapnya
            </button>
    @endif
@else
    <img src="\assets\images\nothing.svg" alt="no-data"
        style="display: flex; margin-left: auto; margin-right: auto; margin-top: 5%; margin-bottom: 5%;  width: 28%;">
    <div class="sec-title mt-5 mb-4 text-center">
        <h4>Anda belum menambahkan dokumen pendukung</h4>
    </div>
@endif
