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
								<span class="text-semibold">Class</span>
								<span class="text-muted">
									<small>Year 11<small>
								</span>
							</h6>
							<div class="heading-elements">
								<button class="btn btn-link daterange-ranges heading-btn text-semibold" type="button">
									<i class="icon-calendar3 position-left"></i> <span>Next Period: Undefined</span>
								</button>
		                	</div>
						<a class="heading-elements-toggle"><i class="icon-menu"></i></a></div>

						<div class="table-responsive">
							<table class="table table-xlg text-nowrap">
								<tbody>
									<tr>
										<td class="col-md-3">
											<div class="media-left media-middle">
												<a class="btn border-indigo-400 text-indigo-400 btn-flat btn-rounded btn-xs btn-icon" href="#"><i class="icon-users"></i></a>
											</div>

											<div class="media-left">
												<h5 class="text-semibold no-margin">
													32 <small class="display-block no-margin">students</small>
												</h5>
											</div>
										</td>

										<td class="col-md-3">
											<div class="media-left media-middle">
												<a class="btn border-indigo-400 text-indigo-400 btn-flat btn-rounded btn-xs btn-icon" href="#"><i class="icon-alarm-add"></i></a>
											</div>

											<div class="media-left">
												<h5 class="text-semibold no-margin">
													1,132 <small class="display-block no-margin">total tickets</small>
												</h5>
											</div>
										</td>

										<td class="col-md-3">
											<div class="media-left media-middle">
												<a class="btn border-indigo-400 text-indigo-400 btn-flat btn-rounded btn-xs btn-icon" href="#"><i class="icon-spinner11"></i></a>
											</div>

											<div class="media-left">
												<h5 class="text-semibold no-margin">
													06:25:00 <small class="display-block no-margin">response time</small>
												</h5>
											</div>
										</td>

										<td class="text-right col-md-2">
											<a class="btn bg-teal-400" href="#"><i class="icon-statistics position-left"></i> View Seating Plan</a>
										</td>
									</tr>
								</tbody>
							</table>	
						</div>

						<div class="table-responsive">
							<table class="table text-nowrap">
								<thead>
									<tr>
										<th style="width: 300px;">Student</th>
										<th>CAL</th>
										<th>Target</th>
										<th>PP</th>
										<th>Ability Tier</th>
										<th style="width: 20px;" class="text-center"><i class="icon-arrow-down12"></i></th>
									</tr>
								</thead>
								<tbody>
									<tr>
										<td>
											<div class="media-left media-middle">
												<a class="btn bg-teal-400 btn-rounded btn-icon btn-xs" href="#">
													<span class="letter-icon">A</span>
												</a>
											</div>

											<div class="media-body">
												<a class="display-inline-block text-default text-semibold letter-icon-title" href="#">Toby Mellor</a>
												<div class="text-muted text-size-small"><span class="status-mark border-blue position-left"></span> Active</div>
											</div>
										</td>
										<td class="text-center">
											<h6 class="no-margin">B</h6>
										</td>
										<td class="text-center">
											<h6 class="no-margin">A</h6>
										</td>
										<td class="text-center">
											<i class="icon-checkmark3 text-success"></i>
										</td>
										<td class="text-center">
											<h6 class="no-margin">H</h6>
										</td>
										<td class="text-center">
											<ul class="icons-list">
												<li class="dropdown">
													<a data-toggle="dropdown" class="dropdown-toggle" href="#"><i class="icon-menu7"></i></a>
													<ul class="dropdown-menu dropdown-menu-right">
														<li><a href="#"><i class="icon-undo"></i> Quick reply</a></li>
														<li><a href="#"><i class="icon-history"></i> Full history</a></li>
														<li class="divider"></li>
														<li><a href="#"><i class="icon-checkmark3 text-success"></i> Resolve issue</a></li>
														<li><a href="#"><i class="icon-cross2 text-danger"></i> Close issue</a></li>
													</ul>
												</li>
											</ul>
										</td>
									</tr>
								</tbody>
							</table>
						</div>
						<form action="/student" method="POST">
							<!-- TODO: Load class id -->
							<input type="text" name="class_id" value="1" hidden>
							<input name="_token" value="{{ csrf_token() }}" hidden>
						    <div class="content">
						        <div class="row">
						            <div class="col-md-12">
						                <fieldset class="text-semibold">
						                    <legend><i class="icon-user-plus position-left"></i> Add Student</legend>
						                    <div class="form-group">
												<input type="text" placeholder="Student Name" title="" data-popup="tooltip" class="form-control" data-original-title="Enter the students name">
											</div>
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
																<label class="display-block text-bold">Student Information</label>
																<input data-original-title="Enter the students name" class="form-control" data-popup="tooltip" title="" placeholder="Students Name" type="text" name="student_name">
																<label class="checkbox-inline">
																    <input type="checkbox" class="styled" name="pupil_premium">
																    Pupil Premium
																</label>
															</div>
															<div class="col-md-6">
																<label class="display-block text-bold">Student Ability Tier</label>
																<div class="radio">
																	<label>
																		<input type="radio" checked="checked" name="ability_cap_high">
																		High
																	</label>
																</div>
																<div class="radio">
																	<label>
																		<input type="radio" name="ability_cap_medium">
																		Medium
																	</label>
																</div>
																<div class="radio">
																	<label>
																		<input type="radio" name="ability_cap_low">
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
						<ul class="nav nav-pills nav-stacked">
							<li class="active"><a data-toggle="tab" href="#stacked-labels-pill1"><i class="icon-book position-left"></i> Year 11</a></li>
							<li style="background-color:#FFF; border:solid #DDD; border-radius: 3px; border-width: 1px; border- box-shadow: 0 1px 1px rgba(0, 0, 0, 0.05);"><a data-toggle="tab" href="#stacked-labels-pill2"><i class="icon-book2 position-left"></i> <span class="label label-info pull-right">New</span> Year 12</a></li>
							<li style="background-color:#FFF; border:solid #DDD; border-radius: 3px; border-width: 1px; border- box-shadow: 0 1px 1px rgba(0, 0, 0, 0.05);"><a data-toggle="tab" href="#stacked-labels-pill2"><i class="icon-book3 position-left"></i>Year 7</a></li>
						</ul>
					</div>
				</div>
			</div>
			<!-- /dashboard content -->


			<!-- Footer -->
			<div class="footer text-muted">
				&copy; 2015. SeatingPlanner by Toby Mellor
			</div>
			<!-- /footer -->
		</div>
		<!-- /content area -->
	</div>
	<!-- /main content -->

@stop
@section('scripts')

	<script>
	    $(".drag-item").draggable({
	        grid: [32, 32],
	        containment: '.drop-target',
	        drag: function(){
	            var position = $(this).position();
	            var xPos = position.left;
	            var yPos = position.top;
	            console.log('x: ' + xPos / 32 + ' | y: ' + yPos / 32);
	        }
	    });
	</script>

@stop