@extends("partials.horizontal_menu",['disableNav' => true, 'footer' => false]) <!-- layout header dan footer -->

@section('page_style')
<style>
  .custom-card-bg {
    background-color: #1a3826;
    border-radius: 20px;
  }
  .main-container {
    display: flex;/
    margin-top:20px
  }
  .scrollbarhide::-webkit-scrollbar {
      display: none;
  }
  .scrollbarhide {
      -ms-overflow-style: none;
      scrollbar-width: none;
  }
  button:disabled {
    opacity: 0.5;
    cursor: not-allowed;
  }
</style>
@endsection

@section('content')
<div class="col mt-5 w-full" style="background-color:white;">
    <div class="main-container d-flex justify-content-center align-self-ceneter w-full" style="margin-top=2rem;">
        <div style="width: 926px">
            @component('chatbot.components.chatsection', [
                'messages' => $messages,
                'status' => $status,
                'id_pendaftaran' => $id_pendaftaran
            ])
            @endcomponent
        </div>
    </div>
</div>
@endsection



@section('page_script')
<script>
  document.addEventListener("DOMContentLoaded", function() {
    // Target header dengan ID atau class tertentu
    const header = document.getElementById('layout-navbar'); // Sesuaikan dengan ID/class header Anda

    if (header) {
      // Menonaktifkan semua tombol
      header.querySelectorAll('button').forEach(button => {
        button.disabled = true;
      });

      // Menonaktifkan semua tautan
      header.querySelectorAll('a').forEach(link => {
        link.addEventListener('click', function(event) {
          event.preventDefault(); // Mencegah navigasi
          event.stopPropagation(); // Menghentikan event bubbling
        });
        link.style.pointerEvents = 'none'; // Mencegah klik
        link.style.opacity = '0.5'; // Memberi efek visual bahwa tautan tidak aktif
      });

      // Menonaktifkan input yang dapat mengirimkan form
      header.querySelectorAll('input[type="submit"], input[type="button"]').forEach(input => {
        input.disabled = true;
      });
    }
  });
</script>
@endsection

