<div class="w-full d-flex flex-column gap-3 px-2 py-3" style="margin-bottom:100px; margin-top:30px ;border-radius: 8px; box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);">
    <table class="w-full" style="border-collapse: collapse; margin-top: 20px;">
        <thead>
            <tr style="background-color: #f5f5f5;">
                <th style="border: 1px solid #ddd; padding: 12px; text-align: left;">Kriteria</th>
                <th style="border: 1px solid #ddd; padding: 12px; text-align: center; width: 20%;">Skor</th>
                <th style="border: 1px solid #ddd; padding: 12px; text-align: left;">Kesimpulan</th>
                <th style="border: 1px solid #ddd; padding: 12px; text-align: left;">Aksi</th>
                {{-- <th style="border: 1px solid #ddd; padding: 12px; text-align: left;">History</th> --}}
            </tr>
        </thead>
        <tbody>
            @if ($hasilKesimpulan != null)
            @php
            // dd($hasilKesimpulan);
                $grade = json_decode($hasilKesimpulan['skoring_wawancara'], true);
                $score;
                @endphp
                @forelse(($grade ?? []) as $grades)
                @php
                if($grades['score'] == 0 && $grades['kriteria'] == "Keterangan Lain") $score = "-";
                else $score = $grades['score']
                @endphp
                <tr>
                    <td style="border: 1px solid #ddd; padding: 12px;">{{$grades['kriteria']}}</td>
                    <td style="border: 1px solid #ddd; padding: 12px; text-align: center;">{{$score}}</td>
                    <td style="border: 1px solid #ddd; padding: 12px;">{{$grades['kesimpulan']}}</td>
                    <td style="border: 1px solid #ddd; padding: 12px;">
                        <a href="{{ route('wawancara-flow.history', ['nim' => $hasilKesimpulan['nim'], 'id_pendaftaran' => $hasilKesimpulan['id_pendaftaran'], 'kriteria' => $grades['kriteria']]) }}">Lihat history</a>
                    </td>
                    {{-- <td style="border: 1px solid #ddd; padding: 12px;">
                    @foreach (json_decode($grades['chatHistory'], true) as $chat)

                    {{$chat['sender']}} :
                    {{$chat['text']}}
                    <br>
                    @endforeach
                </td> --}}


                </tr>
                {{-- <tr style="background-color: #f9f9f9;">
                    <td style="border: 1px solid #ddd; padding: 12px;">Penguasaan Teknis</td>
                    <td style="border: 1px solid #ddd; padding: 12px; text-align: center;">5</td>
                    <td style="border: 1px solid #ddd; padding: 12px;">Memahami dasar-dasar yang diperlukan</td>
                </tr> --}}
                @empty
                <tr>
                    <td colspan="4" style="border: 1px solid #ddd; padding: 12px; text-align: center;">Mahasiswa belum melakukan wawancara</td>
                </tr>
                @endforelse
            @else
            @endif
        </tbody>
    </table>

</div>
    <style>
        @media (max-width: 600px) {
            div.w-full {
                padding: 10px;
            }
            div.py-4 {
                font-size: 16px !important;
            }
            ul {
                font-size: 12px !important;
                padding-left: 15px !important;
            }
            button {
                width: 140px !important;
                height: 38px !important;
                font-size: 12px !important;
            }
        }
    </style>
