{{-- Chat Interface Template --}}
<div>
    {{-- Navigation Container --}}
    <div class="nav-container"
     style="display:flex; flex-direction:row-reverse; width:100%; margin-top:2rem; padding:0 16px;">
    <div style="font-weight:500; font-size:18px; display:flex; align-items:center; justify-content:center; gap:12px; border-radius:8px; padding:8px; background-color:#d4f4e2; color:#4EA971">
        <i class="fa-regular fa-clock"></i>
        <span id="timer">60:00</span>
    </div>
</div>



    {{-- Main Container --}}
    <div class="container" style="display:flex; justify-content:space-between; height:90vh; flex-direction:column; padding:1rem 3rem;">
        {{-- Chat Messages Container --}}
        <div class="scrollbarhide" style="overflow-y:scroll; height:80vh; margin-bottom:20px;">
            <div class="bubblechat">
                @foreach ($messages as $message)
                    <div style="display:flex; justify-content:{{ $message['sender'] === 'bot' ? 'flex-start' : 'flex-end' }}; margin-top:10px;">
                        <div style="padding:1rem; border-radius:1rem; background-color:{{ $message['sender'] === 'bot' ? '#C4E2D0' : '#D3D6DB' }}; color:{{ $message['sender'] === 'bot' ? '#34714B' : '#23314B' }}; box-shadow:0 1px 2px rgba(0,0,0,0.1);">
                            {{ $message['text'] }}
                        </div>
                    </div>
                @endforeach
            </div>
        </div>


 {{-- Warning Cards --}}
 <div id="warningcard" style="display:flex; width:100%; background-color:#ffecd9; border-radius:12px; margin-bottom:10px">
    <div style="display:flex; gap:0.5rem; padding:0.5rem; color:#cc7f36">
        <i class="fa-solid fa-triangle-exclamation" style="margin-top:0.25rem; font-size:15px;"></i>

        <div>
            <h3 style="font-size:15px; font-weight:600; margin-bottom:5px; color:#cc7f36">Perhatian</h3>
            <p style="font-size:15px; font-weight:400; margin-bottom:20px;">Sebelum Jawaban dikirim, periksa kembali jawaban anda. Karena jawaban yang telah terkirim tidak dapat dihapus ataupun diperbaiki. Pastikan juga jawaban minimal terdiri dari 5 kata</p>
        </div>
    </div>
</div>

<div id="card-timeup" style="display:none; width:100%; background-color:#d4f4e2; border-radius:12px; margin-bottom:10px">
    <div style="display:flex; gap:0.5rem; padding:0.5rem; color:#4EA971;">
        <i class="fa-solid fa-check" style="margin-top:0.25rem; font-size:15px;"></i>
        <div style="width:100%;">
            <div style="display:flex; justify-content:space-between; align-items:center; cursor:pointer;" onclick="toggleDescription('timeup-description')">
                <h3 style="font-size:15px; font-weight:600; margin-bottom:0;">Sesi Utama Wawancara berakhir</h3>
                <i id="timeup-icon" class="fa-solid fa-chevron-down"></i>
            </div>
            <div id="timeup-description" style="display:none; margin-top:10px;">
                <p style="font-size:15px; font-weight:400; margin-bottom:20px;">Tekan tombol berikut untuk lanjut ke tahap selanjutnya</p>
                <button onclick="window.location.href='{{ route('wawancara-flow.snk', ['id_pendaftaran' => $id_pendaftaran]) }}'" style="background-color:#4EA971; color:white; border:none; padding:8px 16px; border-radius:8px; cursor:pointer; font-size:15px;">
                    Selanjutnya
                </button>
            </div>
        </div>
    </div>
</div>

