@extends('template.dashboard')

@section('title', 'Admin Panel')
@section('main')
    <div class="row row-sortable">
        <div class="col-md-6">
            <div class="panel panel-primary panel-bordered">
                <div class="panel-heading">
                    <h6 class="panel-title">
                        <span class="text-semibold">Users</span>
                    </h6>
                <a class="heading-elements-toggle"><i class="icon-menu"></i></a></div>
                <table class="table text-nowrap">
                    <thead>
                        <tr>
                            <th style="width: 300px;">Name/Email</th>
                            <th># of classes</th>
                            <th>Accepted Invite</th>
                            <th style="width: 20px;" class="text-center"><i class="icon-arrow-down12"></i></th>
                        </tr>
                    </thead>
                    <tbody id="register-user-tbody">
                        @if (Auth::user()->institution_id !== null)
                            @foreach (Auth::user()->institution->users as $institutionUser)
                                <tr user-id="{{ $institutionUser->id }}">
                                    <td>
                                        <div class="media-left media-middle">
                                            <a class="btn bg-teal-400 tooltip-blue btn-rounded btn-icon btn-xs" href="javascript:void(0);">
                                                <div class="letter-icon">
                                                    @if ($institutionUser->first_name === null)
                                                        @
                                                    @else
                                                        {{ strtoupper($institutionUser->first_name[0]) }}
                                                    @endif
                                                </div>
                                            </a>
                                        </div>

                                        <div class="media-body media-middle">
                                            <h6 class="display-inline-block text-default text-semibold letter-icon-title" href="javascript:void(0);" style="margin-bottom: 3px; margin-top: 3px;">
                                                    @if ($institutionUser->first_name === null)
                                                        {{ $institutionUser->email }}
                                                    @else
                                                        {{ $institutionUser->title }}. {{ $institutionUser->first_name }} {{ $institutionUser->last_name }}
                                                    @endif
                                            </h6>
                                        </div>
                                    </td>
                                    <td>
                                        <h6 class="no-margin">{{ $institutionUser->schoolClasses->count() }}</h6>
                                    </td>
                                    <td>
                                        <span>
                                            <i class="@if (!$institutionUser->should_change_password) icon-checkmark3 text-success @else icon-cross2 text-danger-400 @endif"></i>
                                        </span>
                                    </td>
                                    <td>
                                        <div class="btn-group">
                                            <button type="button" data-toggle="dropdown" class="btn btn-danger dropdown-toggle" @if ($institutionUser->priviledge === 1) disabled @endif>
                                                Options <span class="caret"></span>
                                            </button>
                                            <ul class="dropdown-menu dropdown-menu-right">
                                                <li>
                                                    <a id="remove-from-institution">
                                                        <i class="icon-user-minus"></i> Delete
                                                    </a>
                                                </li>
                                                @if ($institutionUser->should_change_password)
                                                    <li>
                                                        <a id="resend-invitation">
                                                            <i class="icon-paperplane"></i> Resend Invite
                                                        </a>
                                                    </li>
                                                @endif
                                            </ul>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        @endif
                    </tbody>
                </table>
                <form action="javascript:void(0);" method="POST" id="register-user-form">
                    <div class="content" style="padding-bottom: 20px;">
                        <div class="row">
                            <div class="col-md-12">
                                <fieldset class="text-semibold">
                                    <legend>
                                        <i class="icon-user-plus position-left"></i> Register Your Users
                                    </legend>
                                    <div class="tabbable tab-content-bordered">
                                        <ul class="nav nav-tabs nav-tabs-highlight">
                                            <li class="active">
                                                <a data-toggle="tab" href="#icon-only-tab1" data-popup="tooltip" title="Information">
                                                    <i class="icon-cog52"></i>
                                                    <span class="visible-xs-inline-block position-right">Information</span>
                                                </a>
                                            </li>
                                        </ul>

                                        <div class="tab-content">
                                            <div id="icon-only-tab1" class="tab-pane has-padding active">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <label class="display-block text-bold">
                                                            Email Address <span class="text-danger">*</span>
                                                        </label>
                                                        <input data-original-title="Enter the users email address" class="form-control" data-popup="tooltip" title="" placeholder="Email Address" type="email" name="email" autocomplete="off" required>
                                                        <span class="text-muted">
                                                            <small>
                                                                The user will login with this email and a random password sent in an email
                                                            </small>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </fieldset>
                                <br />
                                <div class="text-right">
                                    <button type="submit" class="btn btn-primary" id="register-user">
                                        Register User <i class="icon-paperplane position-right"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="col-md-6">
            <div class="panel panel-primary panel-bordered">
                <div class="panel-heading">
                    <h6 class="panel-title">
                        <span class="text-semibold">Class Rooms</span>
                        <span class="text-muted text-muted-light">
                            <small> Users in your institution will be able to use your room plans</small>
                        </span>
                    </h6>
                    <a class="heading-elements-toggle">
                        <i class="icon-menu"></i>
                    </a>
                </div>
                <table class="table text-nowrap">
                    <thead>
                        <tr>
                            <th style="width: 300px;">Room Name</th>
                            <th># of seats</th>
                            <th style="width: 20px;" class="text-center"><i class="icon-arrow-down12"></i></th>
                        </tr>
                    </thead>
                    <tbody id="create-class-tbody">
                        @if (isset($classes))
                            @foreach ($classes as $class)
                                @if ($class->institution_id !== null)
                                    <tr class-id="{{ $class->id }}">
                                        <td class="class-name">
                                            {{ $class->class_name }}
                                        </td>
                                        <td>
                                            {{ $class->canvasItems->count() }}
                                        </td>
                                        <td>
                                            <div class="btn-group">
                                                <button type="button" data-toggle="dropdown" class="btn btn-danger dropdown-toggle">
                                                    Options <span class="caret"></span>
                                                </button>
                                                <ul class="dropdown-menu dropdown-menu-right">
                                                    <li>
                                                        <a id="delete-room">
                                                            <i class="icon-minus3"></i> Delete Room
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a id="edit-room">
                                                            <i class="icon-pencil"></i> Edit Room
                                                        </a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </td>
                                    </tr>
                                @endif
                            @endforeach
                        @endif
                    </tbody>
                </table>
                <form action="javascript:void(0);" method="POST" id="create-room-form">
                    <div class="content" style="padding-bottom: 20px;">
                        <div class="row">
                            <div class="col-md-12">
                                <fieldset class="text-semibold">
                                    <legend>
                                        <i class="icon-user-plus position-left"></i> Create Class Rooms
                                    </legend>
                                    <div class="tabbable tab-content-bordered">
                                        <ul class="nav nav-tabs nav-tabs-highlight">
                                            <li class="active">
                                                <a data-toggle="tab" href="#icon-only-tab1" title="" data-popup="tooltip" data-original-title="Information">
                                                    <i class="icon-cog52"></i>
                                                    <span class="visible-xs-inline-block position-right">Information</span>
                                                </a>
                                            </li>
                                        </ul>

                                        <div class="tab-content">
                                            <div id="icon-only-tab1" class="tab-pane has-padding active">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <label class="display-block text-bold">
                                                            Room Name <span class="text-danger">*</span>
                                                        </label>
                                                        <input title="Enter the rooms name" class="form-control" data-popup="tooltip" placeholder="Room Name" type="text" name="class_name" autocomplete="off" required>
                                                        <span class="text-muted">
                                                            <small>
                                                                Users in your institution will be able to use this Room as a template
                                                            </small>
                                                        </span>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label class="display-block text-bold">Duplicate Seat Layout From</label>
                                                        <div class="form-group">
                                                            <select name="copied_class_id">
                                                                <optgroup label="Seating Plans">
                                                                    <option value="" selected>Select a plan to duplicate</option>
                                                                    @foreach ($classes as $class)
                                                                        <option value="{{ $class->id }}">{{ $class->class_name }}</option>
                                                                    @endforeach
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
                                    <button type="submit" class="btn btn-primary" id="create-room">
                                        Create Room <i class="icon-plus3 position-right"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="row row-sortable">
        <div class="col-md-6">
            <div class="panel panel-primary panel-bordered">
                <div class="panel-heading">
                    <h6 class="panel-title">
                        <span class="text-semibold">Students</span>
                        <span class="text-muted text-muted-light">
                            <small id="class-name"> Users in your institution will be able to add these students to their class rooms<small>
                        </span>
                    </h6>
                <a class="heading-elements-toggle"><i class="icon-menu"></i></a></div>
                <table class="table text-nowrap">
                    <thead>
                        <tr>
                            <th style="width: 300px;">Student</th>
                            <th>Gender</th>
                            <th>PP</th>
                            <th style="width: 20px;" class="text-center"><i class="icon-arrow-down12"></i></th>
                        </tr>
                    </thead>
                    <tbody id="create-student-tbody">
                        @if (isset($students))
                            @foreach ($students as $student)
                                <tr student-id="{{ $student->id }}">
                                    <td>
                                        <div class="media-left media-middle">
                                            <a class="btn bg-teal-400 @if ($student->gender === 'male') tooltip-blue @else tooltip-pink @endif btn-rounded btn-icon btn-xs" href="javascript:void(0);">
                                                <div class="letter-icon">
                                                    {{ strtoupper($student->name[0]) }}
                                                </div>
                                            </a>
                                        </div>

                                        <div class="media-body media-middle">
                                            <h6 class="display-inline-block text-default text-semibold letter-icon-title student-name" href="javascript:void(0);">{{ $student->name }}</h6>
                                        </div>
                                    </td>
                                    <td class="gender">
                                        {{ $student->gender }}
                                    </td>
                                    <td class="pupil-premium">
                                        <span>
                                            <i class="@if ($student->pupil_premium) icon-checkmark3 text-success @else icon-cross2 text-danger-400 @endif"></i>
                                        </span>
                                    </td>
                                    <td>
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
                    <input name="class_id" value="" hidden>
                    <div class="content" style="padding-bottom: 20px;">
                        <div class="row">
                            <div class="col-md-12">
                                <fieldset class="text-semibold">
                                    <legend>
                                        <i class="icon-user-plus position-left"></i> Add Student
                                    </legend>
                                    <div class="tabbable tab-content-bordered">
                                        <ul class="nav nav-tabs nav-tabs-highlight">
                                            <li class="active">
                                                <a data-toggle="tab" href="#icon-only-tab1" title="Information" data-popup="tooltip">
                                                    <i class="icon-cog52"></i>
                                                    <span class="visible-xs-inline-block position-right">
                                                        Information
                                                    </span>
                                                </a>
                                            </li>

                                            <li>
                                                <a data-toggle="tab" href="#icon-only-tab2" title="Picture" data-popup="tooltip">
                                                    <i class="icon-stack-picture"></i>
                                                    <span class="visible-xs-inline-block position-right">
                                                        Picture
                                                    </span>
                                                </a>
                                            </li>
                                        </ul>

                                        <div class="tab-content">
                                            <div id="icon-only-tab1" class="tab-pane has-padding active">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <label class="display-block text-bold">Basic Information <span class="text-danger">*</span></label>
                                                        <input title="Enter the students name" class="form-control" data-popup="tooltip" placeholder="Students Name" type="text" name="student_name" autocomplete="off" required id="student-name">
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label class="display-block text-bold">Additional Information</label>
                                                        <label class="checkbox-inline">
                                                            <input type="checkbox" class="styled" name="pupil_premium">
                                                            Pupil Premium
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <br />
                                                    <div class="col-md-6">
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
    </div>
