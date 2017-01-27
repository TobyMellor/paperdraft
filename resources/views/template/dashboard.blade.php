<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>@yield('title') | SeatingPlanner</title>
        <!-- Global stylesheets -->
        <link href="https://fonts.googleapis.com/css?family=Roboto:400,300,100,500,700,900" rel="stylesheet" type="text/css">
        <link href="{{ asset('assets/css/icons/icomoon/styles.css') }}" rel="stylesheet" type="text/css">
        <link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css">
        <link href="{{ asset('assets/css/core.min.css') }}" rel="stylesheet" type="text/css">
        <link href="{{ asset('assets/css/components.min.css') }}" rel="stylesheet" type="text/css">
        <link href="{{ asset('assets/css/colors.min.css') }}" rel="stylesheet" type="text/css">
        <link href="{{ asset('assets/css/seatingplanner.css') }}" rel="stylesheet" type="text/css">
        <link href="{{ asset('assets/css/components.min.css') }}" rel="stylesheet" type="text/css">
        <!-- /global stylesheets -->

        <!-- Core JS files -->
        <script type="text/javascript" src="{{ asset('assets/js/plugins/loaders/pace.min.js') }}"></script>
        <script type="text/javascript" src="{{ asset('assets/js/core/libraries/jquery.min.js') }}"></script>
        <script type="text/javascript" src="{{ asset('assets/js/core/libraries/bootstrap.min.js') }}"></script>
        <script type="text/javascript" src="{{ asset('assets/js/plugins/loaders/blockui.min.js') }}"></script>
        <!-- /core JS files -->

        <!-- Theme JS files -->
        <script type="text/javascript" src="{{ asset('assets/js/core/libraries/jquery_ui/interactions.min.js') }}"></script>
        <script type="text/javascript" src="{{ asset('assets/js/core/libraries/jquery_ui/touch.min.js') }}"></script>
        <script type="text/javascript" src="{{ asset('assets/js/core/libraries/jquery_ui/effects.min.js') }}"></script>
        <script type="text/javascript" src="{{ asset('assets/js/plugins/uploaders/fileinput.min.js') }}"></script>
        <script type="text/javascript" src="{{ asset('assets/js/plugins/buttons/spin.min.js') }}"></script>
        <script type="text/javascript" src="{{ asset('assets/js/plugins/buttons/ladda.min.js') }}"></script>
        <script type="text/javascript" src="{{ asset('assets/js/plugins/notifications/noty.min.js') }}"></script>
        <script type="text/javascript" src="{{ asset('assets/js/plugins/notifications/sweet_alert.min.js') }}"></script>



        <script type="text/javascript" src="{{ asset('assets/js/core/app.js') }}"></script>
        <script type="text/javascript" src="{{ asset('assets/js/pages/appearance_draggable_panels.js') }}"></script>
        <script type="text/javascript" src="{{ asset('assets/js/pages/components_buttons.js') }}"></script>
        <script type="text/javascript" src="{{ asset('assets/js/pages/components_modals.js') }}"></script>
        <script type="text/javascript" src="{{ asset('assets/js/pages/uploader_bootstrap.js') }}"></script>

        <script type="text/javascript" src="{{ asset('assets/js/plugins/forms/selects/select2.min.js') }}"></script>
        <script type="text/javascript" src="{{ asset('assets/js/plugins/forms/styling/uniform.min.js') }}"></script>

        <style>
            .class-button-active > .text-muted {
                color: #ddd;
            }
        </style>
    </head>

    <body>
        <!-- Main navbar -->
        <div class="navbar navbar-inverse">
            <div class="navbar-header">
                <a class="navbar-brand" href="{{ url('/') }}"><img src="{{ asset('assets/images/logo_light.png') }}" alt=""></a>
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
                        <a class="dropdown-toggle" data-toggle="dropdown" href="javascript:void(0);">
                        <img src="{{ asset('assets/images/placeholder.jpg') }}" alt="">
                        <span class="username">@if (isset(Auth::user()->last_name)){{ Auth::user()->title }}. {{ Auth::user()->last_name }}@else{{ current(explode("@", Auth::user()->email, 2)) }}@endif</span>
                        <i class="caret"></i>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-right">
                            <li><a href="javascript:void(0);"><i class="icon-cog5"></i> Account settings</a></li>
                            <li><a href="{{ url('logout') }}"><i class="icon-switch2"></i> Logout</a></li>
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
                                    <a href="javascript:void(0);" class="media-left"><img src="{{ asset('assets/images/placeholder.jpg') }}" class="img-circle img-sm" alt=""></a>
                                    <div class="media-body">
                                        <span class="media-heading text-semibold username">@if (isset(Auth::user()->last_name)){{ Auth::user()->title }}. {{ Auth::user()->last_name }}@else{{ current(explode("@", Auth::user()->email, 2)) }}@endif</span>
                                        <div class="text-size-mini text-muted">
                                            <i class="icon-pin text-size-small"></i> &nbsp;Santa Ana, CA
                                        </div>
                                    </div>
                                    <div class="media-right media-middle">
                                        <ul class="icons-list">
                                            <li>
                                                <a href="javascript:void(0);"><i class="icon-cog3"></i></a>
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
                                    <li class="navigation-header">
                                        <span>Main</span>
                                        <i class="icon-menu" title="Main pages"></i>
                                    </li>
                                    <li @if (app('url')->current() == url('dashboard')) class="active" @endif>
                                        <a id="planner-href" href="{{ url('dashboard') }}">
                                            <i class="icon-home4"></i>
                                            <span>Dashboard</span>
                                        </a>
                                    </li>
                                    <li @if (strpos(app('url')->current(), url('dashboard/classes')) !== false) class="active" @endif>
                                        <a id="classes-href" href="{{ url('dashboard/classes') }}">
                                            <i class="icon-design"></i>
                                            <span>Manage Classes</span>
                                        </a>
                                    </li>
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