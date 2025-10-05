<div class="card border cursor-pointer my-2" onclick="window.location.href=`{{ $urlAction }}`">
    <div class="card-body">
        <div class="d-flex justify-content-between">
            <div class="d-flex justify-content-start">
                <div class="rounded-circle text-center" style="overflow: hidden; width: 70px; height: 70px;">
                    <img src="{{ asset('app-assets/img/avatars/user.png') }}" alt="user-avatar" class="d-block" width="70" id="image_industri">
                </div>
                <div class="d-flex flex-column justify-content-center ms-3">
                    {{-- <h4 class="mb-1">{{ $data->intern_position }}</h4> --}}
                    <h4 class="mb-1">{{ $data->bidangPekerjaanIndustri->namabidangpekerjaan }}</h4>
                    <span>{{ $data->deskripsi }}</span>
                </div>
            </div>
            <div>
                <span class="badge bg-label-primary">Status</span>
            </div>
        </div>
        <div class="d-flex justify-content-between border-bottom pb-4 mt-4">
            <div class="d-flex justify-content-start">
                <span class="badge badge-center rounded-pill bg-label-primary" style="padding: 1.5rem;">
                    <i class="ti ti-users" style="font-size: 15pt"></i>
                </span>
                <div class="d-flex flex-column justify-content-start ms-2">
                    <span>Total Kandidat</span>
                    <h5 class="text-primary">{{ $data->total_kandidat }}</h5>
                </div>
            </div>
            @for ($i = 1; $i <= ($data->tahapan_seleksi + 1); $i++)
            <div class="d-flex justify-content-start">
                <span class="badge badge-center rounded-pill bg-label-primary" style="padding: 1.5rem;">
                    <i class="ti ti-file-report" style="font-size: 15pt"></i>
                </span>
                <div class="d-flex flex-column justify-content-start ms-2">
                    <span>Seleksi Tahap {{ $i }}</span>
                    <h5 class="text-primary">{{ $data->{'seleksi_tahap_' . $i} }}</h5>
                </div>
            </div>
            @endfor
        </div>
        <div class="d-flex justify-content-start mt-3">
            <div class="d-flex justify-content-start align-items-center">
                <i class="ti ti-calendar"></i>
                <span class="ms-3">{{ Carbon\Carbon::parse($data->mulai_magang)->format('d M Y') }} - {{ Carbon\Carbon::parse($data->selesai_magang)->format('d M Y') }}</span>
            </div>
            <div class="ms-4 d-flex justify-content-start align-items-center">
                <i class="ti ti-users"></i>
                <span class="ms-3">Kuota Penerimaan: {{ $data->kuota }}</span>
            </div>
        </div>
    </div>
</div>
