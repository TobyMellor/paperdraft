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
                                    cursor: crosshair;
                                    
                                }
                                .outline-highlight {
                                    -webkit-filter: drop-shadow(1px 1px 0 #26a69a) drop-shadow(-1px -1px 0 #26a69a);
                                    filter:drop-shadow(1px 1px 0 #26a69a) drop-shadow(-1px -1px 0 #26a69a);
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
    <script type="text/javascript" src="http://cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
    <script type="text/javascript" src="/assets/js/plugins/drag_selection.js"></script>

    <script>
        $(document).ready(function() {
            $('.drop-target').on('mousedown', '.drag-item', function()
            {
                if(selectedIds.indexOf($(this).attr('active-object-id')) == -1)
                    updateSelected([$(this)]);
            });

            $('#selected-delete').click(function()
            {
                softDeleteActiveObjects(selectedIds);
            });

            $('#save-button').click(function()
            {
                saveActiveObjects(null);
            });

            $('.create-active-object').click(function()
            {
                var objectId = parseInt($(this).attr('object-id'));
                if (selectedIds.length > 0) {
                    var selectedObjectPositionX = activeObjects[selectedIds[0]].object_position_y;
                    var selectedObjectPositionY = activeObjects[selectedIds[0]].object_position_y;

                    var nearestEmptySpace = getNearestEmpty(selectedObjectPositionX, selectedObjectPositionY, 5, 5);

                    if (nearestEmptySpace == -1) {
                        createActiveObject(objectId, 0, 0);
                    } else {
                        createActiveObject(objectId, nearestEmptySpace[0] * 32, nearestEmptySpace[1] * 32);
                    }
                } else {
                    createActiveObject(objectId, 0, 0);
                }
            });

            $('.class-button').click(function()
            {
                if (hasChanged)
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

            $(document).on('keydown', function(e)
            {
                if ((e.which === 8 || e.which === 46) && !$(e.target).is('input, textarea')) {
                    e.preventDefault();
                    softDeleteActiveObjects(selectedIds);
                } else if ((e.ctrlKey && e.keyCode == 0x56) || (e.metaKey && e.keyCode == 0x56)) {
                    pasteActiveObject();
                }
            }).bind('copy', function()
            {
                copyActiveObject(false);
            }).bind('cut', function()
            {
                copyActiveObject(true);
            }).keydown(function(e)
            {
                if (e.ctrlKey || e.metaKey) {
                    if (e.which == 90) {
                        undoActionHistory();
                    } else if (e.which == 89) {
                        redoActionHistory();
                    }
                }
            });
        });

        $.ui.draggable.prototype._generatePosition = function(event, constrainPosition) {
            var containment, co, top, left,
                o = this.options,
                scrollIsRootNode = this._isRootNode(this.scrollParent[0]),
                pageX = event.pageX,
                pageY = event.pageY;

            if (!scrollIsRootNode || !this.offset.scroll) {
                this.offset.scroll = {
                    top: this.scrollParent.scrollTop(),
                    left: this.scrollParent.scrollLeft()
                };
            }

            if (constrainPosition) {
                if (this.containment) {
                    if (this.relativeContainer) {
                        co = this.relativeContainer.offset();
                        containment = [
                            this.containment[0] + co.left,
                            this.containment[1] + co.top,
                            this.containment[2] + co.left,
                            this.containment[3] + co.top
                        ];
                    } else {
                        containment = this.containment;
                    }

                    if (event.pageX - this.offset.click.left < containment[0]) {
                        pageX = containment[0] + this.offset.click.left;
                    }
                    if (event.pageY - this.offset.click.top < containment[1]) {
                        pageY = containment[1] + this.offset.click.top;
                    }
                    if (event.pageX - this.offset.click.left > containment[2]) {
                        pageX = containment[2] + this.offset.click.left;
                    }
                    if (event.pageY - this.offset.click.top > containment[3]) {
                        pageY = containment[3] + this.offset.click.top;
                    }
                }

                if (o.grid) {
                    top = o.grid[1] ? this.originalPageY + Math.round((pageY - this.originalPageY) / o.grid[1]) * o.grid[1] : this.originalPageY;
                    pageY = containment ? ((top - this.offset.click.top >= containment[1] || top - this.offset.click.top > containment[3]) ? top : ((top - this.offset.click.top >= containment[1]) ? top - o.grid[1] : top + o.grid[1])) : top;

                    left = o.grid[0] ? this.originalPageX + Math.round((pageX - this.originalPageX) / o.grid[0]) * o.grid[0] : this.originalPageX;
                    pageX = containment ? ((left - this.offset.click.left >= containment[0] || left - this.offset.click.left > containment[2]) ? left : ((left - this.offset.click.left >= containment[0]) ? left - o.grid[0] : left + o.grid[0])) : left;
                }

                if (o.axis === "y") {
                    pageX = this.originalPageX;
                }

                if (o.axis === "x") {
                    pageY = this.originalPageY;
                }
            }

            // This is the only part added to the original function.
            // You have access to the updated position after it's been
            // updated through containment and grid, but before the
            // element is modified.
            // If there's an object in position, you prevent dragging.

            if(selectedObjectPosition[0] != (pageX - this.offset.click.left - this.offset.parent.left) / 32
                    || selectedObjectPosition[1] != (pageY - this.offset.click.top - this.offset.parent.top) / 32) {
                if (getObjectByPosition((pageX - this.offset.click.left - this.offset.parent.left) / 32, (pageY - this.offset.click.top - this.offset.parent.top) / 32) != -1) {
                    return false;
                }
            }

            return {
                top: (
                    pageY -
                    this.offset.click.top -
                    this.offset.relative.top -
                    this.offset.parent.top +
                    (this.cssPosition === "fixed" ? -this.offset.scroll.top : (scrollIsRootNode ? 0 : this.offset.scroll.top))
                ),
                left: (
                    pageX -
                    this.offset.click.left -
                    this.offset.relative.left -
                    this.offset.parent.left +
                    (this.cssPosition === "fixed" ? -this.offset.scroll.left : (scrollIsRootNode ? 0 : this.offset.scroll.left))
                )
            };
        }

        let token = '{{ csrf_token() }}';
        let assetsBasePath = '{{ $assetsBasePath }}';

        var objects = [],
            activeObjects = [],
            activeObjectsGrid = [],
            selectedIds = [],
            selectedNames = [],
            softDeletedActiveObjects = [],
            copyClipboard = [],
            actionHistory = [];

        var selectedObjectPosition = [];

        var classId = parseInt($('.class-button:first').attr('class-id'));

        var actionUndoCount = 1;

        var hasObjects = false,
            hasChanged = false;

        loadObjects();

        function storeActionHistory(activeObjectId)
        {
            actionHistory.push([activeObjectId, [activeObjects[activeObjectId].object_position_x, activeObjects[activeObjectId].object_position_y]]);
            if (actionUndoCount > 1) {
                actionHistory.splice(actionHistory.length - actionUndoCount + 1, actionUndoCount);
                actionUndoCount = 1;
            }
        }

        function undoActionHistory()
        {
            if (actionHistory.length - actionUndoCount >= 0) {
                var action = actionHistory[actionHistory.length - actionUndoCount];
                var activeObject = activeObjects[action[0]];

                if (actionUndoCount == 1) {
                    storeActionHistory(action[0]);
                    actionUndoCount++;
                }

                updateObjectByPosition(action[0], action[1][0], action[1][1]);

                $('div[active-object-id="' + action[0] + '"]').css({
                    left: activeObject.object_position_x * 32,
                    top: activeObject.object_position_y * 32
                });

                actionUndoCount++;
            } else {
                alert('Nothing left to undo!');
            }
        }

        function redoActionHistory()
        {
            if (actionUndoCount > 2) {
                actionUndoCount--;
                var action = actionHistory[actionHistory.length - actionUndoCount + 1];
                var activeObject = activeObjects[action[0]];

                updateObjectByPosition(action[0], action[1][0], action[1][1]);

                $('div[active-object-id="' + action[0] + '"]').css({
                    left: activeObject.object_position_x * 32,
                    top: activeObject.object_position_y * 32
                });
            } else {
                alert('Nothing left to redo!');
            }
        }

        function createActiveObject(objectId, objectPositionX, objectPositionY)
        {
            hasChanged = true;

            activeObjects[activeObjects.length] = {
                'object_id': objectId,
                'active_object_id': null,
                'object_position_x': objectPositionX,
                'object_position_y': objectPositionY
            };

            var object = objects[activeObjects[activeObjects.length - 1].object_id];
            var objectLocation = object.object_location;
            var objectWidth = object.object_width;
            var objectHeight = object.object_height;

            $('.drop-target').append(
                '<div class="drag-item" active-object-id="' + (activeObjects.length - 1) + '" style="left: ' + objectPositionX + 'px; top: ' + objectPositionY + 'px; background-image: url(\'' + assetsBasePath + objectLocation + '\'); background-size: ' + objectWidth + 'px; height: ' + objectHeight + 'px; width: ' + objectWidth + 'px;"></div>'
            );
            initializeDraggable();
            updateSelected([$('div[active-object-id="' + (activeObjects.length - 1) + '"]')]);

            return activeObjects[activeObjects.length - 1];
        }

        function initializeDraggable()
        {
            $('.drag-item').draggable({
                grid: [32, 32],
                containment: '.drop-target',
                drag: function() {
                    hasChanged = true;

                    let activeObjectId = $(this).attr('active-object-id');

                    var objectPositionX = $(this).position().left / 32;
                    var objectPositionY = $(this).position().top / 32;

                    var previousPositionX = Math.floor(activeObjects[activeObjectId].object_position_x);
                    var previousPositionY = Math.floor(activeObjects[activeObjectId].object_position_y);

                    selectedObjectPosition = [previousPositionX, previousPositionY];

                    if (objectPositionX != previousPositionX || objectPositionY != previousPositionY) {
                        var selectedObjects = [$(this)],
                            selectedPositions = [
                                [
                                    [previousPositionX, previousPositionY],
                                    [objectPositionX, objectPositionY]
                                ]
                            ];

                        var selectedObject,
                            selectedObjectPreviousPositionX,
                            selectedObjectPreviousPositionY,
                            selectedObjectPositionX,
                            selectedObjectPositionY;

                        for(let i = 0; i < selectedIds.length; i++) {
                            if(selectedIds[i] == activeObjectId)
                                continue;
                            selectedObject = $('div[active-object-id=' + selectedIds[i] + ']');

                            selectedObjectPreviousPositionX = selectedObject.position().left / 32;
                            selectedObjectPreviousPositionY = selectedObject.position().top / 32;

                            selectedObjectPositionX = selectedObjectPreviousPositionX - (previousPositionX - objectPositionX);
                            selectedObjectPositionY = selectedObjectPreviousPositionY - (previousPositionY - objectPositionY);

                            selectedObject.css('left', selectedObjectPositionX * 32);
                            selectedObject.css('top', selectedObjectPositionY * 32);

                            selectedObjects.push(selectedObject);
                            selectedPositions.push([[selectedObjectPreviousPositionX, selectedObjectPreviousPositionY], [selectedObjectPositionX, selectedObjectPositionY]]);
                        }
                        if(selectedObjects.length != 0)
                            updateSelected(selectedObjects);
                        for(let i = 0; i < selectedPositions.length; i++) {
                            updateConnectedObjects(selectedPositions[i][1][0], selectedPositions[i][1][1], [], null);

                            updateConnectedObjects(selectedPositions[i][0][0], selectedPositions[i][0][1], [
                                [selectedPositions[i][1][0], selectedPositions[i][1][1], []]
                            ], 0);
                        }
                    }
                },
                start: function() {
                    let activeObjectId = $(this).attr('active-object-id');
                    storeActionHistory(activeObjectId);
                },
                create: function() {
                    let activeObjectId = $(this).attr('active-object-id');
                    updateConnectedObjects(activeObjects[activeObjectId].object_position_x, activeObjects[activeObjectId].object_position_y, [], null);
                }
            });
        }

        function generateGrid(size)
        {
            activeObjectsGrid = [];
            for(let i = 0; i <= size; i++) {
                activeObjectsGrid[activeObjectsGrid.push([]) - 1].length = size;
                activeObjectsGrid[i].fill(-1);
            }
            for (let i = 0; i < activeObjects.length; i++) {
                activeObjectsGrid[activeObjects[i].object_position_x][activeObjects[i].object_position_y] = i;
            }
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

                        objects[object.id] = {
                            'object_name': object.object_name,
                            'object_height': object.object_height,
                            'object_width': object.object_width,
                            'object_location': object.object_location
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
                        activeObject = data[activeObject];

                        var objectId = activeObject.object_id;
                        var activeObjectId = activeObject.id;
                        var objectPositionX = activeObject.object_position_x * 32;
                        var objectPositionY = activeObject.object_position_y * 32;
                        var objectLocation = objects[objectId].object_location;
                        var objectWidth = objects[objectId].object_width;
                        var objectHeight = objects[objectId].object_height;

                        activeObjects[activeObjects.length] = {
                            'object_id': objectId,
                            'active_object_id': activeObjectId,
                            'object_position_x': objectPositionX / 32,
                            'object_position_y': objectPositionY / 32
                        };

                        $('.drop-target').append(
                            '<div class="drag-item " active-object-id="' + (activeObjects.length - 1) + '" style="display: none; left: ' + objectPositionX + 'px; top: ' + objectPositionY + 'px; background-image: url(\'/assets/images/objects/' + objectLocation + '\'); background-size: ' + objectWidth + 'px; height: ' + objectHeight + 'px; width: ' + objectWidth + 'px;"></div>'
                        );
                    }
                }

                generateGrid(23);

                initializeDraggable();
                $('.drop-target').children().fadeIn();

                if (typeof activeObjects[0] !== 'undefined') {
                    updateSelected([$('div[active-object-id="0"]')]);
                } else {
                    hasObjects = false;
                    $('#selected-no-objects').parent().children().fadeOut();
                    $('#selected-no-objects').fadeIn();
                }
            });
        }

        function getArrayInArray(arrayToSearch, arrayToFind)
        {
            for (let i = 0; i < arrayToSearch.length; i++) {
                if (arrayToSearch[i][0] == arrayToFind[0] && arrayToSearch[i][1] == arrayToFind[1]) {
                    return i;
                }
            }
            return -1;
        }

        function getObjectByPosition(objectPositionX, objectPositionY)
        {
            return activeObjectsGrid[objectPositionX][objectPositionY];
        }

        function copyActiveObject(isCut)
        {
            copyClipboard = [];
            for (let i = 0; i < selectedIds.length; i++) {
                copyClipboard.push(activeObjects[selectedIds[i]]);
                if (isCut) {
                    $('div[active-object-id=' + selectedIds[i] + ']').fadeOut('slow', function() {
                        $(this).remove();
                        delete activeObjects[selectedIds[i]];
                        clearSelected();
                        if ($('.drop-target').children().length > 0)
                            updateSelected([$('div[active-object-id="' + $('.drop-target').children(0).attr('active-object-id') + '"]')]);
                    });
                }
            }
        }

        function pasteActiveObject()
        {
            for (let i = 0; i < copyClipboard.length; i++) {
                var copiedObjectPositionX = copyClipboard[i].object_position_x;
                var copiedObjectPositionY = copyClipboard[i].object_position_y;
                var pastedObjectPositionX,
                    pastedObjectPositionY,
                    nearestEmptySpace;

                if (getObjectByPosition(copiedObjectPositionX + 1, copiedObjectPositionY + 1) != -1) {
                    nearestEmptySpace = getNearestEmpty(copyClipboard[i].object_position_x, copyClipboard[i].object_position_y, 5, 5);
                    if (nearestEmptySpace == -1) {
                        alert('There is no space to paste the object at ' + copiedObjectPositionX + ', ' + copiedObjectPositionY);
                        break;
                    }
                    pastedObjectPositionX = nearestEmptySpace[0];
                    pastedObjectPositionY = nearestEmptySpace[1];
                } else {
                    pastedObjectPositionX = copiedObjectPositionX + 1;
                    pastedObjectPositionY = copiedObjectPositionY + 1;
                }
                copyClipboard[i] = createActiveObject(copyClipboard[i].object_id, pastedObjectPositionX * 32, pastedObjectPositionY * 32);
            }
        }

        function getNearestEmpty(objectPositionX, objectPositionY, maxCheckHeight, maxCheckWidth)
        {
            var x = 0,
                y = 0,
                delta = [0, -1],
                potentialEmptyX,
                potentialEmptyY;

            for (let i = 0; i < Math.pow(Math.max(maxCheckWidth, maxCheckHeight), 2); i++) {
                if ((-maxCheckWidth / 2 < x && x <= maxCheckWidth / 2) && (-maxCheckHeight / 2 < y && y <= maxCheckHeight / 2)) {
                    potentialEmptyX = x + objectPositionX;
                    potentialEmptyY = y + objectPositionY;
                    if (potentialEmptyX >= 0 && potentialEmptyY >= 0 && potentialEmptyX <= 23 && potentialEmptyY <= 23) {
                        if (getObjectByPosition(x + objectPositionX, y + objectPositionY) == -1) {
                            return [x + objectPositionX, y + objectPositionY];
                        }
                    }
                }

                if (x === y || (x < 0 && x === -y) || (x > 0 && x === 1 - y)) {
                    delta = [-delta[1], delta[0]];
                }

                x += delta[0];
                y += delta[1];
            }
            return -1;
        }

        function updateSelected(selectedObjects)
        {
            clearSelected();

            $('#selected-position').append('<td>');

            for (let i = 0; i < selectedObjects.length; i++) {
                var activeObjectId = selectedObjects[i].attr('active-object-id');

                var position = selectedObjects[i].position();
                var objectPositionX = position.left / 32;
                var objectPositionY = position.top / 32;

                updateObjectByPosition(activeObjectId, objectPositionX, objectPositionY);

                selectedIds.push(activeObjectId);

                if (i <= 2) {
                    selectedNames.push(objects[activeObjects[activeObjectId].object_id].object_name);
                    $('#selected-position').append(
                        '<strong>X:</strong> ' + objectPositionX + ', <strong>Y:</strong> ' + objectPositionY + '<br>'
                    );
                    $('#selected-image').attr('src', assetsBasePath + objects[activeObjects[activeObjectId].object_id].object_location);
                } else if (i == 3) {
                    selectedNames.push('[' + (selectedObjects.length - i) + ' more]');
                }

                selectedObjects[i].addClass('outline-highlight');
            }

            $('.selected-name').text(selectedNames.join(', '));
            $('#selected-position').append('</td>');
        }

        function updateConnectedObjects(objectPositionX, objectPositionY, checkExemptions, pushedIndex)
        {
            let activeObjectId = getObjectByPosition(objectPositionX, objectPositionY);

            var hasAlreadyBeenChecked,
                objectInCheckPosition;

            var arrayOfKeys = [],
                adjacentDirections = [
                    ['northwest', 'north', 'northeast'],
                    ['west',       null,   'east'],
                    ['southwest', 'south', 'southeast']
                ];

            if (pushedIndex === null)
                pushedIndex = checkExemptions.push([objectPositionX, objectPositionY, []]) - 1;

            if (activeObjectId == -1 || activeObjects[activeObjectId].object_id == 1) {
                if (objectPositionX - 1 >= 0 && objectPositionX + 1 <= 23 && objectPositionY - 1 >= 0 && objectPositionY + 1 <= 23) {
                    for (let i = 0; i < 3; i++) {
                        for (let x = 0; x < 3; x++) {
                            if (i == 1 && x == 1)
                                continue;
                            var checkPositionX = objectPositionX - 1 + x;
                            var checkPositionY = objectPositionY - 1 + i;

                            hasAlreadyBeenChecked = getArrayInArray(checkExemptions, [checkPositionX, checkPositionX]);

                            if (hasAlreadyBeenChecked == -1) {
                                objectInCheckPosition = getObjectByPosition(checkPositionX, checkPositionY);
                                if (objectInCheckPosition != -1 && activeObjects[objectInCheckPosition].object_id == 1) {
                                    if (adjacentDirections[i][x].length == 9) {
                                        objectInCheckPosition = [
                                            getObjectByPosition(objectPositionX, checkPositionY),
                                            getObjectByPosition(checkPositionX, objectPositionY)
                                        ];
                                        if (objectInCheckPosition[0] != -1 
                                                && activeObjects[objectInCheckPosition[0]].object_id == 1
                                                && objectInCheckPosition[1] != -1
                                                && activeObjects[objectInCheckPosition[1]].object_id == 1) {
                                            checkExemptions[pushedIndex][2].push([checkPositionX, checkPositionY, adjacentDirections[i][x], pushedIndex > 0 ? true : false]);
                                        }
                                    } else {
                                        checkExemptions[pushedIndex][2].push([checkPositionX, checkPositionY, adjacentDirections[i][x], pushedIndex > 0 ? true : false]);
                                    }
                                }
                            }
                        }
                    }
                }

                if (checkExemptions[pushedIndex][2].length > 0) {
                    //Gets directions from checkExemptions e.g. [["south", 1, 3], ["west", 0, 3]] => ["south", "west"] => "south-west"
                    arrayOfKeys = [];
                    for (let x = 0; x < checkExemptions[pushedIndex][2].length; x++) {
                        arrayOfKeys.push(checkExemptions[pushedIndex][2][x][2]);
                    }

                    if (activeObjectId !== null) {
                        $('div[active-object-id=' + activeObjectId + ']').css('background-image', 'url(\'' + assetsBasePath + 'desk-connected-' + arrayOfKeys.join('-') + '.png\')');
                    }

                    if (!checkExemptions[pushedIndex][2][0][3]) {
                        for (let x = 0; x < checkExemptions[pushedIndex][2].length; x++) {
                            if (getArrayInArray(checkExemptions, [checkExemptions[pushedIndex][2][x][0], checkExemptions[pushedIndex][2][x][1]]) == -1) {
                                updateConnectedObjects(checkExemptions[pushedIndex][2][x][0], checkExemptions[pushedIndex][2][x][1], checkExemptions, null);
                            }
                        }
                    }
                } else if (activeObjectId != -1 && $('div[active-object-id=' + activeObjectId + ']').css('background-image').indexOf('desk-connected-') > -1) {
                    $('div[active-object-id=' + activeObjectId + ']').css('background-image', 'url(\'' + assetsBasePath + objects[activeObjects[activeObjectId].object_id].object_location + '\')');
                }
            }
            return checkExemptions;
        }

        function updateObjectByPosition(activeObjectId, objectPositionX, objectPositionY) {
            var previousPositionX = activeObjects[activeObjectId].object_position_x;
            var previousPositionY = activeObjects[activeObjectId].object_position_y;

            activeObjectsGrid[previousPositionX][previousPositionY] = -1;

            activeObjectsGrid[objectPositionX][objectPositionY] = activeObjectId;

            activeObjects[activeObjectId].object_position_x = objectPositionX;
            activeObjects[activeObjectId].object_position_y = objectPositionY;
        }

        function clearSelected()
        {
            if (!hasObjects) {
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
            var userConfirmation = message !== null ? confirm(message) : true;
            if (userConfirmation) {
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
            for (let i = 0; i < activeObjectIds.length; i++) {
                var activeObject = $('div[active-object-id="' + activeObjectIds[i] + '"]');
                softDeletedActiveObjects.push(activeObjects[activeObjectIds[i]]);
                activeObject.fadeOut('slow', function() {
                    $(this).remove();
                    delete activeObjects[activeObjectIds[i]];
                    if (i == activeObjectIds.length - 1) {
                        if ($('.drop-target').children().length > 0) {
                            updateSelected([$('div[active-object-id="' + $('.drop-target').children(0).attr('active-object-id') + '"]')]);
                        }
                    }
                });
            }
        }

        function deleteActiveObjects(softDeletedActiveObjects)
        {
            if (softDeletedActiveObjects.length > 0) {
                $.ajax({
                    url: '/class-object',
                    type: 'DELETE',
                    data: {
                        _token: token,
                        class_objects: softDeletedActiveObjects,
                        class_id: classId
                    }
                });

                softDeletedActiveObjects = [];
            }
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