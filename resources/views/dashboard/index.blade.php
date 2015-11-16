@extends('template.dashboard')

@section('title', 'Dashboard')
@section('main')
	<!-- Main content -->
	<div class="content-wrapper">

		<!-- Page header -->
		<div class="page-header">
			<div class="breadcrumb-line">
				<ul class="breadcrumb">
					<li><a href="index.html"><i class="icon-home2 position-left"></i> Home</a></li>
					<li class="active">Dashboard</li>
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
					<div class="panel panel-white">
						<div class="panel-heading">
							<h6 class="panel-title"><span class="text-semibold">Seating Planner</span> <span class="text-muted"><small>Year 11<small></span></h6>
							<div class="heading-elements">
								<ul class="pagination pagination-flat pagination-sm">
									<li><a href="#">←</a></li>
									<li class="active"><a href="#">1</a></li>
									<li><a href="#">2</a></li>
									<li><a href="#">3</a></li>
									<li><a href="#">→</a></li>
								</ul>
								<ul class="icons-list" style="margin-top: 11px;">
									<li>
										<a data-action="reload"></a>
									</li>
								</ul>
							</div>
							<a class="heading-elements-toggle"><i class="icon-menu"></i></a></div>

							<style>
								.no-antialias { 
								    image-rendering: optimizeSpeed;
								    image-rendering: -moz-crisp-edges;
								    image-rendering: -o-crisp-edges;
								    image-rendering: -webkit-optimize-contrast;
								    image-rendering: pixelated;
								    image-rendering: optimize-contrast;
								    -ms-interpolation-mode: nearest-neighbor;

								}
								.drag-item, .outside-drag-item {
								    position: absolute;
								    background-image: url('assets/images/objects/teacher-desk-1.png');
								    background-size: 64px;
								    width: 64px ;
								    height: 64px;
								    cursor: move;
								}
								.drop-target {
									left: 0px; top: 0px;
								    position: absolute;
								    width: 736px;
								    height: 736px;
								    border: dashed 1px orange;
								    background: whitesmoke url('assets/images/objects/grid_64.png') repeat;
								    background-size: 32px 32px;
								    
								}
							</style>
						<div class="panel-body" style="height:960px; overflow-x: scroll;">
							<div class="drop-target">
							    <div class="drag-item" object-id="1"></div>
							    <div class="drag-item" object-id="2"></div>
							</div>
						</div>
					</div>
				</div>
				<div class="col-md-4">
					<div class="tabbable">
						<ul class="nav nav-pills nav-stacked">
							@if(isset($classes))
								{{ $classCount = 0 }}
                                @foreach($classes as $class)
									{{ $classCount++ }}
									<li @if($classCount == 1) class="active" @endif style="background-color:#FFF; border:solid #DDD; border-radius: 3px; border-width: 1px; border- box-shadow: 0 1px 1px rgba(0, 0, 0, 0.05);"><a data-toggle="tab"><i class="icon-book position-left"></i> {{ $class->class_name }}</a></li>
								@endforeach
							@endif
						</ul>
					</div>
					<div class="panel panel-white">
						<div id="selected-id" style="display: none;"></div>
						<div class="panel-heading">
							<h6 class="panel-title">
								Selected Object
								<span class="text-muted">
									<small class="selected-name">Student Desk</small>
								</span>
							</h6>
							<div class="heading-elements">
								<ul class="icons-list">
			                		<li><a title="" data-popup="tooltip" data-action="move" href="#" data-original-title="Move" class="ui-sortable-handle"></a></li>
			                		<li><a title="" data-popup="tooltip" data-action="collapse" data-original-title="Collapse" class=""></a></li>
			                	</ul>
			                	<form class="heading-form" action="#" hidden>
									<div class="form-group">
										<label class="checkbox-inline checkbox-switchery checkbox-right switchery-xs">
											<input type="checkbox" class="switchery" checked="checked">
											Enable editable:
										</label>
									</div>
								</form>
		                	</div>
							<a class="heading-elements-toggle"><i class="icon-menu"></i></a>
						</div>
						
						<div class="panel-body">
							<div class="col-lg-3 col-sm-6">
								<div class="thumbnail" style="margin-top: 5px;">
									<div class="thumb">
										<img id="selected-image" src="assets/images/objects/desk-1.png" alt="" class="no-antialias">
									</div>
								</div>
							</div>
							<div class="col-lg-9 col-sm-6">
								<h5 class="no-margin">
									<name class="selected-name">Student Desk</name>
									<small>Settings</small>
								</h4>
								{{-- <a href="#" id="type-range" data-type="range" data-inputclass="form-control" data-pk="1" data-title="Range">Size</a> --}}
								<table class="table table-bordered table-striped">
									<thead>
										<tr>
											<th>Setting</th>
											<th>Value</th>
										</tr>
									</thead>
									<tbody>
										<tr>
											<td>Size</td>
											<td>
												<input id="selected-size" class="form-control" type="range" max="3" min="1" name="range">
											</td>
										</tr>
										<tr>
											<td>Rotation</td>
											<td>
												<button id="selected-rotation-left" class="btn btn-default btn-sm" type="button" style="padding: 3px 6px;">
													<i class="icon-reply position-left"></i>
													Left 90˚
												</button>
												<button id="selected-rotation-right" class="btn btn-default btn-sm" type="button" style="padding: 3px 6px; margin-top: 10px;">
													<i class="icon-forward position-left"></i>
													Right 90˚
												</button>
											</td>
										</tr>
										<tr>
											<td>Location</td>
											<td id="selected-position">
												<strong>X:</strong> 1<br />
												<strong>Y:</strong> 6
											</td>
										</tr>
										<tr>
											<td>Action</td>
											<td>
												<button id="selected-delete" class="btn btn-danger btn-sm" type="button" style="padding: 3px 6px;">
													Delete
													<i class="icon-diff-removed position-right"></i>
												</button>
											</td>
										</tr>
									</tbody>
								</table>
							</div>
						</div>
					</div>
					<div class="panel panel-white">
						<div class="panel-heading">
							<h6 class="panel-title">Students</h6>
							<div class="heading-elements">
								<form action="#" class="heading-form" style="margin-left: 0px; margin-right: -12px;">
									<div class="form-group has-feedback">
										<input type="search" placeholder="Search..." class="form-control" style="width: 180px;">
										<div class="form-control-feedback">
											<i class="icon-search4 text-size-base text-muted"></i>
										</div>
									</div>
								</form>
								<ul class="icons-list">
			                		<li><a title="" data-popup="tooltip" data-action="move" href="#" data-original-title="Move" class="ui-sortable-handle"></a></li>
			                		<li><a title="" data-popup="tooltip" data-action="collapse" data-original-title="Collapse" class=""></a></li>
			                	</ul>
							</div>
						<a class="heading-elements-toggle"><i class="icon-menu"></i></a></div>
						
						<div class="panel-body">
							@if(isset($classStudents))
								@foreach($classStudents as $classStudent)
									<div class="col-lg-4 col-sm-6">
										<div class="thumbnail">
											<div class="thumb">
												<img alt="" src="http://placehold.it/200x200">
												<div class="caption-overflow">
													<span>
														<a class="btn border-white text-white btn-flat btn-icon btn-rounded" data-popup="lightbox" href="assets/images/demo/flat/1.png"><i class="icon-plus3"></i></a>
													</span>
												</div>
											</div>

											<div class="caption" style="padding: 5px;">
												<p style="font-size: 10px; overflow: hidden; white-space: nowrap; width: 100%; text-overflow: ellipsis; margin-bottom: 0px;">{{ $classStudent->student->name }}</p>
											</div>
										</div>
									</div>
								@endforeach
								<div class="text-center">
									{!! $classStudents->render() !!}
								</div>
							@endif
						</div>
					</div>
					<!-- /editable inputs -->
					<div class="panel panel-white">
						<div class="panel-heading">
							<h6 class="panel-title">Objects</h6>
							<div class="heading-elements">
								<form action="#" class="heading-form" style="margin-left: 0px; margin-right: -12px;">
									<div class="form-group has-feedback">
										<input type="search" placeholder="Search..." class="form-control" style="width: 180px;">
										<div class="form-control-feedback">
											<i class="icon-search4 text-size-base text-muted"></i>
										</div>
									</div>
								</form>
								<ul class="icons-list">
			                		<li><a title="" data-popup="tooltip" data-action="move" href="#" data-original-title="Move" class="ui-sortable-handle"></a></li>
			                		<li><a title="" data-popup="tooltip" data-action="collapse" data-original-title="Collapse" class=""></a></li>
			                	</ul>
							</div>
						<a class="heading-elements-toggle"><i class="icon-menu"></i></a></div>
						
						<div class="panel-body">
							<!-- object -->
							<div class="col-lg-4 col-sm-6">
								<div class="thumbnail">
									<div class="thumb">
										<img class="no-antialias" alt="" src="assets/images/objects/desk-1.png">
										<div class="caption-overflow">
											<span>
												<a class="btn border-white text-white btn-flat btn-icon btn-rounded" data-popup="lightbox" href="assets/images/demo/flat/1.png"><i class="icon-plus3"></i></a>
											</span>
										</div>
									</div>

									<div class="caption" style="padding-top: 5px; padding-bottom: 5px; padding-left: 5px;">
										<h6 class="no-margin"><a href="#" class="text-default" style="font-size: 10px;">Student Desk</a></h6>
									</div>
								</div>
							</div>
							<!-- /object -->
							<!-- object -->
							<div class="col-lg-4 col-sm-6">
								<div class="thumbnail">
									<div class="thumb">
										<img class="no-antialias" alt="" src="assets/images/objects/sofa-1.png">
										<div class="caption-overflow">
											<span>
												<a class="btn border-white text-white btn-flat btn-icon btn-rounded" data-popup="lightbox" href="assets/images/demo/flat/1.png"><i class="icon-plus3"></i></a>
											</span>
										</div>
									</div>

									<div class="caption" style="padding-top: 5px; padding-bottom: 5px; padding-left: 5px;">
										<h6 class="no-margin"><a href="#" class="text-default" style="font-size: 10px;">Sofa</a></h6>
									</div>
								</div>
							</div>
							<!-- /object -->
							<!-- object -->
							<div class="col-lg-4 col-sm-6">
								<div class="thumbnail">
									<div class="thumb">
										<img class="no-antialias" alt="" src="assets/images/objects/chair-1.png">
										<div class="caption-overflow">
											<span>
												<a class="btn border-white text-white btn-flat btn-icon btn-rounded" data-popup="lightbox" href="assets/images/demo/flat/1.png"><i class="icon-plus3"></i></a>
											</span>
										</div>
									</div>

									<div class="caption" style="padding-top: 5px; padding-bottom: 5px; padding-left: 5px;">
										<h6 class="no-margin"><a href="#" class="text-default" style="font-size: 10px;">Chair</a></h6>
									</div>
								</div>
							</div>
							<!-- /object -->
							<!-- object -->
							<div class="col-lg-4 col-sm-6">
								<div class="thumbnail">
									<div class="thumb">
										<img class="no-antialias" alt="" src="assets/images/objects/teacher-desk-1.png">
										<div class="caption-overflow">
											<span>
												<a class="btn border-white text-white btn-flat btn-icon btn-rounded" data-popup="lightbox" href="assets/images/demo/flat/1.png"><i class="icon-plus3"></i></a>
											</span>
										</div>
									</div>

									<div class="caption" style="padding-top: 5px; padding-bottom: 5px; padding-left: 5px;">
										<h6 class="no-margin"><a href="#" class="text-default" style="font-size: 10px;">Teacher Desk</a></h6>
									</div>
								</div>
							</div>
							<!-- /object -->
						</div>
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

