@extends('layouts.app')

@push('head-script')
    <link rel="stylesheet" href="{{ asset('assets/plugins/jQueryUI/jquery-ui.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/lobipanel/dist/css/lobipanel.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/node_modules/bootstrap-datepicker/bootstrap-datepicker.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/node_modules/multiselect/css/multi-select.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/jquery-bar-rating-master/dist/themes/fontawesome-stars.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/node_modules/bootstrap-material-datetimepicker/css/bootstrap-material-datetimepicker.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/colorpicker/bootstrap-colorpicker.min.css') }}">

    <style>
        .board-column{
            /* max-width: 21%; */
        }

        .board-column .card{
            box-shadow: none;
        }
        .notify-button{
            /*width: 9em;*/
            height: 1.5em;
            font-size: 0.730rem !important;
            line-height: 0.5 !important;
        }
        .panel-scroll{
            height: calc(100vh - 330px); overflow-y: scroll
        }
        .mb-20{
            margin-bottom: 20px
        }
        .datepicker{
            z-index: 9999 !important;
        }
        .d-block{
            display: block;
        }
        .upcomingdata {
            height: 37.5rem;
            overflow-x: scroll;
        }
        .notify-button{
            height: 1.5em;
            font-size: 0.730rem !important;
            line-height: 0.5 !important;
        }
        .scheduleul
        {
            padding: 0 15px 0 11px;
        }
        .searchInput
        {
            width: 50%; display: inline
        }
        .searchButton
        {
            margin-bottom: 4px;margin-left: 3px;
        }
    </style>
@endpush

@section('content')

    <div class="row mb-2">
        <div class="col-sm-6">
            <a href="javascript:;" id="toggle-filter" class="btn btn-outline btn-success btn-sm toggle-filter">
                <i class="fa fa-sliders"></i> @lang('app.filterResults')
            </a>
            <a href="{{ route('admin.job-applications.table') }}" class="btn btn-sm btn-primary">
                <i class="fa fa-table"></i> @lang('app.tableView')
            </a>
            <a href="{{ route('admin.application-setting.index').'#mail-setting' }}" class="btn btn-sm btn-info">
                <i class="fa fa-envelope-o"></i>
                @lang('modules.applicationSetting.mailSettings')
            </a>
            <a href="javascript:createApplicationStatus();" class="btn btn-sm btn-success">
                <i class="fa fa-bookmark-o"></i>
                @lang('modules.jobApplication.newStatus')
            </a>
        </div>
        <div class="col-sm-6">
            <div id="search-container" class="form-group pull-right">
                <input id="search" class="form-control" type="text" name="search" placeholder="@lang('modules.jobApplication.enterName')">
                <a href="javascript:;" class="d-none">
                    <i class="fa fa-times-circle-o"></i>
                </a>
            </div>
        </div>
    </div>

    <div class="container-scroll">
        <div class="card" id="ticket-filters">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">
                        <h4>@lang('app.filterBy')
                            <a href="javascript:;" class="pull-right mt-2 mr-2 toggle-filter">
                                <i class="fa fa-times-circle-o"></i>
                            </a>
                        </h4>
                    </div>
                    <div class="col-md-4">
                        <h5>@lang('app.dateApp')
                        </h5>
                    </div>
                    <div class="col-md-4">
                        <h5>@lang('app.jobPosApp')
                        </h5>
                    </div>
                    <div class="col-md-4">
                        <h5>@lang('app.gradYearApp')
                        </h5>
                    </div>
                    {{--
                    <div class="col-md-3">
                        <h5>@lang('app.gpaApp')
                        </h5>
                    </div>
                    --}}
                    <div class="col-md-4">
                        <div class="form-group">
                            <div class="input-daterange input-group">
                                <input type="text" class="form-control" id="date-start" value="{{ $startDate }}" name="start_date">
                                <span class="input-group-addon bg-info b-0 text-white p-1">@lang('app.to')</span>
                                <input type="text" class="form-control" id="date-end" name="end_date" value="{{ $endDate }}">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <select class="select2" name="jobs" id="jobs" data-style="form-control">
                                <option value="all">@lang('modules.jobApplication.allJobs')</option>
                                @forelse($jobs as $job)
                                    <option title="{{ucfirst($job->title)}}" value="{{$job->id}}">{{ucfirst($job->title)}}</option>
                                @empty
                                @endforelse
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group ">
                            <div class="input-group">
                                <input type="number" id="year-start" class="form-control" name="start_year" placeholder="grad. year" />
                                <span class="input-group-addon bg-info b-0 text-white p-1">@lang('app.to')</span>
                                <input type="number" id="year-end" class="form-control" name="end_year" placeholder="grad. year" />
                            </div>
                        </div>
                    </div>
                    {{--
                    <div class="col-md-3">
                        <div class="form-group">
                            <div class="input-group">
                                <input type="number" min="0" max="4" step="0.01" class="form-control" id="gpa-start" name="start_gpa" placeholder="GPA" />
                                <span class="input-group-addon bg-info b-0 text-white p-1">@lang('app.to')</span>
                                <input type="number" min="0" max="4" step="0.01" class="form-control" id="gpa-end" name="end_gpa" placeholder="GPA" />
                            </div>
                        </div>
                    </div>
                    --}}
                    <div class="col-md-12">
                        <div class="form-group">
                            <button type="button" id="apply-filters" class="btn btn-success btn-sm"><i class="fa fa-check"></i> @lang('app.apply')</button>
                            <button type="button" id="reset-filters" class="btn btn-info btn-sm"><i class="fa fa-refresh"></i> @lang('app.reset')</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row container-row">
        </div>
    </div>

    {{--Ajax Modal Start for--}}
    <div class="modal fade bs-modal-md in" id="scheduleDetailModal" role="dialog" aria-labelledby="myModalLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-lg" id="modal-data-application">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                    <span class="caption-subject font-red-sunglo bold uppercase" id="modelHeading"></span>
                </div>
                <div class="modal-body">
                    Loading...
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn default" data-dismiss="modal">Close</button>
                    <button type="button" class="btn blue">Save changes</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    {{--Ajax Modal Ends--}}
