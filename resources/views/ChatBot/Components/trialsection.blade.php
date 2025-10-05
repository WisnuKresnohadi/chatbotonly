<div class="container py-3 px-5" style="display:flex; justify-content:space-between; height: 90vh; flex-direction:column; border-top: 0.5px solid #D3D6DB;">
    <div class="scrollbarhide" style="overflow-y: scroll; height: 90vh;">
        <!-- BubbleChat Container -->
        <div class="bubblechat">
            @foreach ($messages as $message)
                <div class="d-flex justify-content-{{ $message['sender'] === 'bot' ? 'start' : 'end' }}">
                    <div class="message p-3 shadow-sm text-sm" style="margin-bottom:10px; border-radius:1rem; background-color: {{ $message['sender'] === 'bot' ? '#C4E2D0' : '#D3D6DB' }}; color: {{ $message['sender'] === 'bot' ? '#34714B' : '#23314B' }};" >
                        {{ $message['text'] }}
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <!-- Card Sesi Trial Sudah Berakhir -->
    <div id="trialEndCard" style="display: none; width:full; background-color:#d4f4e2; border-radius:12px; margin-bottom:10px; margin-top:10px">
        <div class="d-flex gap-2 p-2" style="color:#4EA971">
            <i class="fa-solid fa-check mt-1" style="font-size: 15px;"></i>
            <div>
                <h3 style="font-size: 15px; font-weight:600; margin-bottom: 5px; color:#4EA971">Sesi Trial Sudah Berakhir</h3>
                <p style="font-size: 15px; font-weight:400; margin-bottom: 20px;">Tekan tombol berikut untuk memulai tahap selanjutnya.</p>
                <button onclick="window.location.href='{{ route('wawancara-flow.snk', ['id_pendaftaran' => $id_pendaftaran]) }}'" style="background-color: #4EA971; color: white; border: none; padding: 8px 16px; border-radius: 8px; cursor: pointer; font-size: 15px;">
                    Selanjutnya
                </button>
            </div>
        </div>
    </div>

    <!-- Input Form -->
    <div class="mb-3">
        <form id="chat-form" style="display: flex; flex-direction: column; align-items: start; width: 100%; border-radius: 12px; border: 1px solid #ccc; padding: 10px; background-color: #f9f9f9;">
            @csrf
            <div style="display: flex; justify-content: space-between; align-items: center; width: 100%;">
                <input
                    type="text"
                    id="message-input"
                    name="message"
                    class=""
                    placeholder="Message Talentern..."
                    style="width: 85%; font-size:15px ; border: none; outline: none; background: transparent; color: black;"
                    autocomplete="off" spellcheck="false" autocorrect="off"
                />
                <button
                    id="SendBtn"
                    type="submit"
                    class="d-flex align-items-center justify-content-center"
                    style="border-radius: 4px; background-color: #4EA971; color: white; border: none; width: 40px; height: 40px;"
                >
                    <i class="fa-regular fa-paper-plane"></i>
                </button>
            </div>

            <div style="text-align: center; margin-bottom: 10px; font-size:13px; padding:12px ;font-weight:600; color:#cc7f36; border-radius:8px; background-color:#ffecd9">
                Sesi Trial Wawancara
            </div>
        </form>

        <!-- Font Awesome -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

        <small class="form-text text-muted">Tolong jawab dengan jujur</small>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('chat-form');
    const input = document.getElementById('message-input');

// Handle pressing Enter inside input
input.addEventListener('keydown', function(e) {
    if (e.key === 'Enter') {
        e.preventDefault();
        form.dispatchEvent(new Event('submit'));
    }
});

    form.addEventListener('submit', async function (e) {
        e.preventDefault(); // Mencegah form submit default

        const messageInput = document.getElementById('message-input');
        const message = messageInput.value.trim();
        const idPendaftaran = @json($id_pendaftaran);

        if (message === '') {
            showSweetAlert({
            title: 'Warning',
            text: `Pesan Tidak Boleh Kosong!`,
            icon: 'warning',
            confirmButtonText: 'OK',
        });
            return;
        }

        // Tambahkan pesan pengguna ke tampilan
        const userMessage = `
            <div class="d-flex justify-content-end" style="margin-top:10px ">
                <div class="message p-3 shadow-sm text-sm" style="border-radius:1rem; background-color: #D3D6DB; color: #23314B;">
                    ${message}
                </div>
            </div>`;
        document.querySelector('.bubblechat').insertAdjacentHTML('beforeend', userMessage);

        messageInput.value = '';
        document.querySelector('.scrollbarhide').scrollTop = document.querySelector('.scrollbarhide').scrollHeight;

        try {
            const response = await fetch("/chat/trial", {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': "{{ csrf_token() }}",
                },
                body: JSON.stringify({
                    message: message,
                    id_pendaftaran: idPendaftaran
                }),
            });

            if (!response.ok) {
                const text = await response.text();
                throw new Error(`Server returned ${response.status}: ${text}`);
            }

            const data = await response.json();

            const botMessage = `
                <div class="d-flex justify-content-start" style="margin-top:10px">
                    <div class="message p-3 shadow-sm text-sm" style="border-radius:1rem; background-color: #C4E2D0; color: #34714B;">
                        ${data.next_question}
                    </div>
                </div>`;
            document.querySelector('.bubblechat').insertAdjacentHTML('beforeend', botMessage);

            if (data.interview_status === 'selesai') {
                const sendButton = document.getElementById('SendBtn');
                sendButton.disabled = true;
                sendButton.style.opacity = '0.5';
                sendButton.style.cursor = 'not-allowed';
                input.disabled = true;

                document.getElementById('trialEndCard').style.display = 'block';
            }

            document.querySelector('.scrollbarhide').scrollTop = document.querySelector('.scrollbarhide').scrollHeight;
        } catch (error) {
            console.error('Error:', error);
            alert('Terjadi kesalahan. Silakan coba lagi.');
        }
    });
});
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
