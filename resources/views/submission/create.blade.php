<div id="addSubmission" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form method="post" class="submission-form">
                @csrf
                <div class="modal-header">
                    <h4 class="modal-title">Add Submission</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <!-- <div class="notification"></div> -->
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group has-error">
                                <label for="submission_id">Submission ID</label>
                                <input type="text" class="form-control" name="submission_id" id="submission_id">
                                <p class="help-block"></p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group has-error">
                                <label for="device_code">Device Code</label>
                                <input type="text" class="form-control" name="device_code" id="device_code">
                                <p class="help-block"></p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group has-error">
                                <label for="ap_version">Finger print</label>
                                <input type="text" name="ap_version" id="ap_version" class="form-control">
                                <p class="help-block"></p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group has-error">
                                <label for="modem_version">Modem version</label>
                                <input type="text" name="modem_version" id="modem_version" class="form-control">
                                <p class="help-block"></p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group has-error">
                                <label for="csc_version">CSC version</label>
                                <input type="text" name="csc_version" id="csc_version" class="form-control">
                                <p class="help-block"></p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group has-error">
                                <label for="total_csc">Total CSC</label>
                                <input type="text" name="total_csc" id="total_csc" class="form-control">
                                <p class="help-block"></p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="approval_type">Approval type</label>
                                <select class="form-control" name="approval_type" id="approval_type">
                                    <option value="Regular">Regular</option>
                                    <option value="NormalException">NormalException</option>
                                    <option value="SMR">SMR</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="reviewer">Reviewer</label>
                                <select class="form-control" name="reviewer" id="reviewer">
                                    @foreach($reviewer as $key => $value)
                                        <option value="{!! $key !!}">{!! $value !!}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group has-error">
                                <label for="pl_email">S/W PL email</label>
                                <input type="text" name="pl_email" id="pl_email" class="form-control" value="">
                                <p class="help-block"></p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="first_model">First model</label>
                                <select class="form-control" name="first_model" id="first_model">
                                    <option value="1">Yes</option>
                                    <option value="0">No</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="svmc_project">SVMC project</label>
                                <select id="svmc_project" name="svmc_project" class="form-control">
                                    <option value="1">True</option>
                                    <option value="0">False</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="date_submit">Submit date</label>
                                <input type="datetime-local" id="date_submit" name="date_submit" class="form-control"
                                       value="">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="date_review">SVMC review date</label>
                                <input type="date" id="date_review" name="date_review" class="form-control" value="">
                            </div>
                        </div>
                        <div class="col-md-6 week">
                            <div class="form-group">
                                <label for="week">Week</label>
                                <input type="text" id="week" name="week" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="urgent_mark">Urgent mark</label>
                                <select id="urgent_mark" name="urgent_mark" class="form-control">
                                    <option value="1">True</option>
                                    <option value="0">False</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="svmc_review_status">SVMC review status</label>
                                <select class="form-control" name="svmc_review_status" id="svmc_review_status">
                                    @foreach($svmc_review_status as $key => $value)
                                        <option value="{!! $key !!}">{!! $value !!}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="progress">Progress</label>
                                <select class="form-control" name="progress">
                                    @foreach($progress as $key => $value)
                                        <option value="{!! $key !!}">{!! $value !!}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="google_review_status">Google review status</label>
                                <select class="form-control" name="google_review_status">
                                    @foreach($google_review_status as $key => $value)
                                        <option value="{!! $key !!}">{!! $value !!}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="svmc_comment">SVMC comment</label>
                                <textarea class="form-control" name="svmc_comment" id="svmc_comment"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <input type="button" class="btn btn-default" data-dismiss="modal" value="Cancel">
                    <input type="button" id="btn-submit" data-id='' class="btn btn-success" value="Save">
                </div>
                <div class="notification"></div>
            </form>
        </div>
    </div>
