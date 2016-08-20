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
            <div class="row row-sortable">
                <div class="col-md-8">
                    <div class="panel panel-white">
                        <div class="panel-heading">
                            <h6 class="panel-title"><span class="text-semibold">Seating Planner</span> <span class="text-muted"><small id="class-name">Year 11<small></span></h6>
                            <div class="heading-elements">
                                <ul class="pagination pagination-flat pagination-sm">
                                    <li><a href="javascript:void(0);">←</a></li>
                                    <li class="active"><a href="javascript:void(0);">1</a></li>
                                    <li><a href="javascript:void(0);">2</a></li>
                                    <li><a href="javascript:void(0);">3</a></li>
                                    <li><a href="javascript:void(0);">→</a></li>
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
                            @if (isset($classes))
                                @foreach ($classes as $key => $class)
                                    <li>
                                        <a href="javascript:void(0);" class="class-button" class-id="{{ $class->id }}">{{ $class->class_name }}</a>
                                        <div class="btn-group">
                                            <a href="javascript:void(0);" class="btn btn-primary btn-icon dropdown-toggle class-options" data-toggle="dropdown" class-id="{{ $class->id }}">
                                                <i class="icon-menu7"></i>
                                                <span class="caret"></span>
                                            </a>
                                            <ul class="dropdown-menu dropdown-menu-right">
                                                <li><a href="{{ url('dashboard/classes/' . $class->id . '/duplicate') }}" data-toggle="modal" data-target="#modal_form_inline">Duplicate class template</a></li>
                                                <li class="divider"></li>
                                                <li><a href="javascript:void(0);" class="clear-seatingplan" data-toggle="modal" data-target="#modal_delete_seatingplan">Clear seating plan</a></li>
                                                <li><a href="javascript:void(0);" class="delete-class" data-toggle="modal" data-target="#modal_delete_class">Delete class</a></li>
                                            </ul>
                                        </div> 
                                    </li>
                                @endforeach
                                <li>
                                <br />
                            @else
                                <li>
                            @endif
                                <a href="javascript:void(0);" class="class-button-create">Create a new class</a>
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
                                    <li><a title="" data-popup="tooltip" data-action="move" href="javascript:void(0);" data-original-title="Move" class="ui-sortable-handle"></a></li>
                                    <li><a title="" data-popup="tooltip" data-action="collapse" data-original-title="Collapse" class=""></a></li>
                                </ul>
                                <form class="heading-form" action="javascript:void(0);" hidden>
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
                                <form action="javascript:void(0);" class="heading-form" style="margin-left: 0px; margin-right: -12px;">
                                    <div class="form-group has-feedback">
                                        <input type="search" placeholder="Search..." class="form-control" style="width: 180px;">
                                        <div class="form-control-feedback">
                                            <i class="icon-search4 text-size-base text-muted"></i>
                                        </div>
                                    </div>
                                </form>
                                <ul class="icons-list">
                                    <li><a title="" data-popup="tooltip" data-action="move" href="javascript:void(0);" data-original-title="Move" class="ui-sortable-handle"></a></li>
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
                                                        <a class="btn border-white text-white btn-flat btn-icon btn-rounded create-canvas-item" href="javascript:void(0);" item-id={{ $item->id }}><i class="icon-plus3"></i></a>
                                                    </span>
                                                </div>
                                            </div>

                                            <div class="caption" style="padding-top: 5px; padding-bottom: 5px; padding-left: 5px;">
                                                <h6 class="no-margin"><a href="javascript:void(0);" class="text-default" style="font-size: 10px;">{{ $item->name }}</a></h6>
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
    <script type="text/javascript" src="{{ asset('assets/js/plugins/drag_selection.js') }}"></script>

    <script>
        $(document).ready(function() {
            $('.drop-target').on('mousedown', '.drag-item', function() {
                var canvasItemId = canvasController.view.getCanvasItemId($(this));
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

            $('.drop-target').on('click', '.drag-item', function() {
                var canvasItemId = canvasController.view.getCanvasItemId($(this));

                canvasController.updateSelected([], false);
                canvasController.updateSelected([canvasItemId]);
            });

            $('.create-canvas-item').click(function() {
                var itemId = parseInt($(this).attr('item-id'));

                canvasController.createPseudoCanvasItem(itemId);
            });

            $('#save-button').click(function() {
                canvasController.saveCanvasItems();
            });

            $('.class-button').click(function() {
                if (!$(this).hasClass('class-button-active')) {
                    if (hasUserMadeChanges) {
                        canvasController.confirmPageLeave($(this));
                    } else {
                        canvasController.view.changeClass($(this));
                    }
                }
            });

            $('#selected-delete').click(function() {
                canvasController.softDeleteCanvasItems();
            });

            $(document).on('keydown', function(e) {
                if ((e.which === 8 || e.which === 46) && !$(e.target).is('input, textarea')) { // The 'delete' or 'backspace' key, but not when the user is typing
                    e.preventDefault();
                    canvasController.softDeleteCanvasItems();
                } else if (e.ctrlKey || e.metaKey) { // The 'ctrl' (windows) or 'cmd' (mac) key
                    if (e.which == 90) { // The 'z' key (combined with ctrl or cmd)
                        historyController.undoCanvasAction();
                    } else if (e.which == 89) { // The 'y' key (combined with ctrl or cmd)
                        historyController.redoCanvasAction();
                    }
                }/* else if ((e.ctrlKey && e.keyCode == 0x56) || (e.metaKey && e.keyCode == 0x56)) {
                    pasteActiveItem();
                }*/
            }).bind('copy', function() {
                //copyActiveItem(false);
            }).bind('cut', function() {
                //copyActiveItem(true);
            });

            $(document).on('click', 'a', function(event) {
                if (hasUserMadeChanges) {
                    event.preventDefault();

                    var clickedLink = $(this).attr('href');

                    if (clickedLink != 'javascript:void(0);') {
                        canvasController.confirmPageLeave(null, clickedLink);
                    }
                }
            });

            bootstrapper(); // Start initializing
        });

        var token = '{{ csrf_token() }}';
        var assetsBasePath = '{{ asset('assets/images/objects') }}/';

        var canvasController,
            historyController,
            notificationController,
            utils;

        var hasUserMadeChanges = false;

        var selectedCanvasItems = {
            parent: {},
            children: {}
        };

        var rect; // The drag rectangle used in drag_selection.js

        class View {
            addCanvasItem(item, canvasItem) {
                var canvasItemId = canvasItem.id;
                var canvasItemPositionX = canvasItem.position_x * 32;
                var canvasItemPositionY = canvasItem.position_y * 32;

                var itemLocation = item.location;
                var itemWidth = item.width;
                var itemHeight = item.height;

                $('.drop-target').append(
                    '<div class="drag-item" canvas-item-id="' + canvasItemId + '" style="display: none; left: ' + canvasItemPositionX + 'px; top: ' + canvasItemPositionY + 'px; background-image: url(\'{{ asset('assets/images/objects') }}/' + itemLocation + '\'); background-size: ' + itemWidth + 'px; height: ' + itemHeight + 'px; width: ' + itemWidth + 'px;"></div>'
                );

                $('.drop-target').children().show();
            }

            updateCanvasItemPosition(canvasItemId, canvasItemPositionX, canvasItemPositionY) {
                var canvasItem = this.getCanvasItem(canvasItemId);

                canvasItem.css('left', canvasItemPositionX * 32);
                canvasItem.css('top', canvasItemPositionY * 32);
            }

            removeCanvasItem(canvasItemId) {
                this.getCanvasItem(canvasItemId).remove();
            }

            removeCanvasItems() {
                $('.drag-item').fadeOut(1000, function() {
                    $(this).remove();
                });
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
                $('#selected-delete').html('Delete <i class="icon-diff-removed position-right"></i>');

                for (var index in selectedBoardItems) {
                    var selectedBoardItem = selectedBoardItems[index];

                    var selectedBoardItemId = selectedBoardItem.id;

                    var selectedBoardItemPositionX = selectedBoardItem.position_x;
                    var selectedBoardItemPositionY = selectedBoardItem.position_y;

                    if (index == 1) {
                        $('#selected-delete').html('Delete All <i class="icon-diff-removed position-right"></i>');
                    }

                    if (index == 2) {
                        $('#selected-position').append('<strong>' + selectedBoardItems[Object.keys(selectedBoardItems).length - 1].name + '</strong>');
                    } else if (index < 2) {
                        $('#selected-position').append('<strong>X:</strong> ' + selectedBoardItemPositionX + ', <strong>Y:</strong> ' + selectedBoardItemPositionY + '<br />');
                    }

                    this.getCanvasItem(selectedBoardItemId).addClass('outline-highlight');
                }
            }

            getCanvasItemId(element) {
                return element.attr('canvas-item-id');
            }

            getCanvasItem(canvasItemId) {
                return $('.drag-item[canvas-item-id=' + canvasItemId + ']');
            }

            isCanvasItemConnected(canvasItemId) {
                var canvasItem = this.getCanvasItem(canvasItemId);

                if (canvasItem.css('background-image').indexOf('desk-connected-') > -1) {
                    return true;
                }

                return false;
            }

            updateCanvasItemBackgroundImage(canvasItemId, canvasBackgroundImage) {
                var canvasItemElement = this.getCanvasItem(canvasItemId);
                
                canvasItemElement.css('background-image', 'url(\'' + assetsBasePath + canvasBackgroundImage + '\')');
            }

            setActiveClass(classId) {
                $('.class-button-active').removeClass('class-button-active').addClass('class-button');
                $('.class-options-active').removeClass('class-options-active').addClass('class-options');

                $('.class-button[class-id=' + classId + ']').removeClass('class-button').addClass('class-button-active');
                $('.class-options[class-id=' + classId + ']').removeClass('class-options').addClass('class-options-active');

                $('#classes-href').attr('href', '{{ url('dashboard/classes') }}/' + classId);
                $('.class-button-create').attr('href', '{{ url('dashboard/classes') }}/' + classId + '/create');

                $('#class-name').text($('.class-button-active[class-id=' + classId + ']').text());
            }

            changeClass(buttonElement) {
                hasUserMadeChanges = false;

                $('.class-button.class-button-active').removeClass('class-button-active');
                buttonElement.addClass('class-button-active');

                $('.class-options-active').removeClass('class-options-active').addClass('class-options');
                buttonElement.parent()
                    .children().eq(1)
                    .children().eq(0)
                    .addClass('class-options-active')
                    .removeClass('class-options');

                var classId = parseInt(buttonElement.attr('class-id'));
                canvasController.view.setActiveClass(classId);

                canvasController.classId = classId;
                canvasController.clearSession();
                canvasController.loadCanvasItems();

                historyController.loadCanvasHistory();
            }
        }

        // Canvas history is the previous actions a user has taken on the canvas
        // e.g. canvasItem 1 movement to X: 5, Y: 8

        // TODO: update this
        // Example:
        // [
        //    {
        //       "id": 1,
        //       "canvas_item_id": "1",
        //       "type": "movement",
        //       "previous_position_x": 5,
        //       "previous_position_y": 8 
        //    }
        // ]
        class CanvasHistoryModel {
            index(classId) {
                $.APIAjax({
                    url: '{{ url('api/canvas-history') }}',
                    type: 'GET',
                    data: {
                        class_id: classId
                    },
                    success: function(jsonResponse) {
                        historyController.jsonCanvasHistory = jsonResponse;

                        historyController.init();
                    },
                    error: function(jsonResponse) {}
                });
            }

            store(classId, canvasHistory, canvasActionUndoCount, buttonElement = null, externalLink = null) {
                $.APIAjax({
                    url: '{{ url('api/canvas-history') }}',
                    type: 'POST',
                    data: {
                        canvas_history: canvasHistory,
                        canvas_action_undo_count: canvasActionUndoCount,
                        class_id: classId
                    },
                    success: function(jsonResponse) {
                        setTimeout(function() {
                            if (buttonElement != null) {
                                canvasController.view.changeClass(buttonElement);
                            } else if (externalLink != null) {
                                window.location.href = externalLink;
                            }
                        }, 2000);
                    },
                    error: function(jsonReponse) {}
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
            index(classId) {
                $.APIAjax({
                    url: '{{ url('api/canvas-item') }}',
                    type: 'GET',
                    data: {
                        class_id: classId
                    },
                    success: function(jsonResponse) {
                        canvasController.jsonCanvasItems = jsonResponse;

                        canvasController.init();
                    },
                    error: function(jsonResponse) {}
                });
            }

            store(classId, canvasItem) {
                $.APIAjax({
                    url: '{{ url('api/canvas-item') }}',
                    type: 'POST',
                    async: false, // TODO: Needs better solution
                    data: {
                        canvas_item: canvasItem,
                        class_id: classId
                    },
                    success: function(jsonResponse) {
                        var returnedCanvasItem = jsonResponse.canvas_item;

                        canvasController.updatePseudoCanvasItemToReal(canvasItem.id, returnedCanvasItem.id, returnedCanvasItem.deleted_at == null ? false : true);

                        canvasItem.id = returnedCanvasItem.id;

                        if (returnedCanvasItem.deleted_at == null) {
                            canvasController.addCanvasItem(canvasItem);
                        } else {
                            canvasController.addSoftDeletedCanvasItem(canvasItem);
                        }
                    },
                    error: function(jsonResponse) {}
                });
            }

            batchDestroy(classId, softDeletedCanvasItems) {
                $.APIAjax({
                    url: '{{ url('api/canvas-item') }}',
                    type: 'DELETE',
                    data: {
                        canvas_items: softDeletedCanvasItems,
                        class_id: classId
                    },
                    success: function(jsonResponse) {},
                    error: function(jsonReponse) {}
                });
            }

            batchUpdate(classId, canvasItems) {
                $.APIAjax({
                    url: '{{ url('api/canvas-item') }}',
                    type: 'PUT',
                    data: {
                        canvas_items: canvasItems,
                        class_id: classId
                    },
                    success: function(jsonResponse) {},
                    error: function(jsonReponse) {}
                });
            }
        }

        class CanvasController {
            constructor(classId, gridSize = 23) {
                this.jsonItems = [
                    @if (isset($items))
                        @foreach ($items as $item)
                            {
                                'id': '{{ $item->id }}',
                                'name': '{{ $item->name }}',
                                'width': '{{ $item->width }}',
                                'height': '{{ $item->height }}',
                                'location': '{{ $item->location }}',
                            },
                        @endforeach
                    @endif
                ],
                this.jsonCanvasItems;

                this.canvasItems = {}, // e.g. Table is stored at X: 5, Y: 8 in the grid
                this.items = {}, // e.g. A Table desk.png, A Teachers Desk teachers_desk.png
                this.canvasItemsGrid = [], // e.g. Grid of all possible locations to store items
                this.softDeletedCanvasItems = {};

                this.classId = classId,
                this.gridSize = gridSize;

                this.canvasItemModel = new CanvasItemModel,

                this.view = new View;
            }

            loadCanvasItems() {
                this.canvasItemModel.index(this.classId);
            }

            init() {
                var jsonItems = this.jsonItems,
                    jsonCanvasItems = this.jsonCanvasItems;

                var items = this.items,
                    canvasItems = this.canvasItems; 

                this.generateGrid(this.gridSize);

                // Take JSON array of all items and store them locally
                for (var jsonItem in jsonItems) {
                    var item = jsonItems[jsonItem];

                    this.addItem(item);
                }

                if (jsonCanvasItems.canvas_items.canvas_items.length > 0) {
                    // Take JSON array of all canvasItems and store them locally
                    for (var jsonCanvasItem in jsonCanvasItems.canvas_items.canvas_items) {
                        var canvasItem = jsonCanvasItems.canvas_items.canvas_items[jsonCanvasItem];

                        this.addCanvasItem(canvasItem);
                    }

                    for (var jsonSoftDeletedCanvasItem in jsonCanvasItems.canvas_items.soft_deleted_canvas_items) {
                        var softDeletedCanvasItem = jsonCanvasItems.canvas_items.soft_deleted_canvas_items[jsonSoftDeletedCanvasItem];

                        this.addSoftDeletedCanvasItem(softDeletedCanvasItem);
                    }
                } else {
                    this.updateSelected([]); 
                }
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

            // A pseudo canvasItem is only stored locally, and will be stored to the database on-save 
            createPseudoCanvasItem(itemId) {
                this.createCanvasItem(itemId, true);
            }

            createCanvasItem(itemId, isPseudoCanvasItem = false) {
                var canvasItems = this.canvasItems,
                    canvasItemModel = this.canvasItemModel,
                    classId = this.classId;

                var canvasItem = {
                    item_id: itemId
                };

                hasUserMadeChanges = true;

                if (isPseudoCanvasItem) {
                    canvasItem.id = 'Pseudo-' + Math.floor(Math.random() * 99999) + 1
                }

                if (!$.isEmptyObject(selectedCanvasItems.parent)) {
                    var parentCanvasItemPositionX = canvasItems[selectedCanvasItems.parent.id].position_x;
                    var parentCanvasItemPositionY = canvasItems[selectedCanvasItems.parent.id].position_y;

                    var nearestEmptySpace = this.getNearestEmpty(parentCanvasItemPositionX, parentCanvasItemPositionY, 5, 5);

                    if (nearestEmptySpace != -1) {
                        canvasItem.position_x = nearestEmptySpace[0];
                        canvasItem.position_y = nearestEmptySpace[1];

                        return isPseudoCanvasItem ? this.addCanvasItem(canvasItem, true) : canvasItemModel.create(classId, canvasItem);
                    }
                }

                canvasItem.position_x = 0;
                canvasItem.position_y = 0;

                return isPseudoCanvasItem ? this.addCanvasItem(canvasItem, true) : canvasItemModel.create(classId, canvasItem);
            }

            // Stores the canvasItem locally and adds it to the view (canvas)
            addCanvasItem(canvasItem, isPseudoCanvasItem = false) {
                var items = this.items,
                    canvasItems = this.canvasItems,
                    canvasItemsGrid = this.canvasItemsGrid;

                var canvasItem = canvasItems[canvasItem.id] = {
                    'id': canvasItem.id,
                    'item_id': canvasItem.item_id,
                    'position_x': canvasItem.position_x,
                    'position_y': canvasItem.position_y,
                    'pseudo_item': isPseudoCanvasItem,
                    'soft_deleted': false
                };

                var item = items[canvasItem.item_id];
                
                canvasItemsGrid[canvasItem.position_x][canvasItem.position_y] = canvasItem.id;

                this.view.addCanvasItem(item, canvasItem); // Render canvas item to view
                this.updateSelected([canvasItem.id]); // Select the newly added item
                this.initializeDraggable(); // Allow it to be dragged

                if (isPseudoCanvasItem) {
                    historyController.addCanvasHistory({
                        canvas_item_id: canvasItem.id,
                        item_id: canvasItem.item_id,
                        type: 'addition',
                        previous_position_x: canvasItem.position_x,
                        previous_position_y: canvasItem.position_y,
                        position_x: null,
                        position_y: null
                    });
                }
            }

            addSoftDeletedCanvasItem(softDeletedCanvasItem) {
                var items = this.items,
                    softDeletedCanvasItems = this.softDeletedCanvasItems;

                softDeletedCanvasItems[softDeletedCanvasItem.id] = {
                    'id': softDeletedCanvasItem.id,
                    'item_id': softDeletedCanvasItem.item_id,
                    'position_x': softDeletedCanvasItem.position_x,
                    'position_y': softDeletedCanvasItem.position_y,
                    'pseudo_item': softDeletedCanvasItem.pseudo_item,
                    'soft_deleted': true
                };
            }

            updatePseudoCanvasItemToReal(oldCanvasItemId, newCanvasItemId, isSoftDeleted = false) {
                var canvasItemsGrid = this.canvasItemsGrid,
                    canvasItems,
                    canvasHistory = historyController.canvasHistory;

                if (isSoftDeleted) {
                    canvasItems = this.softDeletedCanvasItems;
                } else {
                    canvasItems = this.canvasItems;
                }

                Object.defineProperty(canvasItems, newCanvasItemId,
                    Object.getOwnPropertyDescriptor(canvasItems, oldCanvasItemId));

                delete canvasItems[oldCanvasItemId];

                var canvasItem = canvasItems[newCanvasItemId];

                canvasItem.pseudo_item = false;
                canvasItem.id = newCanvasItemId;


                if (!isSoftDeleted) {
                    canvasItemsGrid[canvasItem.position_x][canvasItem.position_y] = newCanvasItemId;
                }
                
                $.grep(canvasHistory, function(e){
                    if (e.canvas_item_id == oldCanvasItemId) {
                        e.canvas_item_id = newCanvasItemId;
                    }
                });

                historyController.canvasHistory = canvasHistory;
            }

            removeCanvasItem(canvasItemId) {
                var canvasItems = this.canvasItems,
                    canvasItemsGrid = this.canvasItemsGrid,
                    softDeletedCanvasItems = this.softDeletedCanvasItems, 
                    view = this.view;

                var canvasItem = canvasItems[canvasItemId];

                canvasItemsGrid[canvasItem.position_x][canvasItem.position_y] = -1;

                this.updateConnectedCanvasItems(canvasItem.position_x, canvasItem.position_y, [], null)

                this.addSoftDeletedCanvasItem(canvasItem);
                delete canvasItems[canvasItem.id];

                view.removeCanvasItem(canvasItemId);
            }

            restoreSoftDeletedCanvasItem(softDeletedCanvasItemId) {
                var softDeletedCanvasItems = this.softDeletedCanvasItems;

                this.addCanvasItem($.extend({}, softDeletedCanvasItems[softDeletedCanvasItemId]));

                delete softDeletedCanvasItems[softDeletedCanvasItemId];
            }

            softDeleteCanvasItem(canvasItemId) {
                var canvasItems = this.canvasItems;

                this.removeCanvasItem(canvasItemId);

                this.updateSelected(Object.keys(canvasItems).length > 0 ? [Object.keys(canvasItems)[0]] : []);
            }

            softDeleteCanvasItems() {
                var canvasItems = this.canvasItems,
                    selectedIds = this.getSelectedIds();

                for (var index in selectedIds) {
                    var canvasItemId = selectedIds[index];

                    historyController.addCanvasHistory({
                        canvas_item_id: canvasItemId,
                        type: 'deletion',
                        previous_position_x: canvasItems[canvasItemId].position_x,
                        previous_position_y: canvasItems[canvasItemId].position_y,
                        position_x: null,
                        position_y: null
                    });

                    this.removeCanvasItem(canvasItemId);
                }

                this.updateSelected(Object.keys(canvasItems).length > 0 ? [Object.keys(canvasItems)[0]] : []);
            }

            deleteCanvasItems() {
                var canvasItemModel = this.canvasItemModel,
                    softDeletedCanvasItems = this.softDeletedCanvasItems,
                    classId = this.classId;

                if (Object.keys(softDeletedCanvasItems).length > 0) {
                    canvasItemModel.batchDestroy(classId, softDeletedCanvasItems);
                }
            }

            isCanvasItemInPosition(positionX, positionY) {
                var canvasItemsGrid = this.canvasItemsGrid;

                if (positionX >= canvasItemsGrid.length - 1 || canvasItemsGrid[positionX][positionY] != -1) {
                    return true;
                }

                return false;
            }

            // Updates the canvasItem position and syncs with grid
            // returns false if item is not allowed in this location
            updateCanvasItemPosition(canvasItem, positionX, positionY) {
                var canvasItemsGrid = this.canvasItemsGrid;

                if (this.isPositionInBounds(positionX, positionY)) {
                    if (!this.isCanvasItemInPosition(positionX, positionY)) { // TODO: Also check if parent is moving into child and allow that
                        canvasItemsGrid[canvasItem.position_x][canvasItem.position_y] = -1; // Free up the old position

                        canvasItem.position_x = positionX;
                        canvasItem.position_y = positionY;

                        canvasItemsGrid[positionX][positionY] = canvasItem.id; // Occupy the new position

                        return true;
                    }
                }

                this.view.updateCanvasItemPosition(canvasItem.id, canvasItem.position_x, canvasItem.position_y); // Ensure the item doesn't move

                return false;
            }

            // Generates a grid array (Size: size * size) that shows all of the locations of canvasItems
            // -1 indicates no item is stored in that spot, anything else is the canvasItem id.

            // Example:
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
                    view = this.view;

                $('.drag-item').draggable({
                    grid: [32, 32],
                    containment: '.drop-target',
                    drag: function() {
                        hasUserMadeChanges = true; // The users changed something. We'll use this to ask if they want to save

                        var parentCanvasItemId = view.getCanvasItemId($(this));

                        // We need the new location of the canvasItem as it may be outdated in the canvasItems array
                        var newParentCanvasItemPositionX = $(this).position().left / 32;
                        var newParentCanvasItemPositionY = $(this).position().top / 32;

                        var oldParentCanvasItemPositionX = canvasItems[parentCanvasItemId].position_x;
                        var oldParentCanvasItemPositionY = canvasItems[parentCanvasItemId].position_y;

                        if (newParentCanvasItemPositionX != oldParentCanvasItemPositionX
                                || newParentCanvasItemPositionY != oldParentCanvasItemPositionY) { // Continue if the item has moved
                            if (canvasController.updateCanvasItemPosition(
                                canvasItems[parentCanvasItemId],
                                newParentCanvasItemPositionX,
                                newParentCanvasItemPositionY
                            )) {
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

                                    var oldChildPositionX = childCanvasItem.position_x;
                                    var oldChildPositionY = childCanvasItem.position_y;

                                    var childRelativePositionX = selectedCanvasItems.children[childCanvasItemId].relative_position_x;
                                    var childRelativePositionY = selectedCanvasItems.children[childCanvasItemId].relative_position_y;
                                    
                                    if (canvasController.updateCanvasItemPosition(
                                        childCanvasItem,
                                        newParentCanvasItemPositionX + childRelativePositionX,
                                        newParentCanvasItemPositionY + childRelativePositionY
                                    )) {
                                        view.removeCanvasItem(childCanvasItem.id);

                                        selectedCanvasItemIds.push(childCanvasItemId);

                                        view.addCanvasItem(items[childCanvasItem.item_id], childCanvasItem);

                                        canvasController.updateConnectedCanvasItems(oldChildPositionX, oldChildPositionY, [], null);
                                        canvasController.updateConnectedCanvasItems(childCanvasItem.position_x, childCanvasItem.position_y, [
                                            [oldChildPositionX, oldChildPositionY, []]
                                        ], 0);
                                    } else {
                                        console.log('somethings already in that position or out of bounds (child)');
                                    }
                                }

                                canvasController.updateSelected(selectedCanvasItemIds);
                                canvasController.initializeDraggable();

                                canvasController.updateConnectedCanvasItems(oldParentCanvasItemPositionX, oldParentCanvasItemPositionY, [], null);
                                canvasController.updateConnectedCanvasItems(newParentCanvasItemPositionX, newParentCanvasItemPositionY, [
                                    [oldParentCanvasItemPositionX, oldParentCanvasItemPositionY, []]
                                ], 0);
                            } else {
                                console.log('somethings already in that position or out of bounds (parent)')
                            }
                        }
                    },
                    start: function() {
                        var pendingCanvasHistoryRecords = historyController.pendingCanvasHistoryRecords,
                            selectedIds = canvasController.getSelectedIds();

                        pendingCanvasHistoryRecords = [];

                        for (var index in selectedIds) {
                            var canvasItemId = selectedIds[index];

                            pendingCanvasHistoryRecords.push({ // Store the canvasItem's history
                                canvas_item_id: canvasItemId,
                                type: 'movement',
                                previous_position_x: canvasItems[canvasItemId].position_x,
                                previous_position_y: canvasItems[canvasItemId].position_y
                            });
                        }
                        
                        historyController.pendingCanvasHistoryRecords = pendingCanvasHistoryRecords;

                        rect.remove(); // Remove the drag rectangle on canvasItem drag
                    },
                    stop: function() {
                        var pendingCanvasHistoryRecords = historyController.pendingCanvasHistoryRecords;

                        if (pendingCanvasHistoryRecords[0].previous_position_x != canvasItems[pendingCanvasHistoryRecords[0].canvas_item_id].position_x
                                || pendingCanvasHistoryRecords[0].previous_position_y != canvasItems[pendingCanvasHistoryRecords[0].canvas_item_id].position_y) {
                            for (var index in pendingCanvasHistoryRecords) {
                                var pendingCanvasHistoryRecord = pendingCanvasHistoryRecords[index];
                                var canvasItemId = pendingCanvasHistoryRecord.canvas_item_id;

                                pendingCanvasHistoryRecord.position_x = canvasItems[canvasItemId].position_x;
                                pendingCanvasHistoryRecord.position_y = canvasItems[canvasItemId].position_y;

                                historyController.addCanvasHistory(pendingCanvasHistoryRecord);
                            }
                        }
                    },
                    create: function() {
                        var canvasItemId = view.getCanvasItemId($(this));
                        
                        canvasController.updateConnectedCanvasItems(canvasItems[canvasItemId].position_x, canvasItems[canvasItemId].position_y, [], null);
                    }
                });
            }

            // Handles canvasController.selectedCanvasItems which stores:
            //     Parent - The item the user is dragging/clicked on
            //     Children - Items (if any) that have a relative position to the parent
            // This will also update the selectedBoard in the view
            // Accepts array of canvasItemIds e.g. [2, 5, 7]
            updateSelected(canvasItemIds, shouldClearView = true) {
                var canvasItems = this.canvasItems,
                    items = this.items,
                    view = this.view;

                var selectedBoardItems = [];

                if (canvasItemIds.length > 0) {
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
                                location: items[canvasItems[canvasItemId].item_id].location,
                                name: items[canvasItems[canvasItemId].item_id].name
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

                        if (canvasItemId in canvasItems) { // We might have just deleted the child
                            selectedBoardItems[index] = {
                                id: canvasItemId,
                                position_x: canvasItems[canvasItemId].position_x,
                                position_y: canvasItems[canvasItemId].position_y,
                                location: items[canvasItems[canvasItemId].item_id].location,
                                name: items[canvasItems[canvasItemId].item_id].name
                            };
                        }
                    }

                    view.clearSelectedBoard(selectedCanvasItems);
                    view.updateSelectedBoard(selectedBoardItems);
                } else {
                    selectedCanvasItems = {
                        parent: {},
                        children: {}
                    };

                    if (shouldClearView) {
                        view.clearSelectedBoard(selectedCanvasItems);
                    }
                }
            }

            getSelectedIds() {
                var selectedIds = [selectedCanvasItems.parent.id];

                for (var canvasItemId in selectedCanvasItems.children) {
                    selectedIds.push(canvasItemId);
                }

                return selectedIds;
            }
            
            getNearestEmpty(positionX, positionY, maxCheckHeight, maxCheckWidth) {
                var x = 0,
                    y = 0,
                    delta = [0, -1],
                    potentialEmptyX,
                    potentialEmptyY;

                for (let i = 0; i < Math.pow(Math.max(maxCheckWidth, maxCheckHeight), 2); i++) {
                    if ((-maxCheckWidth / 2 < x && x <= maxCheckWidth / 2) && (-maxCheckHeight / 2 < y && y <= maxCheckHeight / 2)) {
                        potentialEmptyX = x + positionX;
                        potentialEmptyY = y + positionY;

                        if (this.isPositionInBounds(potentialEmptyX, potentialEmptyY)) {
                            if (!this.isCanvasItemInPosition(x + positionX, y + positionY)) {
                                return [x + positionX, y + positionY];
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

            updateConnectedCanvasItems(canvasItemPositionX, canvasItemPositionY, checkExemptions, checkExemptionsIndex = null) {
                var canvasItemsGrid = this.canvasItemsGrid,
                    canvasItems = this.canvasItems,
                    items = this.items,
                    view = this.view;

                var canvasItemId = canvasItemsGrid[canvasItemPositionX][canvasItemPositionY];

                var adjacentDirections = [
                    ['northwest', 'north', 'northeast'],
                    ['west',       null,   'east'],
                    ['southwest', 'south', 'southeast']
                ]; // All of the possible directions about an item (null), named to what the images are e.g. (north) desk-connected-north.png
                
                //  checkExemptions will keep track of what we've checked so we don't have to check them more than once or infinitely loop
                //  e.g. prevent: 'connected south' -> check south -> 'connected north' -> check north -> (loop)
                // 
                //  Example:
                //  [
                //      5,
                //      7,
                //      [
                //          [5, 6, 'north', false], // 'isDirectConnection', false means don't check this any further
                //          [5, 8, 'south', false]
                //      ]
                //  ]

                if (checkExemptionsIndex === null) {
                    checkExemptionsIndex = checkExemptions.push([
                        canvasItemPositionX,
                        canvasItemPositionY,
                        [] // Connected items and their directions e.g. [[5, 6, 'north', false], [5, 8, 'south', false]]
                    ]) - 1;
                }

                if (canvasItemId == -1 || canvasItems[canvasItemId].item_id == 1) { // Tables are the only supported item type TODO: canvasItemId == -1?
                    if (this.isPositionInBounds(canvasItemPositionX, canvasItemPositionY)) { // Check if check location is out of bounds
                        for (let i = 0; i < 3; i++) {
                            for (let x = 0; x < 3; x++) {
                                if (i == 1 && x == 1) { // Skip the position we're already in
                                    continue;
                                }
                                
                                var checkPositionX = canvasItemPositionX - 1 + x;
                                var checkPositionY = canvasItemPositionY - 1 + i;

                                if (this.isPositionInBounds(checkPositionX, checkPositionY)) {
                                    var canvasItemIdInCheckPosition = canvasItemsGrid[checkPositionX][checkPositionY];
                                    var hasAlreadyBeenChecked = utils.isArrayInArray(checkExemptions, [checkPositionX, checkPositionY]);

                                    var shouldCheckFurther = true; // Only used to check previously checked items

                                    if (hasAlreadyBeenChecked) {
                                        if (canvasItemIdInCheckPosition != -1 && canvasItems[canvasItemIdInCheckPosition].item_id == 1) { // Connect alreadyChecked item, but put isDirectConnected to false to prevent further checking
                                            hasAlreadyBeenChecked = false;
                                            shouldCheckFurther = false;
                                        }
                                    }

                                    if (!hasAlreadyBeenChecked) {
                                        if (canvasItemIdInCheckPosition != -1 && canvasItems[canvasItemIdInCheckPosition].item_id == 1) { // There's a table item in the position we're checking
                                            if (adjacentDirections[i][x].length == 9) { // Check position is northwest, northeast, southeast or southwest (all 9 characters long)
                                                // We need to check to see if adjacent items are present. i.e. northwest requires north (center x, same y) and west (same x, center y)  to be present
                                                var canvasItemIdAdjacentCheckPositionX = canvasItemsGrid[canvasItemPositionX][checkPositionY];
                                                var canvasItemIdAdjacentCheckPositionY = canvasItemsGrid[checkPositionX][canvasItemPositionY];

                                                if (canvasItemIdAdjacentCheckPositionX != -1 
                                                        && canvasItems[canvasItemIdAdjacentCheckPositionX].item_id == 1
                                                        && canvasItemIdAdjacentCheckPositionY != -1
                                                        && canvasItems[canvasItemIdAdjacentCheckPositionY].item_id == 1) {
                                                    checkExemptions[checkExemptionsIndex][2].push([checkPositionX, checkPositionY, adjacentDirections[i][x], checkExemptionsIndex > 0 || !shouldCheckFurther ? false : true]);
                                                }
                                            } else {
                                                checkExemptions[checkExemptionsIndex][2].push([checkPositionX, checkPositionY, adjacentDirections[i][x], checkExemptionsIndex > 0 || !shouldCheckFurther ? false : true]);
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }

                    if (checkExemptions[checkExemptionsIndex][2].length > 0) { // There's connected items
                        var connectedAdjacentDirections = []; // Stores directions from checkExemptions e.g. [["south", 1, 3], ["west", 0, 3]] => ["south", "west"] => "south-west"

                        for (let x = 0; x < checkExemptions[checkExemptionsIndex][2].length; x++) {
                            connectedAdjacentDirections.push(checkExemptions[checkExemptionsIndex][2][x][2]);
                        }

                        view.updateCanvasItemBackgroundImage(canvasItemId, 'desk-connected-' + connectedAdjacentDirections.join('-') + '.png');

                        let isDirectConnection = checkExemptions[checkExemptionsIndex][2][0][3];

                        if (isDirectConnection) { // Only check direct connections
                            for (let x = 0; x < checkExemptions[checkExemptionsIndex][2].length; x++) { // Check each connection
                                if (!utils.isArrayInArray(checkExemptions, [checkExemptions[checkExemptionsIndex][2][x][0], checkExemptions[checkExemptionsIndex][2][x][1]])) { 
                                    let nextCheckPositionX = checkExemptions[checkExemptionsIndex][2][x][0];
                                    let nextCheckPositionY = checkExemptions[checkExemptionsIndex][2][x][1];

                                    this.updateConnectedCanvasItems(nextCheckPositionX, nextCheckPositionY, checkExemptions, null);
                                }
                            }
                        }
                    } else if (canvasItemId != -1 && view.isCanvasItemConnected(canvasItemId)) {
                        view.updateCanvasItemBackgroundImage(canvasItemId, items[canvasItems[canvasItemId].item_id].location);
                    }
                }
            }

            isPositionInBounds(positionX, positionY) {
                var gridSize = this.gridSize;

                if (positionX >= 0
                        && positionY >= 0
                        && positionX < gridSize
                        && positionY < gridSize) {
                    return true;
                }

                return false;
            }

            confirmPageLeave(buttonElement = null, externalLink = null) {
                swal({
                    title: "Do you want to save changes made to '" + $('#class-name').text() + "'?",
                    text: "Your changes will be lost if you don’t save them.",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#66BB6A",
                    confirmButtonText: "Save seating plan",
                    cancelButtonText: "Continue without saving",
                    closeOnConfirm: false,
                    closeOnCancel: true
                }, function(isConfirm){
                    if (isConfirm) {
                        $('.confirm').html('Loading <i class="icon-spinner2 spinner" style="margin-left: 5px;"></i>');

                        canvasController.saveCanvasItems(buttonElement, externalLink);

                        swal({
                            title: "Saved!",
                            text: "Your changes to '" + $('#class-name').text() + "' have been saved.",
                            confirmButtonColor: "#66BB6A",
                            type: "success",
                            timer: 2000
                        });
                    } else {
                        if (buttonElement != null) {
                            canvasController.view.changeClass(buttonElement);
                        } else if (externalLink != null) {
                            window.location.href = externalLink;
                        }
                    }
                });
            }

            saveCanvasItems(buttonElement = null, externalLink = null) {   
                var canvasItems = this.canvasItems,
                    softDeletedCanvasItems = this.softDeletedCanvasItems,
                    canvasItemModel = this.canvasItemModel,
                    classId = this.classId;

                var mergedCanvasItems = $.extend({}, canvasItems, softDeletedCanvasItems); // Merge canvasItems and softDeletedCanvasItems since we need to store softDeleted too so user use history to revert back later

                for (var canvasItemId in mergedCanvasItems) {
                    var canvasItem = mergedCanvasItems[canvasItemId];

                    if (canvasItem.pseudo_item) {
                        this.view.removeCanvasItem(canvasItemId);
                        canvasItemModel.store(classId, canvasItem);
                    }
                }

                if (Object.keys(canvasItems).length > 0) {
                    canvasItemModel.batchUpdate(classId, canvasItems);
                }

                this.deleteCanvasItems(this.softDeletedCanvasItems);

                historyController.storeCanvasHistory(buttonElement, externalLink);
            }

            clearSession() {
                this.view.removeCanvasItems();

                this.canvasItems = {};
                this.canvasItemsGrid = [];

                selectedCanvasItems = {
                    parent: {},
                    children: {}
                };
            }
        }

        class HistoryController {
            constructor() {
                this.jsonCanvasHistory = [];

                this.canvasHistory = []; // Stores array of objects containing actions performed by the user
                this.canvasActionUndoCount = 1; // How many times to undo away from most recent action
                this.pendingCanvasHistoryRecords = []; // Store positions when drag starts, store them in canvasHistory on stop

                this.maxCanvasHistoryCount = 25; // Only used when storing to database

                this.canvasHistoryModel = new CanvasHistoryModel;
                this.view = new View;
            }

            loadCanvasHistory() {
                var canvasHistoryModel = this.canvasHistoryModel;

                canvasHistoryModel.index(canvasController.classId);
            }

            init() {
                var jsonCanvasHistoryRecords = this.jsonCanvasHistory;

                // Take JSON array of all items and store them locally
                for (var index in jsonCanvasHistoryRecords.canvas_history) {
                    var canvasHistoryRecord = jsonCanvasHistoryRecords.canvas_history[index];

                    this.addCanvasHistory(canvasHistoryRecord);
                }

                this.canvasActionUndoCount = jsonCanvasHistoryRecords.canvas_action_undo_count;
            } 

            addCanvasHistory(canvasHistoryRecord) {
                var canvasActionUndoCount = this.canvasActionUndoCount;

                if (canvasActionUndoCount > 1) { // User has undone, then performed another action
                    this.canvasHistory.splice(this.canvasHistory.length - canvasActionUndoCount + 1, canvasActionUndoCount);
                    this.canvasActionUndoCount = 1;
                }

                this.canvasHistory[this.canvasHistory.length] = {
                    canvas_item_id: canvasHistoryRecord.canvas_item_id,
                    type: canvasHistoryRecord.type,
                    previous_position_x: canvasHistoryRecord.previous_position_x,
                    previous_position_y: canvasHistoryRecord.previous_position_y,
                    position_x: canvasHistoryRecord.position_x,
                    position_y: canvasHistoryRecord.position_y
                }
            }

            storeCanvasHistory(buttonElement = null, externalLink = null) {
                var canvasHistory = this.canvasHistory,
                    canvasHistoryModel = this.canvasHistoryModel,
                    maxCanvasHistoryCount = this.maxCanvasHistoryCount,
                    canvasActionUndoCount = this.canvasActionUndoCount,
                    classId = canvasController.classId;

                var slicedHistory = canvasHistory.slice(Math.max(canvasHistory.length - maxCanvasHistoryCount, 0)); // Don't send > maxCanvasHistoryCount to DB

                canvasHistoryModel.store(classId, slicedHistory, canvasActionUndoCount, buttonElement, externalLink);

                this.canvasActionUndoCount = canvasActionUndoCount;
            }

            undoCanvasAction() {
                var canvasHistory = this.canvasHistory,
                    canvasActionUndoCount = this.canvasActionUndoCount,
                    canvasItems = canvasController.canvasItems,
                    view = this.view,
                    softDeletedCanvasItems = canvasController.softDeletedCanvasItems;

                if (Object.keys(canvasHistory).length - canvasActionUndoCount >= 0) {
                    var action = canvasHistory[canvasHistory.length - canvasActionUndoCount];

                    var canvasItemId = action.canvas_item_id;

                    switch (action.type) {
                        case 'deletion':
                            canvasController.restoreSoftDeletedCanvasItem(canvasItemId, action.item_id, action.previous_position_x, action.previous_position_y);
                            break;
                        case 'addition':
                            canvasController.softDeleteCanvasItem(canvasItemId);
                            break;
                        default:
                            var canvasItem = canvasItems[canvasItemId];

                            var currentItemPositionX = canvasItem.position_x;
                            var currentItemPositionY = canvasItem.position_y;

                            var canvasItemPositionX = action.previous_position_x;
                            var canvasItemPositionY = action.previous_position_y;

                            canvasController.updateCanvasItemPosition(canvasItem, canvasItemPositionX, canvasItemPositionY)
                            view.updateCanvasItemPosition(canvasItemId, canvasItemPositionX, canvasItemPositionY);
                            canvasController.updateSelected([selectedCanvasItems.parent.id]);

                            canvasController.updateConnectedCanvasItems(canvasItemPositionX, canvasItemPositionY, [], null);
                            canvasController.updateConnectedCanvasItems(currentItemPositionX, currentItemPositionY, [], null);
                    } 

                    canvasActionUndoCount++;

                    this.canvasActionUndoCount = canvasActionUndoCount;
                } else {
                    alert('Nothing else to undo!');
                }
            }

            redoCanvasAction() {
                var canvasHistory = this.canvasHistory,
                    canvasActionUndoCount = this.canvasActionUndoCount,
                    canvasItems = canvasController.canvasItems,
                    view = this.view;

                if (canvasActionUndoCount > 1) {
                    var action = canvasHistory[canvasHistory.length - canvasActionUndoCount + 1];

                    var canvasItemId = action.canvas_item_id;

                    switch (action.type) {
                        case 'deletion':
                            canvasController.softDeleteCanvasItem(canvasItemId);
                            break;
                        case 'addition':
                            canvasController.restoreSoftDeletedCanvasItem(canvasItemId, action.item_id, action.previous_position_x, action.previous_position_y);
                            break;
                        default:
                            var canvasItem = canvasItems[canvasItemId];

                            var currentItemPositionX = canvasItem.position_x;
                            var currentItemPositionY = canvasItem.position_y;

                            var canvasItemPositionX = action.position_x;
                            var canvasItemPositionY = action.position_y;

                            canvasController.updateCanvasItemPosition(canvasItem, canvasItemPositionX, canvasItemPositionY);
                            view.updateCanvasItemPosition(canvasItemId, canvasItemPositionX, canvasItemPositionY);
                            canvasController.updateSelected([selectedCanvasItems.parent.id]);

                            canvasController.updateConnectedCanvasItems(canvasItemPositionX, canvasItemPositionY, [], null);
                            canvasController.updateConnectedCanvasItems(currentItemPositionX, currentItemPositionY, [], null);
                    }
                    
                    canvasActionUndoCount--;

                    this.canvasActionUndoCount = canvasActionUndoCount;
                } else {
                    alert('Nothing left to redo!');
                }
            }
        }

        class NotificationController {
            // notificationContent is the message e.g. 'hello' (string)
            // type is the display type e.g. 'error' or 'success' (string)
            handleNotification(notificationContent, type, timeout = 7500) {
                var n = noty({
                    text: notificationContent,
                    layout: 'topCenter',
                    type: type
                });

                setTimeout(function() {
                    n.close();
                }, timeout);
            }
        }

        class Utils {
            isArrayInArray(arrayToSearch, arrayToFind) {
                for (let i = 0; i < arrayToSearch.length; i++) {
                    if (arrayToSearch[i][0] == arrayToFind[0] && arrayToSearch[i][1] == arrayToFind[1]) {
                        return true;
                    }
                }
                return false;
            }

            isValidJson(jsonResponse) {
                return $.isPlainObject(jsonResponse);
            }

            getQueryParams() {
                var query_string = {};
                var query = window.location.search.substring(1);
                var vars = query.split("&");
                for (var i=0;i<vars.length;i++) {
                    var pair = vars[i].split("=");
                    // If first entry with this name
                    if (typeof query_string[pair[0]] === "undefined") {
                        query_string[pair[0]] = decodeURIComponent(pair[1]);
                        // If second entry with this name
                    } else if (typeof query_string[pair[0]] === "string") {
                        var arr = [ query_string[pair[0]],decodeURIComponent(pair[1]) ];
                        query_string[pair[0]] = arr;
                    // If third or later entry with this name
                    } else {
                        query_string[pair[0]].push(decodeURIComponent(pair[1]));
                    }
                } 

                return query_string;
            }

            isInt(value) {
              return !isNaN(value) && 
                     parseInt(Number(value)) == value && 
                     !isNaN(parseInt(value, 10));
            }
        }

        function bootstrapper() {
            utils = new Utils;
            notificationController = new NotificationController;

            var queryParameters = utils.getQueryParams();
            var classId = @if ($recentClassId != null) {{ $recentClassId }} @else parseInt($(".class-button:first").attr("class-id")); @endif

            if (queryParameters.hasOwnProperty('class')) {
                if (utils.isInt(queryParameters.class) && $('.class-button[class-id=' + queryParameters.class + ']').length > 0) {
                    classId = queryParameters.class;
                }
            }

            var view = new View;
            view.setActiveClass(classId);

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': token
                }
            });

            $.extend({
                APIAjax: function(params){
                    params.error = function() {
                        notificationController.handleNotification('A server-side error occured. Try refreshing if the problem persists.', 'error');
                    };

                    if (params.success && typeof params.success == 'function') {
                        var successCallback = params.success;
                        var ourCallback = function(responseJson) {
                            if (utils.isValidJson(responseJson)) { // Validate the data
                                if (responseJson.error == 0) {
                                    successCallback(responseJson); // Continue to function
                                } else {
                                    notificationController.handleNotification(responseJson.message, 'error');
                                }
                            } else {
                                notificationController.handleNotification('A server-side error occured. Try refreshing if the problem persists.', 'error');
                            }
                        }

                        params.success = ourCallback;
                    }

                    return $.ajax(params);
                }
            });

            canvasController = new CanvasController(classId);
            canvasController.loadCanvasItems();

            historyController = new HistoryController();
            historyController.loadCanvasHistory();
        }

        // This is the function generating the position by calculating
        // mouse position, different offsets and option.
        $.ui.draggable.prototype._generatePosition = function(event, constrainPosition) {
            var containment, co, top, left,
                o = this.options,
                scrollIsRootNode = this._isRootNode(this.scrollParent[0]),
                pageX = event.pageX,
                pageY = event.pageY;

            // Cache the scroll
            if (!scrollIsRootNode || !this.offset.scroll) {
                this.offset.scroll = {
                    top: this.scrollParent.scrollTop(),
                    left: this.scrollParent.scrollLeft()
                };
            }

            /*
             * - Position constraining -
             * Constrain the position to a mix of grid, containment.
             */

            // If we are not dragging yet, we won't check for options
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

                    //Check for grid elements set to 0 to prevent divide by 0 error causing invalid argument errors in IE (see ticket #6950)
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

            if (canvasController.isCanvasItemInPosition(
                    (pageX - this.offset.click.left - this.offset.parent.left) / 32,
                    (pageY - this.offset.click.top - this.offset.parent.top) / 32)) {
                return false;
            }

            return {
                top: (
                    pageY - // The absolute mouse position
                    this.offset.click.top - // Click offset (relative to the element)
                    this.offset.relative.top - // Only for relative positioned nodes: Relative offset from element to offset parent
                    this.offset.parent.top + // The offsetParent's offset without borders (offset + border)
                    (this.cssPosition === "fixed" ? -this.offset.scroll.top : (scrollIsRootNode ? 0 : this.offset.scroll.top))
                ),
                left: (
                    pageX - // The absolute mouse position
                    this.offset.click.left - // Click offset (relative to the element)
                    this.offset.relative.left - // Only for relative positioned nodes: Relative offset from element to offset parent
                    this.offset.parent.left + // The offsetParent's offset without borders (offset + border)
                    (this.cssPosition === "fixed" ? -this.offset.scroll.left : (scrollIsRootNode ? 0 : this.offset.scroll.left))
                )
            };
        }

    </script>
@stop