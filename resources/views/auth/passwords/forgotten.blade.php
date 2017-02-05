@extends('template.auth')

@section('title', 'Request Password Reset')
@section('main')
    <form action="{{ url('/password/link') }}" method="POST">
        {{ csrf_field() }}
        <div class="panel panel-body login-form">
            <div class="text-center">
                <div class="icon-object border-slate-300 text-slate-300"><i class="icon-reading"></i></div>
                <h5 class="content-group">Reset Password <small class="display-block">Enter your email below</small></h5>
            </div>

            <div class="form-group has-feedback has-feedback-left">
                <input type="text" name="email" class="form-control" placeholder="Email" value="{{ old('email') }}">
                <div class="form-control-feedback">
                    <i class="icon-user text-muted"></i>
                </div>
            </div>
            <div class="form-group">
                <button type="submit" class="btn bg-blue btn-block">Request Password Reset <i class="icon-arrow-right14 position-right"></i></button>
            </div>

            <div class="content-divider text-muted form-group"><span>Just remembered your password?</span></div>
            <a id="button-switch-to-sign-up" href="{{ url('login') }}" class="btn btn-default btn-block content-group">Sign in</a>
        </div>
    </form>
@stop