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
									cursor: crosshair;
								    position: absolute;
								    width: 736px;
								    height: 736px;
								    border: dashed 1px orange;
								    background: whitesmoke url('assets/images/objects/grid_64.png') repeat;
								    background-size: 32px 32px;
								    
								}
								.outline-highlight {
									-webkit-filter: drop-shadow(1px 1px 0 yellow) drop-shadow(-1px -1px 0 yellow);
	    							filter:drop-shadow(1px 1px 0 yellow) drop-shadow(-1px -1px 0 yellow);
    							}
							</style>
						<div class="panel-body" style="height: 736px; overflow-x: scroll;">
							<div class="drop-target" id="paper">
							</div>
						</div>
					</div>
				</div>
				<div class="col-md-4">
					<div class="tabbable">
						<style>
							.nav-pills-bordered > li > a {
							    background-color: #fff;
							}
							.nav-pills > li > .btn-group {
							    position: absolute;
							    right: 0;
							    top: 0;
							}
							.nav-pills > li > .btn-group > .btn {
							    padding: 10px 15px;
							    border-radius: 0 3px 3px 0;
							}
							.class-button {
								background-color: #fcfcfc !important;
							    border-color: #ddd !important;
							    color: #333 !important;
							}
							.class-button-active {
								background-color: #2196f3 !important;
								border-radius: 5px !important;
								border: 1px solid #2196f3 !important;
								color: #fff !important;
							}
							.class-options {
								background-color: #fcfcfc !important;
							    border-color: #ddd !important;
							    color: #333 !important;
								padding: 9px 10px 9px 15px !important;
							}
							.class-options-active {
								padding: 9px 10px 9px 15px !important;
								background-color: #0e7ed5 !important;
							}
						</style>
						<ul class="nav nav-pills nav-pills-bordered nav-stacked">
							@if(isset($classes))
						        @foreach($classes as $key => $class)
								    <li>
								        <a href="javascript:;" class="class-button @if($key == 0) class-button-active @endif" class-id="{{ $class->id }}">{{ $class->class_name }}</a>
									    <div class="btn-group">
									        <a href="javascript:;" class="btn btn-primary btn-icon dropdown-toggle @if($key == 0) class-options-active @else class-options @endif" data-toggle="dropdown" class-id="{{ $class->id }}">
									            <i class="icon-menu7"></i>
									            <span class="caret"></span>
									        </a>
									        <ul class="dropdown-menu dropdown-menu-right">
									            <li><a href="#">Duplicate Class (soon)</a></li>
									            <li><a href="#">Edit Class</a></li>
									            <li class="divider"></li>
									            <li><a href="#">Delete Class</a></li>
									        </ul>
									    </div> 
								    </li>
								@endforeach
							@endif
						</ul>
					</div>
					<div class="panel panel-white">
						<div class="panel-heading">
							<h6 class="panel-title" style="word-wrap: break-word; width: 90%;">
								Selected Object
								<span class="text-muted">
									<small class="selected-name">Loading...</small>
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
						
						<div class="panel-body" style="display: none;">
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
								<table class="table table-bordered table-striped">
									<thead>
										<tr>
											<th>Setting</th>
											<th>Value</th>
										</tr>
									</thead>
									<tbody>
										<tr>
											<td>Location</td>
											<td id="selected-position">
												<strong>X:</strong> 1, <strong>Y:</strong> 6<br />
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
						<div class="panel-body" style="display: none;" id="selected-no-objects">
							There is no objects on the canvas. Start by clicking on an object in the objects panel below.
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
    <script type="text/javascript" src="http://cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
    <script type="text/javascript" src="/assets/js/plugins/drag_selection.js"></script>
	<script>
		$(document).ready(function() {
			$('.drop-target').on('click', '.drag-item', function(){
				updateSelected([$(this)]);
			});

			$('#selected-delete').click(function() {
				deleteSelected(selectedIds);
			});

			$('#save-button').click(function() {
				saveActiveObjects();
			});

			$('.create-active-object').click(function() {
				var objectId = parseInt($(this).attr('object-id'));

				createActiveObject(objectId, 0, 0);
			});

			$('.class-button').click(function() {
				$('.class-button.class-button-active').removeClass('class-button-active');
				$(this).addClass('class-button-active');

				$('.class-options-active').removeClass('class-options-active').addClass('class-options');
				$(this).parent()
					.children().eq(1)
					.children().eq(0)
					.addClass('class-options-active')
					.removeClass('class-options');

				classId = parseInt($(this).attr('class-id'));
				clearSession();
				loadActiveObjects(classId);
			});
		});

  		var token = '{{ csrf_token() }}';
	    var objects = [];
    	var activeObjects = [];

    	var classId = parseInt($('.class-button:first').attr('class-id'));

    	var hasObjects = false;

    	var selectedIds = [];
    	var selectedNames = [];

	    loadObjects();

	    function createActiveObject(objectId, objectPositionX, objectPositionY)
	    {
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
			updateSelected([$('div[active-object-id="' + (activeObjects.length - 1) + '"]')])
	    }

	    function loadObjects()
	    {
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
        		loadActiveObjects(classId);
            });
	    }

	    function loadActiveObjects(classId)
	    {
            $.ajax({
                url: '/class-object',
                type: 'GET',
                data: {
                    _token: token,
                    class_id: classId
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
			            	<div class="drag-item " active-object-id="' + (activeObjects.length - 1) + '" style="display: none; left: ' + objectPositionX + 'px; top: ' + objectPositionY + 'px; background-image: url(\'/assets/images/objects/' + objectLocation + '\'); background-size: ' + objectWidth + 'px; height: ' + objectHeight + 'px; width: ' + objectWidth + 'px;"></div>\
			            ');
			        }
			    }
			    $('.drop-target').children().fadeIn();
			    initializeDraggable();

			    if (typeof activeObjects[0] !== "undefined") {
			    	updateSelected([$('div[active-object-id="0"]')]);
			    } else {
			    	hasObjects = false;
			    	$('#selected-no-objects').parent().children().fadeOut();
			    	$('#selected-no-objects').fadeIn();
			    }
            });
	    }

	    function initializeDraggable()
	    {
			$('.drag-item').draggable({
				grid: [32, 32],
		    	containment: '.drop-target',
			    drag: function(event, ui) {
			        var currentLoc = $(this).position();
			        var prevLoc = $(this).data('prevLoc');
			        if (!prevLoc) {
			            prevLoc = ui.originalPosition;
			        }

			        var offsetLeft = currentLoc.left-prevLoc.left;
			        var offsetTop = currentLoc.top-prevLoc.top;

			        moveSelected(offsetLeft, offsetTop);
			        $(this).data('prevLoc', currentLoc);
			    }
			});
	    }

		function moveSelected(offsetLeft, offsetTop){
		    for(i = 0; i < selectedIds.length; i++) {
		        $this = $('div[active-object-id=' + selectedIds[i] + ']');
		        var position = $this.position();
		        var leftPosition = position.left;
		        var topPosition = position.top;

		        $this.css('left', leftPosition + offsetLeft);
		        $this.css('top', topPosition + offsetTop);

	        	var activeObjectId = selectedIds[i];
	        	var objectPositionX = $this.position().left / 32;
	        	var objectPositionY = $this.position().top / 32;

	        	//TODO: Disallow moving objects into positions with other objects within them
	        	if(objectPositionX != activeObjects[activeObjectId]['object_position_x']
	        			|| objectPositionY != activeObjects[activeObjectId]['object_position_y']) {
					updateSelected([$this]);
		        	updateConnectedObjects(objectPositionX, objectPositionY, []);
	        	}
		    }
		}

	    function updateConnectedObjects(objectPositionX, objectPositionY, checkExemptions)
	    {
	    	var activeObjectId = getObjectByPosition(objectPositionX, objectPositionY);
	    	var pushedIndex = checkExemptions.push([objectPositionX, objectPositionY, []]) - 1;

	    	if(activeObjects[activeObjectId]['object_id'] == 1) {
	    		var directions = ['north', 'east', 'south', 'west'];
	    		for(x = 0; x < directions.length; x++) {
	    			var adjacentPosition = getAdjacentPosition(directions[x], objectPositionX, objectPositionY);
	    			var hasAlreadyBeenChecked = isArrayInArray(checkExemptions, adjacentPosition);
	        		if(adjacentPosition[0] > 0
		        			&& adjacentPosition[0] < 23
		        			&& adjacentPosition[1] > 0
		        			&& adjacentPosition[1] < 23
		        			&& !hasAlreadyBeenChecked) {
	        			if(getObjectByPosition(adjacentPosition[0], adjacentPosition[1]) != null) {
	        				checkExemptions[pushedIndex][2].push([directions[x], adjacentPosition[0], adjacentPosition[1]]);
	        			}
	        		} else if(hasAlreadyBeenChecked) {
	        			checkExemptions[pushedIndex][2].push([directions[x], adjacentPosition[0], adjacentPosition[1]]);
	        		}
	    		}

	    		if(checkExemptions[pushedIndex][2].length > 0) {
	    			var arrayOfKeys = [];
	    			for(x = 0; x < checkExemptions[pushedIndex][2].length; x++) {
	    				arrayOfKeys.push(checkExemptions[pushedIndex][2][x][0]);
	    			}

        			$('div[active-object-id=' + activeObjectId + ']').css('background-image', 'url(\'/assets/images/objects/desk-connected-' + arrayOfKeys.join('-') + '.png\')');
        			for(x = 0; x < checkExemptions[pushedIndex][2].length; x++) {
        				if(!isArrayInArray(checkExemptions, [checkExemptions[pushedIndex][2][x][1], checkExemptions[pushedIndex][2][x][2]])) {
        					updateConnectedObjects(checkExemptions[pushedIndex][2][x][1], checkExemptions[pushedIndex][2][x][2], checkExemptions);
        				}
					}
	    		} else if($('div[active-object-id=' + activeObjectId + ']').css('background-image').indexOf('desk-connected-') > -1) {
        			$('div[active-object-id=' + activeObjectId + ']').css('background-image', 'url(\'/assets/images/objects/' + objects[activeObjects[activeObjectId]['object_id']]['object_location'] + '\')');
        		}
	    	}
	    }

	    function getAdjacentPosition(direction, objectPositionX, objectPositionY)
	    {
	    	switch (direction) {
			    case 'north':
			        position = [objectPositionX, objectPositionY - 1];
			        break;
			    case 'east':
			        position = [objectPositionX + 1, objectPositionY];
			        break;
			    case 'south':
			        position = [objectPositionX, objectPositionY + 1];
			        break;
			    default:
			        position = [objectPositionX - 1, objectPositionY];
			        break;
			} 
	    	return position;
	    }

	    function isArrayInArray(arrayToSearch, arrayToFind)
	    {
	    	for(i = 0; i < arrayToSearch.length; i++) {
	    		if(arrayToSearch[i][0] == arrayToFind[0]
	    			&& arrayToSearch[i][1] == arrayToFind[1]) {
	    			return true;
	    		}
	    	}
	    	return false;
	    }

	    function getObjectByPosition(objectPositionX, objectPositionY)
	    {
	    	for(i = 0; i < activeObjects.length; i++) {
	    		if(objectPositionX == activeObjects[i]['object_position_x']
	    			&& objectPositionY == activeObjects[i]['object_position_y']) {
		    		return i;
	    		}
	    	}
	    	return null;
	    }

	    //TODO: Save to database on window close
	    function saveActiveObjects()
	    {
	    	$.ajax({
                url: '/class-object',
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

	    function updateSelected(activeObject)
	    {
	    	clearSelected();

	    	$('#selected-position').append('<td>');

	    	for(i = 0; i < activeObject.length; i++) {
		    	//TODO: Set a default for the selected panel
		    	var activeObjectId = activeObject[i].attr('active-object-id');

	            var position = activeObject[i].position();
	            var objectPositionX = Math.round(position.left / 32);
	            var objectPositionY = Math.round(position.top / 32);

	            activeObjects[activeObjectId]['object_position_x'] = objectPositionX;
	            activeObjects[activeObjectId]['object_position_y'] = objectPositionY;

				selectedIds.push(activeObjectId);

				if(i <= 2) {
					selectedNames.push(objects[activeObjects[activeObjectId]['object_id']]['object_name']);
		            $('#selected-position').append('\
							<strong>X:</strong> ' + objectPositionX + ', <strong>Y:</strong> ' + objectPositionY + '<br>\
					');
					$('#selected-image').attr('src', '/assets/images/objects/' + objects[activeObjects[activeObjectId]['object_id']]['object_location']);
				} else if(i == 3) {
					selectedNames.push('[' + (activeObject.length - i) + ' more]')
				}
				
				activeObject[i].addClass('outline-highlight');
			}

			$('.selected-name').text(selectedNames.join(', '));
	    	$('#selected-position').append('</td>');
	    }

	    function clearSelected()
	    {
	    	if(!hasObjects) {
	    		hasObjects = true;
		    	$('#selected-no-objects').parent().children().fadeIn();
		    	$('#selected-no-objects').hide();
	    	}

	    	selectedIds = [];
	    	selectedNames = [];

	    	$('#selected-position').empty();
	    	$('.selected-name').empty();
			$('.drag-item').removeClass('outline-highlight');
	    }

	    function deleteSelected(activeObjectIds)
	    {
	    	for(i = 0; i < activeObjectIds.length; i++) {
		    	$('div[active-object-id="' + activeObjectIds[i] + '"]').fadeOut();
		    	$.ajax({
	                url: '/class-object',
	                type: 'DELETE',
	                data: {
	                    _token: token,
	                    class_object: activeObjects[activeObjectIds[i]],
	                    class_id: classId
	                }
	            }).done(function(data) {
		    		delete activeObjects[activeObjectIds[i]];
	            });
        	}
	    }

	    function clearSession()
	    {
	    	var activeClassObjects = $('.drop-target').children();
	    	activeClassObjects.fadeOut(1000, function() {
	    		$(this).remove();
	    	});
	    	activeObjects = []
	    }
	</script>

@stop