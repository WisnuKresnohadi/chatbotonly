@if (count($competition) > 0)
    <ul class="timeline ms-2 mb-0">
        @foreach ($competition->take(2) as $key => $item)
            <li
                class="timeline-item timeline-item-transparent ps-4 {{ count($competition) == $key + 1 ? 'border-0' : '' }}">
                <span class="timeline-point timeline-point-primary"></span>
                <div class="timeline-event pe-4">
                    <div class="d-flex justify-content-between">
                        <h5 class="fw-bolder mb-2">{{ $item->prestasi }}</h5>
                        <div class="d-flex justify-content-end">
                            <a class="cursor-pointer mx-1 text-warning" onclick="editData($(this))"
                                data-target-modal="modalTambahKompetisi" data-id="{{ $item->id_experience }}">
                                <i class="ti ti-edit"></i>
                            </a>
                            <a class="cursor-pointer mx-1 text-danger" onclick="deleteData($(this))"
                                data-function="afterDeleteCompetition"
                                data-url="{{ route('profile.delete_experience', ['id' => $item->id_experience]) }}">
                                <i class="ti ti-trash"></i>
                            </a>
                        </div>
                    </div>
                    <p class="mb-1">{{ $item->nama }}&ensp;-&ensp;{{ $item->name_intitutions }}</p>
                    @if ($item->enddate == null)
                    <small class="mb-1">{{ Carbon\Carbon::parse($item->startdate)->format('F Y') }}&ensp;-&ensp;Sekarang</small>
                    @else
                    <small class="mb-1">{{ Carbon\Carbon::parse($item->startdate)->format('F Y') }}&ensp;-&ensp;{{ Carbon\Carbon::parse($item->enddate)->format('F Y') }}</small>
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
                    <div class="border-bottom mt-3"></div>
                </div>
            </li>
        @endforeach
        <div id="collapseKompetisi" class="accordion-collapse collapse" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
            <div class="mb-3">
                @foreach ($competition->skip(2) as $key => $item)                                
                <li
                    class="timeline-item timeline-item-transparent ps-4 {{ count($competition) == $key + 1 ? 'border-0' : '' }}">
                    <span class="timeline-point timeline-point-primary"></span>
                    <div class="timeline-event pe-4">
                        <div class="d-flex justify-content-between">
                            <h5 class="fw-bolder mb-2">{{ $item->prestasi }}</h5>
                            <div class="d-flex justify-content-end">
                                <a class="cursor-pointer mx-1 text-warning" onclick="editData($(this))"
                                    data-target-modal="modalTambahKompetisi" data-id="{{ $item->id_experience }}">
                                    <i class="ti ti-edit"></i>
                                </a>
                                <a class="cursor-pointer mx-1 text-danger" onclick="deleteData($(this))"
                                    data-function="afterDeleteCompetition"
                                    data-url="{{ route('profile.delete_experience', ['id' => $item->id_experience]) }}">
                                    <i class="ti ti-trash"></i>
                                </a>
                            </div>
                        </div>
                        <p class="mb-1">{{ $item->nama }}&ensp;-&ensp;{{ $item->name_intitutions }}</p>
                        @if ($item->enddate == null)
                        <small class="mb-1">{{ Carbon\Carbon::parse($item->startdate)->format('F Y') }}&ensp;-&ensp;Sekarang</small>
                        @else
                        <small class="mb-1">{{ Carbon\Carbon::parse($item->startdate)->format('F Y') }}&ensp;-&ensp;{{ Carbon\Carbon::parse($item->enddate)->format('F Y') }}</small>
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
                        <div class="border-bottom mt-3"></div>
                    </div>
                </li>
            @endforeach
            </div>
        </div>
        @if (count($competition) > 2)
            <button class="btn btn-outline-primary w-100 btn-collapse" type="button" data-bs-toggle="collapse"
                data-bs-target="#collapseKompetisi" aria-expanded="false" aria-controls="collapseKompetisi">
                Selengkapnya
            </button>
        @endif
    </ul>
@else
    <img src="\assets\images\nothing.svg" alt="no-data"
        style="display: flex; margin-left: auto; margin-right: auto; margin-top: 5%; margin-bottom: 5%;  width: 28%;">
    <div class="sec-title mt-5 mb-4 text-center">
        <h4>Anda belum menambahkan riwayat pengalaman kompetisi</h4>
    </div>
@endif
