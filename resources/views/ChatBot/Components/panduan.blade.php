<div class="w-full d-flex flex-column gap-3 px-2 py-3" style="margin-bottom:100px; margin-top:30px ;border-radius: 8px; box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);">
    <div class="w-full py-4" style="border-bottom:0.5px solid #D3D6DB; font-size:18px; font-weight:600">
    Panduan Wawancara
    </div>
    <div>
        <ul>
            <li>Sebelum sesi wawancara utama dimulai, harap kerjakan pra-wawancara terlebih dahulu.</li>
            <li>Sesi pra-wawancara adalah sesi pertanyaan tambahan dari mitra diluar sesi wawancara utama.</li>
            <li>Pertanyaan tambahan tidak masuk ke poin penilaian dan hanya akan disimpan pada kategori "keterangan lain".</li>
            <li>Ini adalah wawancara resmi, gunakan Bahasa Indonesia yang baku dan hindari kesalahan ketik.</li>
            <li>Jawablah dengan jujur karena akan mempengaruhi nilai anda. Periksa dulu jawaban anda sebelum menekan tombol send. setiap jawaban akan langsung disimpan oleh sistem.</li>
            <li>Wawancara hanya bisa dilakukan maksimal 1x.</li>
            <li>Durasi waktu maksimal wawancara adalah 60 menit, jika melebihi waktu tersebut maka maka hasil wawancara akan tersimpan seadanya tanpa bisa mengulang.</li>
            <li>Apabila anda keluar dari sesi wawancara sebelum durasi berakhir, anda tidak bisa mengulang wawancara lagi.</li>
            <li>Pastikan koneksi internet anda lancar, karena jika terjadi error koneksi maka jawaban akan tersimpan seadanya.</li>
            <li>Mitra magang dapat meminta anda untuk wawancara lanjutan apabila diperlukan(diluar aplikasi talentern).</li>
        </ul>
          Sebelum sesi utama wawancara dimulai, lakukan pra-wawancara terlebih dahulu. Tekan tombol dibawah untuk mulai sesi pra-wawancara
    </div>

    <button onclick="window.location.href='{{ route('wawancara-flow.trial', ['id_pendaftaran' => $id_pendaftaran]) }}'"
        style="width: 160px; height: 42px; border-radius: 8px; font-size: 13px; font-weight: 500; color: white; background-color: #4EA971; border: none; cursor: pointer; padding: 10px 16px; transition: background-color 0.2s ease;"
        onmouseover="this.style.backgroundColor='#3d8c5e'"
        onmouseout="this.style.backgroundColor='#4EA971'"

        disabled = "true"
        id="trialButton"
        >
        <span id="timer">
            45
        </span>

    </button>

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

<script>
    let timeLeft = 45;
    const timerElement = document.getElementById('timer');
    const trialButton = document.getElementById('trialButton');

    const countdown = setInterval(() => {
        timeLeft--;
        timerElement.textContent = timeLeft;

        if (timeLeft == 0) {
            clearInterval(countdown);
            trialButton.disabled = false;
            trialButton.innerHTML = 'Mulai Sekarang';
            trialButton.onclick = function() {
                window.location.href = '{{ route('wawancara-flow.trial', ['id_pendaftaran' => $id_pendaftaran]) }}';
            };
        }
    }, 1000);
</script>
