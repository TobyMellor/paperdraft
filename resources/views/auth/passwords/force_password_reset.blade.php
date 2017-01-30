@extends('template.auth')

@section('title', 'Set New Password')
@section('main')
    <form action="{{ url('/force_password_reset') }}" method="POST">
        <input name="_token" value="{{ csrf_token() }}" hidden />

        <div class="panel panel-body login-form">
            <div class="text-center">
                <div class="icon-object border-slate-300 text-slate-300"><i class="icon-reading"></i></div>
                <h5 class="content-group">Set a new password! <small class="display-block">Set your new password below</small></h5>
            </div>

            <div class="form-group has-feedback has-feedback-left">
                <input type="password" name="password" class="form-control" placeholder="New Password">
                <div class="form-control-feedback">
                    <i class="icon-user-lock text-muted"></i>
                </div>
            </div>

            <div class="form-group has-feedback has-feedback-left">
                <input type="password" name="password_confirmation" class="form-control" placeholder="Confirm New Password">
                <div class="form-control-feedback">
                    <i class="icon-user-check text-muted"></i>
                </div>
            </div>

            <div class="form-group">
                <button type="submit" class="btn bg-blue btn-block">Set New Password <i class="icon-arrow-right14 position-right"></i></button>
            </div>
        </div>
    </form>
@stop

@section('scripts')
    <script>
        //jQuery Element Events
        $(document).ready(function() {
            $('.validation-error-label').on('click', function() {
                $(this).fadeOut(300, function() {
                    $(this).remove();
                });
            });

            @if (session('response') != null)
                var response = {!! json_encode(session('response')) !!};

                if (response.error === 1) {
                    handleNotification(response.message, 'error');
                } else {
                    handleNotification(response.message, 'success');
                }

                handleFieldErrors(response.fields);
            @endif
        });

        function handleFieldErrors(errors) {
            for (var fieldName in errors) {
                var errorMessage = errors[fieldName];

                var element = $('input[name="' + fieldName + '"]').parent();

                element.append(
                    '<label class="validation-error-label" style="cursor: pointer;" for="' + fieldName + '">' +
                        errorMessage +
                    '</label>'
                );
            }
        }
    </script>
@stop