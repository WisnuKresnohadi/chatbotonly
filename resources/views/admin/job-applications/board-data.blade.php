@php
    $emptyData = true;
    foreach ($boardColumns as $key => $value) {
        # code...
        if ($value->applications->count() > 0){
            $emptyData = false;
        }
    }
@endphp
<div class="row">
    @foreach ($boardColumns as $key => $column)
        @foreach ($column->applications as $application)
            <div class="col-lg-4 col-md-6 col-sm-12">
                <div class="show-detail" data-widget="control-sidebar"
                    data-slide="true" data-row-id="{{ $application->id }}"
                    data-company-id="{{ $company_id }}" data-job-id="{{ $job_id }}"
                    data-application-id="{{ $application->id }}" data-sortable="true"
                    style="border-color: {{ $column->color }};cursor:pointer;">
                    <div class="card my-2" style="height: auto;">
                        <div class="card-body">
                            <div class="row mx-2">
                                <div class="content">
                                    <span class="profile-logo"><img src="{{ $application->user->profile_image_url }}"
                                            style="height: 50px;width: 50px;object-fit:cover"
                                            alt="user"></span>
                                    <h4 class="text-truncate mb-0" style="width: 200px;">
                                        {{ ucwords($application->user->name) }}</h4>
                                        <span>{{ $application->user->profile->headline }}</span>

                                </div>
                                <div class="ml-auto">
                                    <label class="badge"
                                        style="font-size: 15px; color: white; background: {{ ucwords($column->color) }};">{{ ucwords($column->status) }}</label>
                                </div>
                                <div class="my-1" style="display: flex; flex-direction: column;">
                                    <div class="d-flex my-2 flex-column">
                                        <div class="d-flex align-items-center">
                                            <i class="text-muted material-symbols-outlined">school</i>
                                            <span class="text-muted mx-2">
                                                @foreach ($jobApplication as $apps)
                                                    @if ($apps->id == $application->id)
                                                        {{ $apps->educations->first()->degree }} {{ $apps->educations->first()->study }}<br>{{ $apps->educations->first()->university }} ({{ $apps->educations->first()->end_date }})
                                                    @endif
                                                @endforeach
                                            </span>
                                        </div>
                                        <div class="d-flex align-items-center mt-1">
                                            <span style="font-weight:500;margin-left:3px" class="text-muted">Rp.</span>
                                            <span class="text-muted mx-2 nominal_salary">{{ $application->user->profile->information->expected_salary_value ?? ' -' }}</span>
                                        </div>
                                    </div>

                                    <div class="mt-2 w-100 d-flex align-content-center">
                                        <i class="text-muted material-symbols-outlined"
                                            style="font-size: 20px;">date_range</i>
                                        <span class="text-muted mx-2">
                                            @if (!is_null($application->schedule) && $column->id == 3)
                                                {{ $application->schedule->schedule_date->format('d M, Y') }}
                                            @else
                                                {{ $application->created_at->format('d M, Y') }}
                                            @endif
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    @endforeach
    @if ($emptyData == true)
        <div class="col-lg-12 col-md-12 col-sm-12">
            <div class="card my-2" style="height: auto;">
                <div class="card-body">
                    <div class="row mx-2">
                        <div class="col">
                            <h5 class="text-truncate mx-auto mb-0" style="width: 200px;">
                                No Data Result</h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>


