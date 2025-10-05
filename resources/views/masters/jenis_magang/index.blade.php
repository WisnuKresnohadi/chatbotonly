@extends('partials.vertical_menu')

@section('page_style')
@endsection

@section('content')
<div class="row">
    <div class="col-md-6 col-12">
        <h4 class="fw-bold"><span class="text-muted fw-light">Master Data /</span> Jenis Magang</h4>
    </div>
    <div class="col-md-6 col-12 text-end">
        <a href="{{ route('jenismagang.create') }}" class="btn btn-success">Tambah Jenis Magang</a>
    </div>
</div>

<div class="row mt-2">
    <div class="col-12">
        <div class="card">
            <div class="card-datatable table-responsive">
                <table class="table" id="table-master-jenis_magang">
                    <thead>
                        <tr>
                            <th>NOMOR</th>
                            <th>JENIS MAGANG</th>
                            <th>TAHUN AJARAN</th>
                            <th>DURASI MAGANG</th>
                            <th>DESKRIPSI MAGANG</th>
                            <th>Dokumen Persyaratan</th>
                            <th>BERKAS AKHIR</th>
                            <th class="text-center">STATUS</th>
                            <th class="text-center">AKSI</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</div>
@include('masters/jenis_magang/components/modal')
@endsection

@section('page_script')
<script>
    $(document).ready(function() {
        $('.read-more-btn').click(function() {  
            const $this = $(this);  
            $this.siblings('.more-content').slideToggle(); // Toggle the visibility of the full description  
            $this.text($this.text() === 'Read More' ? 'Read Less' : 'Read More'); // Change button text  
        });
    });

    var table = $('#table-master-jenis_magang').DataTable({
        ajax: '{{ route("jenismagang.show") }}',
        serverSide: false,
        processing: true,
        deferRender: true,
        type: 'GET',
        destroy: true,
        scrollX: true,
        drawCallback:function() {
            $('.read-more-btn').click(function() {  
                const $this = $(this);  
                $this.siblings('.more-content').slideToggle(); // Toggle the visibility of the full description  
                $this.text($this.text() === 'Read More' ? 'Read Less' : 'Read More'); // Change button text  
            });
        },
        columns: [{
                data: "DT_RowIndex"
            },
            {
                data: 'namajenis',
                name: 'nama_jenis'
            },
            {
                data: 'tahun',
                name: 'tahun'
            },
            {
                data: 'durasimagang',
                name: 'durasi_magang'
            },
            {
                data: 'desc',
                name: 'desc',
            },
            {
                data: 'dokumen_persyaratan',
                name: 'dokumen_persyaratan'
            },
            {
                data: 'berkas_magang',
                name: 'berkas_magang'
            },
            {
                data: "status",
                name: 'status_active'
            },
            {
                data: "action",
                name: 'action'
            }
        ]
    });

    function afterUpdateStatus(response) {
        table.ajax.reload();
    }

    function afterUpdateStatusDokumen(res) {
        $('#container_list_berkas').html(res.data);
    }

    function afterUpdateStatusBerkas(res) {
        $('#container_list_berkas').html(res.data);
    }

    function viewBerkas(e) {
        $.ajax({
            url: `{{ route('jenismagang.get_data_berkas') }}`,
            type: `GET`,
            data: {
                'data_id' : e.attr('data-id'),
                'data_section' : e.attr('data-section'),
            },
            success: function (res) {
                res = res.data;
                let modal = $('#modalViewBerkas');
                modal.find('#title_berkas').text(res.title);
                modal.find('#container_list_berkas').html(res.view);
                modal.modal('show');
            }
        });
    }
</script>
@endsection