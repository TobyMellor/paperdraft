<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>@yield('title') | SeatingPlanner</title>
        <!-- Global stylesheets -->
        <link href="https://fonts.googleapis.com/css?family=Roboto:400,300,100,500,700,900" rel="stylesheet" type="text/css">
        <link href="/assets/css/icons/icomoon/styles.css" rel="stylesheet" type="text/css">
        <link href="/assets/css/bootstrap.min.css" rel="stylesheet" type="text/css">
        <link href="/assets/css/core.min.css" rel="stylesheet" type="text/css">
        <link href="/assets/css/components.min.css" rel="stylesheet" type="text/css">
        <link href="/assets/css/colors.min.css" rel="stylesheet" type="text/css">
        <!-- /global stylesheets -->

        <!-- Core JS files -->
        <script type="text/javascript" src="/assets/js/plugins/loaders/pace.min.js"></script>
        <script type="text/javascript" src="/assets/js/core/libraries/jquery.min.js"></script>
        <script type="text/javascript" src="/assets/js/core/libraries/bootstrap.min.js"></script>
        <script type="text/javascript" src="/assets/js/plugins/loaders/blockui.min.js"></script>
        <!-- /core JS files -->

        <!-- Theme JS files -->
        <script type="text/javascript" src="/assets/js/core/libraries/jquery_ui/interactions.min.js"></script>
        <script type="text/javascript" src="/assets/js/pages/appearance_draggable_panels.js"></script>
        <script type="text/javascript" src="/assets/js/core/libraries/jquery_ui/touch.min.js"></script>
        <script type="text/javascript" src="/assets/js/plugins/uploaders/fileinput.min.js"></script>
        <script type="text/javascript" src="/assets/js/core/app.js"></script>
        <script type="text/javascript" src="/assets/js/pages/uploader_bootstrap.js"></script>
    </head>

    <body>
        <!-- Main navbar -->
        <div class="navbar navbar-inverse">
            <div class="navbar-header">
                <a class="navbar-brand" href="index.html"><img src="/assets/images/logo_light.png" alt=""></a>
                <ul class="nav navbar-nav visible-xs-block">
                    <li><a data-toggle="collapse" data-target="#navbar-mobile"><i class="icon-tree5"></i></a></li>
                    <li><a class="sidebar-mobile-main-toggle"><i class="icon-paragraph-justify3"></i></a></li>
                </ul>
            </div>
            <div class="navbar-collapse collapse" id="navbar-mobile">
                <ul class="nav navbar-nav">
                    <li><a class="sidebar-control sidebar-main-toggle hidden-xs"><i class="icon-paragraph-justify3"></i></a></li>
                </ul>
                <p class="navbar-text"><span class="label bg-success-400">Online</span></p>
                <ul class="nav navbar-nav navbar-right">
                    <li class="dropdown dropdown-user">
                        <a class="dropdown-toggle" data-toggle="dropdown">
                        <img src="/assets/images/placeholder.jpg" alt="">
                        <span>{{ current(explode("@", Auth::user()->email, 2)) }}</span>
                        <i class="caret"></i>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-right">
                            <li><a href="#"><i class="icon-user-plus"></i> My profile</a></li>
                            <li class="divider"></li>
                            <li><a href="#"><i class="icon-cog5"></i> Account settings</a></li>
                            <li><a href="logout"><i class="icon-switch2"></i> Logout</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
        <!-- /main navbar -->
        <!-- Page container -->
        <div class="page-container">
            <!-- Page content -->
            <div class="page-content">
                <!-- Main sidebar -->
                <div class="sidebar sidebar-main">
                    <div class="sidebar-content">
                        <!-- User menu -->
                        <div class="sidebar-user">
                            <div class="category-content">
                                <div class="media">
                                    <a href="#" class="media-left"><img src="/assets/images/placeholder.jpg" class="img-circle img-sm" alt=""></a>
                                    <div class="media-body">
                                        <span class="media-heading text-semibold">{{ current(explode("@", Auth::user()->email, 2)) }}</span>
                                        <div class="text-size-mini text-muted">
                                            <i class="icon-pin text-size-small"></i> &nbsp;Santa Ana, CA
                                        </div>
                                    </div>
                                    <div class="media-right media-middle">
                                        <ul class="icons-list">
                                            <li>
                                                <a href="#"><i class="icon-cog3"></i></a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- /user menu -->
                        <!-- Main navigation -->
                        <div class="sidebar-category sidebar-category-visible">
                            <div class="category-content no-padding">
                                <ul class="navigation navigation-main navigation-accordion">
                                    <!-- Main -->
                                    <li class="navigation-header"><span>Main</span> <i class="icon-menu" title="Main pages"></i></li>
                                    <li @if(app('url')->current() == (url() . '/dashboard')) class="active" @endif><a href="/dashboard"><i class="icon-home4"></i> <span>Dashboard</span></a></li>
                                    <li @if(app('url')->current() == (url() . '/dashboard/classes')) class="active" @endif><a href="/dashboard/classes"><i class="icon-design"></i> <span>Manage Classes</span></a></li>
                                </ul>
                            </div>
                        </div>
                        <!-- /main navigation -->
                    </div>
                </div>
                <!-- /main sidebar -->
                @yield('main')
                @yield('scripts')
            </div>
            <!-- /page content -->
        </div>
        <!-- /page container -->
    </body>
</html>