<div id="card-timelimit" style="display:none; width:100%; background-color:#ffecd9; border-radius:12px; margin-bottom:10px">
    <div style="display:flex; gap:0.5rem; padding:0.5rem; color:#cc7f36;">
        <i class="fa-solid fa-triangle-exclamation" style="margin-top:0.25rem; font-size:15px;"></i>
        <div style="width:100%;">
            <div style="display:flex; justify-content:space-between; align-items:center; cursor:pointer;" onclick="toggleDescription('timelimit-description')">
                <h3 style="font-size:15px; font-weight:600; margin-bottom:0; color:#cc7f36">Sesi utama wawancara akan segera berakhir</h3>
                <i id="timelimit-icon" class="fa-solid fa-chevron-down"></i>
            </div>
            <p id="timelimit-description" style="font-size:15px; font-weight:400; margin-top:10px; display:none;">Segera selesaikan wawancara anda.</p>
        </div>
    </div>
</div>

<div id="card-selesai" style="display:none; width:100%; background-color:#d4f4e2; border-radius:12px; margin-bottom:10px">
    <div style="display:flex; gap:0.5rem; padding:0.5rem; color:#4EA971;">
        <i class="fa-solid fa-check" style="margin-top:0.25rem; font-size:15px;"></i>
        <div style="width:100%;">
            <div style="display:flex; justify-content:space-between; align-items:center; cursor:pointer;" onclick="toggleDescription('selesai-description')">
                <h3 style="font-size:15px; font-weight:600; margin-bottom:0;">Pertanyaan Wawancara Telah Habis</h3>
                <i id="selesai-icon" class="fa-solid fa-chevron-down"></i>
            </div>
            <div id="selesai-description" style="display:none; margin-top:10px;">
                <p style="font-size:15px; font-weight:400; margin-bottom:20px;">Tekan tombol berikut untuk lanjut ke tahap selanjutnya</p>
                <button onclick="window.location.href='{{ route('wawancara-flow.snk', ['id_pendaftaran' => $id_pendaftaran]) }}'" style="background-color:#4EA971; color:white; border:none; padding:8px 16px; border-radius:8px; cursor:pointer; font-size:15px;">
                    Selanjutnya
                </button>
            </div>
        </div>
    </div>
</div>
        {{-- Chat Input Form --}}
        <div style="margin-bottom:6rem;">
            <form id="chat-form" style="display:flex; flex-direction:column; align-items:start; width:100%; border-radius:12px; border:1px solid #ccc; padding:10px; background-color:#f9f9f9;">
                @csrf
                <div style="display:flex; justify-content:space-between; align-items:center; width:100%;">
                    <input
                        type="text"
                        id="message-input"
                        name="message"
                        placeholder="Message Talentern..."
                        style="width:85%; font-size:15px; border:none; outline:none; background:transparent; color:black;"
                        onfocus="bukaWarning()"
                        onblur="tutupWarning()"
                        autocomplete="off" spellcheck="false" autocorrect="off"
                    />
                    <button
                        type="submit"
                        id="SendBtn"
                        style="border-radius:4px; background-color:#4EA971; color:white; border:none; width:40px; height:40px; display:flex; align-items:center; justify-content:center;"
                    >
                        <i class="fa-regular fa-paper-plane"></i>
                    </button>
                </div>

                <div style="text-align:center; margin-bottom:10px; font-size:13px; padding:12px; font-weight:600; color:#cc7f36; border-radius:8px; background-color:#ffecd9">
                    Sesi Utama Wawancara
                </div>
            </form>

            <small style="color:#6c757d;">Tolong jawab dengan jujur</small>
        </div>
    </div>
</div>

