<!doctype html>
<html lang="en">
@include('layouts.main')

<body>
<div class="container">
    <font><marquee class ="hidden happy" direction="left" style="background:orange">Happy Birthday Ms Oanh xinh dep</marquee></font>
    <div class="table-title">
        <div class="title-sub">
            <h2><b><a href ="/" class = "back-to-index">Submission </a></b></h2>
        </div>
        <div class="col-right">
            <div class="add-sub">
                <a href="{!! route('dashboard') !!}" class="btn btn-success add" data-toggle="modal" target="blank">Dashboard</a>
            </div>
            <div class="export-sub">
                <a href="{!! route('first_model') !!}" class="btn btn-success add" data-toggle="modal" target = "blank">First Model</a>
            </div>
            <div class="add-sub">
                <a href="#addSubmission" class="btn btn-success add" data-toggle="modal">Add submission</a>
            </div>
            <div class="dropdown export-sub">
                <button class="btn btn-warning dropdown-toggle" type="button" data-toggle="dropdown">Export
                    <span class="caret"></span></button>
                <ul class="dropdown-menu">
                    <li><a href="{!! route('exportExcel','w') !!}">1 week</a></li>
                    <li><a href="{!! route('exportExcel', 'm') !!}">1 month</a></li>
                    <li><a href="{!! route('exportExcel', 'y') !!}">1 year</a></li>
                </ul>
            </div>
            <div class="import-sub">
                <button type="button" data-toggle="modal" data-target="#myModal" class="export btn btn-primary">Import
                </button>
            </div>
            <div class="dropdown show-sub">
                <button class="btn btn-info dropdown-toggle" type="button" data-toggle="dropdown">Show
                    <span class="caret"></span></button>
                <ul class="dropdown-menu">
                    <li><a href="{!! route('index',['total'=>10]) !!}">10</a></li>
                    <li><a href="{!! route('index',['total'=>30]) !!}">30</a></li>
                    <li><a href="{!! route('index',['total'=>100]) !!}">100</a></li>
                </ul>
            </div>
            <div class="user-logout">
                <a href="{!! route('logout') !!}" class="btn btn-default">Logout</a>
            </div>
            <div class="user-title">
                <span class="title">Chao: {!! isset($user_name) ? $user_name :'' !!}</span>
            </div>
        </div>
    </div>
    <div class="table-wrapper table-sub">
        <table class="table table-striped table-hover" id="submission-table">
            <thead>
            <tr>
                <th>Action</th>
                <th>No</th>
                <th>Submission ID</th>
                <th>Week</th>
                <th>Reviewer</th>
                <th>S/W PL email</th>
                <th>SVMC project</th>
                <th>SVMC review status</th>
                <th>Progress</th>
                <th>Google review status</th>
                <th>Device Code</th>
                <th>Fingerprint</th>
                <th>Modem version</th>
                <th>CSC version</th>
                <th>Total CSC</th>
                <th>Approval type</th>                              
                <th>First model</th> 
                <th>Submit date</th>
                <th>Submit time</th>
                <th>SVMC review date</th>
                <th>Urgent mark</th>             
                <th>SVMC comment</th>
                <th>Action</th>
            </tr>
            </thead>
            <tbody>
            <tr>
            <form name = "search" method="get" id = "searchform" action ="search">
                <th><button type="submit" class="btn btn-sm btn-primary">Search</button></th>
                <th></th>
                <th>
                    <!-- <input type = "hidden" name ="_token" value="{{csrf_token()}}";> -->
                    <input type="text" name="key_id" id = "s" placeholder="Submission ID">
                </th>
                <th>
                    <input type="text" name="key_week" placeholder="Week">
                </th>
                <th>
                    <input type="text" name="key_reviewer" placeholder="Reviewer">
                </th>
                <th>
                    <input type="text" name="key_swpl" placeholder="SWPL email">
                </th>
                <th>
                    <input type="text" name="key_svmc" placeholder="SVMC project">
                </th>
                <th>
                    <input type="text" name="key_revstatus" placeholder="SVMC review status">
                </th>
                <th>
                    <input type="text" name="key_progress" placeholder="Progress">
                </th>
                <th>
                    <input type="text" name="key_ggstt" placeholder="Google review status">
                </th>
                <th>
                    <input type="text" name="key_code" placeholder="Device code">
                </th>
                <th>
                    <input type="text" name="key_apver" placeholder="Fingerprint">
                </th>
                <th>
                    <input type="text" name="key_cpver" placeholder="Modem version">
                </th>
                <th>
                    <input type="text" name="key_cscver" placeholder="CSC version">
                </th>
                <th>
                    <input type="text" name="key_totalcsc" placeholder="Total CSC">
                </th>
                <th>
                    <input type="text" name="key_type" placeholder="Approval type">
                </th>            
                <th>
                    <input type="text" name="key_first" placeholder="First model">
                </th>               
                <th>
                    <input type="text" name="key_submitdate" placeholder="Submit date">
                </th>
                <th>
                    <input type="text" name="key_submittime" placeholder="Submit time">
                </th>
                <th>
                    <input type="text" name="key_revdate" placeholder="SVMC review date">
                </th>
                <th>
                    <input type="text" name="key_urgent" placeholder="Urgent mark">
                </th>               
                <th>
                    <input type="text" name="key_comment" placeholder="SVMC comment">
                </th>                
                <th></th>
            </form>
            </tr>
            <?php $index = 0;?>
            @foreach($submission as $item)
                <?php $index++;?>
                <tr>
                    <td>
                        <a class="edit" href="#addSubmission" data-toggle="modal" data-id="{!! $item['id'] !!}"><span
                                    class="glyphicon glyphicon-pencil" data-toggle="tooltip"></span></a>
                        <a class="delete" href="#deleteEmployeeModal" data-toggle="modal" data-id="{!! $item['id'] !!}"><span
                                    class="glyphicon glyphicon-trash" data-toggle="tooltip"></span></a>
                    </td>
                    <td>{!! $index !!}</td>
                    <td>{!! $item['submission_id'] !!}</td>
                    <td>{!! $item['week'] !!}</td>
                    <td>{!! $item['reviewer'] !!}</td>
                    <td>{!! $item['pl_email'] !!}</td>
                    <td>{!! $item['svmc_project'] !!}</td>
                    <td>{!! $item['svmc_review_status'] !!}</td>
                    <td>{!! $item['progress'] !!}</td>
                    <td>{!! $item['google_review_status'] !!}</td>
                    <td>{!! $item['device_code'] !!}</td>
                    <td>{!! $item['ap_version'] !!}</td>
                    <td>{!! $item['modem_version'] !!}</td>
                    <td>{!! $item['csc_version'] !!}</td>
                    <td>{!! $item['total_csc'] !!}</td>
                    <td>{!! $item['approval_type'] !!}</td>  
                    <td>{!! $item['first_model'] !!}</td>
                    <td>{!! $item['date_submit'] !!}</td>
                    <td>{!! $item['time_submit'] !!}</td>
                    <td>{!! $item['date_review'] !!}</td>
                    <td>{!! $item['urgent_mark'] !!}</td>                    
                    <td>{!! $item['svmc_comment'] !!}</td>
                    <td>
                        <a class="edit" href="#addSubmission" data-toggle="modal" data-id="{!! $item['id'] !!}"><span
                                    class="glyphicon glyphicon-pencil" data-toggle="tooltip"></span></a>
                        <a class="delete" href="#deleteEmployeeModal" data-toggle="modal" data-id="{!! $item['id'] !!}"><span
                                    class="glyphicon glyphicon-trash" data-toggle="tooltip"></span></a>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        <div class="clearfix">
            <div class="hint-text">Showing <b>{!! $index !!}</b> out of <b>{!! $countTotal !!}</b> entries</div>
            <ul class="pagination">
                <li class="page-item">{{ $items->links() }}</li>
            </ul>
        </div>
    </div>
