@extends('partials.vertical_menu')

@section('page_style')
@endsection

@section('content')
<div class="d-flex justify-content-between">
    <h4 class="fw-bold">Jadwal Seleksi</h4>
    
</div>
<div class="row mt-2">
    <div class="col-12">
        <div class="card">
            <div class="card-datatable table-responsive">
                <table class="table" id="table-mitra">
                    <thead>
                        <tr>
                            <th>NO</th>
                            <th>Nama Perusahaan</th>
                            <th>Total Lowongan</th>
                            <th>Total Pelamar</th>
                            <th class="text-center">STATUS Kerjasama</th>
                            <th class="text-center">AKSI</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@section('page_script')
<script>
    $(document).ready(function() {
        table_master_prodi();
    });

    function table_master_prodi() {
        var table = $('#table-mitra').DataTable({
            ajax: "{{ route('jadwal_seleksi_lkm.get_mitra') }}",
            serverSide: false,
            processing: true,
            deferRender: true,
            destroy: true,
            columns: [
                { data: "DT_RowIndex" },
                { data: "namaindustri" },
                { data: "total_lowongan" },
                { data: "total_pelamar" },
                { data: "statuskerjasama" },
                { data: "action" }
            ]
        });
    }
</script>
@endsection