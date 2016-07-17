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
						<a href="#" class="dropdown-toggle" data-toggle="dropdown">
							<i class="icon-gear position-left"></i>
							Settings
							<span class="caret"></span>
						</a>

						<ul class="dropdown-menu dropdown-menu-right">
							<li><a href="#"><i class="icon-user-lock"></i> Account security</a></li>
							<li><a href="#"><i class="icon-statistics"></i> Analytics</a></li>
							<li><a href="#"><i class="icon-accessibility"></i> Accessibility</a></li>
							<li class="divider"></li>
							<li><a href="#"><i class="icon-gear"></i> All settings</a></li>
						</ul>
					</li>
				</ul>
			</div>
		</div>
		<!-- /page header -->
		<!-- Content area -->
		<div class="content">
			<div class="row row-sortable">
				<div class="col-md-8">
					<div class="panel panel-flat">
						<div class="panel-heading">
							<h6 class="panel-title">
								<span class="text-semibold">Manage Class</span>
								<span class="text-muted">
									<small> {{ $selectedClass->class_name }}<small>
								</span>
							</h6>
							<div class="heading-elements">
								<a class="btn bg-teal-400" href="#"><i class="icon-statistics position-left"></i> View Seating Plan</a>
		                	</div>
						<a class="heading-elements-toggle"><i class="icon-menu"></i></a></div>
						<table class="table text-nowrap">
							<thead>
								<tr>
									<th style="width: 300px;">Student</th>
									<th>CAL</th>
									<th>Target</th>
									<th>PP</th>
									<th>Ability</th>
									<th style="width: 20px;" class="text-center"><i class="icon-arrow-down12"></i></th>
								</tr>
							</thead>
							<tbody>
								@if(isset($classStudents))
                                    @foreach($classStudents as $classStudent)
                                		<tr class-student-id="{{ $classStudent->id }}">
											<td>
												<div class="media-left media-middle">
													<a class="btn bg-teal-400 btn-rounded btn-icon btn-xs" href="#">
														<div class="letter-icon">{{ strtoupper($classStudent->student->name[0]) }}</div>
													</a>
												</div>

												<div class="media-body media-middle">
													<h6 class="display-inline-block text-default text-semibold letter-icon-title student-name" href="#" style="margin-bottom: 3px; margin-top: 3px;">{{ $classStudent->student->name }}</h6>
												</div>
											</td>
											<td>
												<h6 class="no-margin current-attainment-level">{{ $classStudent->current_attainment_level or 'N/A'}}</h6>
											</td>
											<td>
												<h6 class="no-margin target-attainment-level">{{ $classStudent->target_attainment_level or 'N/A'}}</h6>
											</td>
											<td>
												<span class="pupil-premium">
													<i class="@if($classStudent->student->pupil_premium) icon-checkmark3 text-success @else icon-cross2 text-danger-400 @endif"></i>
												</span>
											</td>
											<td>
												<h6 class="no-margin ability-cap">{{ $classStudent->ability_cap }}</h6>
											</td>
											<td>
												<div class="btn-group">
							                    	<button type="button" class="btn btn-danger dropdown-toggle" data-toggle="dropdown">Options <span class="caret"></span></button>
							                    	<ul class="dropdown-menu dropdown-menu-right">
														<li><a class="delete-student"><i class="icon-user-minus"></i> Delete</a></li>
														<li><a class="edit-student"><i class="icon-pencil"></i> Edit</a></li>
													</ul>
												</div>
											</td>
										</tr>
									@endforeach
								@endif
							</tbody>
						</table>
						<form action="/student" method="POST" id="create-student">
							<input name="_token" value="{{ csrf_token() }}" hidden>
						    <div class="content">
						        <div class="row">
						            <div class="col-md-12">
						                <fieldset class="text-semibold">
						                    <legend><i class="icon-user-plus position-left"></i> Add Student</legend>
						                    <div class="tabbable tab-content-bordered">
												<ul class="nav nav-tabs nav-tabs-highlight">
													<li class="active">
														<a data-toggle="tab" href="#icon-only-tab1" title="" data-popup="tooltip" data-original-title="Information">
															<i class="icon-cog52"></i>
															<span class="visible-xs-inline-block position-right">Information</span>
														</a>
													</li>

													<li>
														<a data-toggle="tab" href="#icon-only-tab2" title="" data-popup="tooltip" data-original-title="Achievements">
															<i class="icon-stats-bars"></i>
															<span class="visible-xs-inline-block position-right">Achievements</span>
														</a>
													</li>

													<li>
														<a data-toggle="tab" href="#icon-only-tab3" title="" data-popup="tooltip" data-original-title="Picture">
															<i class="icon-stack-picture"></i>
															<span class="visible-xs-inline-block position-right">Picture</span>
														</a>
													</li>
												</ul>

												<div class="tab-content">
													<div id="icon-only-tab1" class="tab-pane has-padding active">
														<div class="row">
															<div class="col-md-6">
																<label class="display-block text-bold">Basic Information*</label>
																<input data-original-title="Enter the students name" class="form-control" data-popup="tooltip" title="" placeholder="Students Name" type="text" name="student_name" required>
																<br />
																<label class="display-block text-bold">Additional Information</label>
																<label class="checkbox-inline">
																    <input type="checkbox" class="styled" name="pupil_premium">
																    Pupil Premium
																</label>
															</div>
															<div class="col-md-6">
																<label class="display-block text-bold">Student Ability Tier</label>
																<div class="radio">
																	<label>
																		<input type="radio" checked="checked" name="ability_cap" value="H">
																		High
																	</label>
																</div>
																<div class="radio">
																	<label>
																		<input type="radio" name="ability_cap" value="M">
																		Medium
																	</label>
																</div>
																<div class="radio">
																	<label>
																		<input type="radio" name="ability_cap" value="L">
																		Low
																	</label>
																</div>
															</div>
														</div>
													</div>

													<div id="icon-only-tab2" class="tab-pane has-padding">
														<div class="row">
															<label class="display-block text-bold" style="margin-left: 10px;">Student Achievements</label>
															<div class="col-md-6">
																<div class="form-group">
																	<select class="form-control" name="current_attainment_level">
																		<optgroup label="Current Attainment Level">
																			<option value="" disabled selected>Select a current attainment level</option>
																			<option value="A*">A*</option>
																			<option value="A">A</option>
																			<option value="B">B</option>
																			<option value="C">C</option>
																			<option value="D">D</option>
																			<option value="E">E</option>
																			<option value="F">F</option>
																			<option value="G">G</option>
																			<option value="U">U</option>
																		</optgroup>
																	</select>
																</div>
															</div>
															<div class="col-md-6">
																<div class="form-group">
																	<select class="form-control" name="target_attainment_level">
																		<optgroup label="Target Level">
																			<option value="" disabled selected>Select a target level</option>
																			<option value="A*">A*</option>
																			<option value="A">A</option>
																			<option value="B">B</option>
																			<option value="C">C</option>
																			<option value="D">D</option>
																			<option value="E">E</option>
																			<option value="F">F</option>
																			<option value="G">G</option>
																			<option value="U">U</option>
																		</optgroup>
																	</select>
																</div>
															</div>
														</div>
													</div>

													<div id="icon-only-tab3" class="tab-pane has-padding">
														<div class="row">
															<label class="display-block text-bold" style="margin-left: 10px;">Student Image</label>
															<div class="col-md-6">
																<div class="form-group">
																	<input type="file" class="file-input" accept="image/*" name="student_image">
																</div>
															</div>
														</div>
													</div>
												</div>
											</div>
						                </fieldset>
						                <br />
						                <div class="text-right">
						                    <button type="submit" class="btn btn-primary">Submit form <i class="icon-arrow-right14 position-right"></i></button>
						                </div>
						            </div>
						        </div>
						    </div>
						</form>
					</div>
				</div>
				<div class="col-md-4">
                    <div class="tabbable">
                        <ul class="nav nav-pills nav-pills-bordered nav-stacked">
                            @if(isset($classes))
                                @foreach($classes as $key => $class)
                                    <li>
                                        <a href="/dashboard/classes/{{ $class->id }}" class="class-button @if($selectedClass->id == $class->id) class-button-active @endif" class-id="{{ $class->id }}">{{ $class->class_name }}</a>
                                        <div class="btn-group">
                                            <a href="javascript:;" class="btn btn-primary btn-icon dropdown-toggle @if($selectedClass->id == $class->id) class-options-active @else class-options @endif" data-toggle="dropdown" class-id="{{ $class->id }}">
                                                <i class="icon-menu7"></i>
                                                <span class="caret"></span>
                                            </a>
                                            <ul class="dropdown-menu dropdown-menu-right">
                                                <li><a href="#" class="duplicate-class" data-toggle="modal" data-target="#modal_form_inline">Duplicate class template</a></li>
                                                <li class="divider"></li>
                                                <li><a href="#" class="delete-seatingplan" data-toggle="modal" data-target="#modal_delete_seatingplan">Clear seating plan</a></li>
                                                <li><a href="#" class="delete-class" data-toggle="modal" data-target="#modal_delete_class">Delete class</a></li>
                                            </ul>
                                        </div> 
                                    </li>
                                @endforeach
                            	<li>
                            	<br />
                            @else
                            	<li>
                            @endif
                                <a href="javascript:;" class="class-button class-button-create" data-toggle="modal" data-target="#modal_form_inline">Create a new class</a>
                            </li>
                        </ul>
                    </div>
				</div>
			</div>
			<!-- /dashboard content -->


			<!-- Footer -->
			<div class="footer text-muted">
				&copy; 2015 SeatingPlanner by Toby Mellor
			</div>
			<!-- /footer -->
		</div>
		<!-- /content area -->
	</div>
	<!-- /main content -->
	<div id="modal_form_inline" class="modal fade">
		<div class="modal-dialog">
			<div class="modal-content text-center">
				<div class="modal-header bg-primary">
					<h5 class="modal-title">Enter information for the new class</h5>
				</div>

				<form action="/class" method="POST" class="form-inline">
					<input name="_token" value="{{ csrf_token() }}" hidden>
					<div class="modal-body">
						<label class="display-block text-bold">What's the classes name?*</label>
						<div class="form-group has-feedback">
							<input type="text" placeholder="Class name" class="form-control" name="class_name">
							<div class="form-control-feedback">
								<i class="icon-book text-muted"></i>
							</div>
						</div>
						@if(isset($classes))
							<br />
							<br />
							<div class="form-group">
								<label class="display-block text-bold">Should we take a seating template from another class?</label>
								<select class="form-control" name="class_template" id="template-picker">
									<optgroup label="Available class templates">
										<option value="" selected>Select a class template to copy</option>
										@foreach($classes as $class)
											<option value="{{ $class->id }}">{{ $class->class_name }}</option>
										@endforeach
									</optgroup>
								</select>
							</div>
						@endif
					</div>

					<div class="modal-footer text-center">
						<button type="submit" class="btn btn-primary">Create new class <i class="icon-plus22"></i></button>
					</div>
				</form>
			</div>
		</div>
	</div>
	<div id="modal_delete_class" class="modal fade">
		<div class="modal-dialog">
			<div class="modal-content text-center">
				<div class="modal-header bg-danger">
					<h5 class="modal-title">Are you sure you want to delete that class?</h5>
				</div>
				<input name="class_id" id="class-id-to-delete" value="" hidden>
				<div class="modal-body">
					<button type="button" class="btn">Cancel</button>
					<button type="button" class="btn btn-danger" onclick="submitDeleteForm('/class', 'The class has been deleted!'); location.reload();">Delete <i class="icon-x"></i></button>
				</div>
			</div>
		</div>
	</div>
	<div id="modal_delete_seatingplan" class="modal fade">
		<div class="modal-dialog">
			<div class="modal-content text-center">
				<div class="modal-header bg-danger">
					<h5 class="modal-title">Are you sure you want to delete the seating plan for that class?</h5>
				</div>
				<input name="class_id" id="class-object-id-to-delete" value="" hidden>
				<div class="modal-body">
					<button type="button" class="btn">Cancel</button>
					<button type="button" class="btn btn-danger" onclick="submitDeleteForm('/class-object', 'The seating plan for that class has been cleared')">Delete <i class="icon-x"></i></button>
				</div>
			</div>
		</div>
	</div>
