<!DOCTYPE html>
<html>

<head>

	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<title>笺记 | DashBoard</title>

	<link href="/resources/admin/css/bootstrap.min.css" rel="stylesheet">
	<link href="/resources/admin/font-awesome/css/font-awesome.css" rel="stylesheet">

	<link href="/resources/admin/css/animate.css" rel="stylesheet">
	<link href="/resources/admin/css/style.css" rel="stylesheet">

</head>

<body>
<div id="wrapper">
	<nav class="navbar-default navbar-static-side" role="navigation">
		<div class="sidebar-collapse">
			<ul class="nav metismenu" id="side-menu">
				<li class="nav-header">
					<div class="dropdown profile-element"> <span>
                            <img alt="image" class="img-circle" src="/resources/admin/img/profile_small.jpg" />
                             </span>
						<a data-toggle="dropdown" class="dropdown-toggle" href="#">
                            <span class="clear"> <span class="block m-t-xs"> <strong class="font-bold"><?=$_SESSION['username'];?></strong>
                             </span> <span class="text-muted text-xs block">Art Director <b class="caret"></b></span> </span> </a>
						<ul class="dropdown-menu animated fadeInRight m-t-xs">
							<li><a href="profile.html">Profile</a></li>
							<li><a href="contacts.html">Contacts</a></li>
							<li><a href="mailbox.html">Mailbox</a></li>
							<li class="divider"></li>
							<li><a href="login.html">Logout</a></li>
						</ul>
					</div>
					<div class="logo-element">笺</div>
				</li>
				<li class="active">
					<a href="index.html"><i class="fa fa-th-large"></i> <span class="nav-label">Dashboards</span> <span class="fa arrow"></span></a>
					<ul class="nav nav-second-level">
						<li><a href="index.html">Dashboard v.1</a></li>
						<li class="active"><a href="dashboard_2.html">Dashboard v.2</a></li>
						<li><a href="dashboard_3.html">Dashboard v.3</a></li>
						<li><a href="dashboard_4_1.html">Dashboard v.4</a></li>
						<li><a href="dashboard_5.html">Dashboard v.5 </a></li>
					</ul>
				</li>
				<li>
					<a href="layouts.html"><i class="fa fa-diamond"></i> <span class="nav-label">Layouts</span></a>
				</li>
			</ul>

		</div>
	</nav>

	<div id="page-wrapper" class="gray-bg">
		<div class="row border-bottom">
			<nav class="navbar navbar-static-top white-bg" role="navigation" style="margin-bottom: 0">
				<div class="navbar-header">
					<a class="navbar-minimalize minimalize-styl-2 btn btn-primary " href="#"><i class="fa fa-bars"></i> </a>
				</div>
				<ul class="nav navbar-top-links navbar-right">
					<li>
						<span class="m-r-sm text-muted welcome-message">Welcome to INSPINIA+ Admin Theme.</span>
					</li>
					<li class="dropdown">
						<a class="dropdown-toggle count-info" data-toggle="dropdown" href="#">
							<i class="fa fa-envelope"></i>  <span class="label label-warning">16</span>
						</a>
						<ul class="dropdown-menu dropdown-messages">
							<li>
								<div class="dropdown-messages-box">
									<a href="profile.html" class="pull-left">
										<img alt="image" class="img-circle" src="/resources/admin/img/a7.jpg">
									</a>
									<div>
										<small class="pull-right">46h ago</small>
										<strong>Mike Loreipsum</strong> started following <strong>Monica Smith</strong>. <br>
										<small class="text-muted">3 days ago at 7:58 pm - 10.06.2014</small>
									</div>
								</div>
							</li>
							<li class="divider"></li>
							<li>
								<div class="dropdown-messages-box">
									<a href="profile.html" class="pull-left">
										<img alt="image" class="img-circle" src="/resources/admin/img/a4.jpg">
									</a>
									<div>
										<small class="pull-right text-navy">5h ago</small>
										<strong>Chris Johnatan Overtunk</strong> started following <strong>Monica Smith</strong>. <br>
										<small class="text-muted">Yesterday 1:21 pm - 11.06.2014</small>
									</div>
								</div>
							</li>
						</ul>
					</li>
					<li class="dropdown">
						<a class="dropdown-toggle count-info" data-toggle="dropdown" href="#">
							<i class="fa fa-bell"></i>  <span class="label label-primary">8</span>
						</a>
						<ul class="dropdown-menu dropdown-alerts">
							<li>
								<a href="mailbox.html">
									<div>
										<i class="fa fa-envelope fa-fw"></i> You have 16 messages
										<span class="pull-right text-muted small">4 minutes ago</span>
									</div>
								</a>
							</li>
							<li class="divider"></li>
							<li>
								<a href="profile.html">
									<div>
										<i class="fa fa-twitter fa-fw"></i> 3 New Followers
										<span class="pull-right text-muted small">12 minutes ago</span>
									</div>
								</a>
							</li>
							<li class="divider"></li>
							<li>
								<a href="grid_options.html">
									<div>
										<i class="fa fa-upload fa-fw"></i> Server Rebooted
										<span class="pull-right text-muted small">4 minutes ago</span>
									</div>
								</a>
							</li>
							<li class="divider"></li>
							<li>
								<div class="text-center link-block">
									<a href="notifications.html">
										<strong>See All Alerts</strong>
										<i class="fa fa-angle-right"></i>
									</a>
								</div>
							</li>
						</ul>
					</li>


					<li>
						<a href="login.html">
							<i class="fa fa-sign-out"></i> Log out
						</a>
					</li>
					<li>
						<a class="right-sidebar-toggle">
							<i class="fa fa-tasks"></i>
						</a>
					</li>
				</ul>

			</nav>
		</div>
		<div class="wrapper wrapper-content">
			<div class="row">
				<div class="col-lg-3">
					<div class="ibox float-e-margins">
						<div class="ibox-title">
							<span class="label label-success pull-right">Monthly</span>
							<h5>Income</h5>
						</div>
						<div class="ibox-content">
							<h1 class="no-margins">40 886,200</h1>
							<div class="stat-percent font-bold text-success">98% <i class="fa fa-bolt"></i></div>
							<small>Total income</small>
						</div>
					</div>
				</div>
				<div class="col-lg-3">
					<div class="ibox float-e-margins">
						<div class="ibox-title">
							<span class="label label-info pull-right">Annual</span>
							<h5>Orders</h5>
						</div>
						<div class="ibox-content">
							<h1 class="no-margins">275,800</h1>
							<div class="stat-percent font-bold text-info">20% <i class="fa fa-level-up"></i></div>
							<small>New orders</small>
						</div>
					</div>
				</div>
				<div class="col-lg-3">
					<div class="ibox float-e-margins">
						<div class="ibox-title">
							<span class="label label-primary pull-right">Today</span>
							<h5>visits</h5>
						</div>
						<div class="ibox-content">
							<h1 class="no-margins">106,120</h1>
							<div class="stat-percent font-bold text-navy">44% <i class="fa fa-level-up"></i></div>
							<small>New visits</small>
						</div>
					</div>
				</div>
				<div class="col-lg-3">
					<div class="ibox float-e-margins">
						<div class="ibox-title">
							<span class="label label-danger pull-right">Low value</span>
							<h5>User activity</h5>
						</div>
						<div class="ibox-content">
							<h1 class="no-margins">80,600</h1>
							<div class="stat-percent font-bold text-danger">38% <i class="fa fa-level-down"></i></div>
							<small>In first month</small>
						</div>
					</div>
				</div>
			</div>

		</div>
		<div class="footer">
			<div class="pull-right">笺记 &copy; 2016 - 2017</div>
		</div>
	</div>
	<div id="right-sidebar">
		<div class="sidebar-container">

			<ul class="nav nav-tabs navs-3">

				<li class="active"><a data-toggle="tab" href="#tab-1">
						Notes
					</a></li>
				<li><a data-toggle="tab" href="#tab-2">
						Projects
					</a></li>
				<li class=""><a data-toggle="tab" href="#tab-3">
						<i class="fa fa-gear"></i>
					</a></li>
			</ul>

			<div class="tab-content">


				<div id="tab-1" class="tab-pane active">

					<div class="sidebar-title">
						<h3> <i class="fa fa-comments-o"></i> Latest Notes</h3>
						<small><i class="fa fa-tim"></i> You have 10 new message.</small>
					</div>

					<div>

						<div class="sidebar-message">
							<a href="#">
								<div class="pull-left text-center">
									<img alt="image" class="img-circle message-avatar" src="/resources/admin/img/a1.jpg">

									<div class="m-t-xs">
										<i class="fa fa-star text-warning"></i>
										<i class="fa fa-star text-warning"></i>
									</div>
								</div>
								<div class="media-body">

									There are many variations of passages of Lorem Ipsum available.
									<br>
									<small class="text-muted">Today 4:21 pm</small>
								</div>
							</a>
						</div>
						<div class="sidebar-message">
							<a href="#">
								<div class="pull-left text-center">
									<img alt="image" class="img-circle message-avatar" src="/resources/admin/img/a2.jpg">
								</div>
								<div class="media-body">
									The point of using Lorem Ipsum is that it has a more-or-less normal.
									<br>
									<small class="text-muted">Yesterday 2:45 pm</small>
								</div>
							</a>
						</div>
						<div class="sidebar-message">
							<a href="#">
								<div class="pull-left text-center">
									<img alt="image" class="img-circle message-avatar" src="/resources/admin/img/a3.jpg">

									<div class="m-t-xs">
										<i class="fa fa-star text-warning"></i>
										<i class="fa fa-star text-warning"></i>
										<i class="fa fa-star text-warning"></i>
									</div>
								</div>
								<div class="media-body">
									Mevolved over the years, sometimes by accident, sometimes on purpose (injected humour and the like).
									<br>
									<small class="text-muted">Yesterday 1:10 pm</small>
								</div>
							</a>
						</div>
						<div class="sidebar-message">
							<a href="#">
								<div class="pull-left text-center">
									<img alt="image" class="img-circle message-avatar" src="/resources/admin/img/a4.jpg">
								</div>

								<div class="media-body">
									Lorem Ipsum, you need to be sure there isn't anything embarrassing hidden in the
									<br>
									<small class="text-muted">Monday 8:37 pm</small>
								</div>
							</a>
						</div>
						<div class="sidebar-message">
							<a href="#">
								<div class="pull-left text-center">
									<img alt="image" class="img-circle message-avatar" src="/resources/admin/img/a8.jpg">
								</div>
								<div class="media-body">

									All the Lorem Ipsum generators on the Internet tend to repeat.
									<br>
									<small class="text-muted">Today 4:21 pm</small>
								</div>
							</a>
						</div>
						<div class="sidebar-message">
							<a href="#">
								<div class="pull-left text-center">
									<img alt="image" class="img-circle message-avatar" src="/resources/admin/img/a7.jpg">
								</div>
								<div class="media-body">
									Renaissance. The first line of Lorem Ipsum, "Lorem ipsum dolor sit amet..", comes from a line in section 1.10.32.
									<br>
									<small class="text-muted">Yesterday 2:45 pm</small>
								</div>
							</a>
						</div>
						<div class="sidebar-message">
							<a href="#">
								<div class="pull-left text-center">
									<img alt="image" class="img-circle message-avatar" src="/resources/admin/img/a3.jpg">

									<div class="m-t-xs">
										<i class="fa fa-star text-warning"></i>
										<i class="fa fa-star text-warning"></i>
										<i class="fa fa-star text-warning"></i>
									</div>
								</div>
								<div class="media-body">
									The standard chunk of Lorem Ipsum used since the 1500s is reproduced below.
									<br>
									<small class="text-muted">Yesterday 1:10 pm</small>
								</div>
							</a>
						</div>
						<div class="sidebar-message">
							<a href="#">
								<div class="pull-left text-center">
									<img alt="image" class="img-circle message-avatar" src="/resources/admin/img/a4.jpg">
								</div>
								<div class="media-body">
									Uncover many web sites still in their infancy. Various versions have.
									<br>
									<small class="text-muted">Monday 8:37 pm</small>
								</div>
							</a>
						</div>
					</div>

				</div>

				<div id="tab-2" class="tab-pane">

					<div class="sidebar-title">
						<h3> <i class="fa fa-cube"></i> Latest projects</h3>
						<small><i class="fa fa-tim"></i> You have 14 projects. 10 not completed.</small>
					</div>

					<ul class="sidebar-list">
						<li>
							<a href="#">
								<div class="small pull-right m-t-xs">9 hours ago</div>
								<h4>Business valuation</h4>
								It is a long established fact that a reader will be distracted.

								<div class="small">Completion with: 22%</div>
								<div class="progress progress-mini">
									<div style="width: 22%;" class="progress-bar progress-bar-warning"></div>
								</div>
								<div class="small text-muted m-t-xs">Project end: 4:00 pm - 12.06.2014</div>
							</a>
						</li>
						<li>
							<a href="#">
								<div class="small pull-right m-t-xs">9 hours ago</div>
								<h4>Contract with Company </h4>
								Many desktop publishing packages and web page editors.

								<div class="small">Completion with: 48%</div>
								<div class="progress progress-mini">
									<div style="width: 48%;" class="progress-bar"></div>
								</div>
							</a>
						</li>
						<li>
							<a href="#">
								<div class="small pull-right m-t-xs">9 hours ago</div>
								<h4>Meeting</h4>
								By the readable content of a page when looking at its layout.

								<div class="small">Completion with: 14%</div>
								<div class="progress progress-mini">
									<div style="width: 14%;" class="progress-bar progress-bar-info"></div>
								</div>
							</a>
						</li>
						<li>
							<a href="#">
								<span class="label label-primary pull-right">NEW</span>
								<h4>The generated</h4>
								<!--<div class="small pull-right m-t-xs">9 hours ago</div>-->
								There are many variations of passages of Lorem Ipsum available.
								<div class="small">Completion with: 22%</div>
								<div class="small text-muted m-t-xs">Project end: 4:00 pm - 12.06.2014</div>
							</a>
						</li>
						<li>
							<a href="#">
								<div class="small pull-right m-t-xs">9 hours ago</div>
								<h4>Business valuation</h4>
								It is a long established fact that a reader will be distracted.

								<div class="small">Completion with: 22%</div>
								<div class="progress progress-mini">
									<div style="width: 22%;" class="progress-bar progress-bar-warning"></div>
								</div>
								<div class="small text-muted m-t-xs">Project end: 4:00 pm - 12.06.2014</div>
							</a>
						</li>
						<li>
							<a href="#">
								<div class="small pull-right m-t-xs">9 hours ago</div>
								<h4>Contract with Company </h4>
								Many desktop publishing packages and web page editors.

								<div class="small">Completion with: 48%</div>
								<div class="progress progress-mini">
									<div style="width: 48%;" class="progress-bar"></div>
								</div>
							</a>
						</li>
						<li>
							<a href="#">
								<div class="small pull-right m-t-xs">9 hours ago</div>
								<h4>Meeting</h4>
								By the readable content of a page when looking at its layout.

								<div class="small">Completion with: 14%</div>
								<div class="progress progress-mini">
									<div style="width: 14%;" class="progress-bar progress-bar-info"></div>
								</div>
							</a>
						</li>
						<li>
							<a href="#">
								<span class="label label-primary pull-right">NEW</span>
								<h4>The generated</h4>
								<!--<div class="small pull-right m-t-xs">9 hours ago</div>-->
								There are many variations of passages of Lorem Ipsum available.
								<div class="small">Completion with: 22%</div>
								<div class="small text-muted m-t-xs">Project end: 4:00 pm - 12.06.2014</div>
							</a>
						</li>

					</ul>

				</div>

				<div id="tab-3" class="tab-pane">

					<div class="sidebar-title">
						<h3><i class="fa fa-gears"></i> Settings</h3>
						<small><i class="fa fa-tim"></i> You have 14 projects. 10 not completed.</small>
					</div>

					<div class="setings-item">
                    <span>
                        Show notifications
                    </span>
						<div class="switch">
							<div class="onoffswitch">
								<input type="checkbox" name="collapsemenu" class="onoffswitch-checkbox" id="example">
								<label class="onoffswitch-label" for="example">
									<span class="onoffswitch-inner"></span>
									<span class="onoffswitch-switch"></span>
								</label>
							</div>
						</div>
					</div>
					<div class="setings-item">
                    <span>
                        Disable Chat
                    </span>
						<div class="switch">
							<div class="onoffswitch">
								<input type="checkbox" name="collapsemenu" checked class="onoffswitch-checkbox" id="example2">
								<label class="onoffswitch-label" for="example2">
									<span class="onoffswitch-inner"></span>
									<span class="onoffswitch-switch"></span>
								</label>
							</div>
						</div>
					</div>
					<div class="setings-item">
                    <span>
                        Enable history
                    </span>
						<div class="switch">
							<div class="onoffswitch">
								<input type="checkbox" name="collapsemenu" class="onoffswitch-checkbox" id="example3">
								<label class="onoffswitch-label" for="example3">
									<span class="onoffswitch-inner"></span>
									<span class="onoffswitch-switch"></span>
								</label>
							</div>
						</div>
					</div>
					<div class="setings-item">
                    <span>
                        Show charts
                    </span>
						<div class="switch">
							<div class="onoffswitch">
								<input type="checkbox" name="collapsemenu" class="onoffswitch-checkbox" id="example4">
								<label class="onoffswitch-label" for="example4">
									<span class="onoffswitch-inner"></span>
									<span class="onoffswitch-switch"></span>
								</label>
							</div>
						</div>
					</div>
					<div class="setings-item">
                    <span>
                        Offline users
                    </span>
						<div class="switch">
							<div class="onoffswitch">
								<input type="checkbox" checked name="collapsemenu" class="onoffswitch-checkbox" id="example5">
								<label class="onoffswitch-label" for="example5">
									<span class="onoffswitch-inner"></span>
									<span class="onoffswitch-switch"></span>
								</label>
							</div>
						</div>
					</div>
					<div class="setings-item">
                    <span>
                        Global search
                    </span>
						<div class="switch">
							<div class="onoffswitch">
								<input type="checkbox" checked name="collapsemenu" class="onoffswitch-checkbox" id="example6">
								<label class="onoffswitch-label" for="example6">
									<span class="onoffswitch-inner"></span>
									<span class="onoffswitch-switch"></span>
								</label>
							</div>
						</div>
					</div>
					<div class="setings-item">
                    <span>
                        Update everyday
                    </span>
						<div class="switch">
							<div class="onoffswitch">
								<input type="checkbox" name="collapsemenu" class="onoffswitch-checkbox" id="example7">
								<label class="onoffswitch-label" for="example7">
									<span class="onoffswitch-inner"></span>
									<span class="onoffswitch-switch"></span>
								</label>
							</div>
						</div>
					</div>

					<div class="sidebar-content">
						<h4>Settings</h4>
						<div class="small">
							I belive that. Lorem Ipsum is simply dummy text of the printing and typesetting industry.
							And typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s.
							Over the years, sometimes by accident, sometimes on purpose (injected humour and the like).
						</div>
					</div>

				</div>
			</div>

		</div>



	</div>
