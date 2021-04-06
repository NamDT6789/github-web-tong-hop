<!doctype html>
<html lang="en">
@include('layouts.main')

<body>
<div class="container">
        <div class="table-title table-first">
                    <div class="title-sub title-first">
                        <h2><b>Submission</b></h2>
                    </div>
                    <div class="col-right">
                        <div class="add-sub">
                            <a href="{!! route('dashboard') !!}" class="btn btn-success add" data-toggle="modal" target = "blank">Dashboard</a>
                        </div>
                        <div class="export-sub">
                            <a href="{!! route('index') !!}" class="btn btn-success add" data-toggle="modal" target = "blank">Submission</a>
                        </div>
                        <div class="add-sub">
                            <a href="#addFirstModel" class="btn btn-success add" data-toggle="modal">Add First Model</a>
                        </div>
                        <div class="import-first">
                            <button type="button" data-toggle="modal" data-target="#myModalFirst" class="export btn btn-primary">Import</button>
                         </div>
                        <div class="user-logout">
                            <a href="{!! route('logout') !!}" class="btn btn-default">Logout</a>
                        </div>
                        <div class="user-title">
                            <a href="" class="btn">Chao: {!! isset($user_name) ? $user_name :'' !!}</a>
                        </div>
                    </div>
            </div>
        <div class="table-wrapper table-sub">
            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th>Action</th>
                        <th>No</th>
                        <th>Submission ID</th>
                        <th>Product name</th>
                        <th>Model name</th>
                        <th>Sale code</th>
                        <th>Assignment</th>
                        <th>Reviewer</th>
                        <th>Ratio FM</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <th></th>
                        <th></th>
                        <th>
                            <input type="text" name="" placeholder="Submission ID">
                        </th>
                        <th>
                            <input type="text" name="" placeholder="Product name">
                        </th>
                        <th>
                            <input type="text" name="" placeholder="Model name">
                        </th>
                        <th style = "width : 100px;">
                            <input type="text" name="" placeholder="Sale code" disabled>
                        </th>
                        <th>
                            <input type="text" name="" value="" placeholder="Assignment" disabled>
                        </th>
                        <th>
                            <input type="text" name="" value="" placeholder="Reviewer" disabled>
                        </th>
                        <th>
                            <input type="text" name="" value="" placeholder="Ratio FM" disabled>
                        </th>
                        <th>
                            <input type="text" name="" placeholder="Status">
                        </th>
                    </tr>
                    <?php $index = 0;?>
                    @foreach($first_model as $item)
                        <?php $index++;?>
                        <tr>
                            <td>
                                <a class="edit" href="#addFirstModel" data-toggle="modal" data-id="{!! $item['id'] !!}"><span
                                            class="glyphicon glyphicon-pencil" data-toggle="tooltip"></span></a>
                                <a class="delete" href="#deleteEmployeeModal" data-toggle="modal" data-id="{!! $item['id'] !!}"><span
                                            class="glyphicon glyphicon-trash" data-toggle="tooltip"></span></a>
                            </td>
                            <td>{!! $index !!}</td>
                            <td>{!! $item['submission_id'] !!}</td>
                            <td>{!! $item['device_code'] !!}</td>
                            <td>{!! $item['model_name'] !!}</td>
                            <td>{!! $item['sale_code'] !!}</td>
                            <td>
                                @if($item['type'] !=2 )
                                    <ul>
                                        <li>Check file & CTS-V</li>
                                        <li>Check list</li>
                                    </ul>
                                @else
                                    <ul>
                                        <li>Variant/Phase2</li>
                                    </ul>
                                @endif
                            </td>
                            <td>
                                @if($item['type'] !=2 )
                                    <ul style="border-bottom: 1px solid">
                                        @foreach($item['check_file_cts'] as $r)
                                            @if($r->check_type === 2)
                                                <li>{{ $r->reviewer_name }}</li>
                                                @endif
                                            @endforeach
                                    </ul>
                                    <ul>
                                        @foreach($item['check_list'] as $r)
                                            @if($r->check_type === 1)
                                                <li>{{ $r->reviewer_name }}</li>
                                            @endif
                                        @endforeach
                                    </ul>
                                @else
                                    <ul>
                                        @foreach($item['ratio_assignment'] as $r)
                                            @if($r->check_type === 3)
                                                <li>{{ $r->reviewer_name }}</li>
                                            @endif
                                        @endforeach
                                    </ul>
                                @endif
                            </td>
                            <td>
                                @if($item['type'] !=2 )
                                    <ul>
                                        @foreach($item['check_file_cts'] as $r)
                                            @if($r->check_type === 2)
                                                <li>{!! $r->percent.'%' !!}</li>
                                            @endif
                                        @endforeach
                                    </ul>
                                    <ul>
                                        @foreach($item['check_list'] as $r)
                                            @if($r->check_type === 1)
                                                <li>{!! $r->percent.'%' !!}</li>
                                            @endif
                                        @endforeach
                                    </ul>
                                @else
                                    <ul>
                                        @foreach($item['ratio_assignment'] as $r)
                                            @if($r->check_type === 3)
                                                <li>{!! $r->percent.'%' !!}</li>
                                            @endif
                                        @endforeach
                                    </ul>
                                @endif
                            </td>
                            <td>{!! $item['status'] !!}</td>
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
        <div class="table-total table-wrapper">
            <div class="col-md-3">
            <table class="table table-striped table-hover">
                <thead>
                    <tr style = "background:  #dff0d8">
                        <th style="font-size: 16px;width:274px">Reviewer</th>
                        <th style="font-size: 16px">Total</th>
                    </tr>
                </thead>
                <tbody>
                @foreach($total_reviewer as $item)
                    <tr>
                        <td>{{ $item->reviewer_name }}</td>
                        <td>{!! $item->total. '%' !!}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            </div>
        </div>
    </div>
