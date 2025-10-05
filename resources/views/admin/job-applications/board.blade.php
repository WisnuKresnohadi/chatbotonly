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

        
        .content {
            position: relative;
            padding-left: 68px;
            min-height: 51px;
        }

        .profile-logo {
            position: absolute;
            left: 0;
            top: 0;
            width: 50px;
            height: 50px;
            -webkit-transition: all 300ms ease;
            -o-transition: all 300ms ease;
            transition: all 300ms ease;
        }

        .content h4 {
            font-size: 18px;
            color: #202124;
            font-weight: 500;
            line-height: 26px;
            top: -3px;
            margin-bottom: 3px;
        }
    </style>
@endpush

@section('content')
@if(request()->segment(2) == 'company')
@php
$company = App\Company::find(request()->segment(3));
$job = App\Job::find(request()->segment(4));
@endphp
<section class="content-header">
    <div class="container-fluid">

        <div class="row mb-2 d-flex align-items-center">
            <div class="col-md-5">
                <h1 class="mb-xs-2">{{ $job->title."'s ".$pageTitle }}</h1>
            </div>
            <div class="col-md-7">
                <span class="float-sm-right">@yield('create-button')</span>
                <ol class="breadcrumb float-sm-right mr-2 mt-xs-2">
                    <li class="breadcrumb-item"><a href="{{ route('admin.company.index') }}"><i class="icon-home text-primary"></i></a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.company.index') }}/{{ request()->segment(3) }}">{{ $company->company_name }}</a></li>
                    <li class="breadcrumb-item active">{{ $job->title }}'s {{ $pageTitle }}</li>
                </ol>
            </div>
        </div>
    </div><!-- /.container-fluid -->