@stop

@section('modals')
    <div id="modal_edit_room" class="modal fade">
        <div class="modal-dialog modal-xs">
            <div class="modal-content text-center">
                <div class="modal-header bg-primary">
                    <h5 class="modal-title">Edit the Room information</h5>
                </div>

                <form action="javascript:void(0);" class="form-inline" id="edit-room-form">
                    <input type="text" id="edit-room-id" name="class-id" hidden disabled>
                    <div class="modal-body">
                        <label class="display-block text-bold">
                            What's the rooms name? <span class="text-danger">*</span>
                        </label>
                        <div class="form-group has-feedback">
                            <input type="text" placeholder="Room name" class="form-control" name="class_name">
                            <div class="form-control-feedback">
                                <i class="icon-book text-muted"></i>
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer text-center">
                        <button class="btn btn-primary" id="edit-room-button">
                            Update Room <i class="icon-pencil"></i>
                        </button>
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
                    <div class="modal-body">
                        <div class="form-group">
                            <div class="row">
                                <div class="col-sm-8">
                                    <label class="display-block text-bold">Students Name <span class="text-danger">*</span></label>
                                    <input type="text" placeholder="Students Name" class="form-control" name="student_name">
                                </div>
                                <div class="col-sm-4">
                                    <label class="display-block text-bold">Pupil Premium</label>
                                    <label class="checkbox-inline">
                                        <input type="checkbox" class="styled" name="pupil_premium">
                                        Pupil Premium
                                    </label>
                                </div>
                            </div>
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
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button data-dismiss="modal" class="btn btn-link" type="button">Close</button>
                        <button class="btn btn-primary" type="submit">Update Student</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@stop