{{-- Modal --}}
<div id="modal" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(0,0,0,0.5); justify-content:center; align-items:center;">
    <div style="background:white; width:483px; padding:20px; border-radius:10px; text-align:center;">
        <div style="font-size:100px; color:#F1C40F;"><i class="fa-solid fa-triangle-exclamation"></i></div>
        <h3 style="font-size:18px; font-weight:bold; margin-top:8px;">Yakin untuk keluar dari sesi utama wawancara?</h3>
        <p style="font-size:14px; color:#666;">Dengan keluar dari halaman ini, sesi utama wawancara akan diulang dari awal</p>

        <div style="margin-top:16px;">
            <button onclick="tutupModal()" style="background:#ffffff; color:#4EA971; border:1px solid #4EA971; padding:8px 16px; border-radius:6px; cursor:pointer; font-size:14px;">
                Batal
            </button>
            <button onclick="mulaiWawancara()" style="background:#4EA971; color:white; border:none; padding:8px 16px; border-radius:6px; cursor:pointer; font-size:14px; margin-left:8px;">
                Tetap Lanjut
            </button>
        </div>
    </div>
</div>

{{-- External CSS --}}
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

{{-- JavaScript --}}
<script>
    document.body.style.overflow = "hidden";
    let status = "{{ $status }}";

    document.addEventListener('DOMContentLoaded', function() {
        // Initialize timer and elements
    const idPendaftaran = @json($id_pendaftaran);
    const display = document.getElementById("timer");
    const backButton = document.getElementById('BackBtn');
    const sendButton = document.getElementById('SendBtn');
    const chatForm = document.getElementById('chat-form');
    const messageInput = document.getElementById('message-input');
    const bubbleChat = document.querySelector('.bubblechat');
    const scrollContainer = document.querySelector('.scrollbarhide');
    let immportantFault = false;
    // Start timer
    startTimer(60 * 60, display, idPendaftaran);

    // Clear chat history
    localStorage.removeItem('chatHistory');

    // Handle finished status
    if (status === 'finished') {
        backButton.disabled = true;
        sendButton.disabled = true;
        backButton.style.opacity = '0.5';
        backButton.style.cursor = 'not-allowed';
        sendButton.style.opacity = '0.5';
        sendButton.style.cursor = 'not-allowed';
    }

// Enable pressing Enter to send
messageInput.addEventListener("keydown", function(e) {
    if (e.key === "Enter") {
        e.preventDefault();
        if (!sendButton.disabled) {
            chatForm.dispatchEvent(new Event("submit"));
            // Scroll bubble chat ke paling bawah saat warning dibuka
            const bubbleChatContainer = document.querySelector(".scrollbarhide");
            if (bubbleChatContainer) {
                bubbleChatContainer.scrollTop = bubbleChatContainer.scrollHeight;
            }
        }
    }
});
    // user switches tab or minimizes
    document.addEventListener("visibilitychange", () => {
        if (document.hidden && status === 'unfinished' && !immportantFault) {
            immportantFault = true;
            sweetAlertConfirm({
            title: 'Pelanggaran Sesi Wawancara!',
            text: 'Kamu Melakukan Minimize atau Switch Tab\nSilahkan Klik Oke Untuk Memulai Ulang Wawancara',
            icon: 'warning',
            confirmButtonText: 'Oke',
            showCancelButton: false,
            allowOutsideClick: false,
            allowEscapeKey: false,
            customClassCancel: ''
        }, function () {
             window.location.reload();
        });
        }
    });

    // Block copy/cut/paste
    ["Copy", "Cut", "Paste"].forEach(evt => {
        const eventName = evt.toLowerCase();
        document.addEventListener(eventName, function(e) {
            e.preventDefault();
            if (status === 'unfinished' && !immportantFault) {
                showSweetAlert({
                    title: 'Aksi Diblokir!',
                    text: `Fungsi ${evt} Tidak Diizinkan`,
                    icon: 'warning',
                    confirmButtonText: 'OK',
                });
            }
        });
    });



    // Block PrintScreen
    document.addEventListener("keyup", function(e) {
        if (e.key === "PrintScreen" && status === 'unfinished') {
            immportantFault = true;
            e.preventDefault();
            triggerViolation("Kamu melakukan PrintScreen!");
        }
    });

    // Block Ctrl+P (Print to PDF)
    document.addEventListener("keydown", function(e) {
        if (e.ctrlKey && e.key.toLowerCase() === "p" && status === 'unfinished') {
            immportantFault = true;
            e.preventDefault();
            triggerViolation("Kamu Mencoba Print Halaman!");
        }
    });

    // Detect Blur (user keluar dari tab/aplikasi)
    window.addEventListener("blur", function() {
        if (status === 'unfinished') {
            immportantFault = true;
            triggerViolation("Kamu Meninggalkan Sesi Wawancara!");
        }
    });

    // Form submission handler
    chatForm.addEventListener('submit', async function(e) {
        e.preventDefault();
        const message = messageInput.value.trim();

        if (!message) {
           showSweetAlert({
            title: 'Warning',
            text: `Pesan Tidak Boleh Kosong!`,
            icon: 'warning',
            confirmButtonText: 'OK',
        });
            return;
        }


        // Add user message to chat
        appendMessage(message, 'user');
        messageInput.value = '';


        // Panggil fungsi sendMessage
        await sendMessage(message, idPendaftaran);
    });

    // Fungsi untuk mengirim pesan
    async function sendMessage(message, idPendaftaran) {
        try {
            const response = await fetch("{{ route('chat.send') }}", {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': "{{ csrf_token() }}"
                },
                body: JSON.stringify({
                    message: message,
                    id_pendaftaran: idPendaftaran
                })
            });

            const data = await response.json();

            if (data.next_question) {
                appendMessage(data.next_question, 'bot');
            }

            if (data.interview_status === 'finished') {
                await fetch("{{ route('wawancara-flow.deqreasequota') }}", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": "{{ csrf_token() }}"
                    },
                    body: JSON.stringify({
                        id_pendaftaran: idPendaftaran
                    })
                });

                sendButton.disabled = true;
                sendButton.style.opacity = '0.5';
                sendButton.style.cursor = 'not-allowed';
                status = 'finished';

                sweetAlertConfirm({
                    title: 'Wawancara Telah Selesai',
                    text: 'Silahkan Menunggu Seleksi Penerimaan Dari Perusahaan!',
                    icon: 'success',
                    confirmButtonText: 'Kembali',
                    showCancelButton: false,
                    allowOutsideClick: false,
                    allowEscapeKey: false,
                    customClassCancel: ''
                }, function () {
                    window.location.href = data.redirect_url;
                });
            }

            scrollContainer.scrollTop = scrollContainer.scrollHeight;
        } catch (error) {
            showSweetAlert({
                    title: 'Koneksi Hilang',
                    text: `Pastikan Internet Anda Lancar!`,
                    icon: 'question',
                    confirmButtonText: 'OK',
                });
        }
    }
    // Fungsi untuk memeriksa jumlah kata
    function checkWordCount() {
        const message = messageInput.value.trim();
        const wordCount = message.split(/\s+/).filter(word => word.length > 0).length;

        if (wordCount < 5) {
            sendButton.disabled = true;
            sendButton.style.opacity = '0.5';
            sendButton.style.cursor = 'not-allowed';
        } else {
            sendButton.disabled = false;
            sendButton.style.opacity = '1';
            sendButton.style.cursor = 'pointer';
        }
    }

    // Tambahkan event listener untuk memeriksa jumlah kata setiap kali input berubah
    messageInput.addEventListener('input', checkWordCount);

    // Panggil fungsi checkWordCount saat halaman dimuat untuk memastikan tombol "Send" sesuai dengan kondisi awal
    checkWordCount();
});

