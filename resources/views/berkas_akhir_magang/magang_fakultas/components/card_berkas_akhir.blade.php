<div class="card mt-4 border shadow-none border-secondary" style="border-color: #D3D6DB !important">
    <div class="card-body">
        <div class="row gy-3">
            <div class="col-2 d-flex flex-column justify-content-center">
                <h6 class="mb-1">
                    <a class="text-nowrap text-primary text-decoration-underline cursor-pointer" onclick="viewMhs($(this))" data-id="{{$data->nim}}">{{$data->namamhs}}</a>
                </h6>
                <p class="mb-1">{{ $data->nim ?? '-' }}</p>
                <p class="mb-1">Nilai Akhir : {{ isset($data->nilai_adjust) ? $data->nilai_adjust : ($x->nilai_akhir_magang ?? '-') }}</p>
                <p class="mb-2">Index : {{ isset($data->indeks_nilai_adjust) ? $data->indeks_nilai_adjust : ($x->indeks_nilai_akhir ?? '-') }}</p>
                <div class="d-flex justify-content-start">
                    <a href="javascript: void(0)" onclick="adjustmentNilai($(this))" data-id="{{$data->id_mhsmagang}}" class="cursor-pointer text-warning"><i class="ti ti-clipboard-list ti-lg"></i></a>
                    </div>
            </div>
            <div class="col-10">
                <table class="table table-striped col-10">
                    <thead>
                        <tr>
                            <th scope="col">Berkas Akhir Magang</th>
                            <th scope="col" class="text-center">Status Pengumpulan</th>
                            <th scope="col" class="text-center">Ketepatan Pengumpulan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach(json_decode($data->berkas_akhir_magang_list, true) as $value)
                            @if (isset($value['id_berkas_akhir_magang']))
                            <tr>
                                <td class="text-nowrap">
                                    @if (isset($value['id_berkas_akhir_magang']))
                                        <a href="{{route('berkas_akhir_magang.fakultas.detail_file', ['id' => $value['id_berkas_akhir_magang']])}}" class="text-primary">{{$value['berkas_magang'].'.'.explode('.', $value['berkas_file'])[1]}}</a>
                                    @else
                                        <a href="javascript: void(0)" class="text-primary">-</a>';
                                    @endif
                                </td>
                                <td class="text-center">
                                    <span class="badge badge-pill bg-label-{{$status[$value['status_berkas']]['color']}}">{{$status[$value['status_berkas']]['title']}}</span>
                                </td>
                                <td class="text-center d-flex flex-column">
                                    <span class="mb-2">{{$carbon->parse($value['tgl_upload'])->format('d/m/Y H:i')}}</span>
                                    @if($value['tgl_upload'] > $value['due_date']) 
                                        <span class="badge bg-label-danger align-self-center">Terlambat Diserahkan</span>
                                    @else
                                        <span class="badge bg-label-success align-self-center">Tepat Waktu Diserahkan</span>
                                    @endif
                                </td>
                            </tr>
                            @endif
                        @endforeach
                    </tbody>
                </table>
            </div>
            @if($data->alasan_adjust)
            <div class="col-12">
                <div class="alert alert-danger d-flex align-items-center mb-0" role="alert">
                    <span style="padding-left:10px;"> Alasan Pengurangan Nilai : {{$data->alasan_adjust}}</span>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>