@extends('template.dashboard')

@section('title', 'Classes')
@section('main')
	<!-- Main content -->
	<div class="content-wrapper">

		<!-- Page header -->
		<div class="page-header">
			<div class="breadcrumb-line">
				<ul class="breadcrumb">
					<li><a href="index.html"><i class="icon-home2 position-left"></i> Home</a></li>
					<li>Dashboard</li>
					<li class="active">Classes</li>
				</ul>

				<ul class="breadcrumb-elements">
					<li class="dropdown">
						<a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown">
							<i class="icon-gear position-left"></i>
							Settings
							<span class="caret"></span>
						</a>

						<ul class="dropdown-menu dropdown-menu-right">
							<li><a href="javascript:void(0);"><i class="icon-user-lock"></i> Account security</a></li>
							<li><a href="javascript:void(0);"><i class="icon-statistics"></i> Analytics</a></li>
							<li><a href="javascript:void(0);"><i class="icon-accessibility"></i> Accessibility</a></li>
							<li class="divider"></li>
							<li><a href="javascript:void(0);"><i class="icon-gear"></i> All settings</a></li>
						</ul>
					</li>
				</ul>
			</div>
		</div>
		<!-- /page header -->
		<!-- Content area -->
		<div class="content">
			<!-- Wizard with validation -->
	            <div class="panel panel-white">
					<div class="panel-heading">
						<h6 class="panel-title">Get started</h6>
						<div class="heading-elements">
							<ul class="icons-list">
		                		<li><a data-action="collapse"></a></li>
		                		<li><a data-action="reload"></a></li>
		                		<li><a data-action="close"></a></li>
		                	</ul>
	                	</div>
					</div>

                	<form class="steps-validation" action="#">
						<h6>Personal data</h6>
						<fieldset>
							<div class="row">
								<div class="col-md-6">
									<div class="form-group">
										<label>Email address: <span class="text-danger">*</span></label>
										<input type="email" class="form-control" value="tobymulberry@hotmail.com" disabled>
									</div>
									<a class="btn btn-primary">Change Email</a>
								</div>
								<div class="col-md-6">
									<div class="form-group">
										<label>Password: <span class="text-danger">*</span></label>
										<input type="text" class="form-control" value="******" disabled>
									</div>
									<a class="btn btn-primary">Change Password</a>
								</div>
							</div>
							<div class="row" style="margin-top: 20px;">
								<div class="col-md-2">
									<div class="form-group">
										<label>Your title: <span class="text-danger">*</span></label>
										<select name="title" data-placeholder="Select your title" class="select">
											<option value="Mr">Mr</option>
											<option value="Mrs">Mrs</option>
											<option value="Miss">Miss</option>
											<option value="Ms">Ms</option>
											<option value="Dr">Dr</option>
										</select>
									</div>
								</div>
								<div class="col-md-5">
									<div class="form-group">
										<label>Your first name: <span class="text-danger">*</span></label>
										<input type="text" name="first_name" class="form-control" placeholder="Your first name">
									</div>
								</div>
								<div class="col-md-5">
									<div class="form-group">
										<label>Your last name: <span class="text-danger">*</span></label>
										<input type="text" name="last_name" class="form-control" placeholder="Your last name">
									</div>
								</div>
							</div>
						</fieldset>

						<h6>Your classes</h6>
						<fieldset>
							<div class="row">
								<div class="col-md-6">
									<div class="form-group">
										<label>Class Name: <span class="text-danger">*</span></label>
		                                <input type="text" name="class_name" placeholder="Class name" class="form-control required">
	                                </div>

									<div class="form-group">
										<label>Subject:</label>
										<input type="text" name="class_subject" value="" data-role="tagsinput" class="subject-typeahead">
									</div>

									<div class="form-group">
										<label>Room:</label>
										<input type="text" name="class_room" value="" data-role="tagsinput" class="room-typeahead">
									</div>

									<a href="javascript:void(0);" class="btn btn-primary pull-right" id="create-class">Create Class <i class="icon-book" style="margin-left: 5px;"></i></a>
								</div>

								<div class="col-md-6">
									<label>Your classes:</label>
									<strong id="no-classes"><br />You have no classes yet. Create one using the form.</strong>
	                                <div class="table-responsive" style="display: none;">
										<table class="table table-bordered table-striped table-hover">
											<thead>
												<tr>
													<th>Class Name</th>
													<th>Subject</th>
													<th>Room</th>
													<th>Action</th>
												</tr>
											</thead>
											<tbody></tbody>
										</table>
									</div>

									<br />
								</div>
							</div>
						</fieldset>
					</form>
	            </div>
	            <!-- /wizard with validation -->
			<!-- Footer -->
			<div class="footer text-muted">
				&copy; 2016 SeatingPlanner by Toby Mellor
			</div>
			<!-- /footer -->
		</div>
		<!-- /content area -->
	</div>
	<!-- /main content -->
