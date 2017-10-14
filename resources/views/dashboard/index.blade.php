@extends('template.dashboard')

@section('title', 'Seating Plans')
@section('main')
    <div class="row row-sortable">
        <div class="col-md-8">
            <div class="panel panel-primary panel-bordered main-canvas">
                <div class="panel-heading">
                    <h6 class="panel-title">
                        <span class="text-semibold">
                            Seating Planner
                        </span> 
                        <span class="text-muted text-muted-light">
                            <small id="class-name">Loading...<small>
                        </span>
                    </h6>
                    <div class="heading-elements">
                        <ul class="icons-list">
                            <li class="undo-list">
                                Actions: <i class="icon-undo" id="undo-button"></i>
                            </li>
                            <li class="redo-list">
                                <i class="icon-redo" id="redo-button"></i>
                            </li>
                            <li>
                                <p id="save-button">
                                    <i class="glyphicon glyphicon-floppy-save"></i> <u>Save Seating Plan</u>
                                </p>
                            </li>
                        </ul>
                    </div>
                    <a class="heading-elements-toggle">
                        <i class="icon-menu"></i>
                    </a>
                </div>
                <div class="panel-body main-panel-body">
                    <div class="drop-target" id="canvas"></div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="tabbable">
                <ul class="nav nav-pills nav-pills-bordered nav-stacked">
                    @if (isset($classes))
                        @foreach ($classes as $key => $class)
                            @if ($class->institution_id === null)
                                <li>
                                    <a href="javascript:void(0);" class="class-button" class-id="{{ $class->id }}" type="seating-plan">
                                        <span class="sidebar-class-name">{{ $class->class_name }}</span>
                                        <span class="text-muted">
                                            <small>{{ $class->class_room or '' }}</small>
                                        </span>
                                        
                                        @if ($class->class_subject !== null)
                                            <span class="label label-primary pull-right sidebar-label">
                                                {{ $class->class_subject }}
                                            </span>
                                        @endif
                                    </a>
                                    <div class="btn-group">
                                        <a href="javascript:void(0);" class="btn btn-primary btn-icon dropdown-toggle class-options" data-toggle="dropdown" class-id="{{ $class->id }}">
                                            <i class="icon-menu7"></i>
                                            <span class="caret"></span>
                                        </a>
                                        <ul class="dropdown-menu dropdown-menu-right">
                                            <li>
                                                <a href="{{ url('dashboard/classes/' . $class->id . '/duplicate') }}">Duplicate Class Layout</a>
                                            </li>
                                            <li>
                                                <a href="javascript:void(0);" class="clear-seatingplan">Clear Seating Plan</a>
                                            </li>
                                        </ul>
                                    </div> 
                                </li>
                            @endif
                        @endforeach
                        <li class="class-create-list-item">
                    @else
                        <li>
                    @endif
                        <a href="javascript:void(0);" class="class-button class-button-create">
                            <i class="icon-plus22"></i> Create a new class
                        </a>
                    </li>
                </ul>
                
                @if ($classRooms !== null)
                    @if (sizeOf($classRooms) > 0)
                        <span class="text-muted">
                            <small>{{ Auth::user()->institution->name }}'s Room Templates<small>
                        </span>
                        <ul class="nav nav-pills nav-pills-bordered nav-stacked">
                            @foreach ($classRooms as $key => $class)
                                <li>
                                    <a href="javascript:void(0);" class="class-button" class-id="{{ $class->id }}" type="room-plan">
                                        <span class="sidebar-class-name">{{ $class->class_name }}</span>
                                        
                                        <span class="label label-danger pull-right sidebar-label">
                                            Room Template
                                        </span>
                                    </a>
                                    <div class="btn-group">
                                        <a href="javascript:void(0);" class="btn btn-primary btn-icon dropdown-toggle class-options" data-toggle="dropdown" class-id="{{ $class->id }}">
                                            <i class="icon-menu7"></i>
                                            <span class="caret"></span>
                                        </a>
                                        <ul class="dropdown-menu dropdown-menu-right">
                                            <li>
                                                <a href="javascript:void(0);" class="clear-seatingplan">Clear Seating Plan</a>
                                            </li>
                                        </ul>
                                    </div> 
                                </li>
                            @endforeach
                        </ul>
                    @endif
                @endif
            </div>

            <div class="panels">
                <div class="panel panel-primary panel-bordered" name="selected_panel">
                    <div class="panel-heading">
                        <h6 class="panel-title selected-panel-header">
                            Selected Item
                            <span class="text-muted text-muted-light">
                                <small class="selected-name">Loading...</small>
                            </span>
                        </h6>
                        <div class="heading-elements">
                            <ul class="icons-list">
                                <li>
                                    <a title="Move" data-popup="tooltip" data-action="move" href="javascript:void(0);" class="ui-sortable-handle"></a>
                                </li>
                                <li>
                                    <a title="Collapse" data-popup="tooltip" data-action="collapse"></a>
                                </li>
                            </ul>
                        </div>
                        <a class="heading-elements-toggle">
                            <i class="icon-menu"></i>
                        </a>
                    </div>
                    
                    <div class="panel-body selected-panel-body">
                        <div class="col-lg-3 col-sm-6">
                            <div class="thumbnail">
                                <div class="thumb">
                                    <img id="selected-image" src="{{ asset('assets/images/objects/desk.png') }}" class="no-antialias">
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-9 col-sm-6">
                            <h5 class="no-margin">
                                <name class="selected-name">Student Desk</name>
                                <small>Settings</small>
                            </h5>
                            <table class="table table-bordered table-striped">
                                <tbody>
                                    <tr>
                                        <td>Location</td>
                                        <td id="selected-position">
                                            <strong>X:</strong> 1, <strong>Y:</strong> 6<br />
                                        </td>
                                    </tr>
                                    <tr id="students-list">
                                        <td>Student(s)</td>
                                        <td id="selected-students">
                                            No student is assigned to this desk.
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Action</td>
                                        <td>
                                            <button id="selected-delete" class="btn btn-danger btn-sm" type="button">
                                                Delete
                                                <i class="icon-database-remove position-right"></i>
                                            </button>

                                            <button id="remove-seated-students" class="btn btn-danger btn-sm" type="button">
                                                Remove Seated
                                                <i class="icon-diff-removed position-right"></i>
                                            </button>

                                            <button id="copy-selected" class="btn btn-success btn-sm" type="button">
                                                Copy Selected
                                                <i class="icon-copy3 position-right"></i>
                                            </button>

                                            <button id="paste-selected" class="btn btn-success btn-sm" type="button">
                                                Paste Selected
                                                <i class="icon-paste2 position-right"></i>
                                            </button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="panel-body" id="selected-no-items">
                        There's no items on the canvas. Start by clicking on an item in the 'Items' panel below.
                    </div>
                </div>

                <div class="panel panel-primary panel-bordered" name="item_panel">
                    <div class="panel-heading">
                        <h6 class="panel-title">
                            Items
                            @if (isset($items))
                                <span class="text-muted text-muted-light">
                                    <small>Click any of the {{ sizeOf($items) }} items to add them</small>
                                </span>
                            @endif
                        </h6>
                        <div class="heading-elements">
                            <ul class="icons-list">
                                <li>
                                    <a title="Move" data-popup="tooltip" data-action="move" href="javascript:void(0);" class="ui-sortable-handle"></a>
                                </li>
                                <li>
                                    <a title="Collapse" data-popup="tooltip" data-action="collapse"></a>
                                </li>
                            </ul>
                        </div>
                        <a class="heading-elements-toggle">
                            <i class="icon-menu"></i>
                        </a>
                    </div>
                    
                    <div class="panel-body item-panel-body">
                        @if (isset($items))
                            @foreach ($items as $item)
                                <div class="col-lg-3 col-sm-6">
                                    <div class="thumbnail item-thumb-frame">
                                        <div class="thumb item-thumb">
                                            <img class="no-antialias" src="assets/images/objects/{{ $item->location }}">
                                            <div class="caption-overflow">
                                                <span>
                                                    <a class="btn border-white text-white btn-flat btn-icon btn-rounded create-canvas-item" href="javascript:void(0);" item-id={{ $item->id }}><i class="icon-plus3"></i></a>
                                                </span>
                                            </div>
                                        </div>

                                        <p class="no-margin item-description">
                                            <a href="javascript:void(0);" class="text-default">
                                                <strong>{{ $item->name }}</strong>
                                            </a>
                                        </p>
                                    </div>
                                </div>
                            @endforeach
                        @endif
                    </div>
                </div>

                <div class="panel panel-primary panel-bordered" name="student_panel">
                    <div class="panel-heading">
                        <h6 class="panel-title">Students</h6>
                        <div class="heading-elements">
                            <form class="heading-form" action="javascript:void(0);">
                                <div class="form-group">
                                    <label class="checkbox-inline checkbox-right">
                                        <input type="checkbox" class="styled-white" id="always-label-seats"> 
                                        <p style="margin-top: 2px;">
                                            Always Label Seats?
                                        </p>
                                    </label>
                                </div>
                            </form>
                            <ul class="icons-list">
                                <li>
                                    <a title="Move" data-popup="tooltip" data-action="move" href="javascript:void(0);" class="ui-sortable-handle"></a>
                                </li>
                                <li>
                                    <a title="Collapse" data-popup="tooltip" data-action="collapse"></a>
                                </li>
                            </ul>
                        </div>
                        <a class="heading-elements-toggle">
                            <i class="icon-menu"></i>
                        </a>
                    </div>

                    <div class="panel-body" id="no-students" style="display: none;">
                        There's no students in this class. You can add students by going to 'Manage Classes', or click <a href="{{ url('dashboard/classes') }}">here</a>.
                    </div>
                    
                    <div id="student-panel-content">
                        <div class="table-responsive student-table">
                            <table class="table text-nowrap">
                                <thead>
                                    <tr>
                                        <th></th>
                                        <th class="student-th-2">Name</th>
                                        <th class="student-th-3">Gender</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody id="class-students"></tbody>
                            </table>
                        </div>

                        <div class="panel-footer">
                            <div class="heading-elements">
                                <div class="heading-btn pull-left">
                                    <div class="btn-group">
                                        <button type="button" class="btn btn-primary" id="generate-seating-positions">
                                            Loading...
                                        </button>
                                        <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown"><span class="caret"></span></button>
                                        <ul class="dropdown-menu dropdown-menu-right">
                                            <li>
                                                <a href="javascript:void(0);" id="remove-seating-positions">
                                                    Remove all seated students
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="heading-btn pull-right">
                                    <button class="btn btn-default" type="button" id="select-all">Deselect All</button>
                                </div>
                            </div>
                            <a class="heading-elements-toggle">
                                <i class="icon-more"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop

