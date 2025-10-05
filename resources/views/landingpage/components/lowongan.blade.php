<div class="nav-align-top">
    <h2 class="text-center mt-3">Lowongan Magang Untuk Kamu</h2>
    <p class="text-center mt-1" style="font-size:20px;">Temukan berbagai lowongan kerja yang kamu inginkan</p>
    <ul class="nav nav-pills mt-2 mb-3 justify-content-center" role="tablist">
        <li class="nav-item" style="font-size: large;">
            <button type="button" class="nav-link active" role="tab" data-bs-toggle="tab" data-bs-target="#navs-pills-justified-terbaru" aria-controls="navs-pills-justified-terbaru" aria-selected="false"> Lowongan Terbaru</button>
        </li>
        <li class="nav-item" style="font-size: large;">
            <button type="button" class="nav-link" role="tab" data-bs-toggle="tab" data-bs-target="#navs-pills-justified-populer" aria-controls="navs-pills-justified-populer" aria-selected="false"> Lowongan Populer</button>
        </li>
    </ul>
</div>
<div class="tab-content p-0">
    <div class="tab-pane fade show active" id="navs-pills-justified-terbaru" role="tabpanel">
        <div class="row d-flex justify-content-center mx-5 px-md-5">
            @foreach ($lowonganTerbaru as $key => $item)
                <div class="col-md-4 mt-4">
                    <div class="card h-100 border">
                        <div class="card-body pb-0">
                            <div class="row">
                                <div class="col-12">
                                    <div class="d-flex justify-content-between" style="height: 70px;">
                                        <img class="img-fluid h-100" src="{{ $item->image }}" alt="admin.upload">
                                        <div class="clock">{{ $item->created_at }}</div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <p class="mb-0 mt-3 text-truncate" style="font-size:18px;">{{ $item->namaindustri }}</p>
                                </div>
                            </div>
                            <h3 class="mb-3 text-truncate">{{ $item->intern_position }}</h3>
                            <div class="location mb-3">
                                <i class="ti ti-map-pin"></i>
                                <span class="ps-2">{{ $item->lokasi }}</span>
                            </div>
                            <div class="location mb-3">
                                <i class="ti ti-cash"></i>
                                <span class="ps-2 text-truncate">{{ uangSakuRupiah($item->nominal_salary) }}</span>
                            </div>
                            <div class="location mb-3">
                                <i class="ti ti-calendar-time"></i>
                                <span class="ps-2 text-truncate">{{ $item->durasimagang }}</span>
                            </div>
                            
                        </div>
                        <div class="card-footer">
                            <div class="demo-inline-spacing text-center">
                                <a href="{{ route('dashboard.detail-lowongan', $item->id_lowongan) }}" class="w-75 btn btn-primary">Detail</a>
                            </div>  
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <div class="tab-pane fade show" id="navs-pills-justified-populer" role="tabpanel">
        <div class="row d-flex justify-content-center mx-5 px-md-5">
            @foreach ($lowonganPopuler as $key => $item)
                <div class="col-md-4 mt-4">
                    <div class="card h-100 border">
                        <div class="card-body pb-0">
                            <div class="row">
                                <div class="col-12">
                                    <div class="d-flex justify-content-between" style="height: 70px;">
                                        <img class="img-fluid h-100" src="{{ $item->image }}" alt="admin.upload">
                                        <div class="clock">{{ $item->created_at }}</div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <p class="mb-0 mt-3" style="font-size:18px;">{{ $item->namaindustri }}</p>
                                </div>
                            </div>
                            <h3 class="mb-3 text-truncate">{{ $item->intern_position }}</h3>
                            <div class="location mb-3">
                                <i class="ti ti-map-pin"></i>
                                <span class="ps-2 text-truncate">{{ $item->lokasi }}</span>
                            </div>
                            <div class="location mb-3">
                                <i class="ti ti-cash"></i>
                                <span class="ps-2 text-truncate">{{ uangSakuRupiah($item->nominal_salary) }}</span>
                            </div>
                            <div class="location mb-3">
                                <i class="ti ti-calendar-time"></i>
                                <span class="ps-2 text-truncate">{{ $item->durasimagang }}</span>
                            </div>
                            
                        </div>
                        <div class="card-footer">
                            <div class="demo-inline-spacing text-center">
                                <a href="{{ route('dashboard.detail-lowongan', $item->id_lowongan) }}" class="w-75 btn btn-primary">Detail</a>
                            </div>  
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>