@stop
@section('scripts')

	<script>
		$(document).ready(function() {
			$('.drag-item').click(function() {
				updateSelected($(this));
			});
			$('#selected-size').on('click', function() {
				console.log('yo');
				var value = $('#selected-size').val();
				var width;
				var height;

				if(value == 1) {
					width = 32;
					height = 32;
				} else if(value == 2) {
					width = 64;
					height = 64;
				} else {
					width = 128;
					height = 128;
				}

				console.log($('#selected-id').html());

			    $('div[object-id="' + $('#selected-id').html() + '"]')
			    	.css('width', width)
			    	.css('height', height)
			    	.css('background-size', width);
			});
		});

  		var token = '{{ csrf_token() }}';
    	var objects = {
    		'1': {
    			'name': 'Teacher Desk',
    			'width': 64,
    			'height': 32,
    			'image': 'http://seatingplanner.dev/assets/images/objects/teacher-desk-1.png'
	    	},
    		'2': {
    			'name': 'Student Desk',
    			'width': 64,
    			'height': 64,
    			'image': 'http://seatingplanner.dev/assets/images/objects/desk-1.png'
	    	}
	    }

	    var objectLocations;

	    $(".drag-item").draggable({
	        grid: [32, 32],
	        containment: '.drop-target',
	        drag: function(){
	        	//TODO: Only update if position has changed
	            updateSelected($(this));
	        }
	    });

	    function saveObjects(){}

	    function updateSelected(object) {
	    	var objectId = object.attr('object-id');

	    	var objectHeight = object.height();
	    	var objectWidth = object.width();
	    	var value;

            var position = object.position();
            var xPos = position.left / 32;
            var yPos = position.top / 32;

	    	if(objectHeight == objectWidth) {
	    		if(objectHeight == 32) {
	    			value = 1;
	    		} else if(objectHeight == 64) {
	    			value = 2;
	    		} else {
	    			value = 3;
	    		}
	    	}

	    	console.log(value);

	    	$('#selected-size').val(value);

            $('#selected-position').html('\
            	<td>\
					<strong>X:</strong> ' + xPos + '<br>\
					<strong>Y:</strong> ' + yPos + '\
				</td>\
			');

			$('#selected-image').attr('src', object.css('background-image').replace('url("','').replace('")',''));

			$('.selected-name').text(objects[objectId]['name']);

			console.log('changing selected id to' + objectId);
			$('#selected-id').text(objectId);
	    }

	    function deleteSelected(){}
	</script>

@stop