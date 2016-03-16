<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>SeatingPlanner</title>

	<!-- Global stylesheets -->
	<link href="https://fonts.googleapis.com/css?family=Roboto:400,300,100,500,700,900" rel="stylesheet" type="text/css">
	<link href="assets/css/icons/icomoon/styles.css" rel="stylesheet" type="text/css">
	<link href="assets/css/bootstrap.min.css" rel="stylesheet" type="text/css">
	<link href="assets/css/core.min.css" rel="stylesheet" type="text/css">
	<link href="assets/css/components.min.css" rel="stylesheet" type="text/css">
	<link href="assets/css/colors.min.css" rel="stylesheet" type="text/css">
	<!-- /global stylesheets -->

	<!-- Core JS files -->
	<script type="text/javascript" src="assets/js/plugins/loaders/pace.min.js"></script>
	<script type="text/javascript" src="assets/js/core/libraries/jquery.min.js"></script>
	<script type="text/javascript" src="assets/js/core/libraries/bootstrap.min.js"></script>
	<script type="text/javascript" src="assets/js/plugins/loaders/blockui.min.js"></script>
	<!-- /core JS files -->

	<!-- Theme JS files -->
	<script type="text/javascript" src="assets/js/plugins/forms/styling/uniform.min.js"></script>

	<script type="text/javascript" src="assets/js/core/app.js"></script>
	<script type="text/javascript" src="assets/js/pages/login.js"></script>
	<!-- /theme JS files -->

	<script src="assets/js/plugins/notifications/noty.min.js" type="text/javascript"></script>

</head>

