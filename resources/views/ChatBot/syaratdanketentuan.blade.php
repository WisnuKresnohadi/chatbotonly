@extends("partials.horizontal_menu") <!-- layout header dan footer -->

@section('page_style')
<style>
  .custom-card-bg {
    background-color: #1a3826;
    border-radius: 20px;
  }
  .main-container {
    display: flex;
    margin-top:20px
  }
  .scrollbarhide::-webkit-scrollbar {
      display: none;
  }
  .scrollbarhide {
      -ms-overflow-style: none;
      scrollbar-width: none;
  }
</style>
@endsection

@section('content')
<div class="col mt-5 w-full" style="background-color:white;">
    <div class="main-container d-flex justify-content-center align-self-ceneter w-full">
        <div  style="width: 926px">
            @component('chatbot.components.chatbotlayout')
            @endcomponent
            @component('chatbot.components.syaratdanketentuan', ['id_pendaftaran' => $id_pendaftaran]);
            @endcomponent
        </div>


        {{-- <div class="container px-0" style="w-full; background:white; " >
            <div class="row container" style="height: 90vh;" >
                @component('chatbot.components.chatsection', ['messages' => $messages])
                @endcomponent
            </div>
        </div> --}}
    </div>
</div>
@endsection
