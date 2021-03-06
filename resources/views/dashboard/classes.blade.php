@extends('template.dashboard')

@section('title', 'Classes')
@section('main')
    <div class="row row-sortable">
        <div class="col-md-8">
            <div class="panel panel-primary panel-bordered">
                <div class="panel-heading">
                    <h6 class="panel-title">
                        <span class="text-semibold">Manage Class</span>
                        <span class="text-muted text-muted-light">
                            <small id="class-name">
                                {{ $selectedClass->class_name }}
                            </small>
                        </span>
                    </h6>
                    <div class="heading-elements">
                        <ul class="icons-list">
                            <li>
                                <a href="{{ url('dashboard') }}?class={{ $classId }}" id="view-seating-plan-button">
                                    <i class="icon-statistics position-left view-seating-plan-icon"></i> <u>View Seating Plan</u>
                                </p>
                            </li>
                        </ul>
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
                        @if (isset($classStudents))
                            @foreach ($classStudents as $classStudent)
                                <tr class-student-id="{{ $classStudent->id }}" student-id="{{ $classStudent->student->id }}" use-institution="{{ $classStudent->student->institution_id === null ? 'false' : 'true' }}">
                                    <td>
                                        <div class="media-left media-middle">
                                            <a class="btn bg-teal-400 @if ($classStudent->student->gender === 'male') tooltip-blue @else tooltip-pink @endif btn-rounded btn-icon btn-xs" href="javascript:void(0);">
                                                <div class="letter-icon">{{ strtoupper($classStudent->student->name[0]) }}</div>
                                            </a>
                                        </div>

                                        <div class="media-body media-middle">
                                            <h6 class="display-inline-block text-default text-semibold letter-icon-title student-name" href="javascript:void(0);" style="margin-bottom: 3px; margin-top: 3px;">{{ $classStudent->student->name }}</h6>
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
                                            <i class="@if ($classStudent->student->pupil_premium) icon-checkmark3 text-success @else icon-cross2 text-danger-400 @endif"></i>
                                        </span>
                                    </td>
                                    <td>
                                        <h6 class="no-margin ability-cap">{{ $classStudent->ability_cap }}</h6>
                                    </td>
                                    <td>
                                        <div class="gender" style="display: none;">{{ $classStudent->student->gender }}</div>
                                        <div class="btn-group">
                                            <button type="button" class="btn btn-danger dropdown-toggle" data-toggle="dropdown">
                                                Options <span class="caret"></span>
                                            </button>
                                            <ul class="dropdown-menu dropdown-menu-right">
                                                <li>
                                                    <a class="delete-student">
                                                        <i class="icon-user-minus"></i> Delete
                                                    </a>
                                                </li>
                                                <li>
                                                    <a class="edit-student">
                                                        <i class="icon-pencil"></i> Edit
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        @endif
                    </tbody>
                </table>
                <form action="javascript:void(0);" method="POST" id="create-student">
                    <input name="class_id" value="{{ $classId }}" hidden>
                    <div class="content" style="padding-bottom: 20px;">
                        <div class="row">
                            <div class="col-md-12">
                                <fieldset class="text-semibold">
                                    <legend><i class="icon-user-plus position-left"></i> Add Student</legend>
                                    <div class="tabbable tab-content-bordered">
                                        <ul class="nav nav-tabs nav-tabs-highlight">
                                            <li class="active">
                                                <a data-toggle="tab" href="#icon-only-tab1" data-popup="tooltip" title="Information">
                                                    <i class="icon-cog52"></i>
                                                    <span class="visible-xs-inline-block position-right">Information</span>
                                                </a>
                                            </li>

                                            <li>
                                                <a data-toggle="tab" href="#icon-only-tab2" data-popup="tooltip" title="Picture">
                                                    <i class="icon-stack-picture"></i>
                                                    <span class="visible-xs-inline-block position-right">Picture</span>
                                                </a>
                                            </li>
                                        </ul>

                                        <div class="tab-content">
                                            <div id="icon-only-tab1" class="tab-pane has-padding active">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <label class="display-block text-bold">
                                                            Basic Information <span class="text-danger">*</span>
                                                        </label>
                                                        <input title="Enter the students name" class="form-control manual-fields" data-popup="tooltip" placeholder="Students Name" type="text" name="student_name" autocomplete="off" required id="student-name">
                                                    </div>
                                                    @if (Auth::user()->institution_id !== null)
                                                        <div id="institution-section">
                                                            <div class="col-md-4" id="institution-students">
                                                                <label class="display-block text-bold">Students from Institution</label>
                                                                <div class="form-group">
                                                                    <select name="institution_student_id" id="institution-students-select">
                                                                        <optgroup label="Students">
                                                                            <option value="" selected>Choose students from your institution</option>
                                                                            @if ($institutionStudents !== null)
                                                                                @php
                                                                                    $classStudentIds = array_values($classStudents->pluck('student_id')->all());
                                                                                @endphp
                                                                                @foreach ($institutionStudents as $student)
                                                                                    @if (!in_array($student->id, $classStudentIds))
                                                                                        <option value="{{ $student->id }}" gender="{{ $student->gender }}" pupil_premium="{{ $student->pupil_premium }}">{{ $student->name }}</option>
                                                                                    @endif
                                                                                @endforeach
                                                                            @endif
                                                                        </optgroup>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-2">
                                                                <label class="display-block text-bold">
                                                                    Use students on record?
                                                                </label>
                                                                <div class="radio">
                                                                    <label>
                                                                        <input type="radio" checked="checked" class="styled" name="use_institution_data" value="true">
                                                                        Use students
                                                                    </label>
                                                                </div>
                                                                <div class="radio">
                                                                    <label>
                                                                        <input type="radio" class="styled" name="use_institution_data" value="false">
                                                                        Make my own
                                                                    </label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endif
                                                </div>
                                                     
                                                <div class="row">
                                                    <div class="col-md-3 manual-fields">
                                                        <label class="display-block text-bold">
                                                            Gender <span class="text-danger">*</span>
                                                            <span class="text-muted" style="padding-left: 6px;">
                                                                <small class="selected-name" id="guessing-text" style="display: none;">
                                                                    Guessing gender...
                                                                </small>
                                                            </span>
                                                        </label>
                                                        <div class="radio">
                                                            <label>
                                                                <input type="radio" checked="checked" class="styled manual-fields" name="gender" value="male">
                                                                Male
                                                            </label>
                                                        </div>
                                                        <div class="radio">
                                                            <label>
                                                                <input type="radio" class="styled manual-fields" name="gender" value="female">
                                                                Female
                                                            </label>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3 manual-fields">
                                                        <label class="display-block text-bold">Additional Information</label>
                                                        <label class="checkbox-inline">
                                                            <input type="checkbox" class="styled manual-fields" name="pupil_premium">
                                                            Pupil Premium
                                                        </label>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <label class="display-block text-bold">Student Ability Tier</label>
                                                        <div class="radio">
                                                            <label>
                                                                <input type="radio" class="styled" name="ability_cap" value="H">
                                                                High
                                                            </label>
                                                        </div>
                                                        <div class="radio">
                                                            <label>
                                                                <input type="radio" class="styled" checked="checked" name="ability_cap" value="M">
                                                                Medium
                                                            </label>
                                                        </div>
                                                        <div class="radio">
                                                            <label>
                                                                <input type="radio" class="styled" name="ability_cap" value="L">
                                                                Low
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>

                                                <br />

                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <label class="display-block text-bold">Current Attainment Level</label>
                                                        <div class="form-group">
                                                            <select name="current_attainment_level">
                                                                <optgroup label="Current Attainment Level">
                                                                    <option value="" selected>Select a current attainment level</option>
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
                                                        <label class="display-block text-bold">Target Level</label>
                                                        <div class="form-group">
                                                            <select name="target_attainment_level">
                                                                <optgroup label="Target Level">
                                                                    <option value="" selected>Select a target level</option>
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
                                        </div>
                                    </div>
                                </fieldset>
                                <br />
                                <div class="text-right">
                                    <button type="submit" class="btn btn-primary">Add Student<i class="icon-arrow-right14 position-right"></i></button>
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
                    @if (isset($classes))
                        @foreach ($classes as $key => $class)
                            @if ($class->institution_id === null)
                                <li>
                                    <a href="/dashboard/classes/{{ $class->id }}" class="class-button @if ($selectedClass->id === $class->id) class-button-active @endif" class-id="{{ $class->id }}">
                                        {{ $class->class_name }} <span class="text-muted"><small>{{ $class->class_room or '' }}</small></span>
                                        
                                        @if ($class->class_subject !== null)
                                            <span class="label label-primary pull-right" style="margin-right: 60px;">
                                                {{ $class->class_subject }}
                                            </span>
                                        @endif
                                    </a>
                                    <div class="btn-group">
                                        <a href="javascript:void(0);" class="btn btn-primary btn-icon dropdown-toggle @if ($selectedClass->id == $class->id) class-options-active @else class-options @endif" data-toggle="dropdown" class-id="{{ $class->id }}">
                                            <i class="icon-menu7"></i>
                                            <span class="caret"></span>
                                        </a>
                                        <ul class="dropdown-menu dropdown-menu-right">
                                            <li>
                                                <a href="{{ url('dashboard/classes/' . $class->id . '/duplicate') }}">Duplicate Class Layout</a>
                                            </li>
                                            <li class="divider"></li>
                                            <li>
                                                <a href="{{ url('dashboard/classes') }}/{{ $class->id }}/clear" class="clear-seatingplan">Clear Seating Plan</a>
                                            </li>
                                            <li>
                                                <a href="javascript:void(0);" class="delete-class">Delete Class</a>
                                            </li>
                                        </ul>
                                    </div> 
                                </li>
                            @endif
                        @endforeach
                        <li>
                        <br />
                    @else
                        <li>
                    @endif
                        <a href="javascript:void(0);" class="class-button class-button-create" data-toggle="modal" data-target="#modal_create_class">
                            <i class="icon-plus22" style="padding-bottom: 1px;"></i> Create a new class
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
@stop

