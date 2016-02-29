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
								.outline-highlight {
									-webkit-filter: drop-shadow(1px 1px 0 #26a69a) drop-shadow(-1px -1px 0 #26a69a);
	    							filter:drop-shadow(1px 1px 0 #26a69a) drop-shadow(-1px -1px 0 #26a69a);
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
										<img id="selected-image" src="assets/images/objects/desk.png" alt="" class="no-antialias">
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

	<script>
		$(document).ready(function() {
			$('.drop-target').on('click', '.drag-item', function(){
				updateSelected([$(this)]);
			});

			$('#selected-delete').click(function() {
				softDeleteActiveObjects(selectedIds);
			});

			$('#save-button').click(function() {
				saveActiveObjects(null);
			});

			$('.create-active-object').click(function() {
				var objectId = parseInt($(this).attr('object-id'));
				createActiveObject(objectId, 0, 0);
			});

			$('.class-button').click(function() {
				if(hasChanged)
					saveActiveObjects('Do you want to save the changes made to the seating plan for “' + $('.class-button.class-button-active').text() + '”?');
				hasChanged = false;

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

			$(document).on('keydown', function (e) {
			    if ((e.which === 8 || e.which === 46) && !$(e.target).is('input, textarea')) {
			        e.preventDefault();
			        softDeleteActiveObjects(selectedIds);
			    }
			});
		});

  		let token = '{{ csrf_token() }}';
  		let assetsBasePath = '{{ $assetsBasePath }}';
  		let directions = ['north', 'east', 'south', 'west'];

	    var objects = [],
	    	activeObjects = [],
	    	selectedIds = [],
	    	softDeletedActiveObjects = [];

    	var classId = parseInt($('.class-button:first').attr('class-id'));

    	var hasObjects = false,
    		hasChanged = false;

	    loadObjects();

	    function createActiveObject(objectId, objectPositionX, objectPositionY)
	    {
	    	hasChanged = true;

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
            	<div class="drag-item" active-object-id="' + (activeObjects.length - 1) + '" style="left: ' + objectPositionX + 'px; top: ' + objectPositionY + 'px; background-image: url(\'' + assetsBasePath + objectLocation + '\'); background-size: ' + objectWidth + 'px; height: ' + objectHeight + 'px; width: ' + objectWidth + 'px;"></div>\
            ');
			initializeDraggable();
			updateSelected([$('div[active-object-id="' + (activeObjects.length - 1) + '"]')]);
	    }

	    function initializeDraggable()
	    {
	    	$('.drag-item').draggable({
		        grid: [32, 32],
		        containment: '.drop-target',
		        drag: function(){
		        	hasChanged = true;

		        	var activeObjectId = $(this).attr('active-object-id');

		        	var objectPositionX = $(this).position().left / 32;
		        	var objectPositionY = $(this).position().top / 32;

		        	var previousPositionX = Math.floor(activeObjects[activeObjectId]['object_position_x']);
		        	var previousPositionY = Math.floor(activeObjects[activeObjectId]['object_position_y']);

		        	if(objectPositionX != previousPositionX
		        			|| objectPositionY != previousPositionY) {
						updateSelected([$(this)]);
			        	var checkExemptions = updateConnectedObjects(objectPositionX, objectPositionY, [], null, false);

			        	//Update everything in old location
			        	//TODO: Update direct connections only!
		        		updateConnectedObjects(previousPositionX, previousPositionY, [[objectPositionX, objectPositionY, []]], 0, false);
			        	checkForClusters(checkExemptions);
		        	}
		        }
		    });
	    }

	    //TODO: Move back /w updates
	    function updateConnectedObjects(objectPositionX, objectPositionY, checkExemptions, pushedIndex, direct)
	    {
	    	let activeObjectId = getObjectByPosition(objectPositionX, objectPositionY);
	    	var pushedIndex,
	    		adjacentPosition,
	    		hasAlreadyBeenChecked;
	    	var arrayOfKeys = [];

	    	if(pushedIndex == null)
	    		pushedIndex = checkExemptions.push([objectPositionX, objectPositionY, []]) - 1;

	    	if(activeObjectId == -1 || activeObjects[activeObjectId]['object_id'] == 1) {
	    		for(x = 0; x < directions.length; x++) {
	    			adjacentPosition = getAdjacentPosition(directions[x], objectPositionX, objectPositionY);
	    			hasAlreadyBeenChecked = getArrayInArray(checkExemptions, adjacentPosition);
	        		if(adjacentPosition[0] >= 0
		        			&& adjacentPosition[0] <= 23
		        			&& adjacentPosition[1] >= 0
		        			&& adjacentPosition[1] <= 23
		        			&& hasAlreadyBeenChecked == -1) {
	        			if(getObjectByPosition(adjacentPosition[0], adjacentPosition[1]) != -1) {
	        				checkExemptions[pushedIndex][2].push([adjacentPosition[0], adjacentPosition[1], directions[x], pushedIndex > 0 ? true : false]);
	        			}
	        		} else if(hasAlreadyBeenChecked  != -1) {
	        			checkExemptions[pushedIndex][2].push([adjacentPosition[0], adjacentPosition[1], directions[x], pushedIndex > 0 ? true : false]);
	        		}
	    		}

	    		if(checkExemptions[pushedIndex][2].length > 0) {
	    			//Gets directions from checkExemptions e.g. [["south", 1, 3], ["west", 0, 3]] => ["south", "west"] => "south-west"
	    			arrayOfKeys = [];
	    			for(x = 0; x < checkExemptions[pushedIndex][2].length; x++) {
	    				arrayOfKeys.push(checkExemptions[pushedIndex][2][x][2]);
	    			}

	    			if(activeObjectId != null) {
        				$('div[active-object-id=' + activeObjectId + ']').css('background-image', 'url(\'' + assetsBasePath + '/desk-connected-' + arrayOfKeys.join('-') + '.png\')');
        			}

        			if(!direct || !checkExemptions[pushedIndex][2][0][3]) {
	        			for(let x = 0; x < checkExemptions[pushedIndex][2].length; x++) {
	        				if(getArrayInArray(checkExemptions, [checkExemptions[pushedIndex][2][x][0], checkExemptions[pushedIndex][2][x][1]]) == -1) {
	        					updateConnectedObjects(checkExemptions[pushedIndex][2][x][0], checkExemptions[pushedIndex][2][x][1], checkExemptions, null, direct);
	        				}
						}
					}
	    		} else if(activeObjectId != null && $('div[active-object-id=' + activeObjectId + ']').css('background-image').indexOf('desk-connected-') > -1) {
        			$('div[active-object-id=' + activeObjectId + ']').css('background-image', 'url(\'' + assetsBasePath + objects[activeObjects[activeObjectId]['object_id']]['object_location'] + '\')');
        		}
	    	}
	    	return checkExemptions;
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

			    if (typeof activeObjects[0] !== 'undefined') {
			    	updateSelected([$('div[active-object-id="0"]')]);
			    } else {
			    	hasObjects = false;
			    	$('#selected-no-objects').parent().children().fadeOut();
			    	$('#selected-no-objects').fadeIn();
			    }
            });
	    }

	    function checkForClusters(checkExemptions)
	    {
	    	var specialConnections = [],
	    		betweenClusterCheck = [];
	    	var activeObjectId,
	    		activeObject,
	    		activeObjectBGImage;

	    	for(let i = 0; i < checkExemptions.length; i++) {

	    		var cluster = checkCluster(checkExemptions, i);

		    	if (cluster.length > 3) {
		        	specialConnections = updateCluster(cluster, 1, specialConnections);
		        }
			}

	    	for(let i = 0; i < specialConnections.length; i++) {
	    		activeObjectId = getObjectByPosition(specialConnections[i][0], specialConnections[i][1]);
				activeObject = $('div[active-object-id=' + activeObjectId + ']');
				activeObjectBGImage = activeObject.css('background-image');

	    		if(specialConnections[i][3] == true) {
	    			betweenClusterCheck = [];
					if(getArrayInArray(specialConnections, [(specialConnections[i][0] - 1), (specialConnections[i][1] - 1)]) != -1) {
						betweenClusterCheck.push('north_west');
					}

					if(getArrayInArray(specialConnections, [(specialConnections[i][0] + 1), (specialConnections[i][1] - 1)]) != -1) {
						betweenClusterCheck.push('north_east');
					}

					if(getArrayInArray(specialConnections, [(specialConnections[i][0] - 1), (specialConnections[i][1] + 1)]) != -1) {
						betweenClusterCheck.push('south_west');
					}

					if(getArrayInArray(specialConnections, [(specialConnections[i][0] + 1), (specialConnections[i][1] + 1)]) != -1) {
						betweenClusterCheck.push('south_east');
					}

					if(betweenClusterCheck.length == 4)
						betweenClusterCheck = ['special', 'north', 'east', 'south', 'west'];

					specialConnections[i][3] = 'url("' + assetsBasePath + 'desk-connected-' + betweenClusterCheck.join('-') + '.png")';
	    		}
	    		$('div[active-object-id=' + activeObjectId + ']').css('background-image', specialConnections[i][3]);
	    	}
	    }

	    function checkCluster(checkExemptions, i)
		{
			var clusters = [];
		    var objectPositionX, objectPositionY, specialConnections;

		    let objectPosition = checkExemptions[i];

		    nestedLoop: {
			    for (let i = 0; i <= 1; i++) {
			        for (let x = 0; x <= 1; x++) {
			            objectPositionX = objectPosition[0] + x;
			            objectPositionY = objectPosition[1] + i;

			            if (objectPositionX < 23 && objectPositionY < 23) {
			                if (getArrayInArray(checkExemptions, [objectPositionX, objectPositionY]) != -1) {
			                	if(i == 0 && x == 0)
			                		specialConnections = ['east', 'south'];
			                	else if(i == 0 && x == 1)
			                		specialConnections = ['south', 'west'];
			                	else if(i == 1 && x == 0)
			                		specialConnections = ['north', 'east'];
			                	else
			                		specialConnections = ['north', 'west'];
			                  	clusters.push([objectPositionX, objectPositionY, specialConnections]);
			                } else {
			                  	break nestedLoop;
			                }
			            } else {
			              	break nestedLoop;
			            }
			        }
			    }
			}
		    return clusters;
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
			} 
	    	return position;
	    }

	    function getArrayInArray(arrayToSearch, arrayToFind)
	    {
	    	for(let i = 0; i < arrayToSearch.length; i++) {
	    		if(arrayToSearch[i][0] == arrayToFind[0]
	    			&& arrayToSearch[i][1] == arrayToFind[1]) {
	    			return i;
	    		}
	    	}
	    	return -1;
	    }

	    function getObjectByPosition(objectPositionX, objectPositionY)
	    {
	    	for(i = 0; i < activeObjects.length; i++) {
	    		if(typeof activeObjects[i] != 'undefined'
	    				&& objectPositionX == activeObjects[i]['object_position_x']
	    				&& objectPositionY == activeObjects[i]['object_position_y']) {
		    		return i;
	    		}
	    	}
	    	return -1;
	    }

	    function updateCluster(cluster, clusterSize, specialConnections)
	    {
			var x,
				newImageLocation,
				pushedIndex;

			for (let i = 0; i < cluster.length; i++) {
				var activeObjectId = getObjectByPosition(cluster[i][0], cluster[i][1]);
				var activeObject = $('div[active-object-id=' + activeObjectId + ']');
				var activeObjectBGImage = activeObject.css('background-image');
				var startPosition = activeObjectBGImage.indexOf('desk-connected-');
				var endPosition = activeObjectBGImage.indexOf('.png');
				var connectedObjects = activeObjectBGImage.substring(startPosition, endPosition);
				pushedIndex = getArrayInArray(specialConnections, [activeObjects[activeObjectId]['object_position_x'], activeObjects[activeObjectId]['object_position_y']]);

				if(pushedIndex == -1) {
					pushedIndex = specialConnections.push([activeObjects[activeObjectId]['object_position_x'], activeObjects[activeObjectId]['object_position_y'], []]) - 1;
				}

				cluster[i][2].forEach(function(entry){
					if(specialConnections[pushedIndex][2].indexOf(entry) == -1) {
						specialConnections[pushedIndex][2].push(entry);
					}
				});

				specialConnections[pushedIndex][2].forEach(function(entry, index) {
					specialConnections[pushedIndex][2][index] = directions.indexOf(specialConnections[pushedIndex][2][index]);
				});

				specialConnections[pushedIndex][2].sort(function(a, b){ return a - b; });

				specialConnections[pushedIndex][2].forEach(function(entry, index) {
					specialConnections[pushedIndex][2][index] = directions[entry];
				});

				connectedObjects = connectedObjects.split('-');

				x = connectedObjects.length
				while (x--) {
				    if(specialConnections[pushedIndex][2].indexOf(connectedObjects[x]) != -1) {
						connectedObjects.splice(x, 1);
					}
				}

				if(specialConnections[pushedIndex][2].length < 4) {
					newImageLocation = connectedObjects.join('-') + '-special-' + specialConnections[pushedIndex][2].join('-');

					activeObjectBGImage = 'url("' + assetsBasePath + newImageLocation + '.png")';
					specialConnections[pushedIndex][3] = activeObjectBGImage;
				} else {
					specialConnections[pushedIndex][3] = true;
				}
			}
			return specialConnections;
	    }

	    function updateSelected(activeObject)
	    {
	    	clearSelected();

	    	$('#selected-position').append('<td>');

	    	for(i = 0; i < activeObject.length; i++) {
		    	var activeObjectId = activeObject[i].attr('active-object-id');

	            var position = activeObject[i].position();
	            var objectPositionX = position.left / 32;
	            var objectPositionY = position.top / 32;

	            activeObjects[activeObjectId]['object_position_x'] = objectPositionX;
	            activeObjects[activeObjectId]['object_position_y'] = objectPositionY;

				selectedIds.push(activeObjectId);

				if(i <= 2) {
					selectedNames.push(objects[activeObjects[activeObjectId]['object_id']]['object_name']);
		            $('#selected-position').append('\
							<strong>X:</strong> ' + objectPositionX + ', <strong>Y:</strong> ' + objectPositionY + '<br>\
					');
					$('#selected-image').attr('src', assetsBasePath + objects[activeObjects[activeObjectId]['object_id']]['object_location']);
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

	    function saveActiveObjects(message)
	    {
	    	console.log(activeObjects);
	    	userConfirmation = message != null ? confirm(message) : true;
	    	if(userConfirmation) {
	    		deleteActiveObjects(softDeletedActiveObjects);
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
	    }

	    function softDeleteActiveObjects(activeObjectIds)
	    {
	    	for(let i = 0; i < activeObjectIds.length; i++) {
		    	var activeObject = $('div[active-object-id="' + activeObjectIds[i] + '"]');
		    	softDeletedActiveObjects.push(activeObjects[activeObjectIds[i]]);
		    	activeObject.fadeOut('slow', function(){
					$(this).remove();
					delete activeObjects[activeObjectIds[i]];
				});
	        }
	    }

	    function deleteActiveObjects(softDeletedActiveObjects)
	    {
	    	for(i = 0; i < softDeletedActiveObjects.length; i++) {
		    	$.ajax({
	                url: '/class-object',
	                type: 'DELETE',
	                data: {
	                    _token: token,
	                    class_object: softDeletedActiveObjects[i],
	                    class_id: classId
	                }
	            });
	        }

	        softDeletedActiveObjects = [];
	    }

	    function clearSession()
	    {
	    	var activeClassObjects = $('.drop-target').children();
	    	activeClassObjects.fadeOut(1000, function() {
	    		$(this).remove();
	    	});
	    	activeObjects = [];
	    }
	</script>

@stop