@stop
@section('scripts')
	<script>
		//
	    // Wizard with validation
	    //

	    // Show form
	    var form = $(".steps-validation").show();
	    var token = '{{ csrf_token() }}';

	    // Initialize wizard
	    $(".steps-validation").steps({
	        headerTag: "h6",
	        bodyTag: "fieldset",
	        transitionEffect: "fade",
	        titleTemplate: '<span class="number">#index#</span> #title#',
	        autoFocus: true,
	        onStepChanging: function (event, currentIndex, newIndex) {
	            $('.validation-error-label').remove();

	            var requiredErrorLabel = '<label id="position-error" class="validation-error-label" for="position">This field is required.</label>';

	            if (currentIndex == 0) {
	                var title = $('select[name=title]');
	                var firstName = $('input[name=first_name]');
	                var lastName = $('input[name=last_name]');

	                if (title.val() == "" || title.val() == null) {
	                    title.parent().append(requiredErrorLabel);
	                } else if (['Mr', 'Mrs', 'Miss', 'Ms', 'Dr'].indexOf(title.val()) == -1) {
	                    title.parent().append(requiredErrorLabel);
	                }

	                if (firstName.val() == "" || firstName.val() == null) {
	                    firstName.parent().append(requiredErrorLabel);
	                } else if (firstName.val().length == 0 || firstName.val().length >= 20) {
	                    firstName.parent().append('<label id="position-error" class="validation-error-label" for="position">The first name must be less than 20 characters.</label>');
	                }

	                if (lastName.val() == "" || lastName.val() == null) {
	                    lastName.parent().append(requiredErrorLabel);
	                } else if (lastName.val().length == 0 || lastName.val().length >= 20) {
	                    lastName.parent().append('<label id="position-error" class="validation-error-label" for="position">The last name must be less than 20 characters.</label>');
	                }
	            }

	            if ($('.validation-error-label').length > 0) {
	                return false;
	            }

	            // Allways allow previous action even if the current form is not valid!
	            if (currentIndex > newIndex) {
	                return true;
	            }

	            // Forbid next action on "Warning" step if the user is to young
	            if (newIndex === 3 && Number($("#age-2").val()) < 18) {
	                return false;
	            }

	            return form.valid();
	        },

	        onStepChanged: function (event, currentIndex, priorIndex) {
	            // Used to skip the "Warning" step if the user is old enough.
	            if (currentIndex === 2 && Number($("#age-2").val()) >= 18) {
	                form.steps("next");
	            }

	            // Used to skip the "Warning" step if the user is old enough and wants to the previous step.
	            if (currentIndex === 2 && priorIndex === 3) {
	                form.steps("previous");
	            }
	        },

	        onFinishing: function (event, currentIndex) {
	            form.validate().settings.ignore = ":disabled";
	            return form.valid();
	        },

	        onFinished: function (event, currentIndex) {
	            alert("Submitted!");
	        }
	    });

	    // Initialize plugins
	    // ------------------------------

	    // Select2 selects
	    $('.select').select2();

	    // Simple select without search
	    $('.select-simple').select2({
	        minimumResultsForSearch: '-1'
	    });

	    // Styled checkboxes and radios
	    $('.styled').uniform({
	        radioClass: 'choice'
	    });

	    // Styled file input
	    $('.file-styled').uniform({
	        wrapperClass: 'bg-warning',
	        fileButtonHtml: '<i class="icon-googleplus5"></i>'
	    });

	    $('input[name=last_name]').on('keyup', function() {
	    	triggerNameChange();
	    });

	    $('select[name=title]').on('change', function() {
	    	triggerNameChange();
	    });

	    $('#create-class').on('click', function() {
	    	createClass();
	    });

	    function createClass() {
	        var formData = $('.steps-validation').serializeArray().reduce(function(obj, item) {
			    obj[item.name] = item.value;
			    return obj;
			}, {});

			$('#create-class').addClass('disabled');

			$.APIAjax({
	        	url: '{{ url('api/class') }}',
	        	type: 'POST',
	        	data: {
	        		class_name: formData['class_name'],
					class_subject: formData['class_subject'],
					class_room: formData['class_room']
	        	},
	        	success: function(jsonResponse) {
					handleNotification(jsonResponse.message, 'success');

					$('tbody').append('<tr>' +
						'<td>' + formData['class_name'] + '</td>' +
						'<td>' + formData['class_subject'] + '</td>' +
						'<td>' + formData['class_room'] + '</td>' +
						'<td>' +
							'<div class="btn-group">' +
        						'<button type="button" class="btn btn-danger">Delete</span></button>' +
        					'</div>' +
        				'</td>' +
					'</tr>');

					$('.table-responsive').fadeIn();
					$('#no-classes').fadeOut();

					$('input[name=class_name]').val('');
					$('input[name=class_subject]').tagsinput('removeAll');
					$('input[name=class_room]').tagsinput('removeAll');
	        	},
	        	error: function(jsonResponse) {
					handleNotification(jsonResponse.message, 'error');
	        	}
	        }).done(function() {
				$('#create-class').removeClass('disabled');
	        });
	    }

	    function triggerNameChange() {
	        var title = $('select[name=title]');
	        var lastName = $('input[name=last_name]');
	        var originalName = '{{ current(explode("@", Auth::user()->email, 2)) }}';

	        $('.username').text(originalName);

	        if (title.val() != "" && title.val() != null && ['Mr', 'Mrs', 'Miss', 'Ms', 'Dr'].indexOf(title.val()) > -1) {
	            if (lastName.val() != "" && lastName.val() != null && lastName.val().length > 0 && lastName.val().length < 20) {
	                $('.username').text(title.val() + '. ' + lastName.val());
	            }
	        }
	    }

        // notificationContent is the message e.g. 'hello' (string)
        // type is the display type e.g. 'error' or 'success' (string)
        function handleNotification(notificationContent, type, timeout = 5000) {
            var n = noty({
                text: notificationContent,
                layout: 'topCenter',
                type: type
            });

            setTimeout(function() {
                n.close();
            }, timeout);
        }

        function isValidJson(jsonResponse) {
            return $.isPlainObject(jsonResponse);
        }

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': token
            }
        });

        $.extend({
            APIAjax: function(params){
                params.error = function() {
                    handleNotification('A server-side error occured. Try refreshing if the problem persists.', 'error');
                };

                if (params.success && typeof params.success == 'function') {
                    var successCallback = params.success;
                    var ourCallback = function(responseJson) {
                        if (isValidJson(responseJson)) { // Validate the data
                            if (responseJson.error == 0) {
                                successCallback(responseJson); // Continue to function
                            } else {
                                handleNotification(responseJson.message, 'error');
                            }
                        } else {
                            handleNotification('A server-side error occured. Try refreshing if the problem persists.', 'error');
                        }
                    }

                    params.success = ourCallback;
                }

                return $.ajax(params);
            }
        });
    </script>
@stop