@section('modals')
    <div id="modal_create_class" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-primary">
                    <h5 class="modal-title">Enter information for the new class</h5>
                </div>

                <form action="{{ url('/class') }}" method="POST" class="form-inline">
                    {{ csrf_field() }}
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6">
                                <label class="display-block text-bold">
                                    What's the classes name? <span class="text-danger">*</span>
                                </label>
                                <div class="form-group has-feedback" style="width: 100%;">
                                    <input type="text" placeholder="Class name" style="width: 100%;" class="form-control" name="class_name">
                                    <div class="form-control-feedback">
                                        <i class="icon-book text-muted"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="display-block text-bold">What's the subject you're teaching?</label>
                                <div class="form-group has-feedback" style="width: 100%;">
                                    <input type="text" placeholder="Subject name" style="width: 100%;" class="form-control" name="class_subject">
                                    <div class="form-control-feedback">
                                        <i class="icon-graduation text-muted"></i>
                                    </div>
                                </div>
                                <br />
                                <br />
                                @if ($classRooms !== null)
                                    <div class="form-group">
                                        <label class="display-block text-bold">
                                            Class Room:
                                        </label>
                                        <select class="form-control" name="class_id">
                                            <optgroup label="Class Rooms Available">
                                                <option value="" disabled selected>Select a room to duplicate</option>
                                                @foreach ($classRooms as $room)
                                                    <option value="{{ $room->id }}">{{ $room->class_name }}</option>
                                                @endforeach
                                            </optgroup>
                                        </select>
                                        <span class="text-muted">
                                            <small>
                                                Choosing a class room will load a template plan of this room.
                                            </small>
                                        </span>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer text-center">
                        <button type="submit" class="btn btn-primary">Create new class <i class="icon-plus22"></i></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div id="modal_update_student" class="modal fade in">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-primary text-center">
                    <h5 class="modal-title">Update Student Information</h5>
                </div>

                <form action="javascript:void(0);" method="PUT" id="update-student">
                    <input name="student_id" value="" hidden>
                    <input name="class_student_id" value="" hidden>
                    <input name="use_institution_data" value="" hidden>
                    <div class="modal-body">
                        <div class="form-group">
                            <div class="row">
                                <div class="col-sm-12">
                                    <label class="display-block text-bold">Students Name <span class="text-danger">*</span></label>
                                    <input type="text" placeholder="Students Name" class="form-control" name="student_name">
                                </div>
                            </div>
                            <span class="text-muted" id="institution-only-message">
                                <small>
                                    Some of the data on this page can only be edited by your institution.
                                </small>
                            </span>
                        </div>

                        <div class="form-group">
                            <div class="row">
                                <div class="col-sm-6">
                                    <label class="display-block text-bold">
                                        Gender <span class="text-danger">*</span>
                                    </label>
                                    <div class="radio">
                                        <label>
                                            <input type="radio" checked="checked" class="styled" name="gender" value="male">
                                            Male
                                        </label>
                                    </div>
                                    <div class="radio">
                                        <label>
                                            <input type="radio" class="styled" name="gender" value="female">
                                            Female
                                        </label>
                                    </div>
                                    <br />
                                    <label class="display-block text-bold">Pupil Premium</label>
                                    <label class="checkbox-inline">
                                        <input type="checkbox" class="styled" name="pupil_premium">
                                        Pupil Premium
                                    </label>
                                </div>

                                <div class="col-sm-6">
                                    <label class="display-block text-bold">Student Ability Tier</label>
                                    <div class="radio">
                                        <label>
                                            <input type="radio" class="styled" checked="checked" name="ability_cap" value="H">
                                            High
                                        </label>
                                    </div>
                                    <div class="radio">
                                        <label>
                                            <input type="radio" class="styled" name="ability_cap" value="M">
                                            Medium
                                        </label>
                                    </div>
                                    <div class="radio">
                                        <label>
                                            <input type="radio" class="styled" name="ability_cap" value="L">
                                            Low
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="row">
                                <div class="col-sm-6">
                                    <label class="display-block text-bold">Current Attainment Level</label>
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

                                <div class="col-sm-6">
                                    <label class="display-block text-bold">Target Level</label>
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

                    <div class="modal-footer">
                        <button data-dismiss="modal" class="btn btn-link" type="button">Close</button>
                        <button class="btn btn-primary" type="submit">Submit form</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@stop

