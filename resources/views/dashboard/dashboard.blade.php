<!doctype html>
<html lang="en">
@include('layouts.main')

<body>
<div class="container page-dashboard">
    <div class="table-title">
        <div class="title-sub">
            <h2><b>Submission</b></h2>
        </div>
        <div class="col-right">
            <div class="add-sub">
                <a href="{!! route('dashboard') !!}" class="btn btn-success add" data-toggle="modal">Dashboard</a>
            </div>
            <div class="export-sub">
                <a href="{!! route('index') !!}" class="btn btn-success add" data-toggle="modal" target = "blank">Submission</a>
            </div>
            
            <div class="export-sub">
                <a href="{!! route('first_model') !!}" class="btn btn-success add" data-toggle="modal" target = "blank">First Model</a>
            </div>
            <div class="user-logout">
                <a href="{!! route('logout') !!}" class="btn btn-default">Logout</a>
            </div>
            <div class="user-title">
                <span class="title">Chao: {!! isset($user_name) ? $user_name :'' !!}</span>
            </div>
        </div>
    </div>
    <div class="table-wrapper">
        <div class="container hightchart">
            <div class="row">
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="start_date">Start date</label>
                        <input type="date" id="start_date" name="start_date" class="form-control">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="end_date">End date</label>
                        <input type="date" id="end_date" name="end_date" class="form-control">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="reviewer">Reviewer</label>
                        <select class="form-control" name="reviewer" id="reviewer">
                            <option value=""></option>
                            @foreach($reviewer as $key => $value)
                                <option value="{!! $key !!}">{!! $value !!}</option>
                            @endforeach
                    </select>
                    </div>
                </div>
                <div class="col-md-3 search-fillter">
                    <input type="button" id="btn-submit" class="btn btn-success" value="Search">
                </div>
            </div>
            <div class="col-md-12" id="chart" >
                <div id="chart_year" style="width:50%; height:auto; display: none;"></div>
                <div id="chart_week" style="width:45%; height:auto; display: none"></div>
                <div id="chart_month" style="width:45%; height:auto; display: none;"></div>
                <div class="table-wrapper" id="table_submission" style="display: none;">
                    <table class="table table-striped table-hover">
                        <thead>
                        <tr>
                            <th>First model</th>
                            <th>Submission ID</th>
                            <th>Fingerprint</th>
                            <th>Approval type</th>
                            <th>SVMC review status</th>
                            <th>SVMC comment</th>
                        </tr>
                        </thead>
                        <tbody id="data_submission">
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

</body>
</html>
<script>
    $(document).ready(function(){
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        let regularOfWeek = [];
        let normalOfWeek = [];
        let smrOfWeek = [];
        let week = [];

        let month = [];
        let regularOfMonth = [];
        let normalOfMonth = [];
        let smrOfMonth = [];

        let year = [];
        let regularOfYear = [];
        let normalOfYear = [];
        let smrOfYear = [];

        var urlYear = '/dashboard/getDataYear';
        $.ajax({
            type: 'POST',
            data:{

            },
            url: urlYear,
            success: function (data) {
                regularOfYear = data.regular_year_Y;
                normalOfYear = data.normal_year_Y;
                smrOfYear = data.smr_year_Y;
                year = data.year_X;

                $('#chart_year').css({'display':'block'});

                var chartYear = Highcharts.chart('chart_year', {
                    chart: {
                        type: 'column'
                    },
                    title: {
                        text: 'Submission of YEAR'
                    },
                    xAxis: {
                        categories: year
                    },
                    yAxis: {
                        title: {
                            text: 'Count'
                        }
                    },
                    series: [{
                        name: 'Regular',
                        data: regularOfYear
                    }, {
                        name: 'Normal',
                        data: normalOfYear
                    }, {
                        name: 'SMR',
                        data: smrOfYear
                    }]
                });
            }
        });


        $("#btn-submit").click(function (e) {
            e.preventDefault();
            var start_date = $("input[name=start_date]").val();
            var end_date = $("input[name=end_date]").val();
            var reviewer = $("select[name=reviewer]").val();

            if (start_date != '' && end_date != '') {
                var url = '/dashboard';
                $.ajax({
                    type: 'POST',
                    url: url,
                    data: {
                        start_date: start_date,
                        end_date: end_date,
                        reviewer: reviewer
                    },
                    success: function (data) {
                        regularOfWeek = data.regular_week_Y;
                        normalOfWeek = data.normal_week_Y;
                        smrOfWeek = data.smr_week_Y;

                        week = data.week_X;
                        regularOfMonth = data.regular_month_Y;
                        normalOfMonth = data.normal_month_Y;
                        smrOfMonth = data.smr_month_Y;
                        month = data.month_X;

                        $('#chart_week').css({'display':'inline-block'});
                        $('#chart_month').css({'display':'inline-block'});

                        if (data.data.length > 0) {
                            $('#table_submission').css({'display':'block'});
                            $('#data_submission').html('');
                            $.each(data.data, function(index, item) {
                                $('#data_submission').append('<tr><td>'+item.first_model+'</td><td>'+item.submission_id+'</td><td>'+item.ap_version+'</td><td>'+item.approval_type+'</td><td>'+item.svmc_review_status+'</td><td>'+item.svmc_comment+'</td></tr>')
                            });
                        }

                        var chart = Highcharts.chart('chart_week', {
                            chart: {
                                type: 'column'
                            },
                            title: {
                                text: 'Submission of WEEK'
                            },
                            xAxis: {
                                categories: week
                            },
                            yAxis: {
                                title: {
                                    text: ''
                                }
                            },
                            series: [{
                                name: 'Regular',
                                data: regularOfWeek
                            }, {
                                name: 'Normal',
                                data: normalOfWeek
                            }, {
                                name: 'SMR',
                                data: smrOfWeek
                            }]
                        });
                        var chartMonth = Highcharts.chart('chart_month', {
                            chart: {
                                type: 'column'
                            },
                            title: {
                                text: 'Submission of MONTH'
                            },
                            xAxis: {
                                categories: month
                            },
                            yAxis: {
                                title: {
                                    text: ''
                                }
                            },
                            series: [{
                                name: 'Regular',
                                data: regularOfMonth
                            }, {
                                name: 'Normal',
                                data: normalOfMonth
                            }, {
                                name: 'SMR',
                                data: smrOfMonth
                            }]
                        });
                    }
                });
            }
        });

    });

</script>