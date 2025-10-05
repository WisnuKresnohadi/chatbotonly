<div style="width: 100%; border-radius: 8px; box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1); padding: 16px; margin-bottom: 24px;">

    <!-- Header -->
    <div style="border-bottom: 0.5px solid #D3D6DB; font-size: 18px; font-weight: 600; padding-bottom: 12px;">
        Syarat dan Ketentuan Sesi Utama Wawancara
    </div>

    <!-- List Ketentuan -->
    <ul style="margin-top: 12px; padding-left: 16px; color: #4A4A4A; font-size: 14px; line-height: 1.6;">
        <li>Durasi waktu maksimal wawancara adalah 60 menit, jika melebihi waktu tersebut maka jawaban akan disimpan apa adanya dan tidak bisa mengulang</li>
        <li>Dengan keluar dari sesi wawancara sebelum durasi waktu berakhir jawaban akan disimpan apa adanya dan tidak bisa mengulang</li>
        <li>Jawab dengan jujur dan sesuai dengan diri anda</li>
        <li>Pastikan sebelum jawaban dikirim, diperiksa terlebih dahulu. Karena jawaban yang telah terkirim tidak dapat dihapus ataupun diperbaiki dan akan langsung disimpan oleh sistem</li>
        <li>Pastikan anda tidak menggunakan tools atau alat bantu apapun dari browser bawaan maupun extension.</li>
    </ul>

    <!-- Panduan -->
    <div style="background-color: #E6F7FF; padding: 12px; border-radius: 8px; margin-top: 16px; display: flex; align-items: center;">
        <div style="justify-content: start; align-self:start; color: #007B8F">
            <i class="fa-solid fa-circle-info"></i>
        </div>

        <div style="flex-direction: row">
            <p style="margin-left: 8px; font-size: 15px; color: #007B8F; font-weight:600">
                Information
            </p>
            <p style="margin-left: 8px; font-size: 15px; color: #007B8F;">
                Tulis ulang kalimat berikut <b>“Saya melakukan wawancara dengan jujur dan sesuai fakta yang sebenarnya tentang diri saya”</b>
                pada form di bawah sebelum memulai sesi utama wawancara.
            </p>
        </div>
    </div>

    <!-- Input Pernyataan -->
    <div style="margin-top: 16px;">
        <label for="pernyataan" style="font-size: 14px; font-weight: 600; color: #333;">Pernyataan</label>
        <input id="pernyataan" type="text" placeholder="Tulis Pernyataan"
            style="width: 100%; padding: 10px; margin-top: 6px; border: 1px solid #D3D6DB; border-radius: 6px; font-size: 14px;"
            oninput="cekPernyataan()" onpaste="blokirPaste(event)"
            autocomplete="off" spellcheck="false" autocorrect="off"
            >
    </div>

    <!-- Tombol Mulai -->
    <button id="mulaiBtn" disabled onclick="tampilkanModal()"
        style="width: 160px; height: 42px; border-radius: 8px; font-size: 14px; font-weight: 600; color: white; background-color: #A9A9A9; border: none; cursor: not-allowed; margin-top: 16px; transition: background-color 0.2s ease;">
        Mulai Sekarang
    </button>
</div>

<!-- Modal -->
<div id="modal" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0, 0, 0, 0.5); justify-content: center; align-items: center;">
    <div style="background: white; width: 483px; padding: 20px; border-radius: 10px; text-align: center;">
        <div style="font-size: 100px; color: #F1C40F;"><i class="fa-solid fa-triangle-exclamation"></i></div>
        <h3 style="font-size: 18px; font-weight: bold; margin-top: 8px;">Yakin Untuk Memulai Sesi Utama Wawancara?</h3>
        <p style="font-size: 14px; color: #666;">Pastikan Periksa Kembali Syarat Dan Ketentuan</p>

        <div style="margin-top: 16px;">
            <button onclick="tutupModal()" style="background: #ffffff; color: #4EA971; border: 1px solid #4EA971; padding: 8px 16px; border-radius: 6px; cursor: pointer; font-size: 14px;">
                Batal
            </button>
            <button onclick="window.location.href='{{ route('wawancara-flow.main-session', ['id_pendaftaran' => $id_pendaftaran]) }}'"style="background: #4EA971; color: white; border: none; padding: 8px 16px; border-radius: 6px; cursor: pointer; font-size: 14px; margin-left: 8px;">
                Mulai
            </button>
        </div>
    </div>
</div>

<script>

    function cekPernyataan() {
        const inputPernyataan = document.getElementById("pernyataan").value.trim();
        const tombolMulai = document.getElementById("mulaiBtn");

        const kalimatBenar = "Saya melakukan wawancara dengan jujur dan sesuai fakta yang sebenarnya tentang diri saya";

        if (inputPernyataan === kalimatBenar) {
            tombolMulai.disabled = false;
            tombolMulai.style.backgroundColor = "#4EA971";
            tombolMulai.style.cursor = "pointer";
        } else {
            tombolMulai.disabled = true;
            tombolMulai.style.backgroundColor = "#A9A9A9";
            tombolMulai.style.cursor = "not-allowed";
        }
    }

    function tampilkanModal() {

        sweetAlertConfirm({
            title: 'Yakin Untuk Memulai Sesi Utama Wawancara?',
            text: 'Pastikan Periksa Kembali Syarat Dan Ketentuan',
            icon: 'warning',
            confirmButtonText: 'Mulai',
            cancelButtonText: 'Batal'
        }, function () {
            window.location.href = '{{ route('wawancara-flow.main-session', ['id_pendaftaran' => $id_pendaftaran]) }}';
        });
    }

    function tutupModal() {
        document.getElementById("modal").style.display = "none";
    }

    function mulaiWawancara() {
        alert("Sesi wawancara dimulai!"); // Ganti ini dengan aksi lain seperti redirect
        tutupModal();
    }

    function blokirPaste(event) {
        event.preventDefault();
        alert("Menempel teks tidak diperbolehkan. Silakan ketik pernyataan secara manual.");
    }

    document.getElementById("pernyataan").addEventListener("paste", blokirPaste);
</script>
