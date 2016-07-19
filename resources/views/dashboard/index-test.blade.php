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
                        <div class="panel-body" style="height: 736px; overflow-x: scroll;">
                            <div class="drop-target" id="paper">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="tabbable">
                        <ul class="nav nav-pills nav-pills-bordered nav-stacked">
                            @if(isset($classes))
                                @foreach($classes as $key => $class)
                                    <li>
                                        <a href="javascript:void(0);" class="class-button @if($key == 0) class-button-active @endif" class-id="{{ $class->id }}">{{ $class->class_name }}</a>
                                        <div class="btn-group">
                                            <a href="javascript:void(0);" class="btn btn-primary btn-icon dropdown-toggle @if($key == 0) class-options-active @else class-options @endif" data-toggle="dropdown" class-id="{{ $class->id }}">
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
                                <a href="javascript:void(0);" class="class-button class-button-create" data-toggle="modal" data-target="#modal_form_inline">Create a new class</a>
                            </li>
                        </ul>
                    </div>
                    <div class="panel panel-white">
                        <div class="panel-heading">
                            <h6 class="panel-title" style="word-wrap: break-word; width: 90%;">
                                Selected item
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
                        <div class="panel-body" style="display: none;" id="selected-no-items">
                            There is no items on the canvas. Start by clicking on an item in the items panel below.
                        </div>
                    </div>
                    <!-- /editable inputs -->
                    <div class="panel panel-white">
                        <div class="panel-heading">
                            <h6 class="panel-title">Items</h6>
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
                            @if(isset($items))
                                @foreach($items as $item)
                                    <div class="col-lg-4 col-sm-6">
                                        <div class="thumbnail">
                                            <div class="thumb">
                                                <img class="no-antialias" src="assets/images/objects/{{ $item->location }}">
                                                <div class="caption-overflow">
                                                    <span>
                                                        <a class="btn border-white text-white btn-flat btn-icon btn-rounded create-active-item" href="javascript:void(0);" item-id={{ $item->id }}><i class="icon-plus3"></i></a>
                                                    </span>
                                                </div>
                                            </div>

                                            <div class="caption" style="padding-top: 5px; padding-bottom: 5px; padding-left: 5px;">
                                                <h6 class="no-margin"><a href="#" class="text-default" style="font-size: 10px;">{{ $item->name }}</a></h6>
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
                var canvasItemId = $(this).attr('canvas-item-id');
                var selectedCanvasItemIds = [canvasItemId];

                if (Object.keys(selectedCanvasItems.children).indexOf(canvasItemId) != -1) {
                    for (var selectedCanvasItemId in selectedCanvasItems.children) {
                        if (selectedCanvasItemId == canvasItemId) {
                            selectedCanvasItemId = selectedCanvasItems.parent.id;
                        }

                        selectedCanvasItemIds.push(selectedCanvasItemId);
                    }
                }

                canvasController.updateSelected(selectedCanvasItemIds);
            });

            // $('#selected-delete').click(function()
            // {
            //     softDeleteActiveItems(selectedIds);
            // });

            // $('#save-button').click(function()
            // {
            //     saveActiveItems(null);
            // });

            // $('.create-active-item').click(function()
            // {
            //     var itemId = parseInt($(this).attr('item-id'));
            //     if (selectedIds.length > 0) {
            //         var selectedItemPositionX = activeItems[selectedIds[0]].position_y;
            //         var selectedItemPositionY = activeItems[selectedIds[0]].position_y;

            //         var nearestEmptySpace = getNearestEmpty(selectedItemPositionX, selectedItemPositionY, 5, 5);

            //         if (nearestEmptySpace == -1) {
            //             createActiveItem(itemId, 0, 0);
            //         } else {
            //             createActiveItem(itemId, nearestEmptySpace[0] * 32, nearestEmptySpace[1] * 32);
            //         }
            //     } else {
            //         createActiveItem(itemId, 0, 0);
            //     }
            // });

            // $('.class-button').click(function()
            // {
            //     if (hasChanged)
            //         saveActiveItems('Do you want to save the changes made to the seating plan for “' + $('.class-button.class-button-active').text() + '”?');
            //     hasChanged = false;

            //     $('.class-button.class-button-active').removeClass('class-button-active');
            //     $(this).addClass('class-button-active');

            //     $('.class-options-active').removeClass('class-options-active').addClass('class-options');
            //     $(this).parent()
            //         .children().eq(1)
            //         .children().eq(0)
            //         .addClass('class-options-active')
            //         .removeClass('class-options');

            //     classId = parseInt($(this).attr('class-id'));
            //     clearSession();
            //     loadActiveItems(classId);
            // });

            // $(document).on('keydown', function(e)
            // {
            //     if ((e.which === 8 || e.which === 46) && !$(e.target).is('input, textarea')) {
            //         e.preventDefault();
            //         softDeleteActiveItems(selectedIds);
            //     } else if ((e.ctrlKey && e.keyCode == 0x56) || (e.metaKey && e.keyCode == 0x56)) {
            //         pasteActiveItem();
            //     }
            // }).bind('copy', function()
            // {
            //     copyActiveItem(false);
            // }).bind('cut', function()
            // {
            //     copyActiveItem(true);
            // }).keydown(function(e)
            // {
            //     if (e.ctrlKey || e.metaKey) {
            //         if (e.which == 90) {
            //             undoActionHistory();
            //         } else if (e.which == 89) {
            //             redoActionHistory();
            //         }
            //     }
            // });
        });

        var token = '{{ csrf_token() }}';
        var assetsBasePath = '{{ asset('assets/images/objects') }}/';

        var canvasController;
        var selectedCanvasItems = {
            parent: {},
            children: {}
        };

        class View {
            addCanvasItem(item, canvasItem) {
                var canvasItemId = canvasItem.id;
                var canvasItemPositionX = canvasItem.position_x * 32;
                var canvasItemPositionY = canvasItem.position_y * 32;

                var itemLocation = item.location;
                var itemWidth = item.width;
                var itemHeight = item.height;

                // TODO: correct path /w laravel
                $('.drop-target').append(
                    '<div class="drag-item" canvas-item-id="' + canvasItemId + '" style="display: none; left: ' + canvasItemPositionX + 'px; top: ' + canvasItemPositionY + 'px; background-image: url(\'/assets/images/objects/' + itemLocation + '\'); background-size: ' + itemWidth + 'px; height: ' + itemHeight + 'px; width: ' + itemWidth + 'px;"></div>'
                );

                $('.drop-target').children().show();
            }

            updateCanvasItemPosition(canvasItemId, canvasItemPositionX, canvasItemPositionY) {
                console.log(canvasItemId);
                console.log(canvasItemPositionX);
                var canvasItem = $('.drag-item[canvas-item-id=' + canvasItemId + ']');

                canvasItem.css('left', canvasItem.position_x * 32);
                canvasItem.css('top', canvasItem.position_y * 32);

                console.log(canvasItem);
                console.log(canvasItem.css('left'));
            }

            removeCanvasItem(canvasItem) {
                var canvasItemId = canvasItem.id;

                $('.drag-item[canvas-item-id=' + canvasItemId + ']').remove();
            }

            removeCanvasItems() {
                $('.drag-item').remove();
            }

            clearSelectedBoard(selectedCanvasItems) {
                if ($.isEmptyObject(selectedCanvasItems.parent)) {
                    $('#selected-no-items').parent().children(':nth-child(2)').fadeOut(250, function() {
                        $('#selected-no-items').fadeIn(250);
                    });
                } else {
                    $('#selected-no-items').fadeOut(250, function() {
                        $('#selected-no-items').parent().children(':nth-child(2)').fadeIn(250);
                    });
                }

                $('#selected-position').empty();
                $('.selected-name').empty();
                $('.drag-item').removeClass('outline-highlight');
            }

            updateSelectedBoard(selectedBoardItems) {
                if (Object.keys(selectedBoardItems).length > 2) {
                    selectedBoardItems[selectedBoardItems.length - 1].name = '[' + (selectedBoardItems.length - 2) + ' more]';
                }
                
                var selectedNames = $.extend(true, [], selectedBoardItems);
                selectedNames.splice(1, selectedBoardItems.length - 3);

                selectedNames = selectedNames.map(function(selectedName){
                    return selectedName.name;
                }).join(', ');

                $('.selected-name').text(selectedNames);
                $('#selected-image').attr('src', assetsBasePath + selectedBoardItems[0].location);

                for (var index in selectedBoardItems) {
                    var selectedBoardItem = selectedBoardItems[index];

                    var selectedBoardItemId = selectedBoardItem.id;

                    var selectedBoardItemPositionX = selectedBoardItem.position_x;
                    var selectedBoardItemPositionY = selectedBoardItem.position_y;

                    if (index == 2) {
                        $('#selected-position').append('<strong>' + selectedBoardItems[Object.keys(selectedBoardItems).length - 1].name + '</strong>');
                    } else if (index < 2) {
                        $('#selected-position').append('<strong>X:</strong> ' + selectedBoardItemPositionX + ', <strong>Y:</strong> ' + selectedBoardItemPositionY + '<br />');
                    }

                    $('.drag-item[canvas-item-id=' + selectedBoardItemId + ']').addClass('outline-highlight');
                }
            }
        }

        // An 'item' is a classroom item from the database.
        // e.g. Table - desk-1.png
        // This is not specific to any single classroom nor is any position data stored here

        // Example:
        // [
        //    {
        //       "id": 1,
        //       "item_name": "Student Desk",
        //       "item_width": 32,
        //       "item_height": 32,
        //       "item_location": "desk.png"
        //    }
        // ]
        class ItemModel {
            getAll() {
                $.ajax({
                    url: '/item',
                    type: 'GET',
                    data: {
                        _token: token
                    }
                }).done(function(jsonItems) {
                    canvasController.jsonItems = jsonItems;
                    canvasController.loadCanvasItems();
                });
            }
        }

        // An 'canvas item' is a classroom 'item' that is stored at a location for a given class
        // e.g. item: Table -- Canvas item: Table is stored at x: 25, y: 5
        // This is specific to a particular classroom, and the items can be any 'item' (a Table)

        //Example:
        // [
        //     {
        //         "id": 1,
        //         "item_id": 1,
        //         "class_id": 1,
        //         "position_x": 5,
        //         "position_y": 10,
        //     }
        // ]
        class CanvasItemModel {
            getAll(classId) {
                $.ajax({
                    url: '/canvas-item',
                    type: 'GET',
                    data: {
                        _token: token,
                        class_id: classId
                    }
                }).done(function(jsonCanvasItems) {
                    canvasController.jsonCanvasItems = jsonCanvasItems;
                    canvasController.init();
                });
            }
        }

        class CanvasController {
            constructor(classId, gridSize = 23) {
                this.jsonItems,
                this.jsonCanvasItems;

                this.canvasItems = {}, // e.g. Table is stored at X: 5, Y: 8 in the grid
                this.items = {}, // e.g. A Table desk.png, A Teachers Desk teachers_desk.png
                this.canvasItemsGrid = [], // e.g. Grid of all possible locations to store items

                this.classId = classId;
                this.gridSize = gridSize;

                this.canvasItemModel = new CanvasItemModel,
                this.itemModel = new ItemModel;

                this.view = new View;
            }

            loadItems() {
                this.itemModel.getAll();
            }

            loadCanvasItems() {
                this.canvasItemModel.getAll(this.classId);
            }

            init() {
                var jsonItems = this.jsonItems,
                    jsonCanvasItems = this.jsonCanvasItems;

                var items = this.items,
                    canvasItems = this.canvasItems; 

                // Take JSON array of all items and store them locally
                for (var jsonItem in jsonItems) {
                    var item = jsonItems[jsonItem];

                    this.addItem(item);
                }

                // Take JSON array of all canvasItems and store them locally
                for (var jsonCanvasItem in jsonCanvasItems) {
                    var canvasItem = jsonCanvasItems[jsonCanvasItem];

                    this.addCanvasItem(canvasItem);
                }

                this.generateGrid(this.gridSize);

                this.initializeDraggable();
            }

            // Stores the item locally
            addItem(item) {
                var items = this.items;

                var item = items[item.id] = {
                    'name': item.name,
                    'height': item.height,
                    'width': item.width,
                    'location': item.location
                };
            }

            // Stores the canvasItem locally and adds it to the view (canvas)
            addCanvasItem(canvasItem) {
                var items = this.items,
                    canvasItems = this.canvasItems;

                var canvasItem = canvasItems[canvasItem.id] = {
                    'id': canvasItem.id,
                    'item_id': canvasItem.item_id,
                    'position_x': canvasItem.position_x,
                    'position_y': canvasItem.position_y
                };

                var item = items[canvasItem.item_id];

                this.view.addCanvasItem(item, canvasItem);
            }

            // Updates the canvasItem position and syncs with grid
            // returns false if item is not allowed in this location
            updateCanvasItemPosition(canvasItem, positionX, positionY) {
                var canvasItemsGrid = this.canvasItemsGrid;

                if (positionX >= 0
                        && positionY >= 0
                        && positionX < canvasItemsGrid.length
                        && positionY < canvasItemsGrid.length) {
                    if (canvasItemsGrid[positionX][positionY] == -1) { // TODO: Also check if parent is moving into child and allow that
                        canvasItemsGrid[canvasItem.position_x][canvasItem.position_y] = -1; // Free up the old position

                        canvasItem.position_x = positionX;
                        canvasItem.position_y = positionY;

                        canvasItemsGrid[positionX][positionY] = canvasItem.id; // Occupy the new position

                        return true;
                    }
                }

                console.log('GO BACK TO ' + canvasItem.position_x);

                this.view.updateCanvasItemPosition(canvasItem.id, canvasItem.position_x, canvasItem.position_y); // Ensure the item doesn't move

                return false;
            }

            // Generates a grid array (Size: size * size) that shows all of the locations of canvasItems
            // -1 indicates no item is stored in that spot, anything else is the canvasItem id.
            // [
            //     [-1, -1, -1, 5, ..., 18],
            //     [2, -1, -1, -1, ..., -1],
            //     ...
            //     [-1, 3, -1, -1, ..., -1],
            // ]
            generateGrid(gridSize) {
                var canvasItemsGrid = this.canvasItemsGrid,
                    canvasItems = this.canvasItems;

                for (let i = 0; i <= gridSize; i++) {
                    canvasItemsGrid[canvasItemsGrid.push([]) - 1].length = gridSize;
                    canvasItemsGrid[i].fill(-1);
                }

                for (let i = 0; i < canvasItems.length; i++) {
                    canvasItemsGrid[canvasItems[i].position_x][canvasItems[i].position_y] = i;
                }
            }

            initializeDraggable() {
                var items = this.items,
                    canvasItems = this.canvasItems,
                    view = this.view
                    canvasController = this;

                $('.drag-item').draggable({
                    grid: [32, 32],
                    containment: '.drop-target',
                    drag: function() {
                        var parentCanvasItemId = $(this).attr('canvas-item-id');

                        // We need the new location of the canvasItem as it may be outdated in the canvasItems array
                        var newParentCanvasItemPositionX = $(this).position().left / 32;
                        var newParentCanvasItemPositionY = $(this).position().top / 32;

                        var oldParentCanvasItemPositionX = canvasItems[parentCanvasItemId].position_x;
                        var oldParentCanvasItemPositionY = canvasItems[parentCanvasItemId].position_y;

                        if (newParentCanvasItemPositionX != oldParentCanvasItemPositionX
                                || newParentCanvasItemPositionY != oldParentCanvasItemPositionY) { // Continue if the item has moved
                            if (canvasController.updateCanvasItemPosition(canvasItems[parentCanvasItemId], newParentCanvasItemPositionX, newParentCanvasItemPositionY)) { // TODO not working with parent?
                                var lastDeltaX = newParentCanvasItemPositionX - oldParentCanvasItemPositionX;
                                var lastDeltaY = newParentCanvasItemPositionY - oldParentCanvasItemPositionY;

                                selectedCanvasItems.parent.last_delta_x = lastDeltaX;
                                selectedCanvasItems.parent.last_delta_y = lastDeltaY;

                                var selectedCanvasItemIds = [parentCanvasItemId];

                                var sortedChildren = []; // Stores childrenIds sorted based on the parents movement direction. If the parent moves right, the children will update from right to left to prevent collisions

                                for (var childrenId in selectedCanvasItems.children) {
                                    if (Math.abs(lastDeltaX) >= Math.abs(lastDeltaY) && lastDeltaX > 0) {
                                        // right
                                        sortedChildren.push([childrenId, -selectedCanvasItems.children[childrenId].relative_position_x]);
                                    } else if (Math.abs(lastDeltaX) >= Math.abs(lastDeltaY) && lastDeltaX < 0) {
                                        // left
                                        sortedChildren.push([childrenId, selectedCanvasItems.children[childrenId].relative_position_x]);
                                    } else if (Math.abs(lastDeltaX) <= Math.abs(lastDeltaY) && lastDeltaY > 0) {
                                        // up
                                        sortedChildren.push([childrenId, -selectedCanvasItems.children[childrenId].relative_position_y]);
                                    } else if (Math.abs(lastDeltaX) <= Math.abs(lastDeltaY) && lastDeltaY < 0) {
                                        // down
                                        sortedChildren.push([childrenId, selectedCanvasItems.children[childrenId].relative_position_y]);
                                    }
                                }

                                sortedChildren.sort(
                                    function(a, b) {
                                        return a[1] - b[1];
                                    }
                                );

                                for (let i = 0; i < sortedChildren.length; i++) {
                                    var childCanvasItemId = sortedChildren[i][0];
                                    var childCanvasItem = canvasItems[childCanvasItemId];

                                    var childRelativePositionX = selectedCanvasItems.children[childCanvasItemId].relative_position_x;
                                    var childRelativePositionY = selectedCanvasItems.children[childCanvasItemId].relative_position_y;
                                    
                                    if (canvasController.updateCanvasItemPosition(
                                        childCanvasItem,
                                        newParentCanvasItemPositionX + childRelativePositionX,
                                        newParentCanvasItemPositionY + childRelativePositionY
                                    )) {
                                        view.removeCanvasItem(childCanvasItem);

                                        selectedCanvasItemIds.push(childCanvasItemId);

                                        view.addCanvasItem(items[childCanvasItem.item_id], childCanvasItem);
                                    } else {
                                        console.log('somethings already in that position or out of bounds (child)');
                                    }
                                }

                                canvasController.updateSelected(selectedCanvasItemIds);
                                canvasController.initializeDraggable();

                                // for (let i = 0; i < selectedPositions.length; i++) {
                                //     updateConnectedItems(selectedPositions[i][1][0], selectedPositions[i][1][1], [], null);

                                //     updateConnectedItems(selectedPositions[i][0][0], selectedPositions[i][0][1], [
                                //         [selectedPositions[i][1][0], selectedPositions[i][1][1], []]
                                //     ], 0);
                                // }
                            } else {
                                console.log('somethings already in that position or out of bounds (parent)');
                                return false;
                            }
                        }
                    },
                    // start: function() {
                    //     var activeItemId = $(this).attr('canvas-item-id');
                    //     storeActionHistory(activeItemId);
                    // },
                    // create: function() {
                    //     var activeItemId = $(this).attr('canvas-item-id');
                    //     updateConnectedItems(activeItems[activeItemId].position_x, activeItems[activeItemId].position_y, [], null);
                    // }
                });
            }

            // Handles canvasController.selectedCanvasItems which stores:
            //     Parent - The item the user is dragging/clicked on
            //     Children - Items (if any) that have a relative position to the parent
            // This will also update the selectedBoard in the view
            // Accepts array of canvasItemIds e.g. [2, 5, 7]
            updateSelected(canvasItemIds) {
                var canvasItems = this.canvasItems,
                    items = this.items,
                    view = this.view;

                var selectedBoardItems = [];

                canvasItemIds.forEach(function(canvasItemId, index) {
                    var selectedParentId = selectedCanvasItems.parent.id;
                    var childrenIndexOf = Object.keys(selectedCanvasItems.children).toString().split(',').map(Number).indexOf(canvasItemId); // Object.keys returns strings, lets change to integers to use indexOf

                    if (index == 0) {
                        if (selectedParentId != canvasItemId) {
                            if (childrenIndexOf != -1) { // If the new selected parent was a child, make the old selected parent a child (switch)
                                selectedCanvasItems.children[selectedParentId] = {
                                    relative_position_x: canvasItems[selectedParentId].position_x - canvasItems[canvasItemId].position_x,
                                    relative_position_y: canvasItems[selectedParentId].position_y - canvasItems[canvasItemId].position_y
                                }

                                delete selectedCanvasItems.children[canvasItemId];
                            } else {
                                selectedCanvasItems.children = {};
                            }
                        }

                        selectedCanvasItems.parent.id = canvasItemId;

                        selectedBoardItems[index] = {
                            id: canvasItemId,
                            position_x: canvasItems[canvasItemId].position_x,
                            position_y: canvasItems[canvasItemId].position_y,
                            location: items[canvasItems[canvasItemId].id].location,
                            name: items[canvasItems[canvasItemId].id].name
                        };
                    } else {
                        if (childrenIndexOf == -1) {
                            selectedCanvasItems.children[canvasItemIds[index]] = {
                                relative_position_x: canvasItems[canvasItemId].position_x - canvasItems[selectedParentId].position_x,
                                relative_position_y: canvasItems[canvasItemId].position_y - canvasItems[selectedParentId].position_y
                            }
                        }
                    }
                });

                for (var canvasItemId in selectedCanvasItems.children) {
                    var index = Object.keys(selectedCanvasItems.children).indexOf(canvasItemId) + 1;

                    selectedBoardItems[index] = {
                        id: canvasItemId,
                        position_x: canvasItems[canvasItemId].position_x,
                        position_y: canvasItems[canvasItemId].position_y,
                        location: items[canvasItems[canvasItemId].id].location,
                        name: items[canvasItems[canvasItemId].id].name
                    };
                }

                view.clearSelectedBoard(selectedCanvasItems);
                view.updateSelectedBoard(selectedBoardItems);
            }
        }

        function bootstrapper() {
            var classId = parseInt($('.class-button:first').attr('class-id'));

            canvasController = new CanvasController(classId);
            canvasController.loadItems();
        }

        bootstrapper(); // Start initializing

        // $.ui.draggable.prototype._generatePosition = function(event, constrainPosition) {
        //     var containment, co, top, left,
        //         o = this.options,
        //         scrollIsRootNode = this._isRootNode(this.scrollParent[0]),
        //         pageX = event.pageX,
        //         pageY = event.pageY;

        //     if (!scrollIsRootNode || !this.offset.scroll) {
        //         this.offset.scroll = {
        //             top: this.scrollParent.scrollTop(),
        //             left: this.scrollParent.scrollLeft()
        //         };
        //     }

        //     if (constrainPosition) {
        //         if (this.containment) {
        //             if (this.relativeContainer) {
        //                 co = this.relativeContainer.offset();
        //                 containment = [
        //                     this.containment[0] + co.left,
        //                     this.containment[1] + co.top,
        //                     this.containment[2] + co.left,
        //                     this.containment[3] + co.top
        //                 ];
        //             } else {
        //                 containment = this.containment;
        //             }

        //             if (event.pageX - this.offset.click.left < containment[0]) {
        //                 pageX = containment[0] + this.offset.click.left;
        //             }
        //             if (event.pageY - this.offset.click.top < containment[1]) {
        //                 pageY = containment[1] + this.offset.click.top;
        //             }
        //             if (event.pageX - this.offset.click.left > containment[2]) {
        //                 pageX = containment[2] + this.offset.click.left;
        //             }
        //             if (event.pageY - this.offset.click.top > containment[3]) {
        //                 pageY = containment[3] + this.offset.click.top;
        //             }
        //         }

        //         if (o.grid) {
        //             top = o.grid[1] ? this.originalPageY + Math.round((pageY - this.originalPageY) / o.grid[1]) * o.grid[1] : this.originalPageY;
        //             pageY = containment ? ((top - this.offset.click.top >= containment[1] || top - this.offset.click.top > containment[3]) ? top : ((top - this.offset.click.top >= containment[1]) ? top - o.grid[1] : top + o.grid[1])) : top;

        //             left = o.grid[0] ? this.originalPageX + Math.round((pageX - this.originalPageX) / o.grid[0]) * o.grid[0] : this.originalPageX;
        //             pageX = containment ? ((left - this.offset.click.left >= containment[0] || left - this.offset.click.left > containment[2]) ? left : ((left - this.offset.click.left >= containment[0]) ? left - o.grid[0] : left + o.grid[0])) : left;
        //         }

        //         if (o.axis === "y") {
        //             pageX = this.originalPageX;
        //         }

        //         if (o.axis === "x") {
        //             pageY = this.originalPageY;
        //         }
        //     }

        //     // This is the only part added to the original function.
        //     // You have access to the updated position after it's been
        //     // updated through containment and grid, but before the
        //     // element is modified.
        //     // If there's an item in position, you prevent dragging.
        //     let activeItemId = this.element.attr('canvas-item-id');

        //     var itemPositionX = Math.round((pageX - this.offset.click.left - this.offset.parent.left) / 32);
        //     var itemPositionY = Math.round((pageY - this.offset.click.top - this.offset.parent.top) / 32);

        //     var previousPositionX = Math.floor(activeItems[activeItemId].position_x);
        //     var previousPositionY = Math.floor(activeItems[activeItemId].position_y);

        //     var mousePositionX = Math.floor((event.pageX - this.element.parent().offset().left) / 32);
        //     var mousePositionY = Math.floor((event.pageY - this.element.parent().offset().top) / 32);

        //     var netMovementX = previousPositionX - itemPositionX;
        //     var netMovementY = previousPositionY - itemPositionY;

        //     var delta = [netMovementX, netMovementY];

        //     if (Math.abs(netMovementX) > Math.abs(netMovementY) && netMovementX > 0) {
        //         delta = [1, 0];
        //     } else if (Math.abs(netMovementX) > Math.abs(netMovementY) && netMovementX < 0) {
        //         delta = [-1, 0];
        //     } else if (Math.abs(netMovementY) > Math.abs(netMovementX) && netMovementY > 0) {
        //         delta = [0, 1];
        //     } else if (Math.abs(netMovementY) > Math.abs(netMovementX) && netMovementY < 0) {
        //         delta = [0, -1]
        //     }

        //     if (itemPositionX != previousPositionX
        //             || itemPositionY != previousPositionY) {
        //         if (getItemByPosition((pageX - this.offset.click.left - this.offset.parent.left) / 32, (pageY - this.offset.click.top - this.offset.parent.top) / 32) != -1) {
        //             if (getArrayInArray(moveAttempts, [mousePositionX, mousePositionY]) == -1) {
        //                 if (moveAttempts.length > 1) {
        //                     moveAttempts[moveAttempts.length - 2] = [moveAttempts[moveAttempts.length - 1][0], moveAttempts[moveAttempts.length - 1][1]];
        //                     moveAttempts[moveAttempts.length - 1] = [mousePositionX, mousePositionY];
        //                 } else {
        //                     moveAttempts = [[mousePositionX, mousePositionY], [itemPositionX, itemPositionY]];
        //                 }

        //                 var netMovementX = moveAttempts[moveAttempts.length - 2][0] - moveAttempts[moveAttempts.length - 1][0];
        //                 var netMovementY = moveAttempts[moveAttempts.length - 2][1] - moveAttempts[moveAttempts.length - 1][1];

        //                 if (Math.abs(netMovementX) > Math.abs(netMovementY) && netMovementX > 0) {
        //                     delta = [1, 0];
        //                 } else if (Math.abs(netMovementX) > Math.abs(netMovementY) && netMovementX < 0) {
        //                     delta = [-1, 0];
        //                 } else if (Math.abs(netMovementY) > Math.abs(netMovementX) && netMovementY > 0) {
        //                     delta = [0, 1];
        //                 } else if (Math.abs(netMovementY) > Math.abs(netMovementX) && netMovementY < 0) {
        //                     delta = [0, -1]
        //                 }

        //                 selectedPositions = [
        //                     [
        //                         [previousPositionX, previousPositionY],
        //                         [previousPositionX, previousPositionY],
        //                         delta
        //                     ]
        //                 ];
        //             } else {
        //                 selectedPositions = [];
        //             }
        //             return false;
        //         } else {
        //             this.element.css('left', itemPositionX * 32);
        //             this.element.css('top', itemPositionY * 32);
        //             selectedPositions = [
        //                 [
        //                     [previousPositionX, previousPositionY],
        //                     [itemPositionX, itemPositionY],
        //                     delta
        //                 ]
        //             ];
        //         }
        //     } else {
        //         selectedPositions = [];
        //     }

        //     moveAttempts = [];

        //     return {
        //         top: (
        //             pageY -
        //             this.offset.click.top -
        //             this.offset.relative.top -
        //             this.offset.parent.top +
        //             (this.cssPosition === "fixed" ? -this.offset.scroll.top : (scrollIsRootNode ? 0 : this.offset.scroll.top))
        //         ),
        //         left: (
        //             pageX -
        //             this.offset.click.left -
        //             this.offset.relative.left -
        //             this.offset.parent.left +
        //             (this.cssPosition === "fixed" ? -this.offset.scroll.left : (scrollIsRootNode ? 0 : this.offset.scroll.left))
        //         )
        //     };
        // }

        // var items = [],
        //     activeItems = [],
        //     activeItemsGrid = [],
        //     selectedIds = [],
        //     selectedNames = [],
        //     selectedPositions = [],
        //     softDeletedActiveItems = [],
        //     copyClipboard = [],
        //     actionHistory = [];

        // var classId = parseInt($('.class-button:first').attr('class-id'));

        // var hasItems = false,
        //     hasChanged = false;

        // var selectedTriedPositions = [];

        // function initializeDraggable()
        // {
        //     $('.drag-item').draggable({
        //         grid: [32, 32],
        //         containment: '.drop-target',
        //         drag: function() {
        //             hasChanged = true;

        //             let activeItemId = $(this).attr('canvas-item-id');

        //             var itemPositionX = $(this).position().left / 32;
        //             var itemPositionY = $(this).position().top / 32;

        //             var previousPositionX = Math.floor(activeItems[activeItemId].position_x);
        //             var previousPositionY = Math.floor(activeItems[activeItemId].position_y);

        //             if (selectedPositions.length > 0) {
        //                 var selectedItems = [$(this)];

        //                 var selectedItem,
        //                     selectedItemPreviousPositionX,
        //                     selectedItemPreviousPositionY,
        //                     selectedItemPositionX,
        //                     selectedItemPositionY,
        //                     selectedTriedPosition;

        //                 for(let i = 0; i < selectedIds.length; i++) {
        //                     if(selectedIds[i] == activeItemId)
        //                         continue;
        //                     selectedItem = $('div[canvas-item-id=' + selectedIds[i] + ']');

        //                     selectedItemPreviousPositionX = selectedItem.position().left / 32;
        //                     selectedItemPreviousPositionY = selectedItem.position().top / 32;

        //                     selectedItemPositionX = selectedItemPreviousPositionX - selectedPositions[0][2][0];
        //                     selectedItemPositionY = selectedItemPreviousPositionY - selectedPositions[0][2][1];

        //                     selectedTriedPosition = getArrayInArray(selectedTriedPositions, [selectedItemPositionX, selectedItemPositionY]);

        //                     if(selectedItemPreviousPositionX != selectedItemPositionX
        //                             || selectedItemPreviousPositionY != selectedItemPositionY
        //                             || selectedTriedPosition != -1) {
        //                         if(getItemByPosition(selectedItemPositionX, selectedItemPositionY) == -1
        //                                 || selectedTriedPosition != -1) {
        //                             if(selectedTriedPosition != -1) {
        //                                 selectedItemPositionX -= selectedPositions[0][2][0];
        //                                 selectedItemPositionY -= selectedPositions[0][2][1];
        //                                 selectedTriedPositions.splice(selectedTriedPosition, 1);
        //                             }
        //                             selectedItem.css('left', selectedItemPositionX * 32);
        //                             selectedItem.css('top', selectedItemPositionY * 32);
        //                         } else {
        //                             selectedTriedPositions.push([selectedItemPositionX, selectedItemPositionY]);
        //                         }
        //                     } else {
        //                         selectedTriedPositions.push([selectedItemPositionX, selectedItemPositionY]);
        //                     }
                            
        //                     selectedItems.push(selectedItem);
        //                     selectedPositions.push([[selectedItemPreviousPositionX, selectedItemPreviousPositionY], [selectedItemPositionX, selectedItemPositionY]]);
        //                 }
        //                 updateSelected(selectedItems);
        //                 for(let i = 0; i < selectedPositions.length; i++) {
        //                     updateConnectedItems(selectedPositions[i][1][0], selectedPositions[i][1][1], [], null);

        //                     updateConnectedItems(selectedPositions[i][0][0], selectedPositions[i][0][1], [
        //                         [selectedPositions[i][1][0], selectedPositions[i][1][1], []]
        //                     ], 0);
        //                 }
        //                 selectedPositions = [];
        //             }
        //         },
        //         start: function() {
        //             let activeItemId = $(this).attr('canvas-item-id');
        //             storeActionHistory(activeItemId);
        //         },
        //         create: function() {
        //             let activeItemId = $(this).attr('canvas-item-id');
        //             updateConnectedItems(activeItems[activeItemId].position_x, activeItems[activeItemId].position_y, [], null);
        //         }
        //     });
        // }

        // function getArrayInArray(arrayToSearch, arrayToFind)
        // {
        //     for (let i = 0; i < arrayToSearch.length; i++) {
        //         if (arrayToSearch[i][0] == arrayToFind[0] && arrayToSearch[i][1] == arrayToFind[1]) {
        //             return i;
        //         }
        //     }
        //     return -1;
        // }

        // function getItemByPosition(itemPositionX, itemPositionY)
        // {
        //     return activeItemsGrid[itemPositionX][itemPositionY];
        // }

        // function updateConnectedItems(itemPositionX, itemPositionY, checkExemptions, pushedIndex)
        // {
        //     var activeItemId = getItemByPosition(itemPositionX, itemPositionY);

        //     var hasAlreadyBeenChecked,
        //         itemInCheckPosition;

        //     var arrayOfKeys = [],
        //         adjacentDirections = [
        //             ['northwest', 'north', 'northeast'],
        //             ['west',       null,   'east'],
        //             ['southwest', 'south', 'southeast']
        //         ];

        //     if (pushedIndex === null) {
        //         pushedIndex = checkExemptions.push([itemPositionX, itemPositionY, []]) - 1;
        //     }

        //     if (activeItemId == -1 || activeItems[activeItemId].item_id == 1) {
        //         if (itemPositionX - 1 >= 0 && itemPositionX + 1 <= 23 && itemPositionY - 1 >= 0 && itemPositionY + 1 <= 23) {
        //             for (let i = 0; i < 3; i++) {
        //                 for (let x = 0; x < 3; x++) {
        //                     if (i == 1 && x == 1) {
        //                         continue;
        //                     }

        //                     var checkPositionX = itemPositionX - 1 + x;
        //                     var checkPositionY = itemPositionY - 1 + i;

        //                     hasAlreadyBeenChecked = getArrayInArray(checkExemptions, [checkPositionX, checkPositionX]);

        //                     if (hasAlreadyBeenChecked == -1) {
        //                         itemInCheckPosition = getItemByPosition(checkPositionX, checkPositionY);
        //                         if (itemInCheckPosition != -1 && activeItems[itemInCheckPosition].item_id == 1) {
        //                             if (adjacentDirections[i][x].length == 9) {
        //                                 itemInCheckPosition = [
        //                                     getItemByPosition(itemPositionX, checkPositionY),
        //                                     getItemByPosition(checkPositionX, itemPositionY)
        //                                 ];
        //                                 if (itemInCheckPosition[0] != -1 
        //                                         && activeItems[itemInCheckPosition[0]].item_id == 1
        //                                         && itemInCheckPosition[1] != -1
        //                                         && activeItems[itemInCheckPosition[1]].item_id == 1) {
        //                                     checkExemptions[pushedIndex][2].push([checkPositionX, checkPositionY, adjacentDirections[i][x], pushedIndex > 0 ? true : false]);
        //                                 }
        //                             } else {
        //                                 checkExemptions[pushedIndex][2].push([checkPositionX, checkPositionY, adjacentDirections[i][x], pushedIndex > 0 ? true : false]);
        //                             }
        //                         }
        //                     }
        //                 }
        //             }
        //         }

        //         if (checkExemptions[pushedIndex][2].length > 0) {
        //             //Gets directions from checkExemptions e.g. [["south", 1, 3], ["west", 0, 3]] => ["south", "west"] => "south-west"
        //             arrayOfKeys = [];
        //             for (let x = 0; x < checkExemptions[pushedIndex][2].length; x++) {
        //                 arrayOfKeys.push(checkExemptions[pushedIndex][2][x][2]);
        //             }

        //             if (activeItemId !== null) {
        //                 $('div[canvas-item-id=' + activeItemId + ']').css('background-image', 'url(\'' + assetsBasePath + 'desk-connected-' + arrayOfKeys.join('-') + '.png\')');
        //             }

        //             if (!checkExemptions[pushedIndex][2][0][3]) {
        //                 for (let x = 0; x < checkExemptions[pushedIndex][2].length; x++) {
        //                     if (getArrayInArray(checkExemptions, [checkExemptions[pushedIndex][2][x][0], checkExemptions[pushedIndex][2][x][1]]) == -1) {
        //                         updateConnectedItems(checkExemptions[pushedIndex][2][x][0], checkExemptions[pushedIndex][2][x][1], checkExemptions, null);
        //                     }
        //                 }
        //             }
        //         } else if (activeItemId != -1 && $('div[canvas-item-id=' + activeItemId + ']').css('background-image').indexOf('desk-connected-') > -1) {
        //             $('div[canvas-item-id=' + activeItemId + ']').css('background-image', 'url(\'' + assetsBasePath + items[activeItems[activeItemId].item_id].item_location + '\')');
        //         }
        //     }
        //     return checkExemptions;
        // }

        // function updateItemByPosition(activeItemId, itemPositionX, itemPositionY) {
        //     var previousPositionX = activeItems[activeItemId].item_position_x;
        //     var previousPositionY = activeItems[activeItemId].position_y;

        //     activeItemsGrid[previousPositionX][previousPositionY] = -1;

        //     activeItemsGrid[itemPositionX][itemPositionY] = activeItemId;

        //     activeItems[activeItemId].position_x = itemPositionX;
        //     activeItems[activeItemId].position_y = itemPositionY;
        // }

        // function saveActiveItems(message)
        // {
        //     var userConfirmation = message !== null ? confirm(message) : true;

        //     if (userConfirmation) {
        //         deleteActiveItems(softDeletedActiveItems);
        //         $.ajax({
        //             url: '/class-item',
        //             type: 'POST',
        //             data: {
        //                 _token: token,
        //                 items: activeItems,
        //                 class_id: classId
        //             }
        //         }).done(function(returnedActiveItems) {
        //             activeItems = returnedActiveItems;
        //         });
        //     }
        // }

        // function softDeleteActiveItems(activeItemIds)
        // {
        //     for (let i = 0; i < activeItemIds.length; i++) {
        //         var activeItem = $('div[canvas-item-id="' + activeItemIds[i] + '"]');
        //         softDeletedActiveItems.push(activeItems[activeItemIds[i]]);

        //         activeItem.fadeOut('slow', function() {
        //             $(this).remove();
        //             delete activeItems[activeItemIds[i]];

        //             if (i == activeItemIds.length - 1) {
        //                 if ($('.drop-target').children().length > 0) {
        //                     updateSelected([$('div[canvas-item-id="' + $('.drop-target').children(0).attr('canvas-item-id') + '"]')]);
        //                 }
        //             }
        //         });
        //     }
        // }

        // function deleteActiveItems(softDeletedActiveItems)
        // {
        //     if (softDeletedActiveItems.length > 0) {
        //         $.ajax({
        //             url: '/class-item',
        //             type: 'DELETE',
        //             data: {
        //                 _token: token,
        //                 class_items: softDeletedActiveItems,
        //                 class_id: classId
        //             }
        //         });

        //         softDeletedActiveItems = [];
        //     }
        // }

        // function clearSession()
        // {
        //     var activeClassItems = $('.drop-target').children();

        //     activeClassItems.fadeOut(1000, function() {
        //         $(this).remove();
        //     });

        //     activeItems = [];
        // }
    </script>
@stop