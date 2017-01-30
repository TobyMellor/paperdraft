@extends('template.dashboard')

@section('title', 'Admin Panel')
@section('main')
    <div class="row row-sortable">
        <div class="col-md-6">
            <div class="panel panel-primary panel-bordered">
                <div class="panel-heading">
                    <h6 class="panel-title">
                        <span class="text-semibold">Users</span>
                        <span class="text-muted text-muted-light">
                        </span>
                    </h6>
                <a class="heading-elements-toggle"><i class="icon-menu"></i></a></div>
                <table class="table text-nowrap">
                    <thead>
                        <tr>
                            <th style="width: 300px;">Full Name</th>
                            <th># of classes</th>
                            <th>Admin</th>
                            <th style="width: 20px;" class="text-center"><i class="icon-arrow-down12"></i></th>
                        </tr>
                    </thead>
                    <tbody>
                        @if (Auth::user()->institution_id !== null)
                            @foreach (Auth::user()->institution->users as $institutionUser)
                                <tr user-id="{{ $institutionUser->id }}">
                                    <td>
                                        <div class="media-left media-middle">
                                            <a class="btn bg-teal-400 tooltip-blue btn-rounded btn-icon btn-xs" href="javascript:void(0);">
                                                <div class="letter-icon">{{ strtoupper($institutionUser->first_name[0]) }}</div>
                                            </a>
                                        </div>

                                        <div class="media-body media-middle">
                                            <h6 class="display-inline-block text-default text-semibold letter-icon-title" href="javascript:void(0);" style="margin-bottom: 3px; margin-top: 3px;">
                                                {{ $institutionUser->title }}. {{ $institutionUser->first_name }} {{ $institutionUser->last_name }}
                                            </h6>
                                        </div>
                                    </td>
                                    <td>
                                        <h6 class="no-margin">{{ $institutionUser->schoolClasses->count() }}</h6>
                                    </td>
                                    <td>
                                        <span>
                                            <i class="@if ($institutionUser->priviledge === 1) icon-checkmark3 text-success @else icon-cross2 text-danger-400 @endif"></i>
                                        </span>
                                    </td>
                                    <td>
                                        <div class="btn-group">
                                            <button type="button" class="btn btn-danger dropdown-toggle" @if ($institutionUser->priviledge === 1) disabled @endif>
                                                Options <span class="caret"></span>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        @endif
                    </tbody>
                </table>
                <form action="javascript:void(0);" method="POST">
                    <div class="content" style="padding-bottom: 20px;">
                        <div class="row">
                            <div class="col-md-12">
                                <fieldset class="text-semibold">
                                    <legend><i class="icon-user-plus position-left"></i> Invite User</legend>
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
                                                        <label class="display-block text-bold">Email Address <span class="text-danger">*</span></label>
                                                        <input data-original-title="Enter the users email address" class="form-control" data-popup="tooltip" title="" placeholder="Email Address" type="text" name="student_name" autocomplete="off" required>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </fieldset>
                                <br />
                                <div class="text-right">
                                    <button type="submit" class="btn btn-primary">Invite User<i class="icon-paperplane position-right"></i></button>
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
                            <small id="class-name"> Rooms your users will see /w respective templates you set<small>
                        </span>
                    </h6>
                <a class="heading-elements-toggle"><i class="icon-menu"></i></a></div>
                <table class="table text-nowrap">
                    <thead>
                        <tr>
                            <th style="width: 300px;">User</th>
                            <th># of classes</th>
                            <th>Admin</th>
                            <th style="width: 20px;" class="text-center"><i class="icon-arrow-down12"></i></th>
                        </tr>
                    </thead>
                    <tbody>
                        @if (Auth::user()->institution_id !== null)
                            @foreach (Auth::user()->institution->users as $institutionUser)
                                <tr user-id="{{ $institutionUser->id }}">
                                    <td>
                                        <div class="media-left media-middle">
                                            <a class="btn bg-teal-400 tooltip-blue btn-rounded btn-icon btn-xs" href="javascript:void(0);">
                                                <div class="letter-icon">{{ strtoupper($institutionUser->first_name[0]) }}</div>
                                            </a>
                                        </div>

                                        <div class="media-body media-middle">
                                            <h6 class="display-inline-block text-default text-semibold letter-icon-title" href="javascript:void(0);" style="margin-bottom: 3px; margin-top: 3px;">
                                                {{ $institutionUser->title }}. {{ $institutionUser->first_name }} {{ $institutionUser->last_name }}
                                            </h6>
                                        </div>
                                    </td>
                                    <td>
                                        <h6 class="no-margin">{{ $institutionUser->schoolClasses->count() }}</h6>
                                    </td>
                                    <td>
                                        <span>
                                            <i class="@if ($institutionUser->priviledge === 1) icon-checkmark3 text-success @else icon-cross2 text-danger-400 @endif"></i>
                                        </span>
                                    </td>
                                    <td>
                                        <div class="btn-group">
                                            <button type="button" class="btn btn-danger dropdown-toggle" @if ($institutionUser->priviledge === 1) disabled @endif>
                                                Options <span class="caret"></span>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        @endif
                    </tbody>
                </table>
                <form action="javascript:void(0);" method="POST">
                    <div class="content" style="padding-bottom: 20px;">
                        <div class="row">
                            <div class="col-md-12">
                                <fieldset class="text-semibold">
                                    <legend><i class="icon-user-plus position-left"></i> Invite User</legend>
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
                                                        <label class="display-block text-bold">Email Address <span class="text-danger">*</span></label>
                                                        <input data-original-title="Enter the users email address" class="form-control" data-popup="tooltip" title="" placeholder="Email Address" type="text" name="student_name" autocomplete="off" required>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </fieldset>
                                <br />
                                <div class="text-right">
                                    <button type="submit" class="btn btn-primary">Invite User<i class="icon-paperplane position-right"></i></button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@stop

@section('scripts')
    <script>
        var token = '{{ csrf_token() }}';
        
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