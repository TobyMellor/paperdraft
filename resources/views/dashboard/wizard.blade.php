@extends('template.dashboard')

@section('title', 'Basic Settings')
@section('main')
    <style>
        .content {
            overflow: visible !important;
        }
    </style>

    <div class="panel panel-primary panel-bordered">
        <div class="panel-heading">
            <h6 class="panel-title">Your Basic Settings</h6>
        </div>
        <div class="panel-body">
            <form class="steps-validation" action="javascript:void(0);">
                @if (Auth::user()->institution_id === null || Auth::user()->priviledge === 1)
                    <h6>Basic Institution Details</h6>
                    <fieldset>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group has-feedback">
                                    <label class="display-block text-bold">
                                        Are you an admin of an institution?: <span class="text-danger">*</span>
                                    </label>
                                    <div class="radio">
                                        <label>
                                            <input type="radio" checked="checked" class="styled" name="is-institution" value="false">
                                            I'm just an individual (stand-alone teacher)
                                        </label>
                                    </div>
                                    <div class="radio">
                                        <label>
                                            <input type="radio" class="styled" name="is-institution" value="true">
                                            I'm registering on behalf of an institution I'd like to become admin of
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div id="institution">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group has-feedback">
                                        <label class="display-block text-bold">
                                            Institution Name: <span class="text-danger">*</span>
                                        </label>
                                        @if (isset(Auth::user()->institution))
                                            <input type="text" name="institution_name" placeholder="Give your institution a name" class="form-control" value="{{ Auth::user()->institution->name }}">
                                        @else
                                            <input type="text" name="institution_name" placeholder="Give your institution a name" class="form-control">
                                        @endif
                                        <div class="form-control-feedback">
                                            <i class="icon-home text-muted"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </fieldset>
                @endif

                <h6>Personal data</h6>
                <fieldset>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group has-feedback">
                                <label class="display-block text-bold">
                                    Email address: <span class="text-danger">*</span>
                                </label>
                                <input type="email" class="form-control" value="{{ Auth::user()->email }}" disabled>
                                <div class="form-control-feedback">
                                    <i class="icon-vcard text-muted"></i>
                                </div>
                            </div>
                            <a class="btn btn-primary">Change Email</a>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group has-feedback">
                                <label class="display-block text-bold">Password: <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" value="****" disabled>
                                <div class="form-control-feedback">
                                    <i class="icon-user-lock text-muted"></i>
                                </div>
                            </div>
                            <a class="btn btn-primary">Change Password</a>
                        </div>
                    </div>
                    <div class="row" style="margin-top: 20px;">
                        <div class="col-md-2">
                            <div class="form-group">
                                <label class="display-block text-bold">Your title: <span class="text-danger">*</span></label>
                                <select name="title" data-placeholder="Select your title" class="select">
                                    <option value="Mr">Mr</option>
                                    <option value="Mrs">Mrs</option>
                                    <option value="Miss">Miss</option>
                                    <option value="Ms">Ms</option>
                                    <option value="Dr">Dr</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-5">
                            <div class="form-group">
                                <label class="display-block text-bold">Your first name: <span class="text-danger">*</span></label>
                                <input type="text" name="first_name" value="{{ Auth::user()->first_name }}" class="form-control" placeholder="Your first name">
                            </div>
                        </div>
                        <div class="col-md-5">
                            <div class="form-group">
                                <label class="display-block text-bold">Your last name: <span class="text-danger">*</span></label>
                                <input type="text" name="last_name" value="{{ Auth::user()->last_name }}" class="form-control" placeholder="Your last name">
                            </div>
                        </div>
                    </div>
                </fieldset>

                <h6>Your classes</h6>
                <fieldset>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group has-feedback">
                                <label class="display-block text-bold">
                                    Class Name: <span class="text-danger">*</span>
                                </label>
                                <input type="text" name="class_name" placeholder="Class name" class="form-control required">
                                <div class="form-control-feedback">
                                    <i class="icon-book text-muted"></i>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="display-block text-bold">
                                    Subject:
                                </label>
                                <input type="text" name="class_subject" placeholder="Subject name" value="" class="form-control">
                            </div>
                            
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
                                </div>
                            @endif

                            <a href="javascript:void(0);" class="btn btn-primary pull-right" id="create-class">Create Class <i class="icon-book" style="margin-left: 5px;"></i></a>
                        </div>

                        <div class="col-md-6">
                            <label class="display-block text-bold">Your classes:</label>
                            <div class="table-responsive" style="display: none;">
                                <table class="table table-bordered table-striped table-hover">
                                    <thead>
                                        <tr>
                                            <th>Class Name</th>
                                            <th>Subject</th>
                                            <th>Class Room</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if (sizeOf($classes) > 0)
                                            @foreach ($classes as $class)
                                                @if ($class->institution_id === null)
                                                    <tr>
                                                        <td>{{ $class->class_name }}</td>
                                                        <td>{{ $class->class_subject or 'N/A' }}</td>
                                                        <td>{{ $class->class_room or 'N/A' }}</td>
                                                        <td>
                                                            <div class="btn-group">
                                                                <button type="button" class="btn btn-danger delete-class" class-id="{{ $class->id }}">Delete</span></button>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                @endif
                                            @endforeach
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                            <strong id="no-classes"><br />You have no classes yet. Create one using the form.</strong>

                            <br />
                        </div>
                    </div>
                </fieldset>

                <h6>Your students</h6>
                <fieldset>
                    <h2>We'll redirect you to the students page.</h2>
                </fieldset>
            </form>
        </div>
    </div>