@section('scripts')
    <script>
        var token = '{{ csrf_token() }}';

        $(document).ready(function() {
            $('#register-user').click(function() {
                registerUser();
            });

            $(document).delegate('#resend-invitation', 'click', function() {
                var userId = getAttributeFromTr($(this), 'user-id');
                
                registerUser(userId);
            });

            $(document).delegate('#remove-from-institution', 'click', function() {
                var userId = getAttributeFromTr($(this), 'user-id');

                deleteUser(userId);
            });

            $(document).delegate('#edit-room', 'click', function() {
                var classId = getAttributeFromTr($(this), 'class-id');

                $('#edit-room-id').val(classId);

                $('#modal_edit_room').modal('show');
            });

            $(document).delegate('#delete-room', 'click', function() {
                var classId = getAttributeFromTr($(this), 'class-id');

                deleteRoom(classId);
            });

            $('#create-room').click(function() {
                createRoom();
            });

            $('#edit-room-button').click(function() {
                editRoom($('#edit-room-id').val());
            });

            $('#create-student').submit(function(event) {
                $('#guessing-text').fadeOut();

                event.preventDefault();

                var formData = $('#create-student').serializeArray().reduce(function(obj, item) {
                    obj[item.name] = item.value;
                    return obj;
                }, {});

                if (formData['pupil_premium'] === 'on') {
                    formData['pupil_premium'] = true;
                } else {
                    formData['pupil_premium'] = false;
                }

                $.APIAjax({
                    url: '{{ url('api/student') }}',
                    type: 'POST',
                    data: {
                        student_name:             formData['student_name'],
                        gender:                   formData['gender'],
                        pupil_premium:            formData['pupil_premium'],
                        class_id:                 formData['class_id']
                    },
                    success: function(jsonResponse) {
                        handleNotification(jsonResponse.message, 'success');

                        $('#create-student-tbody').append(
                            '<tr student-id="' + jsonResponse.student.id + '">' +
                                '<td>' +
                                    '<div class="media-left media-middle">' +
                                        '<a class="btn bg-teal-400 ' + (formData['gender'] === 'male' ? 'tooltip-blue' : 'tooltip-pink') + ' btn-rounded btn-icon btn-xs" href="javascript:void(0);">' +
                                            '<div class="letter-icon">' +
                                                formData['student_name'].charAt(0).toUpperCase() +
                                            '</div>' +
                                        '</a>' +
                                    '</div>' +
                                    '<div class="media-body media-middle">' +
                                        '<h6 class="display-inline-block text-default text-semibold letter-icon-title" href="javascript:void(0);">' +
                                            formData['student_name'] +
                                        '</h6>' +
                                    '</div>' +
                                '</td>' +
                                '<td>' +
                                    formData['gender'] +
                                '</td>' +
                                '<td>' +
                                    '<span>' +
                                        '<i class="' + (formData['pupil_premium'] ? "icon-checkmark3 text-success" : "icon-cross2 text-danger-400") + '"></i>' +
                                    '</span>' +
                                '</td>' +
                                '<td>' +
                                    '<div class="btn-group">' +
                                        '<button type="button" class="btn btn-danger dropdown-toggle" data-toggle="dropdown">' +
                                            'Options <span class="caret"></span>' +
                                        '</button>' +
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

                        $('tr[student-id=' + jsonResponse.student.id + ']').fadeIn();

                        $('#create-student').trigger('reset');
                        $('a[title="Information"]').tab('show');

                        $('select').select2();
                        $('.styled').uniform({
                            radioClass: 'choice'
                        });
                    },
                    error: function(jsonResponse) {}
                });
            });

            $('#update-student').submit(function(event) {
                event.preventDefault();

                updateStudent($(this));
            });

            var timer,
                genderAJAXRequest;

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
                deleteStudent(getAttributeFromTr($(this), 'student-id'));
            });

            $(document).delegate('.edit-student', 'click', function() {
                var classStudent = $(this).closest('tr'),
                    studentId    = classStudent.attr('student-id');

                var studentName  = classStudent.find('.student-name').text(),
                    gender       = classStudent.find('.gender').text(),
                    pupilPremium = classStudent.find('.pupil-premium').html();

                if (pupilPremium.indexOf('icon-cross2') > -1) {
                    pupilPremium = false;
                } else {
                    pupilPremium = true;
                }

                $('#update-student input[name=student_id]').val(studentId);
                $('#update-student input[name=student_name]').val(studentName);
                $('#update-student input[name=pupil_premium]').prop('checked', pupilPremium);
                $('#update-student input[value=' + gender + ']').prop('checked', true);

                $.uniform.update();
                $('select').select2().trigger('change');
                $('#modal_update_student').modal('show');
            });

            $('select').select2();
            $('.styled').uniform({
                radioClass: 'choice'
            });
        });

        function getAttributeFromTr(element, attribute) {
            return element
                .parent()
                .parent()
                .parent()
                .parent()
                .parent()
                .attr(attribute);
        }

        function registerUser(userId = null) {
            $('#register-user').prop('disabled', true);
            $('#register-user').html('Registering <i class="icon-spinner2 spinner position-right"></i>');

            var formData = $('#register-user-form').serializeArray().reduce(function(obj, item) {
                obj[item.name] = item.value;

                return obj;
            }, {});

            $.APIAjax({
                url: '{{ url('api/user') }}',
                type: 'POST',
                data: {
                    email:   formData['email'],
                    user_id: userId
                },
                success: function(jsonResponse) {
                    handleNotification(jsonResponse.message, 'success');

                    if (userId === null) {
                        $('#register-user-tbody').append(
                            '<tr user-id="' + jsonResponse.user.id + '">' +
                                '<td>' +
                                    '<div class="media-left media-middle">' +
                                        '<a class="btn bg-teal-400 tooltip-blue btn-rounded btn-icon btn-xs" href="javascript:void(0);">' +
                                            '<div class="letter-icon">@</div>' +
                                        '</a>' +
                                    '</div>' +
                                    '<div class="media-body media-middle">' +
                                        '<h6 class="display-inline-block text-default text-semibold letter-icon-title" href="javascript:void(0);" style="margin-bottom: 3px; margin-top: 3px;">' +
                                            formData['email'] +
                                        '</h6>' +
                                    '</div>' +
                                '</td>' +
                                '<td>' +
                                    '<h6 class="no-margin">0</h6>' +
                                '</td>' +
                                '<td>' +
                                    '<span>' +
                                        '<i class="icon-cross2 text-danger-400"></i>' +
                                    '</span>' +
                                '</td>' +
                                '<td>' +
                                    '<div class="btn-group">' +
                                        '<button type="button" data-toggle="dropdown" class="btn btn-danger dropdown-toggle">' +
                                            'Options <span class="caret"></span>' +
                                        '</button>' +
                                        '<ul class="dropdown-menu dropdown-menu-right">' +
                                            '<li>' +
                                                '<a id="remove-from-institution">' +
                                                    '<i class="icon-user-minus"></i> Delete' +
                                                '</a>' +
                                            '</li>' +
                                            '<li>' +
                                                '<a id="resend-invitation">' +
                                                    '<i class="icon-paperplane"></i> Resend Invite' +
                                                '</a>' +
                                            '</li>' +
                                        '</ul>' +
                                    '</div>' +
                                '</td>' +
                            '</tr>'
                        );
                    }
                },
                error: function(jsonResponse) {}
            }).always(function() {
                $('#register-user').prop('disabled', false);
                $('#register-user').html('Register User <i class="icon-paperplane position-right"></i>');
            });
        }

        function createRoom() {
            $('#create-room').prop('disabled', true);
            $('#create-room').html('Creating Room <i class="icon-spinner2 spinner position-right"></i>');

            var formData = $('#create-room-form').serializeArray().reduce(function(obj, item) {
                obj[item.name] = item.value;

                return obj;
            }, {});

            $.APIAjax({
                url: '{{ url('api/class') }}',
                type: 'POST',
                data: {
                    class_name:      formData['class_name'],
                    for_institution: true
                },
                success: function(jsonResponse) {
                    handleNotification(jsonResponse.message, 'success');

                    $('#create-class-tbody').append(
                        '<tr class-id="' + jsonResponse.class.id + '">' +
                            '<td class="class-name">' +
                                formData['class_name'] +
                            '</td>' +
                            '<td>' +
                                '0' +
                            '</td>' +
                            '<td>' +
                                '<div class="btn-group">' +
                                    '<button type="button" data-toggle="dropdown" class="btn btn-danger dropdown-toggle">' +
                                        'Options <span class="caret"></span>' +
                                    '</button>' +
                                    '<ul class="dropdown-menu dropdown-menu-right">' +
                                        '<li>' +
                                            '<a id="delete-room">' +
                                                '<i class="icon-minus3"></i> Delete Room' +
                                            '</a>' +
                                        '</li>' +
                                        '<li>' +
                                            '<a id="edit-room">' +
                                                '<i class="icon-pencil"></i> Edit Room' +
                                            '</a>' +
                                        '</li>' +
                                    '</ul>' +
                                '</div>' +
                            '</td>' +
                        '</tr>'
                    );

                    $.APIAjax({
                        url: '{{ url('api/class/duplicate') }}',
                        type: 'POST',
                        data: {
                            new_class_id: jsonResponse.class.id,
                            copied_class_id: formData['copied_class_id']
                        },
                        success: function(jsonResponse) {
                            handleNotification(jsonResponse.message, 'success');
                        },
                        error: function(jsonResponse) {}
                    });
                },
                error: function(jsonResponse) {}
            }).always(function() {
                $('#create-room').prop('disabled', false);
                $('#create-room').html('Create Room <i class="icon-plus3 position-right"></i>');
            });
        }

        function editRoom(classId) {
            $('#edit-room-button').prop('disabled', true);
            $('#edit-room-button').html('Updating room <i class="icon-spinner2 spinner position-right"></i>');

            var formData = $('#edit-room-form').serializeArray().reduce(function(obj, item) {
                obj[item.name] = item.value;

                return obj;
            }, {});

            $.APIAjax({
                url: '{{ url('api/class') }}/' + classId,
                type: 'PUT',
                data: {
                    class_name: formData['class_name']
                },
                success: function(jsonResponse) {
                    handleNotification(jsonResponse.message, 'success');

                    $('tr[class-id="' + classId + '"]').find('.class-name').html(formData['class_name']);
                },
                error: function(jsonResponse) {}
            }).always(function() {
                $('#edit-room-button').prop('disabled', false);
                $('#edit-room-button').html('Update Room <i class="icon-plus3 position-right"></i>');
                $('#edit-room-form').trigger('reset');
                $('#modal_edit_room').modal('hide');
            });
        }

        function deleteRoom(classId) {
            $.APIAjax({
                url: '{{ url('api/class') }}/' + classId,
                type: 'DELETE',
                success: function(jsonResponse) {
                    handleNotification(jsonResponse.message, 'success');

                    $('tr[class-id="' + classId + '"]').fadeOut(300, function() {
                        $(this).remove();
                    });
                },
                error: function(jsonResponse) {}
            });
        }

        function deleteUser(userId) {
            $.APIAjax({
                url: '{{ url('api/user') }}/' + userId,
                type: 'DELETE',
                success: function(jsonResponse) {
                    handleNotification(jsonResponse.message, 'success');

                    $('tr[user-id="' + userId + '"]').fadeOut(300, function() {
                        $(this).remove();
                    });
                },
                error: function(jsonResponse) {}
            });
        }


        function updateStudent(form) {
            var formData = form.serializeArray().reduce(function(obj, item) {
                obj[item.name] = item.value;

                return obj;
            }, {});

            if (formData['pupil_premium'] == 'on') {
                formData['pupil_premium'] = true;
            } else {
                formData['pupil_premium'] = false;
            }

            $.APIAjax({
                url: '{{ url('api/student') }}/' + formData['student_id'],
                type: 'PUT',
                data: {
                    student_name:  formData['student_name'],
                    gender:        formData['gender'],
                    pupil_premium: formData['pupil_premium']
                },
                success: function(jsonResponse) {
                    var classStudent = $('tr[student-id=' + formData['student_id'] + ']').closest('tr');

                    if (formData['pupil_premium']) {
                        formData['pupil_premium'] = '<i class="icon-checkmark3 text-success"></i>';
                    } else {
                        formData['pupil_premium'] = '<i class="icon-cross2 text-danger-400"></i>';
                    }

                    var studentName            = classStudent.find('.student-name').html(formData['student_name']),
                        gender                 = classStudent.find('.gender').html(formData['gender']),
                        pupilPremium           = classStudent.find('.pupil-premium').html(formData['pupil_premium']);

                    handleNotification(jsonResponse.message, 'success');

                    $('#modal_update_student').modal('hide');
                    $('#update-student').trigger('reset');
                },
                error: function(jsonResponse) {}
            });
        }

        function deleteStudent(studentId) {
            $.APIAjax({
                url: '{{ url('api/student') }}/' + studentId,
                type: 'DELETE',
                success: function(jsonResponse) {
                    $('tr[student-id=' + studentId + ']').fadeOut(300, function() {
                        $(this).remove();
                    });

                    handleNotification(jsonResponse.message, 'success');
                },
                error: function(jsonResponse) {}
            });
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