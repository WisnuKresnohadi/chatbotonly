@extends('partials.vertical_menu')

@section('meta_header')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@section('page_style')
@endsection

@section('content')
    <div class="row">
        <div class="col-md-6 col-12">
            <h4 class="fw-bold"><span class="text-muted fw-light">Mitra /</span> Kelola Mitra</h4>
        </div>
        <div class="col-md-6 col-12 text-end">
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalTambahMitra">Tambah Mitra</button>
        </div>
    </div>
    <div class="col-xl-12">
        <div class="nav-align-top">
            <ul class="mb-3 nav nav-pills " role="tablist">
                <li class="nav-item">
                    <button type="button" class="nav-link active" role="tab" data-bs-toggle="tab"
                        data-bs-target="#navs-pills-justified-pending" aria-controls="navs-pills-justified-pending"
                        aria-selected="true">
                        <i class="tf-icons ti ti-clock ti-xs me-1"></i> Pending
                    </button>
                </li>
                <li class="nav-item">
                    <button type="button" class="nav-link" role="tab" data-bs-toggle="tab"
                        data-bs-target="#navs-pills-justified-verified" aria-controls="navs-pills-justified-verified"
                        aria-selected="false">
                        <i class="tf-icons ti ti-user-check ti-xs me-1"></i> Verified
                    </button>
                </li>
                <li class="nav-item">
                    <button type="button" class="nav-link" role="tab" data-bs-toggle="tab"
                        data-bs-target="#navs-pills-justified-rejected" aria-controls="navs-pills-justified-rejected"
                        aria-selected="false">
                        <i class="tf-icons ti ti-user-x ti-xs me-1"></i> Rejected
                    </button>
                </li>
            </ul>
            <div class="tab-content">
                @foreach (['pending', 'verified', 'rejected'] as $key => $item)
                <div class="tab-pane fade {{ $key == 0 ? 'show active' : '' }}" id="navs-pills-justified-{{ $item }}" role="tabpanel">
                    <div class="card-datatable table-responsive">
                        <table class="table" id="{{ $item }}">
                            <thead>
                                <tr>
                                    <th>NOMOR</th>
                                    <th style="min-width: 100px;">Perusahaan</th>
                                    <th>PENANGGUNG JAWAB</th>
                                    <th>KATEGORI MITRA</th>
                                    <th class="text-center">STATUS KERJASAMA</th>
                                    <th style="text-align:center;">AKSI</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        @include('company.kelola_mitra.modal')
    </div>
@endsection

