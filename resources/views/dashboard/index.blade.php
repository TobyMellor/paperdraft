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
										<i class="glyphicon glyphicon-floppy-save" id="save-button" style="cursor: pointer;"></i>
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
						<div class="panel-body" style="height: 736px; overflow-x: scroll;">
							<div class="drop-target">
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
										<!--
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
										-->
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
							@if(isset($objects))
								@foreach($objects as $object)
									<div class="col-lg-4 col-sm-6">
										<div class="thumbnail">
											<div class="thumb">
												<img class="no-antialias" src="assets/images/objects/{{ $object->object_location }}">
												<div class="caption-overflow">
													<span>
														<a class="btn border-white text-white btn-flat btn-icon btn-rounded create-active-object" href="javascript:;" object-id={{ $object->id }}><i class="icon-plus3"></i></a>
													</span>
												</div>
											</div>

											<div class="caption" style="padding-top: 5px; padding-bottom: 5px; padding-left: 5px;">
												<h6 class="no-margin"><a href="#" class="text-default" style="font-size: 10px;">{{ $object->object_name }}</a></h6>
											</div>
										</div>
									</div>
								@endforeach
							@endif
						</div>
					</div>
				</div>
			</div>
			<!-- /dashboard content -->


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
		$(document).ready(function() {
			$('.drop-target').on('click', '.drag-item', function(){
				updateSelected($(this));
			});

			$('#selected-delete').click(function() {
				deleteSelected($('#selected-id').html());
			});

			$('#save-button').click(function() {
				saveActiveObjects();
			});

			//TODO: Implement size saving
			$('#selected-size').on('change', function() {
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

			    $('div[active-object-id="' + $('#selected-id').html() + '"]')
			    	.css('width', width)
			    	.css('height', height)
			    	.css('background-size', width);
			});

			$('.create-active-object').click(function() {
				var objectId = parseInt($(this).attr('object-id'));

				createActiveObject(objectId, 0, 0);
			});
		});

  		var token = '{{ csrf_token() }}';
	    var objects = [];
    	var activeObjects = []

    	//TODO: Allow for multiple classes
    	var classId = 1;

	    loadObjects();

	    function createActiveObject(objectId, objectPositionX, objectPositionY) {
	    	activeObjects[activeObjects.length] = {
            	'object_id': objectId,
            	'active_object_id': null,
            	'object_position_x': objectPositionX,
            	'object_position_y': objectPositionY
	    	}

	    	var object = objects[activeObjects[activeObjects.length - 1]['object_id']];
	    	var objectLocation = object['object_location'];
	    	var objectWidth = object['object_width'];
	    	var objectHeight = object['object_height'];
			            
            $('.drop-target').append('\
            	<div class="drag-item" active-object-id="' + (activeObjects.length - 1) + '" style="left: ' + objectPositionX + 'px; top: ' + objectPositionY + 'px; background-image: url(\'/assets/images/objects/' + objectLocation + '\'); background-size: ' + objectWidth + 'px; height: ' + objectHeight + 'px; width: ' + objectWidth + 'px;"></div>\
            ');
			initializeDraggable();
	    }

	    function loadObjects() {
	    	$.ajax({
                url: '/object',
                type: 'GET',
                data: {
                    _token: token
                }
            }).done(function(data) {
            	for (var dataObjects in data) {
			        if (data.hasOwnProperty(dataObjects)) {
			            var object = data[dataObjects];

			            objects[object['id']] = {
			            	'object_name': object['object_name'],
			            	'object_height': object['object_height'],
			            	'object_width': object['object_width'],
			            	'object_location': object['object_location']
			            };
			        }
			    }
            	loadActiveObjects();
            });
	    }

	    function loadActiveObjects() {
            $.ajax({
                url: '/class-object',
                type: 'GET',
                data: {
                    _token: token
                }
            }).done(function(data) {
		    	for (var activeObject in data) {
			        if (data.hasOwnProperty(activeObject)) {
			            var activeObject = data[activeObject];
			            var objectId = activeObject['object_id'];
			            var activeObjectId = activeObject['id']
			            var objectPositionX = activeObject['object_position_x'] * 32;
			            var objectPositionY = activeObject['object_position_y'] * 32;
			            var objectLocation = objects[objectId]['object_location'];
			            var objectWidth = objects[objectId]['object_width'];
			            var objectHeight = objects[objectId]['object_height'];

			            activeObjects[activeObjects.length] = {
			            	'object_id': objectId,
			            	'active_object_id': activeObjectId,
			            	'object_position_x': objectPositionX / 32,
			            	'object_position_y': objectPositionY / 32
			            };

			            $('.drop-target').append('\
			            	<div class="drag-item" active-object-id="' + (activeObjects.length - 1) + '" style="left: ' + objectPositionX + 'px; top: ' + objectPositionY + 'px; background-image: url(\'/assets/images/objects/' + objectLocation + '\'); background-size: ' + objectWidth + 'px; height: ' + objectHeight + 'px; width: ' + objectWidth + 'px;"></div>\
			            ');
			        }
			    }
			    initializeDraggable();
            });
	    }

	    function initializeDraggable()
	    {
	    	$(".drag-item").draggable({
		        grid: [32, 32],
		        containment: '.drop-target',
		        drag: function(){
		        	var activeObjectId = $(this).attr('active-object-id');
		        	var objectPositionX = $(this).position().left / 32;
		        	var objectPositionY = $(this).position().top / 32;

		        	//TODO: Disallow moving objects into positions with other objects within them
		        	//TODO: Connect objects that are next to eachother

		        	if(objectPositionX != activeObjects[activeObjectId]['object_position_x']
		        			|| objectPositionY != activeObjects[activeObjectId]['object_position_y']) {
						updateSelected($(this));
		        	}
		        }
		    });
	    }

	    //TODO: Save to database on window close
	    //TODO: What happens if you save multiple times in one session?
	    function saveActiveObjects()
	    {
	    	$.ajax({
                url: '/object',
                type: 'POST',
                data: {
                    _token: token,
                    objects: activeObjects,
                    class_id: classId
                }
            }).done(function(returnedActiveObjects) {
            	activeObjects = returnedActiveObjects;
            });
	    }

	    function updateSelected(activeObject) {
	    	var activeObjectId = activeObject.attr('active-object-id');

	    	var activeObjectHeight = activeObject.height();
	    	var activeObjectWidth = activeObject.width();
	    	var value;

            var position = activeObject.position();
            var objectPositionX = position.left / 32;
            var objectPositionY = position.top / 32;

            activeObjects[activeObjectId]['object_position_x'] = objectPositionX;
            activeObjects[activeObjectId]['object_position_y'] = objectPositionY;

            //TODO: There's definately a better way of doing this.
	    	if(activeObjectHeight == activeObjectWidth) {
	    		if(activeObjectHeight == 32) {
	    			value = 1;
	    		} else if(activeObjectHeight == 64) {
	    			value = 2;
	    		} else {
	    			value = 3;
	    		}
	    	}

	    	$('#selected-size').val(value);
            $('#selected-position').html('\
            	<td>\
					<strong>X:</strong> ' + objectPositionX + '<br>\
					<strong>Y:</strong> ' + objectPositionY + '\
				</td>\
			');
			$('#selected-image').attr('src', '/assets/images/objects/' + objects[activeObjects[activeObjectId]['object_id']]['object_location']);
			$('.selected-name').text(objects[activeObjects[activeObjectId]['object_id']]['object_name']);
			$('#selected-id').text(activeObjectId);
	    }

	    function deleteSelected(activeObjectId) {
	    	$('div[active-object-id="' + activeObjectId + '"]').fadeOut();
	    	delete activeObjects[activeObjectId];
	    	//TODO: Delete from database
	    }
	</script>

@stop