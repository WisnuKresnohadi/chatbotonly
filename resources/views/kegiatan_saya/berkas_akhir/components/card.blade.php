@forelse  ($berkas_akhir as $item)
    @php
        $now = Carbon\Carbon::now();
        $due_date = Carbon\Carbon::parse($item->due_date);
        $prevDate = $due_date->copy()->subWeek();
        $color = ($now->greaterThanOrEqualTo($prevDate)) ? 'danger' : 'warning';

        $due_date = $due_date->format('d/m/y H:i');
        $item->alert_due_date = "<div class='alert alert-$color text-start' role='alert'>
            Unggah dokumen sebelum tanggal <span class='fw-bolder'>$due_date!</span>
        </div>";
    @endphp
    @if (isset($item->berkas_file))
        @if ($item->status_berkas == App\Enums\BerkasAkhirMagangStatus::REJECTED)
        <div class="border text-center pt-4 pb-5 mt-4" style="border-radius: 8px; background-color:#fff">
            <div class="d-flex justify-content-end mx-4">
                @php
                    $status = App\Enums\BerkasAkhirMagangStatus::getWithLabel($item->status_berkas);
                    $item->status_berkas = '<span class="badge bg-label-'.$status['color'].'">'.$status['title'].'</span>';
                @endphp
                {!! $item->status_berkas !!}
            </div>
            <h4>Upss! {{ $item->nama_berkas }} membutuhkan perbaikan</h4>
            <p>Silahkan lakukan pengecekan detail dokumen dibawah ini.</p>
            <button type="button" class="btn btn-outline-danger btn-upload-berkas mb-1" data-id="{{ $item->id_berkas_magang }}" data-berkas="{{ $item->nama_berkas }}"><i class="ti ti-edit"></i>&ensp;Perbaiki {{ $item->nama_berkas }}</button>
            <hr class="mx-5">
            <div class="text-start mx-5">
                <p class="text-danger fw-bolder mb-1">Komentar Perbaikan:</p>
                <p class="mb-0">{{ $item->rejected_reason }}</p>
            </div>
        </div>
        @else
        <div class="border text-center py-4 mt-4" style="border-radius: 8px; background-color:#fff">
            <div class="d-flex justify-content-end mx-4">
                @php
                    $status = App\Enums\BerkasAkhirMagangStatus::getWithLabel($item->status_berkas);
                    $item->status_berkas = '<span class="badge bg-label-'.$status['color'].'">'.$status['title'].'</span>';
                @endphp
                {!! $item->status_berkas !!}
            </div>
            <h4>Terkirim! {{ $item->nama_berkas }} Anda telah berhasil diserahkan</h4>
            <p>Silahkan lakukan pengecekan detail dokumen dibawah ini.</p>
            <a href="{{ url('storage/' . $item->berkas_file) }}" class="text-primary mb-1" download>{{ $item->nama_berkas }}.{{ explode('.', $item->berkas_file)[1] }}</a>
        </div>
        @endif
    @else
    <div class="border text-center p-3 mt-4" style="border-radius: 8px; background-color:#fff">
        {!! $item->alert_due_date !!}
        <h4 class="mt-1">{{ $item->nama_berkas }}</h4>
        @if($item->status_upload == 1)
        <p class="text-danger fw-semibold">Wajib Diunggah</p>
        @endif
        <p>Harap pastikan bahwa berkas akhir magang Anda telah lengkap dan selesai sepenuhnya. Anda hanya memiliki satu kesempatan untuk mengunggahnya.</p>
        <div class="d-flex flex-column align-items-center">
            @if (isset($item->template))
            <a href="{{ url('storage/' . $item->template) }}" class="text-primary mb-3" download>Template File.{{ explode('.', $item->template)[1] }}</a>
            @endif
            <button type="button" class="btn btn-primary btn-upload-berkas mb-1" data-id="{{ $item->id_berkas_magang }}" data-berkas="{{ $item->nama_berkas }}">Upload</button>
        </div>
    </div>
    @endif
@empty
<div class="d-flex flex-column">
    <img alt="no-berkas-akhir-set" class="img-fluid align-self-center" style="width: 500px; height: 508.214px; flex-shrink: 0;" src="{{ asset('assets/images/nothing.svg') }}" alt="Login" />
    <div class="sec-title mt-3 mb-4 text-center">
        <h4>LKM belum mengonfigurasi pengaturan berkas akhir magang</h4>
    </div>
</div>
@endforelse