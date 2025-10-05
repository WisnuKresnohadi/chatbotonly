@extends("partials.horizontal_menu",['disableNav' => false]) <!-- layout header dan footer -->
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
            @component('chatbot.components.historychat', ['kriteria' => $kriteria, 'hasilKesimpulan' => $hasilKesimpulan])
            @endcomponent
        </div>
    </div>
</div>
@endsection