<body>

	<!-- Main navbar -->
	<div class="navbar navbar-inverse">
		<div class="navbar-header">
			<a class="navbar-brand" href="index.html"><img src="assets/images/logo_light.png" alt=""></a>

			<ul class="nav navbar-nav pull-right visible-xs-block">
				<li><a data-toggle="collapse" data-target="#navbar-mobile"><i class="icon-tree5"></i></a></li>
			</ul>
		</div>
	</div>
	<!-- /main navbar -->


	<!-- Page container -->
	<div class="page-container login-container">

		<!-- Page content -->
		<div class="page-content">

			<!-- Main content -->
			<div class="content-wrapper">

				<!-- Content area -->
				<div class="content">

					<!-- login -->
					<form id="sign-in" action="login" method="POST">
						<div class="panel panel-body login-form">
							<div class="text-center">
								<div class="icon-object border-slate-300 text-slate-300"><i class="icon-reading"></i></div>
								<h5 class="content-group">Login to your account <small class="display-block">Your credentials</small></h5>
							</div>

							<input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">

							<div class="form-group has-feedback has-feedback-left">
								<input type="text" name="email" class="form-control" placeholder="Email" @if(session('predefinedData')['email'] != null) value="{{ session('predefinedData')['email'] }}" @endif>
								<div class="form-control-feedback">
									<i class="icon-user text-muted"></i>
								</div>
							</div>

							<div class="form-group has-feedback has-feedback-left">
								<input type="password" name="password" class="form-control" placeholder="Password">
								<div class="form-control-feedback">
									<i class="icon-lock2 text-muted"></i>
								</div>
							</div>

							<div class="form-group login-options">
								<div class="row">
									<div class="col-sm-6">
										<label class="checkbox-inline">
											<input type="checkbox" name="checkbox" class="styled">
											Remember
										</label>
									</div>

									<div class="col-sm-6 text-right">
										<a href="login_password_recover.html">Forgot password?</a>
									</div>
								</div>
							</div>

							<div class="form-group">
								<button type="submit" class="btn bg-blue btn-block">Login <i class="icon-arrow-right14 position-right"></i></button>
							</div>

							<div class="content-divider text-muted form-group"><span>Don't have an account?</span></div>
							<a id="button-switch-to-sign-up" href="javascript:;" class="btn btn-default btn-block content-group">Sign up</a>
						</div>
					</form>
					<!-- /login -->

					<!-- registration -->
					<form id="sign-up" action="register" method="POST" style="display:none;">
						<div class="panel panel-body login-form">
							<div class="text-center">
								<div class="icon-object border-success text-success"><i class="icon-plus3"></i></div>
								<h5 class="content-group">Create account <small class="display-block">All fields are required</small></h5>
							</div>

							<input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">

							<div class="content-divider text-muted form-group"><span>Your credentials</span></div>

							<div class="form-group has-feedback has-feedback-left">
								<input type="text" name="email" class="form-control" placeholder="Email" @if(session('predefinedData')['email'] != null) value="{{ session('predefinedData')['email'] }}" @endif>
								<div class="form-control-feedback">
									<i class="icon-mention text-muted"></i>
								</div>
								@if($errors->register->first('email') != null)
									<span class="help-block text-danger"><i class="icon-cancel-circle2 position-left"></i>{{ $errors->register->first('email') }}</span>
								@endif
							</div>

							<div class="content-divider text-muted form-group"><span>Your privacy</span></div>

							<div class="form-group has-feedback has-feedback-left">
								<input type="password" name="password" class="form-control" placeholder="Create password">
								<div class="form-control-feedback">
									<i class="icon-user-lock text-muted"></i>
								</div>
								@if($errors->register->first('password') != null)
									<span class="help-block text-danger"><i class="icon-cancel-circle2 position-left"></i>{{ $errors->register->first('password') }}</span>
								@endif
							</div>

							<div class="form-group has-feedback has-feedback-left">
								<input type="password" name="confirm_password" class="form-control" placeholder="Confirm Password">
								<div class="form-control-feedback">
									<i class="icon-user-check text-muted"></i>
								</div>
							</div>

							<div class="content-divider text-muted form-group"><span>Additions</span></div>

							<div class="form-group">
								<div class="checkbox">
									<label>
										<input type="checkbox" name="checkbox" class="styled">
										Accept <a href="#">terms of service</a>
									</label>
								</div>
								@if($errors->register->first('checkbox') != null)
									<span class="help-block text-danger"><i class="icon-cancel-circle2 position-left"></i>{{ $errors->register->first('checkbox') }}</span>
								@endif
							</div>

							<div class="form-group">
								<button type="submit" class="btn bg-teal btn-block btn-lg">Register <i class="icon-circle-right2 position-right"></i></button>
							</div>

							<div class="content-divider text-muted form-group">
								<span>Already have an account?</span>
							</div>
							<a id="button-switch-to-sign-in" class="btn btn-default btn-block content-group" href="javascript:;">Sign in</a>
						</div>
					</form>
					<!-- /registration -->


					<!-- Footer -->
					<div class="footer text-muted">
						&copy; 2015. SeatingPlanner by Toby Mellor
					</div>
					<!-- /footer -->

				</div>
				<!-- /content area -->

			</div>
			<!-- /main content -->

		</div>
		<!-- /page content -->

	</div>
	<!-- /page container -->
	<script>
	    //jQuery Element Events
	    $(document).ready(function() {
	      $('#button-switch-to-sign-in').click(function() {
	        switchForms('sign-in');
	      });
	      $('#button-switch-to-sign-up').click(function() {
	        switchForms('sign-up');
	      });
	    });
	  
	    //Javascript Functions
	    var token = '<?php echo csrf_token(); ?>';

	    @if (session('errorMessage') != null)
	    	handleNotification('{{ session('errorMessage') }}', 'error');
	    @endif
		@if (session('successMessage') != null)
	    	handleNotification('{{ session('successMessage') }}', 'success');
	    @endif
	    @if (session('changeSection') != null)
	    	switchForms('{{ session('changeSection') }}')
	    @endif

	    function switchForms(switchTo)
	    {
	      if(switchTo == 'sign-in') {
	        $('#sign-up').hide();
	        $('#sign-in').show();
	      } else {
	        $('#sign-in').hide();
	        $('#sign-up').show();
	      }
	    }

	    function handleNotification(notificationContent, type)
	    {
		    var n = noty({
			    text: notificationContent,
			    layout: 'topCenter',
			    type: type
			});

			setTimeout(function() {
				n.close();
			}, 5000);
	    }
  	</script>
</body>
</html>
