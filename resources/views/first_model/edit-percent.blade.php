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
                <a href="{!! route('dashboard') !!}" class="btn btn-success add" data-toggle="modal" target="blank">Dashboard</a>
            </div>
            <div class="export-sub">
                <a href="{!! route('index') !!}" class="btn btn-success add" data-toggle="modal" target="blank">Submission</a>
            </div>
            <div class="add-sub">
                <a href="#addFirstModel" class="btn btn-success add" data-toggle="modal">Add First Model</a>
            </div>
            <div class="import-first">
                <button type="button" data-toggle="modal" data-target="#myModalFirst" class="export btn btn-primary">
                    Import
                </button>
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
        <h3 style="text-align: center">Percent update</h3>
        @if(session('notify'))
            <div class="clearfix"></div>
            <div class="note note-success">
                <p style="text-align: center; color: #5cb85c;"> {{session('notify')}} </p>
            </div>
        @endif
        <div class="row">
            <div class="list-reviewer">
                <form action="{{route('first_model.storePercent', $firstModel['id'])}}" class="form-horizontal"
                      method="post">
                    {{csrf_field()}}
                    <ul>
                        @foreach($reviewer as $key => $item)
                            {{--@dd($item);--}}
                            <li>
                                <div class="form-group">
                                    <label>{{ $item->reviewer_name }}</label>
                                    <input type="text" class="form-control" name="{{ $item->id }}" id="model_name"
                                           value={{ $item->percent }} required>%
                                    {{--<input name="reviewer_id" value="{{ $item->id }}" hidden>--}}
                                </div>
                            </li>
                        @endforeach
                    </ul>

                    <div style="display: flex; justify-content: center">
                        <button type="submit" id="btn_submit" class="btn btn-success a1">Update
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@include('first_model.import')
</body>
</html>
<script>
    $(document).ready(function () {
        $('.a1').on('click', function (e) {
            console.log($(e.relatedTarget).data());
            var id = $(e.relatedTarget).data('reviewer_id');
            console.log($(this).find('input[type="hidden"]').val());
            var submission_id = $("input[name=reviewer_id]").val();
            // var id = $(this).data('id');
            console.log(id);
        });
        $('.edit').on('click', function () {
            var id = $(this).data('id');
            // var selectedValues = new Array();
            $.ajax({
                type: 'GET',
                url: '/first_model/update/' + id,
                data: {},
                success: function (data) {
                    console.log(data);

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
                        $('#addFirstModel').find('#fullFM').prop('checked', true);
                        $('#simplifiedFM').prop('checked', false);
                        $('#fullFM').prop('checked', true);
                        $('#variant').prop('checked', false);
                    }
                    if (data.type === 0) {
                        $('#addFirstModel').find('#simplifiedFM').prop('checked', true);
                    }
                    if (data.type === 2) {
                        $('#addFirstModel').find('#variant').prop('checked', true);
                        $('#simplifiedFM').prop('checked', false);
                        $('#fullFM').prop('checked', false);
                        $('#variant').prop('checked', true);
                        $('#type_all').css({'display': 'none'});
                        $('#type_variant').css({'display': 'block'});
                    }
                }
            });
        });
    });
</script>