@endsection

@push('footer-script')
    <script src="{{ asset('assets/plugins/jQueryUI/jquery-ui.min.js') }}"></script>
    <script src="{{ asset('assets/lobipanel/dist/js/lobipanel.min.js') }}"></script>
    <script src="{{ asset('assets/node_modules/moment/moment.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/node_modules/multiselect/js/jquery.multi-select.js') }}"></script>
    <script src="{{ asset('assets/node_modules/bootstrap-datepicker/bootstrap-datepicker.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/node_modules/select2/dist/js/select2.full.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/node_modules/bootstrap-select/bootstrap-select.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/plugins/jquery-bar-rating-master/dist/jquery.barrating.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/node_modules/bootstrap-material-datetimepicker/js/bootstrap-material-datetimepicker.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/plugins/colorpicker/bootstrap-colorpicker.min.js') }}"></script>
    {{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script> --}}
    <script src="{{ asset('assets/plugins/yearpicker/yearpicker.js') }}" async></script>
    <script>
        $(".select2").select2({
            width: '100%'
        });
        loadData();

        $('#apply-filters').click(function () {
            loadData();
        });

        $('#reset-filters').click(function () {
            $('#date-start').val('{{ $startDate }}');
            $('#date-end').val('{{ $endDate }}');
            $('#jobs').val('all').trigger('change');

            loadData();
        })
        $('#applySearch').click(function () {
            var search = $('#search').val();
            if(search !== undefined && search !== null && search !== ""){
                loadData();
            }
        })

        $('#date-end').bootstrapMaterialDatePicker({ weekStart : 0, time: false });
        $('#date-start').bootstrapMaterialDatePicker({ weekStart : 0, time: false }).on('change', function(e, year)
        {
            $('#date-end').bootstrapMaterialDatePicker('setMinDate', date);
        });

        // $('#year-end').bootstrapMaterialDatePicker({ weekStart : 0, time: false, year: true, date: false });
        // $('#year-start').bootstrapMaterialDatePicker({ weekStart : 0, time: false, year: true, date: false }).on('yearSelected', function(e, year)
        // {
        //     $('#year-end').bootstrapMaterialDatePicker('setMinDate', year);
        // });
        
        // $('#year-end').bootstrapMaterialDatePicker({ weekStart : 0, date: false, time: false, year: true });
        // $('#year-start').bootstrapMaterialDatePicker({format: "yyyy",viewMode: "months",minViewMode: "months"}).on('change', function(e, date)
        // {
        // $('#year-end').bootstrapMaterialDatePicker('setMinDate', date);
        // });
        $("#year-start").datepicker( {
        format: "yyyy",
        viewMode: "years", 
        minViewMode: "years"
        });
        $("#year-end").datepicker( {
        format: "yyyy",
        viewMode: "years", 
        minViewMode: "years"
        });
        // Schedule create modal view
        function createSchedule (id) {
            var url = "{{ route('admin.job-applications.create-schedule',':id') }}";
            url = url.replace(':id', id);
            $('#modelHeading').html('Schedule');
            $.ajaxModal('#scheduleDetailModal', url);
        }

        // Create application status modal view
        function createApplicationStatus () {
            var url = "{{ route('admin.application-status.create') }}";

            $('#modelHeading').html('Application Status');
            $.ajaxModal('#scheduleDetailModal', url);
        }

        function deleteStatus(id) {
            const panels = $('.board-column[data-column-id="' + id + '"').find('.lobipanel.show-detail');
            let applicationIds = [];
            panels.each((ind, element) => {
                applicationIds.push($(element).data('application-id'));
            });

            swal({
                title: "@lang('errors.areYouSure')",
                text: "@lang('errors.deleteStatusWarning')",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "@lang('app.delete')",
                cancelButtonText: "@lang('app.cancel')",
                closeOnConfirm: true,
                closeOnCancel: true
            }, function(isConfirm){
                if (isConfirm) {
                    let url = "{{ route('admin.application-status.destroy', ':id') }}";
                    url = url.replace(':id', id);

                    let data = {
                        _token: '{{ csrf_token() }}',
                        _method: 'DELETE',
                        applicationIds: applicationIds
                    }

                    $.easyAjax({
                        url,
                        data,
                        type: 'POST',
                        container: '.container-row',
                        success: function (response) {
                            if (response.status == 'success') {
                                loadData();
                            }
                        }
                    })
                }
            });
        }

        function editStatus(id) {
            var url = "{{ route('admin.application-status.edit', ':id') }}";
            url = url.replace(':id', id);

            $('#modelHeading').html('Application Status');
            $.ajaxModal('#scheduleDetailModal', url);
        }

        function saveStatus() {
            $.easyAjax({
                url: "{{ route('admin.application-status.store') }}",
                container: '#createStatus',
                type: "POST",
                data: $('#createStatus').serialize(),
                success: function (response) {
                    $('#scheduleDetailModal').modal('hide');
                    loadData();
                }
            });
        }

        function updateStatus(id) {
            let url = "{{ route('admin.application-status.update', ':id') }}";
            url = url.replace(':id', id);

            $.easyAjax({
                url: url,
                container: '#updateStatus',
                type: "POST",
                data: $('#updateStatus').serialize(),
                success: function (response) {
                    $('#scheduleDetailModal').modal('hide');
                    loadData();
                }
            });
        }

        function loadData () {
            var startDate = $('#date-start').val();
            var jobs = $('#jobs').val();
            var search = $('#search').val();
            var startYear = $('#year-start').val();
            var endYear = $('#year-end').val();
            var startGpa = '';
            var endGpa = '';

            if (startDate == '') {
                startDate = null;
            }

            var endDate = $('#date-end').val();

            if (endDate == '') {
                endDate = null;
            }

            var url = '{{route('admin.job-applications.index')}}?startDate=' + startDate + '&endDate=' + endDate + '&jobs=' + jobs + '&search=' + search + '&startYear=' + startYear + '&endYear=' + endYear + '&startGpa=' + startGpa + '&endGpa=' + endGpa;

            $.easyAjax({
                url: url,
                container: '.container-row',
                type: "GET",
                success: function (response) {
                    $('.container-row').html(response.view);
                }

            })
        }

        search($('#search'), 500, 'data');

        $('.toggle-filter').click(function () {
            $('#ticket-filters').toggle('slide');
        });
        $(function() {  
        $('.yearpicker').yearpicker();
            // year : 2021,
            // startYear : 2010,
            // endyear : 2040,
        });
        // $(function() {
        //     $('.yearpicker').datepicker( {
        //     changeMonth: true,
        //     changeYear: true,
        //     showButtonPanel: true,
        //     dateFormat: 'MM yy',
        //     onClose: function(dateText, inst) { 
        //         $(this).datepicker('setDate', new Date(inst.selectedYear, inst.selectedMonth, 1));
        //     }
        //     });
        // });
    </script>
@endpush