@section('modals')
    <div id="modal-assign-seating-positions" class="modal fade in">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-primary text-center">
                    <h5 class="modal-title">Auto-Assign Seating Positions</h5>
                </div>
                
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-4">
                            <label class="display-block text-bold">Assignment Algorithm</label>
                            <select class="select" name="assignment-algorithm">
                                <option value="" disabled selected>Select an algorithm</option>
                                <option value="boy-girl">Boy/Girl</option>
                            </select>
                        </div>
                    </div>
                    
                    <div id="algorithm-boy-girl-settings">
                        <div class="row text-center">
                            <p class="text-muted">
                                Choose which seats you want the algorithm to apply to.
                            </p>

                            <div class="btn-group" data-toggle="buttons">
                                <label class="btn btn-primary active">
                                    <input name="options" id="all-seats" type="radio"> All Seats
                                </label>

                                <label class="btn btn-primary">
                                    <input name="options" id="only-selected-seats" type="radio"> <s>Only Selected Seats</s>
                                </label>
                            </div>
                        </div>

                        <br />

                        <div class="alert alert-warning alert-styled-left" id="boy-girl-warning">
                            <button type="button" class="close" data-dismiss="alert">
                                <span>×</span><span class="sr-only">Close</span>
                            </button>
                            <span class="text-semibold">Warning!</span> <p id="boy-girl-warning-text">Loading...</p>
                        </div>

                        <h5>Exemptions (optional)</h5>

                        <div class="row">
                            <div class="col-md-6">
                                <label class="display-block text-bold">Select 1st student</label>
                                <select class="select" name="exemption-1">
                                    <option value="" disabled selected>Select 1st troublesum student</option>
                                    <option value="boy-girl">John Smith</option>
                                </select>

                                <label class="display-block text-bold second-student">Select 2nd student to be separated from the 1st</label>
                                <select class="select" name="exemption-2">
                                    <option value="" disabled selected>Select 2nd troublesum student</option>
                                    <option value="boy-girl">John Smith</option>
                                </select>

                                <button type="button" class="btn btn-primary" id="add-exemption" disabled>
                                    <i class="icon-plus3 position-left"></i> Add Exemption
                                </button>
                            </div>
                            <div class="col-md-6">
                                <label class="display-block text-bold">Students exempt from sitting with eachother:</label>
                                <table class="table table-bordered table-striped" id="exemptions-table">
                                    <thead>
                                        <tr>
                                            <th>First Student</th>
                                            <th>Second Student</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody id="exemptions-table-body"></tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button data-dismiss="modal" class="btn btn-link" type="button">Close</button>
                    <button class="btn btn-primary" type="submit" disabled id="auto-assign-seating-positions">
                        Auto-Assign Seating Positions
                    </button>
                </div>
            </div>
        </div>
    </div>
