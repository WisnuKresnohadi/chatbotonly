<button
    class="button-kembali"
    onclick="history.back()"
    style="width: 126px;
        height: 38px;
        border-radius: 6px;
        border-width: 1px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #4EA971;
        gap: 8px;
        background-color: white;
        border-color: #4EA971;
        cursor: pointer;

        "
    >
    <i class="fas fa-arrow-left"></i>
        Kembali
    </button>
<div class="container py-3 px-5" style="display:flex; justify-content:space-between; height: 90vh; flex-direction:column; border-top: 0.5px solid #D3D6DB;">
    <div class="scrollbarhide" style="overflow-y: scroll; height: 90vh;">
        <!-- BubbleChat Container -->
        @php
        // dd($hasilKesimpulan);
            $grade = json_decode($hasilKesimpulan['skoring_wawancara'], true);
            // $historychat = json_decode($grade['chatHistory'], true);
        @endphp
        <div class="bubblechat">
    @foreach ($grade as $grades)
        @if ($grades['kriteria'] == $kriteria)
            @foreach (json_decode($grades['chatHistory'], true) as $history)
                <div class="d-flex justify-content-{{ $history['sender'] === 'bot' ? 'start' : 'end' }}">
                    <div class="message p-3 shadow-sm text-sm"
                         style="margin-bottom:10px; border-radius:1rem;
                                background-color: {{ $history['sender'] === 'bot' ? '#C4E2D0' : '#D3D6DB' }};
                                color: {{ $history['sender'] === 'bot' ? '#34714B' : '#23314B' }};">
                        {{ $history['text'] }}
                    </div>
                </div>
            @endforeach
        @endif
    @endforeach
</div>
    </div>

</div>