</div>
<!--Start Add Submission -->
@include('submission.create', ['svmc_review_status' => $svmc_review_status, 'progress' => $progress, 'google_review_status' => $google_review_status, 'reviewer' => $reviewer])

<!-- End Add Submission -->

<!-- Delete Modal HTML -->
<div id="deleteEmployeeModal" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <form>
                <div class="modal-header">
                    <h4 class="modal-title">Delete Employee</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to delete these Records?</p>
                    <p class="text-warning">
                        <small>This action cannot be undone.</small>
                    </p>
                </div>
                <div class="modal-footer">
                    <input type="button" id="delete" data-id='' class="btn btn-danger" value="Delete">
                    <input type="button" class="btn btn-default" data-dismiss="modal" value="Cancel">
                </div>
            </form>
        </div>
    </div>
</div>
<!-- Import Submission -->
@include('submission.import')
</body>
</html>
<script>
    $(document).ready(function () {
        $('.add').on('click', function () {
            $('#addSubmission').find('#btn-submit').data('id', '');
            $('#addSubmission').find('#submission_id').val('');
            $('#addSubmission').find('#device_code').val('');
            $('#addSubmission').find('#ap_version').val('');
            $('#addSubmission').find('#modem_version').val('');
            $('#addSubmission').find('#csc_version').val('');
            $('#addSubmission').find('#total_csc').val('');
            $('#addSubmission').find('#approval_type').val('Regular');
            $('#addSubmission').find('#reviewer').val(1);
            $('#addSubmission').find('#pl_email').val('');
            $('#addSubmission').find('#first_model').val(1);
            $('#addSubmission').find('#svmc_project').val(1);
            $('#addSubmission').find('#date_submit').val('');
            $('#addSubmission').find('#date_review').val('');
            $('#addSubmission').find('#urgent_mark').val(1);
            $('#addSubmission').find('#svmc_review_status').val(1);
            $('#addSubmission').find('#progress').val(1);
            $('#addSubmission').find('#google_review_status').val(1);
            $('#addSubmission').find('#svmc_comment').val('');
            $('#addSubmission').find('#week').val('');
            $('#addSubmission').find('.week').css({'display':'none'});
        });
        $('.edit').on('click', function () {
            var id = $(this).data('id');
            $.ajax({
                type: 'GET',
                url: '/submission/update/' + id,
                data: {},
                success: function (data) {
                    var date_submit = data.submit_date_time.replace(' ', 'T');
                    var date_review = data.svmc_review_date.slice(0,10);
                    $('#addSubmission').find('#btn-submit').data('id', id);
                    $('#addSubmission').find('#submission_id').val(data.submission_id);
                    $('#addSubmission').find('#device_code').val(data.device_code);
                    $('#addSubmission').find('#ap_version').val(data.ap_version);
                    $('#addSubmission').find('#modem_version').val(data.modem_version);
                    $('#addSubmission').find('#csc_version').val(data.csc_version);
                    $('#addSubmission').find('#total_csc').val(data.total_csc);
                    $('#addSubmission').find('#approval_type').val(data.approval_type);
                    $('#addSubmission').find('#reviewer').val(data.reviewer);
                    $('#addSubmission').find('#pl_email').val(data.pl_email);
                    $('#addSubmission').find('#first_model').val(data.first_model);
                    $('#addSubmission').find('#svmc_project').val(data.svmc_project);
                    $('#addSubmission').find('#date_submit').val(date_submit);
                    $('#addSubmission').find('#date_review').val(date_review);
                    $('#addSubmission').find('#urgent_mark').val(data.urgent_mark);
                    $('#addSubmission').find('#svmc_review_status').val(data.svmc_review_status);
                    $('#addSubmission').find('#progress').val(data.progress);
                    $('#addSubmission').find('#google_review_status').val(data.google_review_status);
                    $('#addSubmission').find('#svmc_comment').val(data.svmc_comment);
                    $('#addSubmission').find('#week').val(data.week);
                    $('#addSubmission').find('.week').css({'display':'block'});
                }
            });
        });
        $('.delete').on('click', function () {
            var id = $(this).data('id');
            $('#deleteEmployeeModal').find('#delete').data('id', id);
        });
        $('#delete').on('click', function () {
            var id = $(this).data('id');
            $.ajax({
                type: 'POST',
                url: '/submission/destroy/' + id,
                data: {},
                success: function (data) {
                    if (Number(data.status) === 200) {
                        window.location.href = '/submission/index';
                    }
                }
            });
        });
    });
</script>

@if (session('success'))
<script>
    alert("Imported Successfully");
</script>
@endif