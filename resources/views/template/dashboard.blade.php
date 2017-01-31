<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>@yield('title') | SeatingPlanner</title>

        <link href="https://fonts.googleapis.com/css?family=Roboto:400,300,100,500,700,900" rel="stylesheet" type="text/css">
        <link href="{{ asset('assets/css/icons/icomoon/styles.css') }}" rel="stylesheet" type="text/css">
        <link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css">
        <link href="{{ asset('assets/css/core.min.css') }}" rel="stylesheet" type="text/css">
        <link href="{{ asset('assets/css/components.min.css') }}" rel="stylesheet" type="text/css">
        <link href="{{ asset('assets/css/colors.min.css') }}" rel="stylesheet" type="text/css">
        <link href="{{ asset('assets/css/seatingplanner.css') }}" rel="stylesheet" type="text/css">
        <link href="{{ asset('assets/css/components.min.css') }}" rel="stylesheet" type="text/css">

        <script type="text/javascript" src="{{ asset('assets/js/plugins/loaders/pace.min.js') }}"></script>
        <script type="text/javascript" src="{{ asset('assets/js/core/libraries/jquery.min.js') }}"></script>
        <script type="text/javascript" src="{{ asset('assets/js/core/libraries/bootstrap.min.js') }}"></script>
        <script type="text/javascript" src="{{ asset('assets/js/plugins/loaders/blockui.min.js') }}"></script>

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
    </head>

    <body>
        <div class="navbar navbar-inverse">
            <div class="navbar-header">
                <a class="navbar-brand" href="{{ url('/') }}"><img src="{{ asset('assets/images/logo_light.png') }}"></a>
                <ul class="nav navbar-nav visible-xs-block">
                    <li>
                        <a data-toggle="collapse" data-target="#navbar-mobile">
                            <i class="icon-tree5"></i>
                        </a>
                    </li>
                    <li>
                        <a class="sidebar-mobile-main-toggle">
                            <i class="icon-paragraph-justify3"></i>
                        </a>
                    </li>
                </ul>
            </div>

            <div class="navbar-collapse collapse" id="navbar-mobile">
                <ul class="nav navbar-nav">
                    <li>
                        <a class="sidebar-control sidebar-main-toggle hidden-xs">
                            <i class="icon-paragraph-justify3"></i>
                        </a>
                    </li>
                </ul>
                <ul class="nav navbar-nav navbar-right">
                    <li class="dropdown dropdown-user">
                        <a class="dropdown-toggle" data-toggle="dropdown" href="javascript:void(0);">
                            <img src="{{ asset('assets/images/placeholder.jpg') }}">
                            <span class="username">
                                @if (isset(Auth::user()->last_name))
                                    {{ Auth::user()->title }}. {{ Auth::user()->last_name }}
                                @else
                                    {{ current(explode("@", Auth::user()->email, 2)) }}
                                @endif
                            </span>
                            <i class="caret"></i>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-right">
                            <li>
                                <a href="{{ url('dashboard/settings') }}">
                                    <i class="icon-cog5"></i> Account settings
                                </a>
                            </li>
                            <li>
                                <a href="{{ url('logout') }}">
                                    <i class="icon-switch2"></i> Logout
                                </a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
        <div class="page-container">
            <div class="page-content">
                <div class="sidebar sidebar-main">
                    <div class="sidebar-content">
                        <div class="sidebar-user">
                            <div class="category-content">
                                <div class="media">
                                    <a href="javascript:void(0);" class="media-left"><img src="{{ asset('assets/images/placeholder.jpg') }}" class="img-circle img-sm"></a>
                                    <div class="media-body">
                                        <span class="media-heading text-semibold username">@if (isset(Auth::user()->last_name)){{ Auth::user()->title }}. {{ Auth::user()->last_name }}@else{{ current(explode("@", Auth::user()->email, 2)) }}@endif</span>
                                        <div class="text-size-mini text-muted">
                                            <i class="icon-pin text-size-small"></i>
                                            @if (Auth::user()->institution_id !== null)
                                                {{ Auth::user()->institution->name }}
                                            @else
                                                PaperDraft
                                            @endif
                                        </div>
                                    </div>
                                    <div class="media-right media-middle">
                                        <ul class="icons-list">
                                            <li>
                                                <a href="{{ url('dashboard/settings') }}"><i class="icon-cog3"></i></a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="sidebar-category sidebar-category-visible">
                            <div class="category-content no-padding">
                                <ul class="navigation navigation-main navigation-accordion">
                                    <li class="navigation-header">
                                        <span>Administration</span>
                                        <i class="icon-vcard" title="Administration"></i>
                                    </li>
                                    <li @if (strpos(app('url')->current(), 'admin')) class="active" @endif>
                                        <a href="{{ url('dashboard/admin') }}">
                                            <i class="icon-user-tie"></i>
                                            <span>Institution Admin Panel</span>
                                        </a>
                                    </li>
                                    <li class="navigation-header">
                                        <span>Main Menu</span>
                                        <i class="icon-menu" title="Main pages"></i>
                                    </li>
                                    <li @if (app('url')->current() === url('dashboard')) class="active" @endif>
                                        <a id="planner-href" href="{{ url('dashboard') }}">
                                            <i class="icon-home4"></i>
                                            <span>Seating Plans</span>
                                        </a>
                                    </li>
                                    <li @if (strpos(app('url')->current(), 'classes')) class="active" @endif>
                                        <a id="classes-href" href="{{ url('dashboard/classes') }}">
                                            <i class="icon-design"></i>
                                            @if (Auth::user()->priviledge === 1)
                                                <span>Manage Personal Classes</span>
                                            @else
                                                <span>Manage Classes</span>
                                            @endif
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="content-wrapper">
                    <div class="page-header">
                        <div class="breadcrumb-line">
                            <ul class="breadcrumb">
                                <li>
                                    <a href="{{ url('dashboard') }}">
                                        <i class="icon-home2 position-left"></i> Home
                                    </a>
                                </li>
                                <li class="active">@yield('title')</li>
                            </ul>
                            @if (Auth::user()->institution_id !== null)
                                <ul class="breadcrumb-elements">
                                    <li>
                                        <a href="javascript:void(0);">
                                            <i class="icon-code position-left"></i> Institution Code: <strong>{{ Auth::user()->institution->institution_code }}</strong>
                                        </a>
                                    </li>
                                </ul>
                            @endif
                        </div>
                    </div>

                    <div class="content" style="padding-top: 20px;">

                        @yield('main')

                        <div class="footer text-muted">
                            &copy; {{ date("Y") }} SeatingPlanner by Toby Mellor
                        </div>
                    </div>
                </div>

                @yield('modals')
                @yield('scripts')

            </div>
        </div>
    </body>
</html>