// Helper Functions
function appendMessage(message, sender) {
    const bubbleChat = document.querySelector('.bubblechat');
    const messageHTML = `
        <div style="display:flex; justify-content:${sender === 'bot' ? 'flex-start' : 'flex-end'}; margin-top:10px;">
            <div style="padding:1rem; border-radius:1rem; background-color:${sender === 'bot' ? '#C4E2D0' : '#D3D6DB'}; color:${sender === 'bot' ? '#34714B' : '#23314B'}; box-shadow:0 1px 2px rgba(0,0,0,0.1);">
                ${message}
            </div>
        </div>`;
    bubbleChat.insertAdjacentHTML('beforeend', messageHTML);
}

function startTimer(duration, display, idPendaftaran) {
    let timer = duration;
    const interval = setInterval(function() {
        const minutes = Math.floor(timer / 60);
        const seconds = timer % 60;

        display.textContent = `${minutes}:${seconds < 10 ? '0' : ''}${seconds}`;


        if (timer < 20 && timer > 0) {
            bukaTimeLimitCard();
        } else if (timer <= 0) {
            status = 'finished';
            clearInterval(interval);
            display.textContent = "00:00";
            tutupTimeLimitcard();
            bukaTimeUpCard(idPendaftaran);
            document.getElementById("SendBtn").disabled = true;
            document.getElementById("SendBtn").style.opacity = '0.5';
            document.getElementById("SendBtn").style.cursor = 'not-allowed';
            document.getElementById("BackBtn").disabled = true;
        }

        timer--;
    }, 1000);
}

