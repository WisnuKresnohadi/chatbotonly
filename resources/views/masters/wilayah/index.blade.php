@extends('partials.vertical_menu')

@section('meta_header')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@section('page_style')
@endsection

@section('content')
    <div class="row">
        <div class="col-md-6 col-12">
            <h4 class="fw-bold"><span class="text-muted fw-light">Master Data /</span> Wilayah</h4>
        </div>
        <div class="col-md-6 col-12 text-end">
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalTambahWilayah">Tambah Wilayah</button>
        </div>
    </div>
    <div class="col-xl-12">
        <div class="nav-align-top">
            <ul class="nav nav-pills mb-3 " role="tablist">
                <li class="nav-item">
                    <button type="button" class="nav-link active" role="tab" data-bs-toggle="tab"
                        data-bs-target="#navs-pills-justified-countries" aria-controls="navs-pills-justified-countries"
                        aria-selected="true">
                        <i class="tf-icons ti ti-map ti-xs me-1"></i> Countries
                    </button>
                </li>
                <li class="nav-item">
                    <button type="button" class="nav-link" role="tab" data-bs-toggle="tab" id="provinces-tab"
                        data-bs-target="#navs-pills-justified-provinces" aria-controls="navs-pills-justified-provinces"
                        aria-selected="false">
                        <i class="tf-icons ti ti-map-pin ti-xs me-1"></i> Provinces
                    </button>
                </li>
                <li class="nav-item">
                    <button type="button" class="nav-link" role="tab" data-bs-toggle="tab" id="cities-tab"
                        data-bs-target="#navs-pills-justified-cities" aria-controls="navs-pills-justified-cities"
                        aria-selected="false">
                        <i class="tf-icons ti ti-map-pins ti-xs me-1"></i> Cities
                    </button>
                </li>
            </ul>
            <div class="tab-content">
                @foreach (['countries', 'provinces', 'cities'] as $key => $item)
                <div class="tab-pane fade {{ $key == 0 ? 'show active' : '' }}" id="navs-pills-justified-{{ $item }}" role="tabpanel">
                    <div class="card-datatable table-responsive">
                        <table class="table" id="{{ $item }}">
                            <thead>
                                <tr>
                                    <th>NOMOR</th>
                                    <th style="min-width: 100px;">NAMA</th>
                                    @if($item == 'provinces')
                                    <th>NEGARA</th>
                                    @elseif($item == 'cities')
                                    <th>PROVINSI</th>
                                    @endif
                                    <th style="text-align:center;">AKSI</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        @include('masters.wilayah.modal')
    </div>
@endsection

@section('page_script')
    <script>
        $(document).ready(function () {
            loadData('countries');
        });

        $('button[data-bs-toggle="tab"]').on('shown.bs.tab', function(e) {
            $($.fn.dataTable.tables(true)).DataTable().columns.adjust().responsive.recalc();
        });

        function afterAction(response) {
            $('#modalTambahWilayah').modal('hide');
            $('#type').val('').trigger('change');
            if(response.data.type == 'country') {
                loadData('countries');
                if(response.data.edit == true){
                    isProvincesClicked = false
                }
            } else if(response.data.type == 'province') {
                loadData('provinces');
                if(response.data.edit == true){
                    isCitiesClicked = false
                }
            } else if(response.data.type == 'city') {
                loadData('cities');
            }
        }

        $('#type').on('change', function() {
            let type = $(this).val();
            if(type != null){
                let label = $(this).find('option:selected').text();
                let url = `{{ route('wilayah.create', ['type' => ':type']) }}`.replace(':type', type);
                $.ajax({
                    type: 'GET',
                    url: url,
                    success: function(data) {
                        if(type == 'country') {
                            $('#parent-col').hide();
                        } else {
                            $('#parent-label').html(label);
                            $('#parent-col').show();
                            var options = data.map(function(item) {
                                return {
                                    id: item.id,
                                    text: item.name
                                };
                            });
                            options.unshift({
                                id: '',
                                text: 'Pilih ' + label
                            });
                            $('#parent-select').empty();
                            initSelect2('#parent-select', options);
                        }
                    }
                });
            }
        });

        const button1 = document.getElementById('provinces-tab');
        const button2 = document.getElementById('cities-tab');
        
        let isProvincesClicked = false;
        button1.addEventListener('click', () => {
            if (!isProvincesClicked) {
                isProvincesClicked = true;
                loadData('provinces');
            }
        });

        let isCitiesClicked = false;
        button2.addEventListener('click', () => {
            if (!isCitiesClicked) {
                isCitiesClicked = true;
                loadData('cities');
            }
        });
        

        function loadData(tab = null) {
            let columns = [
                { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                { data: 'name', name: 'name' }
            ];

            if(tab == 'provinces' || tab == 'cities') {
                columns.push({ data: 'parent', name: 'parent' });
            }

            columns.push({ data: 'aksi', name: 'aksi', orderable: false, searchable: false });

            $('#' + tab).DataTable({
                ajax: "{{ route('wilayah.show') }}?type=" + tab,
                scrollX: true,
                autoWidth: false,
                scrollCollapse: true,
                destroy: true,
                columns: columns
            });
        }

        function edit(e) {
            let id = $(e).data('id');
            let type = $(e).data('type');
            let url = `{{ route('wilayah.edit', ['id' => ':id']) }}`.replace(':id', id)+'?type='+type;
            let action = `{{ route('wilayah.update', ['id' => ':id']) }}`.replace(':id', id);
            $.ajax({
                type: 'GET',
                url: url,
                success: function(data) {
                    $('#modalTambahWilayah').find('.modal-title').html('Edit Wilayah');
                    $('#modalTambahWilayah').find('input[name="id"]').val(data.id);
                    $('#modalTambahWilayah').find('form').attr('action', action);
                    $('#type-col').hide();
                    $('#type').val(type).trigger('change');
                    $('#name').val(data.name);
                    if(type === 'country') {
                        $('#parent-col').hide();
                    }else{
                            let checkDataProcess = setInterval(checkData, 400);

                            function checkData() {
                            if (!$('#parent-select').val()) {
                                if (!$('#type').val()) {
                                    $('#type').val(type).trigger('change');
                                }else{
                                    $('#parent-select').val(data.parent).trigger('change');
                                }
                            }else{
                                clearInterval(checkDataProcess);
                            }
                        }
                    }
                    $('#modalTambahWilayah').modal('show');
                }
            });
        }

        $(".modal").on("hide.bs.modal", function() {
            $('#parent-col').hide();
            $('#parent-select').empty();
            $('#type').val('').trigger('change').prop('disabled', false);
            $('#type-col').show();
            $('#name').val('');
            $('#modalTambahWilayah').find('input[name="id"]').val('');
            $('#modalTambahWilayah').find('.modal-title').html('Tambah Wilayah');
            $('#modalTambahWilayah').find('form').attr('action', '{{ route("wilayah.store") }}');
        });
    </script>
@endsection