@section('page_script')
    <script>
        $(document).ready(function () {
            loadData();
        });

        $('button[data-bs-toggle="tab"]').on('shown.bs.tab', function(e) {
            $($.fn.dataTable.tables(true)).DataTable().columns.adjust().responsive.recalc();
        });


        function afterAction(response) {
            $('#modalTambahMitra').modal('hide');
            $('.table').each(function () {
                if ($(this).attr('id') == undefined) return;
                $(this).DataTable().ajax.reload(null, false);
            });
        }

        function loadData() {
            $('.table').each(function () {
                if ($(this).attr('id') == undefined) return;

                $(this).DataTable({
                    ajax: "{{ route('kelola_mitra.show') }}?status=" + $(this).attr('id'),
                    scrollX: true,
                    autoWidth: false,
                    scrollCollapse: true,
                    destroy: true,
                    drawCallback: function(settings) {
                        initTooltips();
                    },
                    columns: [{
                            data: 'DT_RowIndex'
                        },

                        {
                            data: 'namaindustri',
                            name: 'namaindustri'
                        },
                        {
                            data: 'penanggung_jawab',
                            name: 'penanggung_jawab'
                        },
                        {
                            data: 'kategori_industri',
                            name: 'kategori_industri'
                        },
                        {
                            data: 'statuskerjasama',
                            name: 'statuskerjasama'
                        },
                        {
                            data: 'aksi',
                            name: 'aksi'
                        }
                    ]
                });
            });
        }

        function edit(e) {
            let id = e.attr('data-id');
            let action = `{{ route('kelola_mitra.status_kerja_sama', ':id') }}`.replace(':id', id);
            let url = `{{ route('kelola_mitra.edit', ':id') }}`.replace(':id', id);
            let modal = $('#modalTambahMitra');

            modal.find('.modal-title').html("Edit Status Kerja Sama");
            modal.find('form').attr('action', action);
            modal.modal('show');

            $.ajax({
                type: 'GET',
                url: url,
                success: function(response) {
                    $('#nama').val(response.namaindustri).attr('disabled', true);
                    $('#email').val(response.email).attr('disabled', true);
                    $('#contact_person').val(response.contact_person).attr('disabled', true);
                    $('#penanggung_jawab').val(response.penanggung_jawab).attr('disabled', true);
                    $('#alamat').val(response.alamatindustri ?? '-').attr('disabled', true);
                    $('#deskripsi').val(response.description ?? '-').attr('disabled', true);
                    $('#kategori').val(response.kategori_industri).trigger('change').attr('disabled', true);
                    $('#statuskerjasama').val(response.statuskerjasama).trigger('change');
                }
            });
        }

        $("#modalTambahMitra").on("hide.bs.modal", function() {
            $('#nama').attr('disabled', false);
            $('#email').attr('disabled', false);
            $('#contact_person').attr('disabled', false);
            $('#penanggung_jawab').attr('disabled', false);
            $('#alamat').attr('disabled', false);
            $('#deskripsi').attr('disabled', false);
            $('#kategori').attr('disabled', false);
            let dataLabel = $(this).find('.modal-title').attr('data-label');
            $(this).find('.modal-title').html(dataLabel);
        });

        function approved(e) {
            sweetAlertConfirm({
                title: 'Konfirmasi Persetujuan Data Mitra',
                text: 'Apakah anda yakin untuk menyetujui data mitra?',
                icon: 'warning',
                confirmButtonText: 'Ya, Yakin',
                cancelButtonText: 'Batal',
            }, function () {
                $.ajax({
                    url: `{{ route('kelola_mitra.approved', ['id' => ':id']) }}`.replace(':id', e.attr('data-id')),
                    type: "POST",
                    headers: {
                        "X-CSRF-TOKEN": "{{ csrf_token() }}"
                    },
                    success: function(response) {
                        if (!response.error) {
                            loadData();
                            showSweetAlert({
                                title: 'Berhasil!',
                                text: response.message,
                                icon: 'success'
                            });

                            settingBadgeCount(response.data.kelola_mitra_count);
                        } else {
                            showSweetAlert({
                                title: 'Gagal!',
                                text: response.message,
                                icon: 'error'
                            });
                        }
                    }
                });
            });
        }

        function deleteData(e) {
            sweetAlertConfirm({
                title: 'Konfirmasi Penghapusan Data Mitra',
                text: 'Apakah anda yakin untuk menghapus data mitra?',
                icon: 'warning',
                confirmButtonText: 'Ya, Yakin',
                cancelButtonText: 'Batal',
            }, function () {
                $.ajax({
                    url: `{{ route('kelola_mitra.delete', ['id' => ':id']) }}`.replace(':id', e.attr('data-id')),
                    type: "POST",
                    headers: {
                        "X-CSRF-TOKEN": "{{ csrf_token() }}"
                    },
                    success: function(response) {
                        if (!response.error) {
                            loadData();
                            showSweetAlert({
                                title: 'Berhasil!',
                                text: response.message,
                                icon: 'success'
                            });

                            settingBadgeCount(response.data.kelola_mitra_count);
                        } else {
                            showSweetAlert({
                                title: 'Gagal!',
                                text: response.message,
                                icon: 'error'
                            });
                        }
                    }
                });
            });
        }

        function rejected(e) {
            let modal = $('#modalreject');
            let urlAction = `{{ route('kelola_mitra.rejected', ['id' => ':id']) }}`.replace(':id', e.attr('data-id'));
            modal.find('form').attr('action', urlAction);
            modal.modal('show');
        }

        function resetPassword(e) {
            $.ajax({
                url: "{{ route('kelola_mitra.reset_password', ['id' => ':id']) }}".replace(':id', e.attr('data-id')),
                type: 'POST',
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                success: function(response) {
                    if (!response.error) {
                        showSweetAlert({
                            title: 'Berhasil!',
                            text: response.message,
                            icon: 'success'
                        });
                    } else {
                        showSweetAlert({
                            title: 'Gagal!',
                            text: response.message,
                            icon: 'error'
                        });
                    }
                },
                error: function(xhr, status, error) {
                    let res = xhr.responseJSON;
                    showSweetAlert({
                        title: 'Gagal!',
                        text: res.message,
                        icon: 'error'
                    });
                }
            });
        }

        function afterReject(res) {
            settingBadgeCount(res.data.kelola_mitra_count);
            loadData();
            $('#modalreject').modal('hide');
        }

        function settingBadgeCount(total) {
        if (total > 0) {
            $('#kelola_mitra_count').html(total);
        } else {
            $('#kelola_mitra_count').attr('hidden', true);
        }
    }
    </script>
@endsection