function tampilkanModal() {
    document.getElementById("modal").style.display = "flex";
}

function tutupModal() {
    document.getElementById("modal").style.display = "none";
}

function bukaWarning() {
    document.getElementById("warningcard").style.display = "flex";
}

function tutupWarning() {
    document.getElementById("warningcard").style.display = "none";
}
function bukaTimeLimitCard() {
    document.getElementById("card-timelimit").style.display = "flex";
}

function tutupTimeLimitcard() {
    document.getElementById("card-timelimit").style.display = "none";
}

function bukaTimeUpCard(idPendaftaran) {
    fetch("{{ route('wawancara-flow.deqreasequota') }}", {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
            "X-CSRF-TOKEN": "{{ csrf_token() }}"
        },
        body: JSON.stringify({
            id_pendaftaran: idPendaftaran
        })
    })
    .then(data => {
        sweetAlertConfirm({
            title: 'Wawancara Telah Selesai',
            text: 'Silahkan Menunggu Seleksi Penerimaan Dari Perusahaan!',
            icon: 'success',
            confirmButtonText: 'Kembali',
            showCancelButton: false,
            allowOutsideClick: false,
            allowEscapeKey: false,
            customClassCancel: ''
        }, function () {
            window.location.href = "{{ route('lamaran_saya.detail', ['id' => ':id']) }}".replace(':id', idPendaftaran);
        });
    })
}

// Helper: trigger violation modal
function triggerViolation(message) {
    immportantFault = true;
    sweetAlertConfirm({
        title: 'Pelanggaran Sesi Wawancara!',
        text: message,
        icon: 'warning',
        confirmButtonText: 'Refresh Halaman',
        showCancelButton: false,
        allowOutsideClick: false,
        allowEscapeKey: false,
        customClassCancel: ''
    }, function () {
        window.location.reload();
    });
}



function tutupTimeUpcard() {
    document.getElementById("card-timeup").style.display = "none";
}

function mulaiWawancara() {
    tutupModal();
}
function toggleDescription(descriptionId) {
    const description = document.getElementById(descriptionId);
    const iconId = descriptionId.replace('description', 'icon');
    const icon = document.getElementById(iconId);

    // Prevent the event from bubbling up to other handlers
    event.stopPropagation();

    if (description.style.display === 'none') {
        description.style.display = 'block';
        icon.classList.remove('fa-chevron-down');
        icon.classList.add('fa-chevron-up');
    } else {
        description.style.display = 'none';
        icon.classList.remove('fa-chevron-up');
        icon.classList.add('fa-chevron-down');
    }
}
</script>
<style>
    /* Responsive adjustments */
    @media (max-width: 768px) {
        .container {
            padding-left: 12px;
            padding-right: 12px;
        }

        .message {
            max-width: 90% !important;
        }
    }

    @media (max-width: 576px) {
        .message {
            font-size: 13px !important;
            padding: 8px 12px !important;
        }

        #message-input {
            font-size: 13px !important;
        }
    }
</style>
