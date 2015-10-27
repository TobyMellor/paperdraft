@extends('template.dashboard')

@section('title', 'Classes')
@section('main')
	<!-- Main content -->
	<div class="content-wrapper">

		<!-- Page header -->
		<div class="page-header">
			<div class="breadcrumb-line">
				<ul class="breadcrumb">
					<li><a href="index.html"><i class="icon-home2 position-left"></i> Home</a></li>
					<li>Dashboard</li>
					<li class="active">Classes</li>
				</ul>

				<ul class="breadcrumb-elements">
					<li class="dropdown">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown">
							<i class="icon-gear position-left"></i>
							Settings
							<span class="caret"></span>
						</a>

						<ul class="dropdown-menu dropdown-menu-right">
							<li><a href="#"><i class="icon-user-lock"></i> Account security</a></li>
							<li><a href="#"><i class="icon-statistics"></i> Analytics</a></li>
							<li><a href="#"><i class="icon-accessibility"></i> Accessibility</a></li>
							<li class="divider"></li>
							<li><a href="#"><i class="icon-gear"></i> All settings</a></li>
						</ul>
					</li>
				</ul>
			</div>
		</div>
		<!-- /page header -->
		<!-- Content area -->
		<div class="content">
			<div class="row row-sortable">
				<div class="col-md-5">
					<div class="panel panel-white">
						<div class="panel-heading">
							<h6 class="panel-title">
								<span class="text-semibold">Class</span>
								<span class="text-muted">
									<small>Year 11<small>
								</span>
							</h6>
							<div class="heading-elements">
								<ul class="icons-list">
			                		<li><a title="" data-popup="tooltip" data-action="collapse" data-original-title="Collapse"></a></li>
			                		<li><a title="" data-popup="tooltip" data-action="move" href="#" data-original-title="Move panel" class="ui-sortable-handle" aria-describedby="tooltip413294"></a></li>
			                		<li><a title="" data-popup="tooltip" data-action="close" data-original-title="Close"></a></li>
			                	</ul>
		                	</div>
						<a class="heading-elements-toggle"><i class="icon-menu"></i></a></div>
						
						<div class="panel-body">
							Default panel controls - <code>collapse</code>, <code>update</code> and <code>close</code> buttons
						</div>
					</div>
				</div>
				<div class="col-md-4">
					<div class="panel panel-white">
						<div class="panel-heading">
							<h6 class="panel-title">
								<span class="text-semibold">Students in</span>
								<span class="text-muted">
									<small>Year 11<small>
								</span>
							</h6>
							<div class="heading-elements">
								<ul class="icons-list">
			                		<li><a title="" data-popup="tooltip" data-action="collapse" data-original-title="Collapse"></a></li>
			                		<li><a title="" data-popup="tooltip" data-action="move" href="#" data-original-title="Move panel" class="ui-sortable-handle" aria-describedby="tooltip413294"></a></li>
			                		<li><a title="" data-popup="tooltip" data-action="close" data-original-title="Close"></a></li>
			                	</ul>
		                	</div>
						<a class="heading-elements-toggle"><i class="icon-menu"></i></a></div>
						
						<div class="panel-body">
							Default panel controls - <code>collapse</code>, <code>update</code> and <code>close</code> buttons
						</div>
					</div>
				</div>
				<div class="col-md-3">
					<div class="tabbable">
						<ul class="nav nav-pills nav-stacked">
							<li class="active"><a data-toggle="tab" href="#stacked-labels-pill1"><i class="icon-book position-left"></i> Year 11</a></li>
							<li style="background-color:#FFF; border:solid #DDD; border-radius: 3px; border-width: 1px; border- box-shadow: 0 1px 1px rgba(0, 0, 0, 0.05);"><a data-toggle="tab" href="#stacked-labels-pill2"><i class="icon-book2 position-left"></i> <span class="label label-info pull-right">New</span> Year 12</a></li>
							<li style="background-color:#FFF; border:solid #DDD; border-radius: 3px; border-width: 1px; border- box-shadow: 0 1px 1px rgba(0, 0, 0, 0.05);"><a data-toggle="tab" href="#stacked-labels-pill2"><i class="icon-book3 position-left"></i>Year 7</a></li>
						</ul>
					</div>
				</div>
			</div>
			<!-- /dashboard content -->


			<!-- Footer -->
			<div class="footer text-muted">
				&copy; 2015. SeatingPlanner by Toby Mellor
			</div>
			<!-- /footer -->
		</div>
		<!-- /content area -->
	</div>
	<!-- /main content -->

@stop
@section('scripts')

	<script>
	    $(".drag-item").draggable({
	        grid: [32, 32],
	        containment: '.drop-target',
	        drag: function(){
	            var position = $(this).position();
	            var xPos = position.left;
	            var yPos = position.top;
	            console.log('x: ' + xPos / 32 + ' | y: ' + yPos / 32);
	        }
	    });
	</script>

@stop