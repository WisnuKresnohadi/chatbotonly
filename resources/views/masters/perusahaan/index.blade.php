@extends('partials.vertical_menu')

@section('meta_header')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@section('page_style')
@endsection

@section('content')
<div class="row">
    <div class="col-md-6 col-12">
        <h4 class="fw-bold"><span class="text-muted fw-light">Master Data /</span> Perusahaan Dan Bidang Pekerjaan</h4>
    </div>
    <div class="col-md-6 col-12 text-end">
        {{-- <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modal-bidang-pekerjaan">Tambah Bidang Pekerjaan</button> --}}
    </div>
</div>
    <div class="row mt-2">
        <div class="col-12">
            <div class="card">
                <div class="card-datatable table-responsive">
                    <table class="table" id="table-master-perusahaan">
                        <thead>
                            <tr>
                                <th>NOMOR</th>
                                <th>PERUSAHAAN</th>                                                            
                                <th>JUMLAH BIDANG PEKERJAAN</th>                                                                                            
                                <th>INFORMASI</th>                                                                                            
                                <th>AKSI</th>                                                                                            
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    
@endsection

@section('page_script')
    <script>
        $(document).ready(function() {
            perusahaanList();
        });    

        function perusahaanList() {
            var table = $('#table-master-perusahaan').DataTable({
                ajax: `{{ route('perusahaan.show') }}`,
                serverSide: false,
                processing: true,
                deferRender: true,
                type: 'GET',
                destroy: true,
                columns: [{
                        data: 'DT_RowIndex'
                    },

                    {
                        data: 'namaperusahaan',
                        name: 'namaperusahaan'
                    },    
                    {
                        data: 'jumlah_bidang_pekerjaan',
                        name: 'jumlah_bidang_pekerjaan'
                    },                                 
                    {
                        data: 'informasi',
                        name: 'informasi'
                    },                                 
                    {
                        data: 'action',
                        name: 'action'
                    },                                 
                ],                
            });
        }              
    </script>
@endsection

