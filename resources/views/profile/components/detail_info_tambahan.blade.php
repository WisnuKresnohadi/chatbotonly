<div class="border-bottom mx-3 px-0">
    <p>
        <span class="fw-semibold me-1">Lokasi kerja yang diharapkan&ensp;:</span>
        <span>&ensp;{{ $mahasiswa->lokasi_yg_diharapkan }}</span>
    </p>
</div>
<div class="mt-3 pb-3 border-bottom mx-3 px-0">
    <p class="fw-semibold mb-1">Sosial media</p>
    <table class="ms-3">
        <tbody>
            @foreach ($sosmed as $item)
            <tr>
                <td>{{ $item->namaSosmed }}</td>
                <td class="ps-5 pe-2">:</td>
                <td><a href="{{ $item->urlSosmed }}">{{ $item->urlSosmed }}</a></td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
<div class="my-3 mx-3 px-0">
    <p class="fw-semibold mb-1">Bahasa</p>
    <ul>
        @foreach ($bahasa as $item)
        <li>{{ $item->bahasa }}</li>
        @endforeach
    </ul>
</div>