<script>

    $(document).ready(function(){
        var nominal = document.getElementsByClassName('nominal_salary');

        for (let index = 0; index < nominal.length; index++) {
            if(nominal[index].innerHTML != ' -'){
                var changeNominal = formatRupiahBoardData(nominal[index].innerHTML);
                nominal[index].innerHTML = changeNominal;
            }
        }
    });

    /* Fungsi formatRupiah */
    function formatRupiahBoardData(angka){
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
        return rupiah ? rupiah : null;
    }

    // Send Reminder and notification to Candidate
    function sendReminder(id, type, status) {
        var msg;
        
        if (type == 'notify') {
            if (status == 'hired') {
                msg = "@lang('errors.sendHiredNotification')";
            } else {
                msg = "@lang('errors.sendRejectedNotification')";
            }
        } else {
            msg = "@lang('errors.sendInterviewReminder')";
        }
        swal({
            title: "@lang('errors.areYouSure')",
            text: msg,
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "@lang('app.yes')",
            cancelButtonText: "@lang('app.cancel')",
            closeOnConfirm: true,
            closeOnCancel: true
        }, function (isConfirm) {
            if (isConfirm) {

                var url = "{{ route('admin.interview-schedule.notify',[':id',':type']) }}";
                url = url.replace(':id', id);
                url = url.replace(':type', type);

                // update values for all tasks
                $.easyAjax({
                    url: url,
                    type: 'GET',
                    success: function (response) {
                    }
                });
            }
        });
    }

    $(function () {
        // Getting Data of all colomn and applications
        boardStracture = JSON.parse('{!! $boardStracture !!}');

        var oldParentId, currentParentId, oldElementIds = [], i = 1;

        let draggingTaskId = 0;
        let draggedTaskId = 0;
        let missingElementId = 0;
        let currentApplicationId = 0;

        $('.lobipanel').on('dragged.lobiPanel', function (e, lobiPanel) {
            var $parent = $(this).parent(),
                $children = $parent.children('.show-detail');
            var pr = $(this).closest('.board-column');

            if (draggingTaskId !== 0) {
                oldParentId = pr.data('column-id');
            }
            currentParentId = pr.data('column-id');

            var boardColumnIds = [];
            var applicationIds = [];
            var prioritys = [];

            $children.each(function (ind, el) {
                boardColumnIds.push($(el).closest('.board-column').data('column-id'));
                applicationIds.push($(el).data('application-id'));
                prioritys.push($(el).index());
            });

            if (draggingTaskId !== 0) {
                boardStracture[oldParentId] = [ ...applicationIds, currentApplicationId ];
            } 
            else {
                const result = boardStracture[oldParentId].filter(el => el !== currentApplicationId);
                boardStracture[oldParentId] = result;
                boardStracture[currentParentId] = applicationIds;
            }

            if (oldParentId == 3 && currentParentId == 4) {
                $('#buttonBox' + oldParentId + currentApplicationId).show();
                var button = '<button onclick="sendReminder(' + currentApplicationId + ', \'notify\')" type="button" class="btn btn-sm btn-info notify-button">@lang('app.notify')</button>';
                $('#buttonBox' + oldParentId + currentApplicationId).html(button);
                $('#buttonBox' + oldParentId + currentApplicationId).attr('id', 'buttonBox' + currentParentId + currentApplicationId);

            } else if (oldParentId == 4 && currentParentId == 3) {
                var timeStamp = $('#buttonBox' + oldParentId + currentApplicationId).data('timestamp');
                var currentDate = {{$currentDate}};
                if (currentDate < timeStamp) {
                    $('#buttonBox' + oldParentId + currentApplicationId).show();
                    var button = '<button onclick="sendReminder(' + currentApplicationId + ', \'reminder\')" type="button" class="btn btn-sm btn-info notify-button">@lang('app.reminder')</button>';
                    $('#buttonBox' + oldParentId + currentApplicationId).html(button);
                }
                $('#buttonBox' + oldParentId + currentApplicationId).attr('id', 'buttonBox' + currentParentId + currentApplicationId);
            } else {
                $('#buttonBox' + oldParentId + currentApplicationId).hide();
                $('#buttonBox' + oldParentId + currentApplicationId).attr('id', 'buttonBox' + currentParentId + currentApplicationId);
            }

            var startDate = $('#date-start').val();
            var jobs = $('#jobs').val();
            var search = $('#search').val();

            if (startDate == '') {
                startDate = null;
            }

            var endDate = $('#date-end').val();

            if (endDate == '') {
                endDate = null;
            }
            // update values for all tasks
            $.easyAjax({
                url: '{{ route("admin.job-applications.updateIndex") }}',
                type: 'POST',
                container: '.container-row',
                data: {
                    boardColumnIds: boardColumnIds,
                    applicationIds: applicationIds,
                    prioritys: prioritys,
                    startDate: startDate,
                    jobs: jobs,
                    search: search,
                    endDate: endDate,
                    draggingTaskId: draggingTaskId,
                    draggedTaskId: draggedTaskId,
                    '_token': '{{ csrf_token() }}'
                },
                success: function (response) {
                    if (draggedTaskId !== 0) {
                        $.each( response.columnCountByIds, function( key, value ) {
                            $('#columnCount_' + value.id).html((value.status_count));
                            $('#columnCount_' + value.id).parents('.board-column').find('.lobipanel').css('border-color', value.color);
                        });
                    }
                }
            });
            if (draggingTaskId !== 0) {
                draggedTaskId = draggingTaskId;
                draggingTaskId = 0;
            }
        }).lobiPanel({
            sortable: true,
            reload: false,
            editTitle: false,
            close: false,
            minimize: false,
            unpin: false,
            expand: false,
        });

        var isDragging = 0;
        $('.lobipanel-parent-sortable').on('sortactivate', function(){
            $('.board-column > .panel-body').css('overflow-y', 'unset');
            isDragging = 1;
        });
        $('.lobipanel-parent-sortable').on('sortstop', function(e){
            $('.board-column > .panel-body').css('overflow-y', 'auto');
            isDragging = 0;
        });
    })

    $('.show-detail').click(function (event) {
            if ($(event.target).hasClass('notify-button')) {
                return false;
            }
            var company_id = $(this).data('company-id');
            var job_id = $(this).data('job-id');
            var application_id = $(this).data('application-id');
            draggingTaskId = currentApplicationId = application_id;

            // if (isDragging == 0) {
                var url = "{{ route('admin.company.job-applications.show', [':company_id', ':job_id', ':application_id']) }}";

                url = url.replace(':company_id', company_id);
                url = url.replace(':job_id', job_id);
                url = url.replace(':application_id', application_id);

                $.ajax({
                    type: 'GET',
                    url: url,
                    success: function (response) {
                        if (response.status == "success") {
                            $('#right-sidebar-content').html(response.view);
                        }
                    }
                });
            // }
        })

</script>