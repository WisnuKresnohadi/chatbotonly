@extends('partials.vertical_menu')

@section('page_style')
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12 col-12">
            <h4 class="fw-bolder">{{ $view['title'] }}</h4>
        </div>
    </div>
    <div class="row mt-2">
        <div class="col-12">
            <div class="nav-align-top">
                <ul class="nav nav-pills mb-3 " role="tablist">
                    <li class="nav-item">
                        <button type="button" class="nav-link active" role="tab" data-bs-toggle="tab"
                            data-bs-target="#navs-pills-justified-approval" aria-controls="navs-pills-justified-approval"
                            aria-selected="true">
                            <i class="tf-icons ti ti-clock ti-xs me-1"></i> Belum Approval
                        </button>
                    </li>
                    <li class="nav-item">
                        <button type="button" class="nav-link" role="tab" data-bs-toggle="tab"
                            data-bs-target="#navs-pills-justified-sudah_approval" aria-controls="navs-pills-justified-sudah_approval"
                            aria-selected="false">
                            <i class="tf-icons ti ti-list-check ti-xs me-1"></i> Sudah Approval
                        </button>
                    </li>
                </ul>                                                      
            </div>
        </div>
    </div>

    <div class="tab-content p-0">
        @foreach (['approval', 'sudah_approval'] as $key => $item)
        <div class="tab-pane fade tab-content p-0 {{ $key == 0 ? 'show active' : '' }}" id="navs-pills-justified-{{ $item }}" role="tabpanel">            
                @if ($item == 'approval')
                <div class="d-flex justify-content-end align-items-center mb-4">
                    <button type="button" id="approve-mahasiswa" class="btn btn-primary text-white" onclick="approved($(this), true)">Approve Mahasiswa</button>                            
                </div>   
                @endif            
            <div class="card">
                <div class="card-datatable table-responsive">
                    <table class="table" id="{{ $item }}">
                        <thead>
                            <tr>                                
                                @foreach ($view[$item] as $item)
                                {!! $item !!}
                                @endforeach
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
        @endforeach
    </div>    
@include('approval_mahasiswa/components/modal')
@endsection

@section('page_script')
<script>
    $(document).ready(function () {
        loadData();
    });

    // fix datatable when click button tab
    $('button[data-bs-toggle="tab"]').on('shown.bs.tab', function (event) {
        $('.table').each(function () {
            $(this).DataTable().columns.adjust().responsive.recalc();
        });
    });

    function loadData() {               
        $('.table').each(function () {
        let columns = {!! $view['columnsApproval'] !!};

        if ($(this).attr('id') == 'sudah_approval') {
            columns = {!! $view['columnsSudahApproval'] !!};
        }

        let attrDatatable = {
            ajax: {
                url: `{{ $view['urlGetData'] }}`,
                type: 'GET',
                data: { section: $(this).attr('id') }
            },
            serverSide: false,
            processing: true,
            destroy: true,
            columns: columns,
            columnDefs: [{!! $view['columnDefs'] ?? null !!}],
            ordering: false,
            scrollX: true,      
            drawCallback: function () {
                $('[data-bs-toggle="tooltip"]').tooltip();
            },   
            select: {style: 'multi', selector: 'td:first-child input:checkbox'},            
        };

        if ($(this).attr('id') == 'sudah_approval') {
            delete attrDatatable.columnDefs;
            delete attrDatatable.select;
        }

        $(this).DataTable(attrDatatable);
    });
    }

    function approved(e, isMany = false) {
        let status = e.attr('data-status') ?? '';
        let dataId = e.attr('data-id') ?? $('input.dt-checkboxes:checked').map(function () {return $(this).val()}).get();                       
        let urlApproval = isMany ? `{{ $view['urlApprovals'] }}` :`{{ $view['urlApproval'] }}`.replace(':id', dataId) 
        const data = {
            _token: $('meta[name="csrf-token"]').attr('content'),
            status: status,      
            id_pendaftaran: []              
        }        

        if(isMany) {
            if(dataId.length == 0) {
                showSweetAlert({
                    title: 'Invalid',
                    text: 'Pilih mahasiswa terlebih dahulu',
                    icon: 'warning'
                });
                return;
            }      
            data.id_pendaftaran = dataId     
        }       

        sweetAlertConfirm({
            title: 'Apakah anda yakin ingin menyetujui pendaftaran magang?',
            text: 'Data terpilih akan secara otomatis berubah dan melanjutkan ke status berikutnya!',
            icon: 'warning',
            confirmButtonText: 'Ya, saya yakin!',
            cancelButtonText: 'Batal'
        }, function () {
            $.ajax({
                url: urlApproval,
                type: "POST",
                data: data,
                success: function (response) {
                    if (!response.error) {
                        showSweetAlert({
                            title: 'Berhasil!',
                            text: response.message,
                            icon: 'success'
                        });

                        $('.table').each(function () {
                            $(this).DataTable().ajax.reload(); 
                        });
                    } else {
                        showSweetAlert({
                            title: 'Gagal!',
                            text: response.message,
                            icon: 'error'
                        });
                    }
                },
                error: function (xhr, status, error) {
                    let res = xhr.responseJSON;
                    showSweetAlert({
                        title: 'Gagal!',
                        text: res.message,
                        icon: 'error'
                    });
                }
            });
        });
    }

    function rejected(e) {
        let status = e.attr('data-status');
        let dataId = e.attr('data-id');
        let modal = $("#modalRejectLamaran");

        modal.find('form').attr('action', `{{ $view['urlApproval'] }}`.replace(':id', dataId));
        modal.find('form').prepend(`<input type="hidden" name="status" value="${status}">`);
        modal.modal('show');
    }

    function afterActionRejected(response) {
        let modal = $("#modalRejectLamaran");

        $('.table').each(function () {
            $(this).DataTable().ajax.reload(); 
        });

        modal.modal('hide');
    }

    $("#modalRejectLamaran").on('hide.bs.modal', function () {
        $(this).find('form').find('input[name="status"]').remove();
    });
</script>
@endsection
