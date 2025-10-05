<div class="modal-header">
    <h4 class="modal-title">@lang('modules.jobApplication.exp')</h4>
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
</div>
<div class="modal-body">
    <div class="table-responsive my-3">
        <table id="expTable" class="table table-bordered table-striped w-100">
            <thead>
            <tr>
                <th>#</th>
                <th>@lang('modules.front.expPeriodL')</th>
                <th>@lang('modules.front.expPlace')</th>
            </tr>
            </thead>
        </table>
    </div>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-sm btn-danger" data-dismiss="modal">
        <i class="fa fa-times"></i> @lang('app.close')
    </button>
</div>

<script>
    var expTable = $('#expTable').dataTable({
        responsive: true,
        processing: true,
        serverSide: true,
        destroy: true,
        ajax: "{!! route('admin.exp.data', ['_type' => $_type, '_id' => $_id]) !!}",
        language: languageOptions(),
        "fnDrawCallback": function (oSettings) {
            $("body").tooltip({
                selector: '[data-toggle="tooltip"]'
            });
        },
        order: [['1', 'ASC']],
        columns: [
            { data: 'DT_Row_Index', sortable:false, searchable: false },
            {data: 'period', name: 'period'},
            {data: 'company', name: 'company'}
        ]
    });
</script>