</div>
<script type="text/javascript">
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $("#btn-submit").click(function (e) {
        e.preventDefault();
        var submission_id = $("input[name=submission_id]").val();
        var device_code = $("input[name=device_code]").val();
        var ap_version = $("input[name=ap_version]").val();
        var modem_version = $("input[name=modem_version]").val();
        var csc_version = $("input[name=csc_version]").val();
        var total_csc = $("input[name=total_csc]").val();
        var approval_type = $("select[name=approval_type]").val();
        var reviewer = $("select[name=reviewer]").val();
        var pl_email = $("input[name=pl_email]").val();
        var first_model = $("select[name=first_model]").val();
        var svmc_project = $("select[name=svmc_project]").val();
        var date_submit = $("input[name=date_submit]").val();
        var date_review = $("input[name=date_review]").val();
        var urgent_mark = $("select[name=urgent_mark]").val();
        var svmc_review_status = $("select[name=svmc_review_status]").val();
        var progress = $("select[name=progress]").val();
        var google_review_status = $("select[name=google_review_status]").val();
        var svmc_comment = $("textarea[name=svmc_comment]").val();
        var week = $("input[name=week]").val();
        function validate() {
            var check = false;
            var parent = $('.submission-form');
            if (submission_id === '') {
                parent.find('#submission_id').parent().removeClass('has-success');
                parent.find('#submission_id').parent().addClass('has-error');
                parent.find('#submission_id').parent().find('.help-block').text('Submission Id can not blank!');
                check = true;
            } else {
                parent.find('#submission_id').parent().removeClass('has-error');
                parent.find('#submission_id').parent().addClass('has-success');
                parent.find('#submission_id').parent().find('.help-block').text('');
            }
            if (device_code === '') {
                parent.find('#device_code').parent().removeClass('has-success');
                parent.find('#device_code').parent().addClass('has-error');
                parent.find('#device_code').parent().find('.help-block').text('Device Code can not blank!');
                check = true;
            } else {
                parent.find('#device_code').parent().removeClass('has-error');
                parent.find('#device_code').parent().addClass('has-success');
                parent.find('#device_code').parent().find('.help-block').text('');
            }
            if (ap_version === '') {
                parent.find('#ap_version').parent().removeClass('has-success');
                parent.find('#ap_version').parent().addClass('has-error');
                parent.find('#ap_version').parent().find('.help-block').text('AP version can not blank!');
                check = true;
            } else {
                parent.find('#ap_version').parent().removeClass('has-error');
                parent.find('#ap_version').parent().addClass('has-success');
                parent.find('#ap_version').parent().find('.help-block').text('');
            }
            if (modem_version === '') {
                parent.find('#modem_version').parent().removeClass('has-success');
                parent.find('#modem_version').parent().addClass('has-error');
                parent.find('#modem_version').parent().find('.help-block').text('Modem version can not blank!');
                check = true;
            } else {
                parent.find('#modem_version').parent().removeClass('has-error');
                parent.find('#modem_version').parent().addClass('has-success');
                parent.find('#modem_version').parent().find('.help-block').text('');
            }
            if (csc_version === '') {
                parent.find('#csc_version').parent().removeClass('has-success');
                parent.find('#csc_version').parent().addClass('has-error');
                parent.find('#csc_version').parent().find('.help-block').text('CSC version can not blank!');
                check = true;
            } else {
                parent.find('#csc_version').parent().removeClass('has-error');
                parent.find('#csc_version').parent().addClass('has-success');
                parent.find('#csc_version').parent().find('.help-block').text('');
            }
            if (total_csc === '') {
                parent.find('#total_csc').parent().removeClass('has-success');
                parent.find('#total_csc').parent().addClass('has-error');
                parent.find('#total_csc').parent().find('.help-block').text('Total CSC can not blank!');
                check = true;
            } else {
                parent.find('#total_csc').parent().removeClass('has-error');
                parent.find('#total_csc').parent().addClass('has-success');
                parent.find('#total_csc').parent().find('.help-block').text('');
            }
            if (pl_email === '') {
                parent.find('#pl_email').parent().removeClass('has-success');
                parent.find('#pl_email').parent().addClass('has-error');
                parent.find('#pl_email').parent().find('.help-block').text('S/W PL email can not blank!');
                check = true;
            } else {
                parent.find('#pl_email').parent().removeClass('has-error');
                parent.find('#pl_email').parent().addClass('has-success');
                parent.find('#pl_email').parent().find('.help-block').text('');
            }
            return check;
        }
        if (validate()) {
            return false;
        } else {
            var id = $(this).data('id');
            var url = '/submission/create';
            if (id !== '') {
                url = '/submission/updateSubmission/' + id;
            }
            $.ajax({
                type: 'POST',
                url: url,
                data: {
                    submission_id: submission_id,
                    device_code: device_code,
                    ap_version: ap_version,
                    modem_version: modem_version,
                    csc_version: csc_version,
                    total_csc: total_csc,
                    approval_type: approval_type,
                    reviewer: reviewer,
                    pl_email: pl_email,
                    first_model: first_model,
                    svmc_project: svmc_project,
                    date_submit: date_submit,
                    date_review: date_review,
                    urgent_mark: urgent_mark,
                    svmc_review_status: svmc_review_status,
                    progress: progress,
                    google_review_status: google_review_status,
                    svmc_comment: svmc_comment,
                    week: week
                },
                success: function (data) {
                    $('.notification').append(data.message);
                    setTimeout(function () {
                        if (Number(data.status) === 200) {
                            // window.location.href = '/submission/index'
                            location.reload();
                        }
                    }, 1000);

                }
            });
        }
    });
</script>