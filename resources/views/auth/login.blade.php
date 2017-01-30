@extends('template.auth')

@section('title', 'Login/Register')
@section('main')
    <div class="tabbable panel login-form width-400">
        <ul class="nav nav-tabs nav-justified">
            <li class="active">
                <a href="#basic-tab1" data-toggle="tab">
                    <h6>Sign in</h6>
                </a>
            </li>
            <li>
                <a href="#basic-tab2" data-toggle="tab">
                    <h6>Register</h6>
                </a>
            </li>
        </ul>

        <div class="tab-content panel-body">
            <div class="tab-pane fade in active" id="basic-tab1">
                <form action="{{ url('login') }}" method="POST">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">

                    <div class="text-center">
                        <div class="icon-object border-slate-300 text-slate-300">
                            <i class="icon-reading"></i>
                        </div>
                        <h5 class="content-group">
                            Login to your account <small class="display-block">Your credentials</small>
                        </h5>
                    </div>

                    <div class="form-group has-feedback has-feedback-left">
                        <input type="email" class="form-control" placeholder="Email" name="email" required="required" value="{{ old('email') }}">
                        <div class="form-control-feedback">
                            <i class="icon-mention text-muted"></i>
                        </div>
                    </div>

                    <div class="form-group has-feedback has-feedback-left">
                        <input type="password" class="form-control" placeholder="Password" name="password" required="required">
                        <div class="form-control-feedback">
                            <i class="icon-lock2 text-muted"></i>
                        </div>
                    </div>

                    <div class="form-group login-options">
                        <div class="row">
                            <div class="col-sm-6">
                                <label class="checkbox-inline">
                                    <input type="checkbox" class="styled" checked="checked" name="checkbox">
                                    Remember
                                </label>
                            </div>

                            <div class="col-sm-6 text-right">
                                <a href="{{ url('/password/reset') }}">Forgot password?</a>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <button type="submit" class="btn bg-blue btn-block">
                            Login <i class="icon-arrow-right14 position-right"></i>
                        </button>
                    </div>
                </form>
            </div>

            <div class="tab-pane fade" id="basic-tab2">
                <form action="{{ url('register') }}" method="POST">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <div class="text-center">
                        <div class="icon-object border-success text-success">
                            <i class="icon-plus3"></i>
                        </div>
                        <h5 class="content-group">
                            Create new account <small class="display-block">All fields are required</small>
                        </h5>
                    </div>

                    <div class="form-group has-feedback has-feedback-left">
                        <input type="email" class="form-control" placeholder="Your email" name="email">
                        <div class="form-control-feedback">
                            <i class="icon-mention text-muted"></i>
                        </div>

                        @if (isset($errors) && $errors->register->first('email') != null)
                            <span class="help-block text-danger">
                                <i class="icon-cancel-circle2 position-left"></i>{{ $errors->register->first('email') }}
                            </span>
                        @endif
                    </div>

                    <div class="form-group has-feedback has-feedback-left">
                        <input type="password" class="form-control" placeholder="Create password" name="password">
                        <div class="form-control-feedback">
                            <i class="icon-user-lock text-muted"></i>
                        </div>

                        @if(isset($errors) && $errors->register->first('password') != null)
                            <span class="help-block text-danger">
                                <i class="icon-cancel-circle2 position-left"></i>{{ $errors->register->first('password') }}
                            </span>
                        @endif
                    </div>

                    <div class="form-group has-feedback has-feedback-left">
                        <input type="password" class="form-control" placeholder="Confirm password" name="password_confirmation">
                        <div class="form-control-feedback">
                            <i class="icon-user-check text-muted"></i>
                        </div>
                    </div>

                    <div class="content-divider text-muted form-group">
                        <span>Additions</span>
                    </div>

                    <div class="form-group">
                        <div class="checkbox">
                            <label>
                                <input type="checkbox" class="styled" name="checkbox">
                                Accept <a href="javascript:void(0);">terms of service</a>
                            </label>
                        </div>

                        <div class="checkbox">
                            <label>
                                <input type="checkbox" class="styled" id="has-code">
                                My institution gave me a code (optional)
                            </label>
                        </div>
                    </div>

                    <div class="form-group has-feedback has-feedback-left" style="display: none;" id="institution-code">
                        <input type="text" class="form-control" placeholder="Code given by institution" name="institution_code">
                        <div class="form-control-feedback">
                            <i class="icon-code text-muted"></i>
                        </div>
                    </div>

                    <button type="submit" class="btn bg-indigo-400 btn-block">
                        Register <i class="icon-circle-right2 position-right"></i>
                    </button>
                </form>
            </div>
        </div>
    </div>
@stop

@section('scripts')
    <script>
        //jQuery Element Events
        $(document).ready(function() {
            $('#has-code').prop('checked', false);

            $('.styled').uniform();

            $('#has-code').on('click', function() {
                var hasCode = $(this).prop('checked');

                if (hasCode) {
                    $('#institution-code').fadeIn();
                } else {
                    $('#institution-code').fadeOut();
                }
            });

            $('.validation-error-label').on('click', function() {
                $(this).fadeOut(300, function() {
                    $(this).remove();
                });
            });


            @if (session('response') != null)
                var response = {!! json_encode(session('response')) !!};

                console.log(response);
                if (response.error === 1) {
                    handleNotification(response.message, 'error');
                } else {
                    handleNotification(response.message, 'success');
                }

                handleFieldErrors(response.fields);
            @endif

            @if (session('changeSection') != null)
                switchForms('{{ session('changeSection') }}');
            @endif
        });

        function switchForms(switchTo) {
            if (switchTo == 'sign-in') {
                $('a[href="#basic-tab1"]').click()
            } else {
                $('a[href="#basic-tab2"]').click()
            }
        }

        function handleFieldErrors(errors) {
            for (var fieldName in errors) {
                var errorMessage = errors[fieldName],
                    element;

                if (fieldName == 'checkbox') {
                    element = $('input[name="' + fieldName + '"]')
                        .parent()
                        .parent()
                        .parent()
                        .parent();
                } else {
                    element = $('input[name="' + fieldName + '"]').parent();
                }

                element.append(
                    '<label class="validation-error-label" style="cursor: pointer;" for="' + fieldName + '">' +
                        errorMessage +
                    '</label>'
                );

                if (fieldName == 'institution_code') {
                    $('#has-code').click();
                }
            }
        }
    </script>
@stop