@section('scripts')
    <script>
        @if (session('errorMessage') != null)
            var errorValidationResponses = {!! session('errorValidationResponse') !!},
                errorValidationResponse = '<br />';

            for (var key in errorValidationResponses) {
                errorValidationResponse += errorValidationResponses[key] + '<br />';
            }

            handleNotification('{{ session('errorMessage') }}<br />' + errorValidationResponse, 'error');
        @endif
        @if (session('successMessage') != null)
            handleNotification('{{ session('successMessage') }}', 'success');
        @endif
    </script>
    <script>
        $(document).on('ready', function() {
            $('.duplicate-class').on('click', function() {
                $('#template-picker').val($(this)
                    .parent()
                    .parent()
                    .parent()
                    .children(0)
                    .attr('class-id')
                ).parent().hide();
            });

            $('.class-button-create').on('click', function() {
                $('#template-picker').parent().show();
            });

            $('.delete-class').on('click', function() {
                var classId = $(this).closest('.btn-group').children(0).attr('class-id');

                deleteClass(classId);
            });

            $('.delete-seatingplan').on('click', function() {
                classId = $(this)
                    .parent()
                    .parent()
                    .parent()
                    .children(0)
                    .attr('class-id');
            });

            $('input[name="use_institution_data"]').on('change', function() {
                changeCreationPreference(JSON.parse($(this).val()));
            });

            $('#institution-students-select').on('change', function() {
                var selected = $(this).find(":selected");

                if ($(this).prop('selectedIndex') !== 0) {
                    $('#student-name').val(selected.text());
                }

                $('input[name="gender"][value="' + selected.attr('gender') + '"]').prop('checked', true);
                $('input[name="pupil_premium"]').prop('checked', selected.attr('pupil_premium') == 1 ? true : false);

                $.uniform.update();
            });

            $('#create-student').submit(function(event) {
                $('#guessing-text').fadeOut();

                event.preventDefault();

                disabled = $(this).find(':input:disabled, select:disabled').removeAttr('disabled');

                var formData = parseFormData($(this));

                if (formData['student_name'] !== '' && formData['gender'] !== '' && formData['pupil_premium'] !== '') {
                    if (formData['use_institution_data'] == 'true') {
                        formData['student_id'] = formData['institution_student_id'];

                        createClassStudent(formData);
                    } else {
                        createStudent(formData);
                    }
                }

                disabled.attr('disabled','disabled');
            });

            $('#update-student').submit(function(event) {
                event.preventDefault();

                var formData = parseFormData($(this));

                if (formData['use_institution_data'] != 'true') {
                    updateStudent(formData);
                } else {
                    updateClassStudent(formData);
                }
            });

            $('#student-name').on('keyup', function() {
                if (genderAJAXRequest) { genderAJAXRequest.abort() }
                clearTimeout(timer); // Clear the timer so we don't end up with dupes.

                timer = setTimeout(function() {
                    var studentName = $('#student-name').val(),
                        guessingText = $('#guessing-text');

                    if (studentName.length >= 2) {
                        guessingText.fadeIn();
                        guessingText.text('Guessing gender...');

                        genderAJAXRequest = $.APIAjax({
                            url: '{{ url('api/student/gender') }}',
                            type: 'GET',
                            data: {
                                student_name: studentName.split(" ", 2)[0]
                            },
                            success: function(jsonResponse) {
                                if (jsonResponse.gender === 'male' || jsonResponse.gender === 'female') {
                                    var gender = jsonResponse.gender;

                                    guessingText.text('Guessing ' + gender + ' (' + (jsonResponse.probability) + '% sure)');

                                        $('input[value=' + gender + ']').prop('checked', true);
                                        $.uniform.update();
                                } else {
                                    guessingText.text('Could not guess gender.');
                                }
                            },
                            error: function(jsonResponse) {}
                        });
                    } else {
                        guessingText.fadeOut();
                    }
                }, 250);
            });

            $(document).delegate('.delete-student', 'click', function() {
                var tableRow = $(this).closest('tr');

                deleteClassStudent(tableRow.attr('class-student-id'));
                deleteStudent(tableRow.attr('student-id'));
            });

            $(document).delegate('.edit-student', 'click', function() {
                var classStudent             = $(this).closest('tr'),
                    classStudentId           = classStudent.attr('class-student-id'),
                    studentId                = classStudent.attr('student-id'),
                    shouldUseInstitutionData = JSON.parse(classStudent.attr('use-institution'));

                var studentName            = classStudent.find('.student-name').text(),
                    gender                 = classStudent.find('.gender').text(),
                    pupilPremium           = classStudent.find('.pupil-premium').html(),
                    abilityCap             = classStudent.find('.ability-cap').text(),
                    currentAttainmentLevel = classStudent.find('.current-attainment-level').text(),
                    targetAttainmentLevel  = classStudent.find('.target-attainment-level').text();

                if (pupilPremium.indexOf('icon-cross2') > -1) {
                    pupilPremium = false;
                } else {
                    pupilPremium = true;
                }

                $('#update-student input[name=student_id]').val(studentId);
                $('#update-student input[name=class_student_id]').val(classStudentId);
                $('#update-student input[name=use_institution_data]').val(shouldUseInstitutionData);
                $('#update-student input[name=student_name]').val(studentName);
                $('#update-student input[name=pupil_premium]').prop('checked', pupilPremium);
                $('#update-student input[value=' + gender + ']').prop('checked', true);
                $('#update-student input[value=' + abilityCap + ']').prop('checked', true);
                $('#update-student select[name=current_attainment_level]').val(currentAttainmentLevel === 'N/A' ? '' : currentAttainmentLevel);
                $('#update-student select[name=target_attainment_level]').val(targetAttainmentLevel === 'N/A' ? '' : targetAttainmentLevel);

                $('#update-student input[name="student_name"]').prop('disabled', shouldUseInstitutionData);
                $('#update-student input[name="pupil_premium"]').prop('disabled', shouldUseInstitutionData);
                $('#update-student input[name="gender"]').prop('disabled', shouldUseInstitutionData);

                if (shouldUseInstitutionData) {
                    $('#institution-only-message').fadeIn();
                } else {
                    $('#institution-only-message').fadeOut();
                }

                $.uniform.update();
                $('select').select2().trigger('change');
                $('#modal_update_student').modal('show');
            });

            @if (sizeOf($userPreferences) > 0 && Auth::user()->institution_id !== null)
                var userPreferences = {!! json_encode($userPreferences) !!};

                for (var i = 0; i < userPreferences.length; i++) {
                    var userPreference = userPreferences[i];

                    if (userPreference.setting_id === 3) { // should use students on record
                        if (userPreference.setting_value == 'true') {
                            $('input[name="use_institution_data"][value="true"]').prop('checked', true);
                            changeCreationPreference(true);
                        } else {
                            $('input[name="use_institution_data"][value="false"]').prop('checked', true);
                            changeCreationPreference(false);
                        }

                        break;
                    }
                }
            @elseif (Auth::user()->institution_id !== null)
                $('input[name="use_institution_data"][value="true"]').prop('checked', true);
                changeCreationPreference(true);
            @endif

            $('select').select2();
            $('.styled').uniform({
                radioClass: 'choice'
            });
        });

        var classId = {{ $classId }},
            token = '{{ csrf_token() }}',
            timer,
            genderAJAXRequest;

        $('tbody').prepend('<tr id="no-students" @if (isset($classStudents) && sizeOf($classStudents) > 0) style="display: none;" @endif></tr>');
        $('#no-students').html(
            '<div class="media-body media-middle">' +
                '<h6 class="display-inline-block text-default text-semibold letter-icon-title" style="margin-top: 30px; margin-left: 20px; margin-bottom: 30px;">' +
                    'This class has no students. Create one using the form below.' +
                '</h6>' +
            '</div>'
        );

        setActiveClass(classId);

        @if (session('create'))
            $('#modal_create_class').modal('show');
        @endif

        function createStudent(formData) {
            formData['pupil_premium'] = formData['pupil_premium'] == 'on' ? 1 : 0;

            $.APIAjax({
                url: '{{ url('api/student') }}',
                type: 'POST',
                data: {
                    student_name:             formData['student_name'],
                    gender:                   formData['gender'],
                    pupil_premium:            formData['pupil_premium'],
                },
                success: function(jsonResponse) {
                    handleNotification(formData['student_name'] + ' has been added to the class!', 'success');

                    formData['student_id'] = jsonResponse.student.id;
                    createClassStudent(formData);
                },
                error: function(jsonResponse) {}
            });
        }

        function updateStudent(formData) {
            formData['pupil_premium'] = formData['pupil_premium'] == 'on' ? 1 : 0;

            $.APIAjax({
                url: '{{ url('api/student') }}/' + formData['student_id'],
                type: 'PUT',
                data: {
                    student_name:  formData['student_name'],
                    gender:        formData['gender'],
                    pupil_premium: formData['pupil_premium'],
                },
                success: function(jsonResponse) {
                    updateClassStudent(formData);
                },
                error: function(jsonResponse) {}
            });
        }

        function deleteStudent(studentId) {
            $.APIAjax({
                url: '{{ url('api/student') }}/' + studentId,
                type: 'DELETE',
                success: function(jsonResponse) {
                    handleNotification(jsonResponse.message, 'success');
                },
                error: function(jsonResponse) {}
            });
        }

        function createClassStudent(formData) {
            $.APIAjax({
                url: '{{ url('api/class-student') }}',
                type: 'POST',
                data: {
                    class_id:                 classId,
                    student_id:               formData['student_id'],
                    ability_cap:              formData['ability_cap'],
                    current_attainment_level: formData['current_attainment_level'],
                    target_attainment_level:  formData['target_attainment_level']
                },
                success: function(jsonResponse) {
                    handleNotification(formData['student_name'] + ' has been added to the class!', 'success');

                    $('tbody').append(
                        '<tr class-student-id="' + jsonResponse.class_student.id + '" student-id="' + jsonResponse.student.id + '" use-institution="' + formData['use_institution_data'] + '" style="display: none;">' +
                            '<td>' +
                                '<div class="media-left media-middle">' +
                                    '<a class="btn bg-teal-400 ' + (formData['gender'] === 'male' ? 'tooltip-blue' : 'tooltip-pink') + ' btn-rounded btn-icon btn-xs" href="javascript:void(0);">' +
                                        '<span class="letter-icon">' + formData['student_name'].charAt(0).toUpperCase() + '</span>' +
                                    '</a>' +
                                '</div>' +
                                '<div class="media-body media-middle">' +
                                    '<h6 class="display-inline-block text-default text-semibold letter-icon-title student-name" href="javascript:void(0);" style="margin-bottom: 3px; margin-top: 3px;">' + formData['student_name'] + '</h6>' +
                                '</div>' +
                            '</td>' +
                            '<td>' +
                                '<h6 class="no-margin current-attainment-level">' + ((formData['current_attainment_level'] === "") ? 'N/A' : formData['current_attainment_level']) + '</h6>' +
                            '</td>' +
                            '<td>' +
                                '<h6 class="no-margin target-attainment-level">' + ((formData['target_attainment_level'] === "") ? 'N/A' : formData['target_attainment_level']) + '</h6>' +
                            '</td>' +
                            '<td>' +
                                '<span class="pupil-premium"><i class="' + (formData['pupil_premium'] ? "icon-checkmark3 text-success" : "icon-cross2 text-danger-400") + '"></i></span>' +
                            '</td>' +
                            '<td>' +
                                '<h6 class="no-margin ability-cap">' + formData['ability_cap'] + '</h6>' +
                            '</td>' +
                            '<td>' +
                                '<div class="gender" style="display: none;">' + formData['gender'] + '</div>' +
                                '<div class="btn-group">' + 
                                    '<button type="button" class="btn btn-danger dropdown-toggle" data-toggle="dropdown">Options <span class="caret"></span></button>' +
                                    '<ul class="dropdown-menu dropdown-menu-right">' +
                                        '<li>' +
                                            '<a class="delete-student">' +
                                                '<i class="icon-user-minus"></i> Delete' +
                                            '</a>' +
                                        '</li>' +
                                        '<li>' +
                                            '<a class="edit-student">' +
                                                '<i class="icon-pencil"></i> Edit' +
                                            '</a>' +
                                        '</li>' +
                                    '</ul>' +
                                '</div>' +
                            '</td>' +
                        '</tr>'
                    );

                    if (formData['use_institution_data']) {
                        $('#institution-students-select option[value="' + jsonResponse.student.id + '"]').remove();
                    }

                    if ($('#no-students').is(":visible")) {
                        $('#no-students').fadeOut();
                    }

                    $('tr[student-id=' + jsonResponse.student.id + ']').fadeIn();

                    var creationPreference = JSON.parse($('input[name="use_institution_data"][value="true"]').prop('checked'));

                    $('#create-student').trigger('reset');
                    
                    $('input[name="use_institution_data"][value="' + creationPreference + '"]').prop('checked', true);
                    changeCreationPreference(creationPreference);

                    $('a[title="Information"]').tab('show');

                    $('select').select2();
                    $.uniform.update();
                },
                error: function(jsonResponse) {}
            });
        }

        function updateClassStudent(formData) {
            $.APIAjax({
                url: '{{ url('api/class-student') }}/' + formData['class_student_id'],
                type: 'PUT',
                data: {
                    class_id:                 classId,
                    ability_cap:              formData['ability_cap'],
                    current_attainment_level: formData['current_attainment_level'],
                    target_attainment_level:  formData['target_attainment_level'],
                },
                success: function(jsonResponse) {
                    var classStudent = $('tr[class-student-id=' + formData['class_student_id'] + ']').closest('tr');

                    if (formData['pupil_premium']) {
                        formData['pupil_premium'] = '<i class="icon-checkmark3 text-success"></i>';
                    } else {
                        formData['pupil_premium'] = '<i class="icon-cross2 text-danger-400"></i>';
                    }

                    var studentName            = classStudent.find('.student-name').html(formData['student_name']),
                        gender                 = classStudent.find('.gender').html(formData['gender']),
                        pupilPremium           = classStudent.find('.pupil-premium').html(formData['pupil_premium']),
                        abilityCap             = classStudent.find('.ability-cap').html(formData['ability_cap']),
                        currentAttainmentLevel = classStudent.find('.current-attainment-level').html(formData['current_attainment_level']),
                        targetAttainmentLevel  = classStudent.find('.target-attainment-level').html(formData['target_attainment_level']);

                    handleNotification(jsonResponse.message, 'success');

                    $('#modal_update_student').modal('hide');
                    $('#update-student').trigger('reset');
                },
                error: function(jsonResponse) {}
            });
        }

        function deleteClassStudent(classStudentId) {
            $.APIAjax({
                url: '{{ url('api/class-student') }}/' + classStudentId,
                type: 'DELETE',
                data: {
                    class_id: classId
                },
                success: function(jsonResponse) {
                    $('tr[class-student-id=' + classStudentId + ']').fadeOut(300, function() {
                        $(this).remove();

                        if ($('tbody').children().length == 1) {
                            $('tr').fadeIn();
                        }
                    });

                    handleNotification(jsonResponse.message, 'success');
                },
                error: function(jsonResponse) {}
            });
        }

        function deleteClass(classId) {
            $.APIAjax({
                url: '{{ url('api/class') }}/' + classId,
                type: 'DELETE',
                success: function(jsonResponse) {
                    handleNotification(jsonResponse.message, 'success');

                    if ($('.class-button[class-id=' + classId + ']').hasClass('class-button-active')) {
                        window.location.href = '{{ url('dashboard/classes') }}';
                    } else {
                        $('.class-button[class-id=' + classId + ']').parent().fadeOut(300, function() {
                            $(this).remove();
                        });
                    }
                },
                error: function(jsonResponse) {}
            });
        }

        function setActiveClass(classId) {
            $('#planner-href').attr('href', '{{ url('dashboard') }}?class=' + classId);
        }

        function changeCreationPreference(shouldUseInstitutionData) {
            $('.manual-fields').prop('disabled', shouldUseInstitutionData);
            $('#institution-students-select').val('').trigger('change');

            if (shouldUseInstitutionData) {
                $('#institution-students').fadeIn();
            } else {
                $('#institution-students').fadeOut();
            }

            $.uniform.update();
        }

        // notificationContent is the message e.g. 'hello' (string)
        // type is the display type e.g. 'error' or 'success' (string)
        function handleNotification(notificationContent, type, timeout = 5000) {
            var n = noty({
                text:   notificationContent,
                layout: 'topRight',
                type:   type
            });

            setTimeout(function() {
                n.close();
            }, timeout);
        }

        function isValidJson(jsonResponse) {
            return $.isPlainObject(jsonResponse);
        }

        function parseFormData(form) {
            return form.serializeArray().reduce(function(obj, item) {
                obj[item.name] = item.value;

                return obj;
            }, {});
        }

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': token
            }
        });

        $.extend({
            APIAjax: function(params){
                params.error = function(event) {
                    if (event.statusText != 'abort') {
                        handleNotification('A server-side error occured. Try refreshing if the problem persists.', 'error');
                    }
                };

                if (params.success && typeof params.success == 'function') {
                    var successCallback = params.success,
                        ourCallback = function(responseJson) {
                            if (isValidJson(responseJson)) { // Validate the data
                                if (responseJson.error == 0) {
                                    successCallback(responseJson); // Continue to function
                                } else {
                                    handleNotification(responseJson.message, 'error');
                                }
                            } else {
                                handleNotification('A server-side error occured. Try refreshing if the problem persists.', 'error');
                            }
                        }

                    params.success = ourCallback;
                }

                return $.ajax(params);
            }
        });
    </script>

@stop