@stop

@section('scripts')
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/raphael/2.2.7/raphael.min.js"></script>
    <script type="text/javascript" src="{{ asset('assets/js/PaperDraft/dashboard.min.js') }}"></script>
    <script type="text/javascript">
        var token = '{{ csrf_token() }}';
        var assetsBasePath = '{{ asset('assets/images/objects') }}/';

        var selectedCanvasItems = {
            parent: {},
            children: {}
        };

        var hasUserMadeChanges = false,
            shouldAlwaysLabel  = false;

        var canvasController,
            historyController,
            notificationController,
            userController,
            utils;

        var rect; // The drag rectangle used in drag_selection.js

        var squareWidth = Math.floor($('.main-canvas').width() / 23);

        function bootstrapper() {
            utils = new Utils;
            notificationController = new NotificationController;

            var queryParameters = utils.getQueryParams(),
                classId = @if ($recentClassId != null) {{ $recentClassId }} @else parseInt($(".class-button:first").attr("class-id")); @endif

            if (queryParameters.hasOwnProperty('class')) {
                if (utils.isInt(queryParameters.class) && $('.class-button[class-id=' + queryParameters.class + ']').length > 0) {
                    classId = queryParameters.class;
                }
            }

            var classType = $('a[class-id="' + classId + '"]').attr('type');

            if (classType !== 'seating-plan') {
                $('.panel[name="student_panel"]').fadeOut();
                $('#students-list').fadeOut();
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
                        var successCallback = params.success,
                            ourCallback = function(responseJson) {
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

            var jsonItems = [
                @if (isset($items))
                    @foreach ($items as $item)
                        {
                            id:       '{{ $item->id }}',
                            name:     '{{ $item->name }}',
                            width:    '{{ $item->width }}',
                            height:   '{{ $item->height }}',
                            location: '{{ $item->location }}',
                        },
                    @endforeach
                @endif
            ];

            canvasController = new CanvasController(jsonItems, classId);
            canvasController.loadCanvasItems();

            studentController = new StudentController(classId);
            studentController.loadClassStudents();

            historyController = new HistoryController();
            historyController.loadCanvasHistory();

            var userPreferences = {
                @if (isset($userPreferences))
                    @foreach ($userPreferences as $userPreference)
                        {{ $userPreference->setting->setting_name }}: '{{ $userPreference->setting_value }}',
                    @endforeach
                @endif
            };

            userController = new UserController(userPreferences);
            userController.loadUserPreferences();
        }
    </script>
    <script type="text/javascript" src="{{ asset('assets/js/plugins/drag_selection.js') }}"></script>
@stop