</div>

<!-- Mainly scripts -->
<script src="/resources/admin/js/jquery-3.1.1.min.js"></script>
<script src="/resources/admin/js/bootstrap.min.js"></script>
<script src="/resources/admin/js/plugins/metisMenu/jquery.metisMenu.js"></script>
<script src="/resources/admin/js/plugins/slimscroll/jquery.slimscroll.min.js"></script>

<!-- Flot -->
<script src="/resources/admin/js/plugins/flot/jquery.flot.js"></script>
<script src="/resources/admin/js/plugins/flot/jquery.flot.tooltip.min.js"></script>
<script src="/resources/admin/js/plugins/flot/jquery.flot.spline.js"></script>
<script src="/resources/admin/js/plugins/flot/jquery.flot.resize.js"></script>
<script src="/resources/admin/js/plugins/flot/jquery.flot.pie.js"></script>
<script src="/resources/admin/js/plugins/flot/jquery.flot.symbol.js"></script>
<script src="/resources/admin/js/plugins/flot/jquery.flot.time.js"></script>

<!-- Peity -->
<script src="/resources/admin/js/plugins/peity/jquery.peity.min.js"></script>
<script src="/resources/admin/js/demo/peity-demo.js"></script>

<!-- Custom and plugin javascript -->
<script src="/resources/admin/js/inspinia.js"></script>
<script src="/resources/admin/js/plugins/pace/pace.min.js"></script>

<!-- jQuery UI -->
<script src="/resources/admin/js/plugins/jquery-ui/jquery-ui.min.js"></script>

<!-- Jvectormap -->
<script src="/resources/admin/js/plugins/jvectormap/jquery-jvectormap-2.0.2.min.js"></script>
<script src="/resources/admin/js/plugins/jvectormap/jquery-jvectormap-world-mill-en.js"></script>

<!-- EayPIE -->
<script src="/resources/admin/js/plugins/easypiechart/jquery.easypiechart.js"></script>



</body>
</html>
