<div id="addFirstModel" class="modal fade" role="dialog">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form method="post" class="first-model">
                    <div class="modal-header">
                        <h4 class="modal-title">Add First Model</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    </div>
					<div class="notification"></div>
                    <div class="modal-body">
                    	<div class="row">
                    		<div class="col-md-12">
                    			<div class="check-type">
	                    			<input type="radio" id="simplifiedFM" name="type" value="0" onclick="typeFirstModel(0)">
									<label for="simplifiedFM"> Simplified FM</label><br>
                    			</div>
                    			<div class="check-type">
	                    			<input type="radio" id="fullFM" name="type" value="1" onclick="typeFirstModel(1)">
									<label for="fullFM"> Full FM</label><br>
                    			</div>
                    			<div class="check-type">
	                    			<input type="radio" id="variant" name="type" value="2" onclick="typeFirstModel(2)">
									<label for="variant"> Variant/Phase2</label>
                    			</div>
                    		</div>
	                    	<div class="col-md-6">
	                    		<div class="form-group">
		                            <label>Submission ID</label>
		                            <input type="text" class="form-control" name="submission_id" id="submission_id" value="" required>
	                        	</div>
	                    	</div>
	                    	<div class="col-md-6">
	                    		<div class="form-group">
		                            <label>Product Name</label>
		                            <input type="text" class="form-control" name="device_code" id="device_code" value="" required>
	                        	</div>
	                    	</div>
	                        <div class="col-md-6">
	                    		<div class="form-group">
		                            <label>Model name</label>
		                            <input type="text" class="form-control" name="model_name" id="model_name" value="" required>
	                        	</div>
	                    	</div>
	                    	<div class="col-md-6">
	                    		<div class="form-group">
		                            <label>Sale code</label>
		                            <input type="text" class="form-control" name="sale_code" id="sale_code" value="" required>
	                        	</div>
	                    	</div>
	                    	<div id="type_all">
	                    		<div class="col-md-6">
		                    		<div class="form-group">
										<label>Check file & CTS-V</label>
										<!--<select class="form-control" name="check_file_reviewer" id="check_file" onchange ="removeReviewer()">-->
			                            <select class="form-control" name="check_file_reviewer" id="check_file">
			                            	<option value=""></option>
			                            	@foreach($reviewer as $key => $value)
		                                        <option value="{!! $key !!}">{!! $value !!}</option>
		                                    @endforeach
			                            </select>
		                        	</div>
		                    	</div>
		                    	<div class="col-md-6">
		                    		<div class="form-group">
										<label>Check list</label>
										<!--<select class="form-control" name="check_list_reviewer" id="check_list" onchange="removeReviewer()">-->
			                            <select class="form-control" name="check_list_reviewer" id="check_list">
			                            	<option value=""></option>
			                            	@foreach($reviewer as $key => $value)
		                                        <option value="{!! $key !!}">{!! $value !!}</option>
		                                    @endforeach
			                            </select>
		                        	</div>
		                    	</div>
	                    	</div>
	                    	<div class="col-md-6" id="type_variant" style="display: none">
	                    		<div class="form-group">
		                            <label>Asignment</label>
		                            <select class="form-control" id="asignment_reviewer" name="asignment_reviewer">
		                            	<option value=""></option>
		                            	@foreach($reviewer as $key => $value)
	                                        <option value="{!! $key !!}">{!! $value !!}</option>
	                                    @endforeach
		                            </select>
	                        	</div>
	                    	</div>
	                    	<div class="col-md-6">
	                    		<div class="form-group">
		                            <label>Status</label>
		                            <select class="form-control" id="status" name="status">
		                            	@foreach($status as $key => $value)
	                                        <option value="{!! $key !!}">{!! $value !!}</option>
	                                    @endforeach
		                            </select>
	                        	</div>
	                    	</div>
	                    </div>
                    </div>
                    <div class="modal-footer">
                        <input type="button" class="btn btn-default" data-dismiss="modal" value="Cancel">
                        <input type="button" class="btn btn-success" data-id='' id="btn-submit"  value="Add">
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script type="text/javascript">
    	function typeFirstModel(key) {
    		if (key === 2) {
    			$('#type_all').css({'display':'none'});
    			$('#type_variant').css({'display':'block'});
    		} else {
    			$('#type_all').css({'display':'block'});
    			$('#type_variant').css({'display':'none'});
    		}
    	}
    	function removeReviewer() {
    		var select_check_file = document.getElementById("check_file");
    		var select_check_list = document.getElementById("check_list");
    		var id_reviewer_check_file = select_check_file.options[select_check_file.selectedIndex].value;
    		var id_reviewer_check_list = select_check_list.options[select_check_list.selectedIndex].value;

    		if (id_reviewer_check_file) {
    			for (var i=0; i<select_check_list.length; i++) {
				    if (select_check_list.options[i].value === id_reviewer_check_file)
				        select_check_list.remove(i);
				}
    		}

    		if (id_reviewer_check_list) {
    			for (var i=0; i<select_check_file.length; i++) {
				    if (select_check_file.options[i].value === id_reviewer_check_list)
				        select_check_file.remove(i);
				}
    		}

    	}

    	$.ajaxSetup({
	        headers: {
	            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
	        }
	    });
	    $("#btn-submit").click(function (e) {
	        e.preventDefault();
	        var data = $('.first-model').serialize();
	        var submission_id = $("input[name=submission_id]").val();
	        var device_code = $("input[name=device_code]").val();
	        function validate() {
	            var check = false;
	            var parent = $('.first-model');
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
	            return check;
	        }
	        if (validate()) {
	            return false;
	        } else {
	            var id = $(this).data('id');
	            var url = '/first_model/create';
	            if (id !== '') {
	                url = '/first_model/update/' + id;
	            }
	            $.ajax({
	                type: 'POST',
	                url: url,
	                data: data,
	                success: function (data) {
	                    $('.notification').append(data.message);
	                    setTimeout(function () {
	                        if (Number(data.status) === 200) {
	                            window.location.href = '/first_model/index'
	                        }
	                    }, 3000);

	                }
	            });
	        }
	    });
    </script>