<!--Start Add Submission -->
@include('first_model.create', ['status' => $status, 'reviewer' => $reviewer])

<!-- End Add Submission -->

<!-- Delete Modal HTML -->
<div id="deleteEmployeeModal" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <form>
                <div class="modal-header">
                    <h4 class="modal-title">Delete</h4>
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
@include('first_model.import')
</body>
</html>
<script>
    $(document).ready(function () {
        $('.add').on('click', function () {
            $('#addFirstModel').find('#btn-submit').data('id', '');
            $('#addFirstModel').find('#submission_id').val('');
            $('#addFirstModel').find('#device_code').val('');
            $('#addFirstModel').find('#model_name').val('');
            $('#addFirstModel').find('#sale_code').val('');
            $('#addFirstModel').find('#check_file').val('');
            $('#addFirstModel').find('#check_list').val('');
            $('#addFirstModel').find('#asignment_reviewer').val('');
            $('#addFirstModel').find('#status').val('');
            $('#addFirstModel').find('#simplifiedFM').prop('checked', true);
        });
        $('.edit').on('click', function () {
            var id = $(this).data('id');
            $.ajax({
                type: 'GET',
                url: '/first_model/update/' + id,
                data: {},
                success: function (data) {

                    $('#addFirstModel').find('#btn-submit').data('id', id);
                    $('#addFirstModel').find('#submission_id').val(data.submission_id);
                    $('#addFirstModel').find('#device_code').val(data.device_code);
                    $('#addFirstModel').find('#model_name').val(data.model_name);
                    $('#addFirstModel').find('#sale_code').val(data.sale_code);
                    $('#addFirstModel').find('#check_file').val(data.check_file_cts);
                    $('#addFirstModel').find('#check_list').val(data.check_list);
                    $('#addFirstModel').find('#asignment_reviewer').val(data.asignment);
                    $('#addFirstModel').find('#status').val(data.status);
                    if (data.type === 1) {
                        $('#simplifiedFM').prop('checked', false);
                        $('#fullFM').prop('checked', true);
                        $('#variant').prop('checked', false);
                    }
                    if (data.type === 2) {
                        $('#simplifiedFM').prop('checked', false);
                        $('#fullFM').prop('checked', false);
                        $('#variant').prop('checked', true);
                        $('#type_all').css({'display':'none'});
                        $('#type_variant').css({'display':'block'});
                    }
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
                url: '/first_model/destroy/' + id,
                data: {},
                success: function (data) {
                    if (Number(data.status) === 200) {
                        window.location.href = '/first_model/index';
                    }
                }
            });
        });
    });
</script>