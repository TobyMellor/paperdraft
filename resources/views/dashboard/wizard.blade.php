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
					</div>

                	<form class="steps-validation" action="#">
						<h6>Personal data</h6>
						<fieldset>
							<div class="row">
								<div class="col-md-6">
									<div class="form-group">
										<label>Email address: <span class="text-danger">*</span></label>
										<input type="email" class="form-control" value="{{ Auth::user()->email }}" disabled>
									</div>
									<a class="btn btn-primary">Change Email</a>
								</div>
								<div class="col-md-6">
									<div class="form-group">
										<label>Password: <span class="text-danger">*</span></label>
										<input type="text" class="form-control" value="****" disabled>
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
										<input type="text" name="first_name" value="{{ Auth::user()->first_name }}" class="form-control" placeholder="Your first name">
									</div>
								</div>
								<div class="col-md-5">
									<div class="form-group">
										<label>Your last name: <span class="text-danger">*</span></label>
										<input type="text" name="last_name" value="{{ Auth::user()->last_name }}" class="form-control" placeholder="Your last name">
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

						<h6>Your students</h6>
						<fieldset>
							<h2>We'll redirect you to the students page.</h2>
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
	    var hasErrorOccured = false;

	    // Initialize wizard
	    $(".steps-validation").steps({
	        headerTag: "h6",
	        bodyTag: "fieldset",
	        transitionEffect: "fade",
	        titleTemplate: '<span class="number">#index#</span> #title#',
	        autoFocus: true,
	        @if (Auth::user()->last_name != null)
        		startIndex: 1,
	        @endif
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

	                updateUser();
	            }

	            if (currentIndex == 1 && newIndex == 2) {
		        	if ($('tr').length > 1) {
		        		window.location.href = '{{ url('dashboard/classes') }}';

		        		$(".steps-validation").fadeOut();

		        		return true;
		        	}

		        	handleNotification('You need to create at least one class before continuing.', 'error');

		        	return false;
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

	        onStepChanged: function (event, currentIndex, priorIndex) {},

	        onFinishing: function (event, currentIndex) {},

	        onFinished: function (event, currentIndex) {}
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

	    $('input').on('beforeItemAdd', function(event) {
			$(this).tagsinput('removeAll');
		});

	    $('#create-class').on('click', function() {
            var className = $('input[name=class_name]');
            var classSubject = $('input[name=class_subject]');
            var classRoom = $('input[name=class_room]');

            $('.validation-error-label').remove();

            if (className.val() == "" || className.val() == null) {
                className.parent().append('<label id="position-error" class="validation-error-label" for="position">This field is required.</label>');
            } else if (className.val().length == 0 || className.val().length > 30) {
                className.parent().append('<label id="position-error" class="validation-error-label" for="position">The class name must be less than 30 characters.</label>');
            }

            if (classSubject.val().length > 30) {
                classSubject.parent().append('<label id="position-error" class="validation-error-label" for="position">The subject name must be less than 30 characters.</label>');
            } else {
            	$('.subject-typeahead').tagsinput('add', $('.tt-input:first').val());
            }

            if (classRoom.val().length > 30) {
                classRoom.parent().append('<label id="position-error" class="validation-error-label" for="position">The room name must be less than 30 characters.</label>');
            } else {
            	$('.room-typeahead').tagsinput('add', $('.tt-input:last').val());
            }

            if ($('.validation-error-label').length == 0) {
	    		createClass();
            }
	    });

	    $(document).delegate('.delete-class', 'click', function() {
	    	var classId = $(this).attr('class-id');

	    	$(this).replaceWith('<button class="btn btn-danger" type="button" class-id="' + classId + '" disabled>Deleting <i class="icon-spinner2 spinner" style="margin-left: 5px;"></i></button>');

	    	removeClass(classId);
	    });

	    $('select[name=title]').select2('val', '{{ Auth::user()->title }}');

	    function updateUser() {
	        var formData = $('.steps-validation').serializeArray().reduce(function(obj, item) {
			    obj[item.name] = item.value;
			    return obj;
			}, {});

			$.APIAjax({
	        	url: '{{ url('api/user') }}/{{ Auth::user()->id }}',
	        	type: 'PUT',
	        	data: {
	        		title: formData['title'],
	        		first_name: formData['first_name'],
	        		last_name: formData['last_name']
	        	},
	        	success: function(jsonResponse) {
					handleNotification(jsonResponse.message, 'success');
	        	},
	        	error: function(jsonResponse) {
					$(".steps-validation").steps("previous");
	        	}
	        }).always(function() {
				if (hasErrorOccured) {
					hasErrorOccured = false;

					$('.steps-validation').steps('previous');
				}
	        });
	    }

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

					if (formData['class_subject'] == "") {
						formData['class_subject'] = 'N/A';
					}

					if (formData['class_room'] == "") {
						formData['class_room'] = 'N/A';
					}

					$('tbody').append('<tr>' +
						'<td>' + formData['class_name'] + '</td>' +
						'<td>' + formData['class_subject'] + '</td>' +
						'<td>' + formData['class_room'] + '</td>' +
						'<td>' +
							'<div class="btn-group">' +
        						'<button type="button" class="btn btn-danger delete-class" class-id="' + jsonResponse.class.id + '">Delete</span></button>' +
        					'</div>' +
        				'</td>' +
					'</tr>');

					$('#no-classes').fadeOut(300, function() {
						$('.table-responsive').fadeIn();
					});

					$('input[name=class_name]').val('');
					$('input[name=class_subject]').tagsinput('removeAll');
					$('input[name=class_room]').tagsinput('removeAll');
	        	},
	        	error: function(jsonResponse) {
					$('.steps-validation').steps('previous');
	        	}
	        }).always(function() {
	        	$('#create-class').removeClass('disabled');
	        });
	    }

	    function removeClass(classId) {
			$.APIAjax({
	        	url: '{{ url('api/class') }}/' + classId,
	        	type: 'DELETE',
	        	success: function(jsonResponse) {
					handleNotification(jsonResponse.message, 'success');

					$('button[class-id=' + classId + ']').closest('tr').fadeOut(300, function() {
						$(this).remove();
						
			        	if ($('tr').length == 1) {
							$('.table-responsive').fadeOut(300, function() {
								$('#no-classes').fadeIn();
							});
			        	}
					});
	        	},
	        	error: function(jsonResponse) {}
	        }).always(function() {
				$('button[class-id=' + classId + ']').replaceWith('<button type="button" class="btn btn-danger delete-class" class-id="' + classId + '">Delete</span></button>');
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
                    hasErrorOccured = true;
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
                        	hasErrorOccured = true;
                            handleNotification('A server-side error occured. Try refreshing if the problem persists.', 'error');
                        }
                    }

                    params.success = ourCallback;
                }

                return $.ajax(params);
            }
        });

		function _goToStep(wizard, options, state, index) {
		    return paginationClick(wizard, options, state, index);
		}

        $.fn.steps.setStep = function (step) {
		    var options = getOptions(this),
		        state = getState(this);

		    return _goToStep(this, options, state, step);
		};
    </script>
@stop