</section>
@endif
    <div class="row d-flex align-content-center mx-1">
        <div class="d-flex align-content-center">
            <label class="card-title col-12" style="font-weight: 600; font-size: 18px;">
                Applications
            </label>
        </div>
        <div class="ml-auto d-flex justify-content-end">
            <div class="form-group col-12">
                <select name="filter_status" onchange="filterStatus();" class="filterStatus form-control" data-width="100%">
                    <option value selected>all</option>
                    @foreach ($boardColumns as $value)
                        <option value="{{ $value->id }}">{{ $value->status }}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>

    <div class="row mx-1">
        <div class="col-sm-6">
            <a href="javascript:;" id="toggle-filter" class="btn btn-outline btn-success btn-sm toggle-filter">
                <i class="fa fa-sliders"></i> @lang('app.filterResults')
            </a>
            {{-- <a href="{{ route('admin.company.job-applications').'/'.$company_id.'/'.$job_id.'/table' }}" class="btn btn-outline btn-primary btn-sm">
                <i class="fa fa-table"></i> @lang('app.tableView')
            </a>
            <a href="{{ route('admin.application-setting.index').'#mail-setting' }}" class="btn btn-sm btn-info">
                <i class="fa fa-envelope-o"></i>
                @lang('modules.applicationSetting.mailSettings')
            </a>
            <a href="javascript:createApplicationStatus();" class="btn btn-sm btn-success">
                <i class="fa fa-bookmark-o"></i>
                @lang('modules.jobApplication.newStatus')
            </a> --}}
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
        {{-- <div class="card" style="display: none; background: #fbfbfb;" id="ticket-filters">
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
                        <div class="col-md-3">
                            <h5>@lang('app.gpaApp')
                            </h5>
                        </div>
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
                        <div class="col-md-3">
                            <div class="form-group">
                                <div class="input-group">
                                    <input type="number" min="0" max="4" step="0.01" class="form-control" id="gpa-start" name="start_gpa" placeholder="GPA" />
                                    <span class="input-group-addon bg-info b-0 text-white p-1">@lang('app.to')</span>
                                    <input type="number" min="0" max="4" step="0.01" class="form-control" id="gpa-end" name="end_gpa" placeholder="GPA" />
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <button type="button" id="apply-filters" class="btn btn-success btn-sm"><i class="fa fa-check"></i> @lang('app.apply')</button>
                                <button type="button" id="reset-filters" class="btn btn-info btn-sm"><i class="fa fa-refresh"></i> @lang('app.reset')</button>
                            </div>
                        </div>
                </div>
            </div>
        </div> --}}

        <div class="card" style="display: none; background: #fbfbfb;margin-left:0.560rem;margin-right:0.560rem;" id="ticket-filters">
            <div class="card-body">
                <div class="row">
                    {{-- <div class="col-md-12">
                        <h4>@lang('app.dateApp')
                            <a href="javascript:;" class="pull-right mt-2 mr-2 toggle-filter">
                                <i class="fa fa-times-circle-o"></i>
                            </a>
                        </h4>
                    </div> --}}
                    <div class="col-md-12 mt-1 mb-3">
                        <div class="row">
                            <div class="col-auto">
                                <h3 style="font-weight: 600;" class="text-dark">Filter By</h3>
                            </div>
                            <div class="col-auto my-auto ml-5">
                                <a href="javascript:;" class="toggle-filter">
                                    <i style="font-size:25px" class="material-symbols-outlined text-dark font-weight-bold">
                                        expand_less
                                    </i>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 my-2">
                        <label for="filter_area">Area</label>
                        <select name="filter_area" id="filter_area" class="filterAreas form-control" data-width="100%" onchange="loadData();">
                            <option value selected>All Area</option>
                            @foreach ($areas as $area)
                                <option value="{{ $area->location }}">{{ $area->location }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4 my-2">
                        <label for="filter_industri">Industry</label>
                        <select name="filter_industri" id="filter_industri" class="filterIndustri form-control" data-width="100%" onchange="loadData();">
                            <option value selected>All Industry</option>
                            @foreach ($industries as $industry)
                                <option value="{{$industry->id}}">{{$industry->name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4 my-2">
                        <label for="filter_experience">Experience Status</label>
                        <select name="filter_experience" id="filter_experience" class="filterExperience form-control" data-width="100%" onchange="loadData();">
                            <option value selected>All Experience Status</option>
                            <option value="unexperienced">Unexperienced</option>
                            <option value="experienced">Experienced</option>
                        </select>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 my-2">
                        <label for="language">Language</label>
                        <select name="language[]" id="language" class="filterLanguage form-control select2" data-width="100%" multiple="multiple" onchange="loadData();">
                            @foreach ($language_names as $language)
                                <option value="{{ $language['name'] }}">{{ ucfirst($language['name']) }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6 my-2">
                        <div class="row">
                            <div class="col">
                                <label for="">Salary Range</label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <input type="text" style="padding-top: 8px;padding-bottom:8px;" class="form-control filterMinSalary" id="min_salary" name="min_salary" placeholder="Min Salary" />
                            </div>
                            <div class="col">
                                <input type="text" style="padding-top: 8px;padding-bottom:8px;" class="form-control filterMaxSalary" id="max_salary" name="max_salary" placeholder="Max Salary" />
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-6 my-2">
                        <label for="filter_degree">Education Level</label>
                        <select name="filter_degree" id="filter_degree" class="filterDegree form-control" data-width="100%" onchange="loadData();">
                            <option value selected>All Education Level</option>
                            <option value="S3">S3</option>
                            <option value="S2">S2</option>
                            <option value="S1/D4">S1/D4</option>
                            <option value="D3">D3</option>
                            <option value="D2">D2</option>
                            <option value="D1">D1</option>
                            <option value="SMA/SMK">SMA/SMK</option>
                        </select>
                    </div>
                    <div class="col-md-6 my-2">
                        <div class="row">
                            <div class="col-12">
                                <label for="filterMajor">Major</label>
                                <select class="filterMajor form-control select2" name="major[]" id="major" multiple="multiple" onchange="loadData();">
                                    @foreach ($majors as $major)
                                        <option value="{{ $major->major }}">{{ $major->major }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <label for="filterSkill">Skill</label>
                        <select class="filterSkill form-control select2" name="skill[]" id="skill" multiple="multiple" onchange="loadData();">
                            @foreach ($skills as $skill)
                                <option value="{{ $skill->id }}">{{ $skill->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="row container-row px-3 pb-3"></div>
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

        var min_salary = document.getElementById('min_salary');
        var max_salary = document.getElementById('max_salary');
		min_salary.addEventListener('keyup', function(e){
			min_salary.value = formatRupiah(this.value);
            loadData();
            console.log(min_salary.value);
		});
        max_salary.addEventListener('keyup', function(e){
			max_salary.value = formatRupiah(this.value);
            loadData();
		});
 
		/* Fungsi formatRupiah */
		function formatRupiah(angka){
			var number_string = angka.replace(/[^,\d]/g, '').toString(),
			split   		= number_string.split(','),
			sisa     		= split[0].length % 3,
			rupiah     		= split[0].substr(0, sisa),
			ribuan     		= split[0].substr(sisa).match(/\d{3}/gi);
 
			// tambahkan titik jika yang di input sudah menjadi angka ribuan
			if(ribuan){
				separator = sisa ? '.' : '';
				rupiah += separator + ribuan.join('.');
			}
 
			rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
			return rupiah ? 'Rp. ' + rupiah : null;
		}

        $(".select2").select2({
            width: '100%'
        });
        loadData();

        function filterStatus()
        {
            loadData();
        }

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
            var search = $('#search').val();
            var filter_status = $('.filterStatus').val();
            var filter_industri = $('.filterIndustri').val();
            var filter_degree = $('.filterDegree').val();
            var filter_language = $('.filterLanguage').val();
            var filter_min_salary = $('.filterMinSalary').val();
            var filter_max_salary = $('.filterMaxSalary').val();
            var filter_experience = $('.filterExperience').val();
            var filter_skill = $('.filterSkill').val();
            var filter_major = $('.filterMajor').val();
            var filter_areas = $('.filterAreas').val();

            // normalisasi salary 
            filter_min_salary = filter_min_salary.replace(/[^0-9]/g, '');
            filter_max_salary = filter_max_salary.replace(/[^0-9]/g, '');

            var url = "{{route('admin.company.job-applications', [$company_id, $job_id])}}?search=" + search + '&filter_status=' + filter_status + '&filter_degree=' + filter_degree + '&filter_industri=' + filter_industri + '&filter_language=' + filter_language + '&filter_min_salary=' + filter_min_salary + '&filter_max_salary=' + filter_max_salary + '&filter_experience=' + filter_experience + '&filter_skill=' + filter_skill + '&filter_major=' + filter_major + '&filter_areas=' + filter_areas;

            $.ajax({
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
