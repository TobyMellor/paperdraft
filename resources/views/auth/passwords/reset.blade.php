@extends('template.auth')

@section('title', 'Set New Password')
@section('main')
    <form action="{{ url('/password/reset') }}" method="POST">
        {{ csrf_field() }}
        <input name="token" value="{{ $token }}" hidden/>

        <div class="panel panel-body login-form">
            <div class="text-center">
                <div class="icon-object border-slate-300 text-slate-300"><i class="icon-reading"></i></div>
                <h5 class="content-group">Reset Password <small class="display-block">Set your new password below</small></h5>
            </div>

            <div class="form-group has-feedback has-feedback-left">
                <input type="text" name="email" class="form-control" placeholder="Email" value="{{ old('email') }}">
                <div class="form-control-feedback">
                    <i class="icon-user text-muted"></i>
                </div>
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

            <div class="content-divider text-muted form-group"><span>Just remembered your password?</span></div>
            <a id="button-switch-to-sign-up" href="{{ url('login') }}" class="btn btn-default btn-block content-group">Sign in</a>
        </div>
    </form>
@stop