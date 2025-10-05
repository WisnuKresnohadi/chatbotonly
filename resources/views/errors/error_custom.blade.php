@extends('partials.horizontal_menu')

@section('page_style')
@endsection

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="col-md-12 col-12 mt-3">
        <h4 class="fw-bold">{!! $title !!}</h4>
    </div>
    <div id="container-berkas">
        <div class="text-center mb-5">
            <img src="{{ asset('assets/images/no_data.svg') }}" width="450" alt="No Data">
            <h4 class="text-primary">{{ $message_1 }}</h4>
            <p class="col-8 mx-auto fs-5 fw-semibold">{{ $message_2 }}</p>
            <a href="{{ url('/') }}" class="btn btn-primary mt-3">Oke Saya Mengerti...</a>
        </div>
    </div>
</div>
@endsection

@section('page_script')
@endsection