@extends('partials.vertical_menu')

@section('page_style')
@endsection

@section('content')
<div class="row">
    <div class="col-md-9 col-12">
        @if (isset($urlBack))
        <a href="{{ $urlBack }}" class="btn btn-outline-primary mb-3">
            <i class="ti ti-arrow-left"></i>
            Kembali
        </a>
        @endif
        <div class="col-md-9 col-12">
            <h4 class="fw-bold">Proses Seleksi</h4>
        </div>
    </div>
    <div class="col-md-3 col-12 mb-3 float-end d-flex justify-content-end">
        <select class="select2 form-select" data-placeholder="Pilih Tahun Ajaran" style="width: 95% !important;">
            <option value="1">2023/2024 Genap</option>
            <option value="2">2023/2024 Ganjil</option>
            <option value="3">2022/2023 Genap</option>
            <option value="4">2022/2023 Ganjil</option>
            <option value="5">2021/2022 Genap</option>
            <option value="6">2021/2022 Ganjil</option>
        </select>
    </div>
</div>

<div class="row mt-2">
    <div class="col-12">
        <table class="" id="table-jadwal"></table>
    </div>
</div>
@endsection

@section('page_script')
<script src="{{ asset('app-assets/vendor/libs/sweetalert2/sweetalert2.js') }}"></script>
<script src="{{ asset('app-assets/js/extended-ui-sweetalert2.js') }}"></script>

<script>
    $(function() {
        loadData();
    });

    function loadData() {
        $('#table-jadwal').DataTable({
            ajax: "{{ $urlGetData }}",
            serverSide: false,
            processing: true,
            deferRender: true,
            type: 'GET',
            destroy: true,
            ordering: false,
            columns: [{data: 'card', name: 'card'}]
        });
    }
</script>
@endsection