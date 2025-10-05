@extends('partials.vertical_menu')

@section('meta_header')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@section('page_style')
@endsection

@section('content')
<div class="row">
    <div class="col-md-6 col-12">
        <h4 class="fw-bold"><span class="text-muted fw-light">Master Data /</span> Bidang Pekerjaan</h4>
    </div>
    <div class="col-md-6 col-12 text-end">
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modal-bidang-pekerjaan">Tambah Bidang Pekerjaan</button>
    </div>
</div>
    <div class="mt-2 row">
        <div class="col-12">
            <div class="card">
                <div class="card-datatable table-responsive">
                    <table class="table" id="table-master-bidang-pekerjaan">
                        <thead>
                            <tr>
                                <th>NOMOR</th>
                                <th style="max-width: 30%">NAMA BIDANG PEKERJAAN</th>                                                            
                                <th style="max-width: 40%">DESKRIPSI</th>                                                            
                                <th class="text-center">AKSI</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    @include('masters.bidang_pekerjaan_industri.modal')
@endsection

@section('page_script')
    <script>
        $(document).ready(function() {
            bidangPekerjaanList();
        });        

        function bidangPekerjaanList() {
            var table = $('#table-master-bidang-pekerjaan').DataTable({
                ajax: `{{ route('bidangpekerjaanindustri.show') }}`,
                serverSide: false,
                processing: true,
                deferRender: true,
                type: 'GET',
                destroy: true,
                columns: [{
                        data: 'DT_RowIndex'
                    },

                    {
                        data: 'namabidangpekerjaan',
                        name: 'namabidangpekerjaan'
                    },    
                    {
                        data: 'deskripsi',
                        name: 'deskripsi'
                    },              
                    {
                        data: 'action',
                        name: 'action'
                    }
                ],                
            });
        }



        function edit(e) {
            let id = e.attr('data-id');

            let action = `{{ route('bidangpekerjaanindustri.update', ['id' => ':id']) }}`.replace(':id', id);
            var url = `{{ route('bidangpekerjaanindustri.edit', ['id' => ':id']) }}`.replace(':id', id);
            let modal = $('#modal-bidang-pekerjaan');
            modal.find(".modal-title").html("Edit Bidang Pekerjaan");
            modal.find('form').attr('action', action);
            modal.modal('show');

            $.ajax({
                type: 'GET',
                url: url,
                success: function(response) {
                    
                    $('#namabidangpekerjaan').val(response.data.namabidangpekerjaan);
                    $('#deskripsi').val(response.data.deskripsi);
                }
            });
        }

        function afterAction(response) {
            $("#modal-bidang-pekerjaan").modal("hide");
            afterUpdateStatus(response);
        }

        function afterUpdateStatus(response) {
            $('#table-master-bidang-pekerjaan').DataTable().ajax.reload();            
        }

        $("#modal-bidang-pekerjaan").on("hide.bs.modal", function() {
            $(this).find(".modal-title").html("Tambah Bidang Pekerjaan");
            $(this).find('form').attr('action', "{{ route('bidangpekerjaanindustri.store') }}");
        });
    </script>
@endsection