@stop
@section('scripts')
	<script>
	    @if (session('errorMessage') != null)
	    	let errorValidationResponses = {!! session('errorValidationResponse') !!};
	    	var errorValidationResponse = '<br />';

	    	for(var key in errorValidationResponses) {
	    		errorValidationResponse += errorValidationResponses[key] + '<br />';
	    	}

	    	handleNotification('{{ session('errorMessage') }}<br />' + errorValidationResponse, 'error');
	    @endif
		@if (session('successMessage') != null)
	    	handleNotification('{{ session('successMessage') }}', 'success');
	    @endif
	</script>
	<script>
        $(document).ready(function()
        {
		    $('.duplicate-class').click(function()
	        {
	            $('#template-picker').val($(this)
	            	.parent()
	            	.parent()
	            	.parent()
	            	.children(0)
	            	.attr('class-id')
	            ).parent().hide();
	        });

	        $('.class-button-create').click(function()
	        {
	        	$('#template-picker').parent().show();
	        });

	        $('.delete-class').click(function()
	        {
	        	classId = $(this)
	            	.parent()
	            	.parent()
	            	.parent()
	            	.children(0)
	            	.attr('class-id');
	        });

	        $('.delete-seatingplan').click(function()
	        {
	        	classId = $(this)
	            	.parent()
	            	.parent()
	            	.parent()
	            	.children(0)
	            	.attr('class-id');
	        });

	        $('#create-student').submit(function(event){
		        event.preventDefault();

		        var formData = $('#create-student').serializeArray().reduce(function(obj, item) {
				    obj[item.name] = item.value;
				    return obj;
				}, {});

		        $.ajax({
		        	url: '/student',
		        	type: 'POST',
		        	data: {
						_token: token,
						student_name: formData['student_name'],
						pupil_premium: formData['pupil_premium'],
						class_id: formData['class_id'],
						ability_cap: formData['ability_cap'],
						current_attainment_level: formData['current_attainment_level'],
						target_attainment_level: formData['target_attainment_level']
		        	}
		        }).done(function(data) {
					if(data == "") {
						handleNotification(formData['student_name'] + ' has been added to the class!', 'success');
						$.get('/html-snippets/table_element.html', function(html) {
	                        html = html.replace('%firstLetter%', formData['student_name'].charAt(0).toUpperCase())
	                        		   .replace('%studentName%', formData['student_name'])
	                        		   .replace('%pupilPremium%', (formData['pupil_premium'] ? 'icon-checkmark3 text-success' : 'icon-cross2 text-danger-400'))
	                        		   .replace('%abilityCap%', formData['ability_cap'])
	                        		   .replace('%currentAttainmentLevel%', (formData['current_attainment_level'] === undefined) ? 'N/A' : formData['current_attainment_level'])
	                        		   .replace('%targetAttainmentLevel%', (formData['target_attainment_level'] === undefined) ? 'N/A' : formData['target_attainment_level']);
	                        $(html).appendTo('tbody').fadeIn();
	                    });
	                    $('#create-student').trigger('reset');
	                    $('a[data-original-title="Information"]').tab('show')
					} else {
						data = JSON.parse(data);
						var errorMessage = data[0] + '<br />';
						errorMessage += $.map(data[1], function(e){
						    return e;
						}).join('<br />');

						handleNotification(errorMessage, 'error');
					}
		        });
		    });

	        $('.delete-student').click(function()
	        {

	        });

	        $('.edit-student').click(function()
	        {
                classStudent = $(this).closest('tr');
                classStudentId = classStudent.attr('class-student-id');

                var length = classStudent.children('td').length;
                classStudent.children('td').each(function (index) {
                    if (index != length - 1) {
                        var editableInput = $(this).find('h6, span');

                        if(editableInput.hasClass('current-attainment-level')
                                || editableInput.hasClass('target-attainment-level')) {
                            editableInput.html(
                                '<select class="form-control" name="' + (editableInput.hasClass('current-attainment-level') ? 'current_attainment_level' : 'target_attainment_level') + '" value="' + editableInput.html() + '">' +
                                    '<optgroup label="Choose">' +
                                        '<option selected="" value="A*">A*</option>' + 
                                        '<option value="A">A</option>' + 
                                        '<option value="B">B</option>' +
                                        '<option value="C">C</option>' +
                                        '<option value="D">D</option>' +
                                        '<option value="E">E</option>' +
                                        '<option value="F">F</option>' +
                                        '<option value="G">G</option>' +
                                        '<option value="U">U</option>' +
                                    '</optgroup>' +
                                '</select>'
                            );
                        } else if(editableInput.hasClass('pupil-premium')) {
                            editableInput.html('<input class="styled" type="checkbox" name="pupil_premium">');
                        } else if(editableInput.hasClass('ability-cap')) {
                            editableInput.html(
                                '<select class="form-control" name="ability_cap">' +
                                    '<optgroup label="Ability Cap">' +
                                        '<option selected="" value="H">H</option>' + 
                                        '<option value="M">M</option>' + 
                                        '<option value="L">L</option>' +
                                    '</optgroup>' +
                                '</select>'
                            );
                        } else {
                            editableInput.html('<input class="form-control" type="text" placeholder="Students Name" title="" data-popup="tooltip" data-original-title="Enter the students name" value="' + editableInput.html() + '">');
                        }
                    } else {
                       classStudent.children().last().html('<button class="btn btn-success student-save">Save</button>');
                    }
                });
	        });

            $(document).on('click', '.student-save', function() {
                classStudentId = $(this).closest('tr').attr('class-student-id');

                updateStudentInformation(classStudentId);
                console.log('nice');
            });
        });

        var classId = {{ $classId }};
        var token = '{{ csrf_token() }}';

        function updateStudentInformation(classStudentId)
        {
            console.log(classStudentId);
            classStudent = $('tr[class-student-id=' + classStudentId + ']');

            var studentName = classStudent.find('.student-name').children().first().val();
            var pupilPremium = classStudent.find('.pupil-premium').children().first().val();
            var abilityCap = classStudent.find('.ability-cap').children().first().find(":selected").text();
            var currentAttainmentLevel = classStudent.find('.current-attainment-level').children().first().find(":selected").text();
            var targetAttainmentLevel = classStudent.find('.target-attainment-level').children().first().find(":selected").text();
            console.log(classStudentId);
            console.log(studentName);
            console.log(pupilPremium);
            console.log(classId);
            console.log(abilityCap);
            console.log(currentAttainmentLevel);
            console.log(targetAttainmentLevel);

        	$.ajax({
                url: '/class-student',
                type: 'PUT',
                data: {
                    _token: token,
                    class_student_id: classStudentId,
                    student_name: studentName,
                    pupil_premium: pupilPremium,
                    class_id: classId,
                    ability_cap: abilityCap,
                    current_attainment_level: currentAttainmentLevel,
                    target_attainment_level: targetAttainmentLevel
                }
            }).done(function(data) {

            console.log('test2');
            	classStudent.find('.student-save').parent().html(
                    '<div class="btn-group">' + 
                        '<button type="button" class="btn btn-danger dropdown-toggle" data-toggle="dropdown">Options <span class="caret"></span></button>' +
                        '<ul class="dropdown-menu dropdown-menu-right">' +
                            '<li><a class="delete-student"><i class="icon-user-minus"></i> Delete</a></li>' +
                            '<li><a class="edit-student"><i class="icon-pencil"></i> Edit</a></li>' +
                        '</ul>' +
                    '</div>'
                );
            });
        }

        function submitDeleteForm(URL, successMessage)
        {                
        	$.ajax({
                url: URL,
                type: 'DELETE',
                data: {
                    _token: token,
                    class_id: classId
                }
            }).done(function(data) {
            	handleNotification(successMessage, 'success')
            });
        }

	    function handleNotification(notificationContent, type)
	    {
		    var n = noty({
			    text: notificationContent,
			    layout: 'topCenter',
			    type: type
			});

			setTimeout(function() {
				n.close();
			}, 5000);
	    }
    </script>

@stop