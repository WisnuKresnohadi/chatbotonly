@extends('layouts.front_layout')
<!-- Banner Section-->
@section('content-main')
<style>
    .info-box {
        display: flex!important;
        margin-bottom: 1rem!important;
        min-height: 80px;
        border-radius: 0.25rem;
    }

    .info-box-icon {
        align-items: center!important;
        display: flex!important;
        justify-content: center!important;
    }

    .info-box-content {
        padding-top: 0!important;
        padding: 0px 12px 0px 12px !important;
        flex: 1;
        display: flex;
        flex-direction: column;
        align-content: center;
        align-self: center;
    }

    .info-box-text {
        display: block;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .info-box-number {
        display: block;
        font-weight: 700;
    }

    .info-box-custom {
        box-shadow: none;
        padding: 8px 0px 8px 0px !important;
    }
    
    .info-box-custom .info-box-header {
        display: flex; align-items: center; justify-content: center; flex-direction: column;
    }

    .info-box-custom .info-box-header .info-box-icon {
        border-radius: 100%; text-align: center; width: 48px; height: 48px;
    }

    .info-box-custom .info-box-content {
        padding-top: 0!important;
    }

    .info-box-custom .info-box-header a {
        display: flex; align-items: center; justify-content: center;
    }

    .content {
        position: relative;
        padding-left: 68px;
        min-height: 51px;
    }

    .company-logo {
        position: absolute;
        left: 0;
        top: 0;
        width: 50px;
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

    .job-info {
        position: relative;
        display: flex;
        flex-wrap: wrap;
        margin-bottom: 10px;
    }

    .company-logo {
        position: absolute;
        left: 0;
        top: 0;
        width: 50px;
        -o-transition: all 300ms ease;
        transition: all 300ms ease;
    }
</style>

<title>My Applications</title>
<span class="header-span"></span>

<!--CheckOut Page-->
<section class="py-4">
    <div class="my-4 mx-5">
        <div class="col-12">
        <h4 class="title text-primary">My Applications</h4>
            <div class="card-body mt-4">
                <div class="row d-flex align-content-center">
                    <div class="d-flex align-content-center">
                        <label class="card-title col-12" style="font-weight: 600; font-size: 18px;">
                            @lang('modules.dashboard.statistics')
                        </label>
                    </div>
                    <div class="ml-auto d-flex justify-content-end">
                        <div class="form-group col-6">
                            <input type="number" name="filter_year" min="1900" class="filterYear form-control" placeholder="Filter">
                        </div>
                    </div>
                </div>
                <div class="statistics-div mt-3 mb-5"></div>
                <div class="row d-flex align-content-center">
                    <div class="d-flex align-content-center">
                        <label class="card-title col-12" style="font-weight: 600; font-size: 18px;">
                            Applications
                        </label>
                    </div>
                    <div class="ml-auto d-flex justify-content-end">
                        <div class="form-group col-12">
                            <select name="filter_status" onchange="filterStatus();" class="filterStatus form-control" data-width="100%">
                                <option value="" selected>all</option>
                                @foreach ($status as $value)
                                    <option value="{{ $value->id }}">{{ $value->status }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="data-div my-3"></div>
            </div>
        </div>
    </div>
</section>
<!--End CheckOut Page-->
<script src="{{ asset('front/assets/landing/js/jquery.js') }}"></script> 
<script type="text/javascript">
    $(document).ready(function (e) {
        loadData();
    });
</script>
<script src="{{ asset('assets/plugins/datepicker/bootstrap-datepicker.js') }}"></script>
<script>
    $(".filterYear").datepicker({
        format: "yyyy",
        viewMode: "years", 
        minViewMode: "years",
        autoclose : true
    }).on("change", function(e) {
        loadData();
    });
    $(".filterYear").datepicker("setDate", new Date);

    $(".filterStatus").on("change", function(e) {
        loadData();
    });

    function filterStatus()
    {
        loadData();
    }

    loadData();

    function loadData () {
        var filter_year = $('.filterYear').val();
        var filter_status = $('.filterStatus').val();
        var url = '{{route("application.index")}}?filter_year=' + filter_year + '&filter_status=' + filter_status;

        $.easyAjax({
            url: url,
            container: '.data-div',
            type: "GET",
            success: function (response) {
                $('.statistics-div').html(response.statisticsView);
                $('.data-div').html(response.dataView);
            }

        })
    }
</script>

@endsection