@stop
@section('scripts')
    <script type="text/javascript" src="{{ asset('assets/js/plugins/forms/wizards/steps.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/js/plugins/forms/selects/select2.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/js/plugins/forms/styling/uniform.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/js/plugins/forms/validation/validate.min.js') }}"></script>

    <script>
        // Show form
        var form = $(".steps-validation").show();
        var token = '{{ csrf_token() }}';
        var hasErrorOccured = false;

        $(".steps-validation").steps({
            headerTag: "h6",
            bodyTag: "fieldset",
            transitionEffect: "fade",
            titleTemplate: '<span class="number">#index#</span> #title#',
            autoFocus: true,
            @if (Auth::user()->last_name !== null && !strpos(url()->current(), 'dashboard/settings'))
                startIndex: 1,
            @endif
            onStepChanging: function (event, currentIndex, newIndex) {
                $('.validation-error-label').remove();

                var requiredErrorLabel = '<label id="position-error" class="validation-error-label" for="position">This field is required.</label>';

                @if (Auth::user()->institution_id === null || Auth::user()->priviledge === 1)
                    if (currentIndex === 0) {
                        var institutionName = $('input[name="institution_name"]');

                        if ($('input[name="is-institution"][value="true"]').prop('checked')) {
                            if (institutionName.val() === "" || institutionName.val() === null) {
                                institutionName.parent().append(requiredErrorLabel);
                            } else if (institutionName.val().length === 0 || institutionName.val().length >= 50) {
                                institutionName.parent().append('<label id="position-error" class="validation-error-label" for="position">The first name must be less than 50 characters.</label>');
                            }

                            if ($('.validation-error-label').length === 0) {
                                updateInstitution();
                            }
                        }
                    }

                    if (currentIndex === 1 && newIndex === 2) {
                        var title     = $('select[name=title]'),
                            firstName = $('input[name=first_name]'),
                            lastName  = $('input[name=last_name]');

                        if (title.val() === "" || title.val() === null) {
                            title.parent().append(requiredErrorLabel);
                        } else if (['Mr', 'Mrs', 'Miss', 'Ms', 'Dr'].indexOf(title.val()) === -1) {
                            title.parent().append(requiredErrorLabel);
                        }

                        if (firstName.val() === "" || firstName.val() === null) {
                            firstName.parent().append(requiredErrorLabel);
                        } else if (firstName.val().length === 0 || firstName.val().length >= 20) {
                            firstName.parent().append('<label id="position-error" class="validation-error-label" for="position">The first name must be less than 20 characters.</label>');
                        }

                        if (lastName.val() === "" || lastName.val() === null) {
                            lastName.parent().append(requiredErrorLabel);
                        } else if (lastName.val().length === 0 || lastName.val().length >= 20) {
                            lastName.parent().append('<label id="position-error" class="validation-error-label" for="position">The last name must be less than 20 characters.</label>');
                        }

                        if ($('.validation-error-label').length === 0) {
                            updateUser();
                        }
                    }

                    if (currentIndex === 2 && newIndex === 3) {
                        if ($('tr').length > 1) {
                            window.location.href = '{{ url('dashboard/classes') }}';

                            $(".steps-validation").fadeOut();

                            return true;
                        }

                        handleNotification('You need to create at least one class before continuing.', 'error');

                        return false;
                    }
                @else
                    if (currentIndex === 0) {
                        var title     = $('select[name=title]'),
                            firstName = $('input[name=first_name]'),
                            lastName  = $('input[name=last_name]');

                        if (title.val() === "" || title.val() === null) {
                            title.parent().append(requiredErrorLabel);
                        } else if (['Mr', 'Mrs', 'Miss', 'Ms', 'Dr'].indexOf(title.val()) === -1) {
                            title.parent().append(requiredErrorLabel);
                        }

                        if (firstName.val() === "" || firstName.val() === null) {
                            firstName.parent().append(requiredErrorLabel);
                        } else if (firstName.val().length == 0 || firstName.val().length >= 20) {
                            firstName.parent().append('<label id="position-error" class="validation-error-label" for="position">The first name must be less than 20 characters.</label>');
                        }

                        if (lastName.val() === "" || lastName.val() == null) {
                            lastName.parent().append(requiredErrorLabel);
                        } else if (lastName.val().length === 0 || lastName.val().length >= 20) {
                            lastName.parent().append('<label id="position-error" class="validation-error-label" for="position">The last name must be less than 20 characters.</label>');
                        }

                        if ($('.validation-error-label').length === 0) {
                            updateUser();
                        }
                    }

                    if (currentIndex === 1 && newIndex === 2) {
                        if ($('tr').length > 1) {
                            window.location.href = '{{ url('dashboard/classes') }}';

                            $(".steps-validation").fadeOut();

                            return true;
                        }

                        handleNotification('You need to create at least one class before continuing.', 'error');

                        return false;
                    }
                @endif

                if ($('.validation-error-label').length > 0) {
                    return false;
                }

                // Always allow previous action even if the current form is not valid!
                if (currentIndex > newIndex) {
                    return true;
                }

                return form.valid();
            }
        });
    
        $(document).on('ready', function() {
            // Select2 selects
            $('select[name="title"]').val('{{ Auth::user()->title }}');
            $('select').select2().trigger('change');

            // Styled checkboxes and radios
            $('.styled').uniform({
                radioClass: 'choice'
            });

            // Styled file input
            $('.file-styled').uniform({
                wrapperClass: 'bg-warning',
                fileButtonHtml: '<i class="icon-googleplus5"></i>'
            });

            $('input[name=last_name]').on('keyup', function() {
                triggerNameChange();
            });

            $('select[name=title]').on('change', function() {
                triggerNameChange();
            });

            $('#create-class').on('click', function() {
                var className    = $('input[name=class_name]'),
                    classSubject = $('input[name=class_subject]'),
                    classRoom    = $('input[name=class_room]');

                $('.validation-error-label').remove();

                if (className.val() == "" || className.val() == null) {
                    className.parent().append('<label id="position-error" class="validation-error-label" for="position">This field is required.</label>');
                } else if (className.val().length == 0 || className.val().length > 30) {
                    className.parent().append('<label id="position-error" class="validation-error-label" for="position">The class name must be less than 30 characters.</label>');
                }

                if (classSubject.val().length > 30) {
                    classSubject.parent().append('<label id="position-error" class="validation-error-label" for="position">The subject name must be less than 30 characters.</label>');
                }

                if ($('.validation-error-label').length == 0) {
                    createClass();
                }
            });

            $(document).delegate('.delete-class', 'click', function() {
                var classId = $(this).attr('class-id');

                $(this).replaceWith('<button class="btn btn-danger" type="button" class-id="' + classId + '" disabled>Deleting <i class="icon-spinner2 spinner" style="margin-left: 5px;"></i></button>');

                deleteClass(classId);
            });

            $(document).on('change', 'input[name="is-institution"]', function() {
                if ($(this).val() === 'true') {
                    $('#institution').fadeIn();
                } else {
                    $('#institution').fadeOut();
                }
            });

            @if (Auth::user()->priviledge === 1)
                $('input[name="is-institution"][value="true"]').click().click();
            @endif

            @if (sizeOf($classes) > 0)
                $('#no-classes').hide();
                $('.table-responsive').show();
            @endif
        });

        function updateUser() {
            var formData = $('.steps-validation').serializeArray().reduce(function(obj, item) {
                obj[item.name] = item.value;
                return obj;
            }, {});

            $.APIAjax({
                url: '{{ url('api/user') }}/{{ Auth::user()->id }}',
                type: 'PUT',
                data: {
                    title:            formData['title'],
                    first_name:       formData['first_name'],
                    last_name:        formData['last_name']
                },
                success: function(jsonResponse) {
                    handleNotification(jsonResponse.message, 'success');
                },
                error: function(jsonResponse) {
                    $(".steps-validation").steps("previous");
                }
            }).always(function() {
                if (hasErrorOccured) {
                    hasErrorOccured = false;

                    $('.steps-validation').steps('previous');
                }
            });
        }

        function updateInstitution() {
            var formData = $('.steps-validation').serializeArray().reduce(function(obj, item) {
                obj[item.name] = item.value;
                return obj;
            }, {});

            $.APIAjax({
                url: '{{ url('api/institution') }}',
                type: 'POST',
                data: {
                    institution_name: formData['institution_name']
                },
                success: function(jsonResponse) {
                    handleNotification(jsonResponse.message, 'success');
                },
                error: function(jsonResponse) {
                    $(".steps-validation").steps("previous");
                }
            }).always(function() {
                if (hasErrorOccured) {
                    hasErrorOccured = false;

                    $('.steps-validation').steps('previous');
                }
            });
        }

        function createClass() {
            var formData = $('.steps-validation').serializeArray().reduce(function(obj, item) {
                obj[item.name] = item.value;
                return obj;
            }, {});

            $('#create-class').addClass('disabled');
            $('#create-class').html('Creating Class <i class="icon-spinner2 spinner" style="margin-left: 5px;"></i>')

            $.APIAjax({
                url: '{{ url('api/class') }}',
                type: 'POST',
                data: {
                    class_name:    formData['class_name'],
                    class_subject: formData['class_subject'],
                    class_id:      formData['class_id']
                },
                success: function(jsonResponse) {
                    handleNotification(jsonResponse.message, 'success');

                    if (formData['class_subject'] === "") {
                        formData['class_subject'] = 'N/A';
                    }

                    formData['class_room'] = jsonResponse.class.class_room;

                    if (typeof formData['class_room'] === "undefined") {
                        formData['class_room'] = 'N/A';
                    }

                    $('tbody').append('<tr>' +
                        '<td>' +
                            formData['class_name'] + 
                        '</td>' +
                        '<td>' + 
                            formData['class_subject'] +
                        '</td>' +
                        '<td>' + 
                            formData['class_room'] +
                        '</td>' +
                        '<td>' +
                            '<div class="btn-group">' +
                                '<button type="button" class="btn btn-danger delete-class" class-id="' + jsonResponse.class.id + '">Delete</span></button>' +
                            '</div>' +
                        '</td>' +
                    '</tr>');

                    $('#no-classes').fadeOut(300, function() {
                        $('.table-responsive').fadeIn();
                    });

                    $('input[name=class_name]').val('');


                    $('input[name=class_id]').val('').trigger('change');
                },
                error: function(jsonResponse) {
                    $('.steps-validation').steps('previous');
                }
            }).always(function() {
                $('#create-class').removeClass('disabled');
                $('#create-class').html('Create Class <i class="icon-book" style="margin-left: 5px;"></i>');
            });
        }

        function deleteClass(classId) {
            $.APIAjax({
                url: '{{ url('api/class') }}/' + classId,
                type: 'DELETE',
                success: function(jsonResponse) {
                    handleNotification(jsonResponse.message, 'success');

                    $('button[class-id=' + classId + ']').closest('tr').fadeOut(300, function() {
                        $(this).remove();

                        if ($('tr').length == 1) {
                            $('.table-responsive').fadeOut(300, function() {
                                $('#no-classes').fadeIn();
                            });
                        }
                    });
                },
                error: function(jsonResponse) {}
            }).always(function() {
                $('button[class-id=' + classId + ']').replaceWith('<button type="button" class="btn btn-danger delete-class" class-id="' + classId + '">Delete</span></button>');
            });
        }

        function triggerNameChange() {
            var title = $('select[name=title]');
            var lastName = $('input[name=last_name]');
            var originalName = '{{ current(explode("@", Auth::user()->email, 2)) }}';

            $('.username').text(originalName);

            if (title.val() != "" && title.val() != null && ['Mr', 'Mrs', 'Miss', 'Ms', 'Dr'].indexOf(title.val()) > -1) {
                if (lastName.val() != "" && lastName.val() != null && lastName.val().length > 0 && lastName.val().length < 20) {
                    $('.username').text(title.val() + '. ' + lastName.val());
                }
            }
        }

        // notificationContent is the message e.g. 'hello' (string)
        // type is the display type e.g. 'error' or 'success' (string)
        function handleNotification(notificationContent, type, timeout = 5000) {
            var n = noty({
                text: notificationContent,
                layout: 'topRight',
                type: type
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
                params.error = function() {
                    hasErrorOccured = true;
                    handleNotification('A server-side error occured. Try refreshing if the problem persists.', 'error');
                };

                if (params.success && typeof params.success == 'function') {
                    var successCallback = params.success;
                    var ourCallback = function(responseJson) {
                        if (isValidJson(responseJson)) { // Validate the data
                            if (responseJson.error == 0) {
                                successCallback(responseJson); // Continue to function
                            } else {
                                hasErrorOccured = true;
                                handleNotification(responseJson.message, 'error');
                            }
                        } else {
                            hasErrorOccured = true;
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