@extends('template.auth')

@section('title', 'Request Password Reset')
@section('main')
    <form action="{{ url('/password/email') }}" method="POST">
        <div class="panel panel-body login-form">
            <div class="text-center">
                <div class="icon-object border-slate-300 text-slate-300"><i class="icon-reading"></i></div>
                <h5 class="content-group">Reset Password <small class="display-block">Enter your email below</small></h5>
            </div>

            <input type="hidden" name="_token" value="{{ csrf_token() }}">

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
            <a id="button-switch-to-sign-up" href="javascript:void(0);" class="btn btn-default btn-block content-group">Sign in</a>
        </div>
    </form>
@stop

@section('scripts')
    <script>
        @if($errors->all() != null)
            var errorMessage = 'There was problems with the data entererd.';
            @foreach ($errors->all('<li>:message</li>') as $error)
                errorMessage += '{!! addslashes(html_entity_decode($error)) !!}';
            @endforeach

            handleNotification(errorMessage, 'error');
        @endif

        @if (session('status') != null)
            var successMessage = '{!! addslashes(html_entity_decode(session('status'))) !!}';
            handleNotification(successMessage, 'success');
        @endif
    </script>
@endsection