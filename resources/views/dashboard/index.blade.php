@extends('template.dashboard')

@section('title', 'Dashboard')
@section('main')
	<!-- Main content -->
	<div class="content-wrapper">

		<!-- Page header -->
		<div class="page-header">
			<div class="breadcrumb-line">
				<ul class="breadcrumb">
					<li><a href="index.html"><i class="icon-home2 position-left"></i> Home</a></li>
					<li class="active">Dashboard</li>
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
				<div class="col-md-8">
					<div class="panel panel-white">
						<div class="panel-heading">
							<h6 class="panel-title"><span class="text-semibold">Seating Planner</span> <span class="text-muted"><small>Year 11<small></span></h6>
							<div class="heading-elements">
								<ul class="pagination pagination-flat pagination-sm">
									<li><a href="#">←</a></li>
									<li class="active"><a href="#">1</a></li>
									<li><a href="#">2</a></li>
									<li><a href="#">3</a></li>
									<li><a href="#">→</a></li>
								</ul>
								<ul class="icons-list" style="margin-top: 11px;">
									<li>
										<a data-action="reload"></a>
									</li>
								</ul>
							</div>
							<a class="heading-elements-toggle"><i class="icon-menu"></i></a></div>

							<style>
								.no-antialias { 
								    image-rendering: optimizeSpeed;
								    image-rendering: -moz-crisp-edges;
								    image-rendering: -o-crisp-edges;
								    image-rendering: -webkit-optimize-contrast;
								    image-rendering: pixelated;
								    image-rendering: optimize-contrast;
								    -ms-interpolation-mode: nearest-neighbor;

								}
								.drag-item, .outside-drag-item {
								    position: absolute;
								    background-image: url('assets/images/objects/desk-1.png');
								    background-size: 32px;
								    width:32px;height:32px;
								    cursor:move;
								}
								.drop-target {
									left: 0px; top: 0px;
								    position: absolute;
								    width: 960px; height: 960px;
								    border:dashed 1px orange;
								    background:whitesmoke url('assets/images/objects/grid_64.png') repeat;
								    background-size: 32px 32px;
								    
								}
							</style>
						<div class="panel-body" style="height:960px; overflow-x: scroll;">
							<div class="drop-target">
							    <div class="drag-item"></div>
							    <div class="drag-item"></div>
							    <div class="drag-item"></div>
							    <div class="drag-item"></div>
							    <div class="drag-item"></div>
							</div>
						</div>
					</div>
				</div>
				<div class="col-md-4">
					<div class="tabbable">
						<ul class="nav nav-pills nav-stacked">
							<li class="active"><a data-toggle="tab" href="#stacked-labels-pill1"><i class="icon-book position-left"></i> Year 11</a></li>
							<li style="background-color:#FFF; border:solid #DDD; border-radius: 3px; border-width: 1px; border- box-shadow: 0 1px 1px rgba(0, 0, 0, 0.05);"><a data-toggle="tab" href="#stacked-labels-pill2"><i class="icon-book2 position-left"></i> <span class="label label-info pull-right">New</span> Year 12</a></li>
							<li style="background-color:#FFF; border:solid #DDD; border-radius: 3px; border-width: 1px; border- box-shadow: 0 1px 1px rgba(0, 0, 0, 0.05);"><a data-toggle="tab" href="#stacked-labels-pill2"><i class="icon-book3 position-left"></i>Year 7</a></li>
						</ul>
					</div>
					<div class="panel panel-white">
						<div class="panel-heading">
							<h6 class="panel-title">
								Selected Object
								<span class="text-muted">
									<small>Student Desk</small>
								</span>
							</h6>
							<div class="heading-elements">
								<ul class="icons-list">
			                		<li><a title="" data-popup="tooltip" data-action="move" href="#" data-original-title="Move" class="ui-sortable-handle"></a></li>
			                		<li><a title="" data-popup="tooltip" data-action="collapse" data-original-title="Collapse" class=""></a></li>
			                	</ul>
			                	<form class="heading-form" action="#" hidden>
									<div class="form-group">
										<label class="checkbox-inline checkbox-switchery checkbox-right switchery-xs">
											<input type="checkbox" class="switchery" checked="checked">
											Enable editable:
										</label>
									</div>
								</form>
		                	</div>
							<a class="heading-elements-toggle"><i class="icon-menu"></i></a>
						</div>
						
						<div class="panel-body">
							<div class="col-lg-3 col-sm-6">
								<div class="thumbnail" style="margin-top: 5px;">
									<div class="thumb">
										<img src="assets/images/objects/desk-1.png" alt="" class="no-antialias">
									</div>
								</div>
							</div>
							<div class="col-lg-9 col-sm-6">
								<h5 class="no-margin">
									Student Desk
									<small>Settings</small>
								</h4>
								{{-- <a href="#" id="type-range" data-type="range" data-inputclass="form-control" data-pk="1" data-title="Range">Size</a> --}}
								<table class="table table-bordered table-striped">
									<thead>
										<tr>
											<th>Setting</th>
											<th>Value</th>
										</tr>
									</thead>
									<tbody>
										<tr>
											<td>Size</td>
											<td>
												<input class="form-control" type="range" max="4" min="0" name="range">
											</td>
										</tr>
										<tr>
											<td>Rotation</td>
											<td>
												<button class="btn btn-default btn-sm" type="button" style="padding: 3px 6px;">
													<i class="icon-reply position-left"></i>
													Left 90˚
												</button>
												<button class="btn btn-default btn-sm" type="button" style="padding: 3px 6px; margin-top: 10px;">
													<i class="icon-forward position-left"></i>
													Right 90˚
												</button>
											</td>
										</tr>
										<tr>
											<td>Location</td>
											<td>
												<strong>X:</strong> 1<br />
												<strong>Y:</strong> 6
											</td>
										</tr>
										<tr>
											<td>Action</td>
											<td>
												<button class="btn btn-danger btn-sm" type="button" style="padding: 3px 6px;">
													Delete
													<i class="icon-diff-removed position-right"></i>
												</button>
											</td>
										</tr>
									</tbody>
								</table>
							</div>
						</div>
					</div>
					<!-- /editable inputs -->
					<div class="panel panel-white">
						<div class="panel-heading">
							<h6 class="panel-title">Objects</h6>
							<div class="heading-elements">
								<form action="#" class="heading-form">
									<div class="form-group has-feedback">
										<input type="search" placeholder="Search..." class="form-control">
										<div class="form-control-feedback">
											<i class="icon-search4 text-size-base text-muted"></i>
										</div>
									</div>
								</form>
							</div>
						<a class="heading-elements-toggle"><i class="icon-menu"></i></a></div>
						
						<div class="panel-body">
							<!-- object -->
							<div class="col-lg-4 col-sm-6">
								<div class="thumbnail">
									<div class="thumb">
										<img class="no-antialias" alt="" src="assets/images/objects/desk-1.png">
										<div class="caption-overflow">
											<span>
												<a class="btn border-white text-white btn-flat btn-icon btn-rounded" data-popup="lightbox" href="assets/images/demo/flat/1.png"><i class="icon-plus3"></i></a>
											</span>
										</div>
									</div>

									<div class="caption" style="padding-top: 5px; padding-bottom: 5px; padding-left: 5px;">
										<h6 class="no-margin"><a href="#" class="text-default" style="font-size: 10px;">Student Desk</a></h6>
									</div>
								</div>
							</div>
							<!-- /object -->
							<!-- object -->
							<div class="col-lg-4 col-sm-6">
								<div class="thumbnail">
									<div class="thumb">
										<img class="no-antialias" alt="" src="assets/images/objects/sofa-1.png">
										<div class="caption-overflow">
											<span>
												<a class="btn border-white text-white btn-flat btn-icon btn-rounded" data-popup="lightbox" href="assets/images/demo/flat/1.png"><i class="icon-plus3"></i></a>
											</span>
										</div>
									</div>

									<div class="caption" style="padding-top: 5px; padding-bottom: 5px; padding-left: 5px;">
										<h6 class="no-margin"><a href="#" class="text-default" style="font-size: 10px;">Sofa</a></h6>
									</div>
								</div>
							</div>
							<!-- /object -->
							<!-- object -->
							<div class="col-lg-4 col-sm-6">
								<div class="thumbnail">
									<div class="thumb">
										<img class="no-antialias" alt="" src="assets/images/objects/chair-1.png">
										<div class="caption-overflow">
											<span>
												<a class="btn border-white text-white btn-flat btn-icon btn-rounded" data-popup="lightbox" href="assets/images/demo/flat/1.png"><i class="icon-plus3"></i></a>
											</span>
										</div>
									</div>

									<div class="caption" style="padding-top: 5px; padding-bottom: 5px; padding-left: 5px;">
										<h6 class="no-margin"><a href="#" class="text-default" style="font-size: 10px;">Chair</a></h6>
									</div>
								</div>
							</div>
							<!-- /object -->
							<!-- object -->
							<div class="col-lg-4 col-sm-6">
								<div class="thumbnail">
									<div class="thumb">
										<img class="no-antialias" alt="" src="assets/images/objects/teacher-desk-1.png">
										<div class="caption-overflow">
											<span>
												<a class="btn border-white text-white btn-flat btn-icon btn-rounded" data-popup="lightbox" href="assets/images/demo/flat/1.png"><i class="icon-plus3"></i></a>
											</span>
										</div>
									</div>

									<div class="caption" style="padding-top: 5px; padding-bottom: 5px; padding-left: 5px;">
										<h6 class="no-margin"><a href="#" class="text-default" style="font-size: 10px;">Teacher Desk</a></h6>
									</div>
								</div>
							</div>
							<!-- /object -->
						</div>
					</div>
					<div class="panel panel-white">
						<div class="panel-heading">
							<h6 class="panel-title">Students</h6>
							<div class="heading-elements">
								<form action="#" class="heading-form">
									<div class="form-group has-feedback">
										<input type="search" placeholder="Search..." class="form-control">
										<div class="form-control-feedback">
											<i class="icon-search4 text-size-base text-muted"></i>
										</div>
									</div>
								</form>
							</div>
						<a class="heading-elements-toggle"><i class="icon-menu"></i></a></div>
						
						<div class="panel-body">
							<!-- student -->
							<div class="col-lg-4 col-sm-6">
								<div class="thumbnail">
									<div class="thumb">
										<img alt="" src="http://placehold.it/200x200">
										<div class="caption-overflow">
											<span>
												<a class="btn border-white text-white btn-flat btn-icon btn-rounded" data-popup="lightbox" href="assets/images/demo/flat/1.png"><i class="icon-plus3"></i></a>
											</span>
										</div>
									</div>

									<div class="caption" style="padding-top: 5px; padding-bottom: 5px; padding-left: 5px;">
										<h6 class="no-margin"><a href="#" class="text-default" style="font-size: 10px;">Toby Mellor</a></h6>
									</div>
								</div>
							</div>
							<!-- /student -->
							<!-- student -->
							<div class="col-lg-4 col-sm-6">
								<div class="thumbnail">
									<div class="thumb">
										<img alt="" src="http://placehold.it/200x200">
										<div class="caption-overflow">
											<span>
												<a class="btn border-white text-white btn-flat btn-icon btn-rounded" data-popup="lightbox" href="assets/images/demo/flat/1.png"><i class="icon-plus3"></i></a>
											</span>
										</div>
									</div>

									<div class="caption" style="padding-top: 5px; padding-bottom: 5px; padding-left: 5px;">
										<h6 class="no-margin"><a href="#" class="text-default" style="font-size: 10px;">Test Student</a></h6>
									</div>
								</div>
							</div>
							<!-- /student -->
							<!-- student -->
							<div class="col-lg-4 col-sm-6">
								<div class="thumbnail">
									<div class="thumb">
										<img alt="" src="http://placehold.it/200x200">
										<div class="caption-overflow">
											<span>
												<a class="btn border-white text-white btn-flat btn-icon btn-rounded" data-popup="lightbox" href="assets/images/demo/flat/1.png"><i class="icon-plus3"></i></a>
											</span>
										</div>
									</div>

									<div class="caption" style="padding-top: 5px; padding-bottom: 5px; padding-left: 5px;">
										<h6 class="no-margin"><a href="#" class="text-default" style="font-size: 10px;">Thomas Ev...</a></h6>
									</div>
								</div>
							</div>
							<!-- /student -->
							<!-- student -->
							<div class="col-lg-4 col-sm-6">
								<div class="thumbnail">
									<div class="thumb">
										<img alt="" src="http://placehold.it/200x200">
										<div class="caption-overflow">
											<span>
												<a class="btn border-white text-white btn-flat btn-icon btn-rounded" data-popup="lightbox" href="assets/images/demo/flat/1.png"><i class="icon-plus3"></i></a>
											</span>
										</div>
									</div>

									<div class="caption" style="padding-top: 5px; padding-bottom: 5px; padding-left: 5px;">
										<h6 class="no-margin"><a href="#" class="text-default" style="font-size: 10px;">Toby Mellor</a></h6>
									</div>
								</div>
							</div>
							<!-- /student -->
							<!-- student -->
							<div class="col-lg-4 col-sm-6">
								<div class="thumbnail">
									<div class="thumb">
										<img alt="" src="http://placehold.it/200x200">
										<div class="caption-overflow">
											<span>
												<a class="btn border-white text-white btn-flat btn-icon btn-rounded" data-popup="lightbox" href="assets/images/demo/flat/1.png"><i class="icon-plus3"></i></a>
											</span>
										</div>
									</div>

									<div class="caption" style="padding-top: 5px; padding-bottom: 5px; padding-left: 5px;">
										<h6 class="no-margin"><a href="#" class="text-default" style="font-size: 10px;">Test Student</a></h6>
									</div>
								</div>
							</div>
							<!-- /student -->
							<!-- student -->
							<div class="col-lg-4 col-sm-6">
								<div class="thumbnail">
									<div class="thumb">
										<img alt="" src="http://placehold.it/200x200">
										<div class="caption-overflow">
											<span>
												<a class="btn border-white text-white btn-flat btn-icon btn-rounded" data-popup="lightbox" href="assets/images/demo/flat/1.png"><i class="icon-plus3"></i></a>
											</span>
										</div>
									</div>

									<div class="caption" style="padding-top: 5px; padding-bottom: 5px; padding-left: 5px;">
										<h6 class="no-margin"><a href="#" class="text-default" style="font-size: 10px;">Thomas Ev...</a></h6>
									</div>
								</div>
							</div>
							<!-- /student -->
							<!-- student -->
							<div class="col-lg-4 col-sm-6">
								<div class="thumbnail">
									<div class="thumb">
										<img alt="" src="http://placehold.it/200x200">
										<div class="caption-overflow">
											<span>
												<a class="btn border-white text-white btn-flat btn-icon btn-rounded" data-popup="lightbox" href="assets/images/demo/flat/1.png"><i class="icon-plus3"></i></a>
											</span>
										</div>
									</div>

									<div class="caption" style="padding-top: 5px; padding-bottom: 5px; padding-left: 5px;">
										<h6 class="no-margin"><a href="#" class="text-default" style="font-size: 10px;">Toby Mellor</a></h6>
									</div>
								</div>
							</div>
							<!-- /student -->
							<!-- student -->
							<div class="col-lg-4 col-sm-6">
								<div class="thumbnail">
									<div class="thumb">
										<img alt="" src="http://placehold.it/200x200">
										<div class="caption-overflow">
											<span>
												<a class="btn border-white text-white btn-flat btn-icon btn-rounded" data-popup="lightbox" href="assets/images/demo/flat/1.png"><i class="icon-plus3"></i></a>
											</span>
										</div>
									</div>

									<div class="caption" style="padding-top: 5px; padding-bottom: 5px; padding-left: 5px;">
										<h6 class="no-margin"><a href="#" class="text-default" style="font-size: 10px;">Test Student</a></h6>
									</div>
								</div>
							</div>
							<!-- /student -->
							<!-- student -->
							<div class="col-lg-4 col-sm-6">
								<div class="thumbnail">
									<div class="thumb">
										<img alt="" src="http://placehold.it/200x200">
										<div class="caption-overflow">
											<span>
												<a class="btn border-white text-white btn-flat btn-icon btn-rounded" data-popup="lightbox" href="assets/images/demo/flat/1.png"><i class="icon-plus3"></i></a>
											</span>
										</div>
									</div>

									<div class="caption" style="padding-top: 5px; padding-bottom: 5px; padding-left: 5px;">
										<h6 class="no-margin"><a href="#" class="text-default" style="font-size: 10px;">Thomas Ev...</a></h6>
									</div>
								</div>
							</div>
							<!-- /student -->
						</div>
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