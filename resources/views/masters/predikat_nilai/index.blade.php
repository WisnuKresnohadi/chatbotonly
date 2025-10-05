@extends('partials.vertical_menu')

@section('meta_header')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@section('page_style')
@endsection

@section('content')
<div class="row">
    <div class="col-md-6 col-12">
        <h4 class="fw-bold"><span class="text-muted fw-light">Master Data /</span> Predikat Nilai</h4>
    </div>
    <div class="col-md-6 col-12 text-end">
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modal-predikat-nilai">Tambah Predikat Nilai</button>
    </div>
</div>
    <div class="row mt-2">
        <div class="col-12">
            <div class="card">
                <div class="card-datatable table-responsive">
                    <table class="table" id="table-master-predikat-nilai">
                        <thead>
                            <tr>
                                <th>NOMOR</th>
                                <th>NAMA</th>                                                            
                                <th>NILAI</th>                                                            
                                <th class="text-center">STATUS</th>                                                            
                                <th class="text-center">AKSI</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    @include('masters.predikat_nilai.modal')
@endsection

@section('page_script')
    <script>
        $(document).ready(function() {
            predikatNilaiMagangList();
        });        

        function predikatNilaiMagangList() {
            var table = $('#table-master-predikat-nilai').DataTable({
                ajax: `{{ route('predikatnilai.show') }}`,
                serverSide: false,
                processing: true,
                deferRender: true,
                type: 'GET',
                destroy: true,
                columns: [{
                        data: 'DT_RowIndex'
                    },

                    {
                        data: 'nama',
                        name: 'nama'
                    },    
                    {
                        data: 'nilai',
                        name: 'nilai'
                    },  
                    {
                        data: 'status',
                        name: 'status'
                    },              
                    {
                        data: 'action',
                        name: 'action'
                    }
                ]
            });
        }

        function edit(e) {
            let id = e.attr('data-id');

            let action = `{{ route('predikatnilai.update', ['id' => ':id']) }}`.replace(':id', id);
            var url = `{{ route('predikatnilai.edit', ['id' => ':id']) }}`.replace(':id', id);
            let modal = $('#modal-predikat-nilai');
            modal.find(".modal-title").html("Edit Predikat Nilai");
            modal.find('form').attr('action', action);
            modal.modal('show');

            $.ajax({
                type: 'GET',
                url: url,
                success: function(response) {
                    $('#nama').val(response.nama);
                    $('#nilai').val(response.nilai);
                }
            });
        }

        function afterAction(response) {
            $("#modal-predikat-nilai").modal("hide");
            afterUpdateStatus(response);
        }

        function afterUpdateStatus(response) {
            $('#table-master-predikat-nilai').DataTable().ajax.reload();            
        }

        $("#modal-predikat-nilai").on("hide.bs.modal", function() {
            $(this).find(".modal-title").html("Tambah Predikat Nilai");
            $(this).find('form').attr('action', "{{ route('predikatnilai.store') }}");
        });
    </script>
@endsection
