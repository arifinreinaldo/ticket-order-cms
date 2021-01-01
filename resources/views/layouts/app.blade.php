<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>
    <!-- Favicon icon -->
    <link rel="icon" href="{{url('image/ic_logo.svg')}}" type="image/x-icon">
    <!-- fontawesome icon -->
    <link rel="stylesheet" href="{{url('assets/fonts/fontawesome/css/fontawesome-all.min.css')}}">
    <!-- animation css -->
    <link rel="stylesheet" href="{{url('assets/plugins/animation/css/animate.min.css')}}">
    <!-- vendor css -->
    <link rel="stylesheet" href="{{url('assets/css/style.css')}}">
    <script src="{{url('assets/plugins/jquery/js/jquery.min.js')}}"></script>
    <link href="{{url('/datatable/dataTables.bootstrap4.min.css')}}" rel="stylesheet">
    <script src="{{url('/datatable/jquery.dataTables.min.js')}}" defer></script>
    <script src="{{url('/datatable/dataTables.bootstrap4.min.js')}}" defer></script>
    @yield('injectstyle')
</head>
<body>
<div id="app">

    <!-- [ Pre-loader ] start -->
    <div class="loader-bg">
        <div class="loader-track">
            <div class="loader-fill"></div>
        </div>
    </div>
    <!-- [ Pre-loader ] End -->

    <!-- [ navigation menu ] start -->
    <nav class="pcoded-navbar">
        <div class="navbar-wrapper">
            <div class="navbar-brand header-logo">
                <a class="b-brand" href="{{ url('/') }}">
                    <img class="img-radius" src="{{url('image/ic_logo.svg')}}" title="Trans Studio">
                    <span class="b-title">{{ config('app.name', 'Laravel') }}</span>
                </a>
                {{--                <a class="mobile-menu" id="mobile-collapse" href="javascript:"><span></span></a>--}}
            </div>
            <div class="navbar-content scroll-div">
                <ul class="nav pcoded-inner-navbar">
                    <li class="nav-item pcoded-menu-caption">
                        <label>User Management</label>
                    </li>
                    @foreach (session('menu') as $menu)
                        @if($menu->read_access=='X')
                            <li data-username="t"
                                class="nav-item {{ (request()->is($menu->alias.'*')) ? 'active' : '' }}">
                                <a href="{{url('/'.$menu->alias)}}" class="nav-link ">
                                    <span class="pcoded-mtext">{{$menu->menu}}</span>
                                </a>
                            </li>
                        @endif
                    @endforeach

                    {{--                    @if(session('menu_2')=='X')--}}
                    {{--                        <li data-username="t" class="nav-item {{ (request()->is('mrole*')) ? 'active' : '' }}">--}}
                    {{--                            <a href="{{url('/mrole')}}" class="nav-link "><span class="pcoded-micon"><i--}}
                    {{--                                        class="feather icon-home"></i></span><span--}}
                    {{--                                    class="pcoded-mtext">User Role Management</span></a>--}}
                    {{--                        </li>--}}
                    {{--                    @endif--}}

                    {{--                    @if(session('menu_2')=='X')--}}
                    {{--                        <li data-username="t" class="nav-item">--}}
                    {{--                            <a href="index.html" class="nav-link "><span class="pcoded-micon"><i--}}
                    {{--                                        class="feather icon-home"></i></span><span--}}
                    {{--                                    class="pcoded-mtext">Customer Management</span></a>--}}
                    {{--                        </li>--}}
                    {{--                    @endif--}}

                    {{--                    @if(session('menu_2')=='X')--}}
                    {{--                        <li data-username="t" class="nav-item">--}}
                    {{--                            <a href="index.html" class="nav-link "><span class="pcoded-micon"><i--}}
                    {{--                                        class="feather icon-home"></i></span><span--}}
                    {{--                                    class="pcoded-mtext">Theme Park Management</span></a>--}}
                    {{--                        </li>--}}
                    {{--                    @endif--}}

                    {{--                    @if(session('menu_2')=='X')--}}

                    {{--                        <li data-username="t" class="nav-item">--}}
                    {{--                            <a href="index.html" class="nav-link "><span class="pcoded-micon"><i--}}
                    {{--                                        class="feather icon-home"></i></span><span--}}
                    {{--                                    class="pcoded-mtext">Theme Park Branch Management</span></a>--}}
                    {{--                        </li>--}}
                    {{--                    @endif--}}

                    {{--                    @if(session('menu_2')=='X')--}}
                    {{--                        <li data-username="t" class="nav-item">--}}
                    {{--                            <a href="index.html" class="nav-link "><span class="pcoded-micon"><i--}}
                    {{--                                        class="feather icon-home"></i></span><span--}}
                    {{--                                    class="pcoded-mtext">Game Center Management</span></a>--}}
                    {{--                        </li>--}}
                    {{--                    @endif--}}

                    {{--                    @if(session('menu_2')=='X')--}}

                    {{--                        <li data-username="t" class="nav-item">--}}
                    {{--                            <a href="index.html" class="nav-link "><span class="pcoded-micon"><i--}}
                    {{--                                        class="feather icon-home"></i></span><span--}}
                    {{--                                    class="pcoded-mtext">Product Management</span></a>--}}
                    {{--                        </li>--}}
                    {{--                    @endif--}}

                    {{--                    @if(session('menu_2')=='X')--}}

                    {{--                        <li data-username="t" class="nav-item">--}}
                    {{--                            <a href="index.html" class="nav-link "><span class="pcoded-micon"><i--}}
                    {{--                                        class="feather icon-home"></i></span><span--}}
                    {{--                                    class="pcoded-mtext">Promotion Management</span></a>--}}
                    {{--                        </li>--}}
                    {{--                    @endif--}}

                    {{--                    @if(session('menu_2')=='X')--}}

                    {{--                        <li data-username="t" class="nav-item">--}}
                    {{--                            <a href="index.html" class="nav-link "><span class="pcoded-micon"><i--}}
                    {{--                                        class="feather icon-home"></i></span><span--}}
                    {{--                                    class="pcoded-mtext">Event Calendar Management</span></a>--}}
                    {{--                        </li>--}}
                    {{--                    @endif--}}

                    {{--                    @if(session('menu_2')=='X')--}}

                    {{--                        <li data-username="t" class="nav-item">--}}
                    {{--                            <a href="index.html" class="nav-link "><span class="pcoded-micon"><i--}}
                    {{--                                        class="feather icon-home"></i></span><span--}}
                    {{--                                    class="pcoded-mtext">Banner Management</span></a>--}}
                    {{--                        </li>--}}
                    {{--                    @endif--}}

                    {{--                    @if(session('menu_10')=='X')--}}

                    {{--                        <li data-username="t" class="nav-item">--}}
                    {{--                            <a href="index.html" class="nav-link "><span class="pcoded-micon"><i--}}
                    {{--                                        class="feather icon-home"></i></span><span--}}
                    {{--                                    class="pcoded-mtext">Article Management</span></a>--}}
                    {{--                        </li>--}}
                    {{--                    @endif--}}

                    {{--                    @if(session('menu_11')=='X')--}}

                    {{--                        <li data-username="t" class="nav-item">--}}
                    {{--                            <a href="index.html" class="nav-link "><span class="pcoded-micon"><i--}}
                    {{--                                        class="feather icon-home"></i></span><span--}}
                    {{--                                    class="pcoded-mtext">Static Page Management</span></a>--}}
                    {{--                        </li>--}}
                    {{--                    @endif--}}

                    {{--                    @if(session('menu_12')=='X')--}}

                    {{--                        <li data-username="t" class="nav-item">--}}
                    {{--                            <a href="index.html" class="nav-link "><span class="pcoded-micon"><i--}}
                    {{--                                        class="feather icon-home"></i></span><span--}}
                    {{--                                    class="pcoded-mtext">Point Management</span></a>--}}
                    {{--                        </li>--}}
                    {{--                    @endif--}}

                    {{--                    @if(session('menu_13')=='X')--}}

                    {{--                        <li data-username="t" class="nav-item">--}}
                    {{--                            <a href="index.html" class="nav-link "><span class="pcoded-micon"><i--}}
                    {{--                                        class="feather icon-home"></i></span><span--}}
                    {{--                                    class="pcoded-mtext">Email Template Management</span></a>--}}
                    {{--                        </li>--}}
                    {{--                    @endif--}}

                    {{--                    @if(session('menu_14')=='X')--}}

                    {{--                        <li data-username="t" class="nav-item">--}}
                    {{--                            <a href="index.html" class="nav-link "><span class="pcoded-micon"><i--}}
                    {{--                                        class="feather icon-home"></i></span><span--}}
                    {{--                                    class="pcoded-mtext">Report Management</span></a>--}}
                    {{--                        </li>--}}
                    {{--                    @endif--}}

                    {{--                    @if(session('menu_15')=='X')--}}

                    {{--                        <li data-username="t" class="nav-item">--}}
                    {{--                            <a href="index.html" class="nav-link "><span class="pcoded-micon"><i--}}
                    {{--                                        class="feather icon-home"></i></span><span--}}
                    {{--                                    class="pcoded-mtext">Configuration</span></a>--}}
                    {{--                        </li>--}}
                    {{--                    @endif--}}

                    {{--                    @if(session('menu_16')=='X')--}}
                    {{--                        <li data-username="t" class="nav-item">--}}
                    {{--                            <a href="index.html" class="nav-link "><span class="pcoded-micon"><i--}}
                    {{--                                        class="feather icon-home"></i></span><span--}}
                    {{--                                    class="pcoded-mtext">Activity & Error Log</span></a>--}}
                    {{--                        </li>--}}
                    {{--                    @endif--}}
                    {{--                    <li class="nav-item pcoded-menu-caption">--}}
                    {{--                        <label>UI Element</label>--}}
                    {{--                    </li>--}}
                    {{--                    <li data-username="basic components Button Alert Badges breadcrumb Paggination progress Tooltip popovers Carousel Cards Collapse Tabs pills Modal Grid System Typography Extra Shadows Embeds"--}}
                    {{--                        class="nav-item pcoded-hasmenu">--}}
                    {{--                        <a href="javascript:" class="nav-link "><span class="pcoded-micon"><i--}}
                    {{--                                    class="feather icon-box"></i></span><span class="pcoded-mtext">Components</span></a>--}}
                    {{--                        <ul class="pcoded-submenu">--}}
                    {{--                            <li class=""><a href="bc_button.html" class="">Button</a></li>--}}
                    {{--                            <li class=""><a href="bc_badges.html" class="">Badges</a></li>--}}
                    {{--                            <li class=""><a href="bc_breadcrumb-pagination.html" class="">Breadcrumb & paggination</a>--}}
                    {{--                            </li>--}}
                    {{--                            <li class=""><a href="bc_collapse.html" class="">Collapse</a></li>--}}
                    {{--                            <li class=""><a href="bc_tabs.html" class="">Tabs & pills</a></li>--}}
                    {{--                            <li class=""><a href="bc_typography.html" class="">Typography</a></li>--}}
                    {{--                            <li class=""><a href="icon-feather.html" class="">Feather<span--}}
                    {{--                                        class="pcoded-badge label label-danger">NEW</span></a></li>--}}
                    {{--                        </ul>--}}
                    {{--                    </li>--}}
                    {{--                    <li class="nav-item pcoded-menu-caption">--}}
                    {{--                        <label>Forms & table</label>--}}
                    {{--                    </li>--}}
                    {{--                    <li data-username="form elements advance componant validation masking wizard picker select"--}}
                    {{--                        class="nav-item">--}}
                    {{--                        <a href="form_elements.html" class="nav-link "><span class="pcoded-micon"><i--}}
                    {{--                                    class="feather icon-file-text"></i></span><span--}}
                    {{--                                class="pcoded-mtext">Form elements</span></a>--}}
                    {{--                    </li>--}}
                    {{--                    <li data-username="Table bootstrap datatable footable" class="nav-item">--}}
                    {{--                        <a href="tbl_bootstrap.html" class="nav-link "><span class="pcoded-micon"><i--}}
                    {{--                                    class="feather icon-server"></i></span><span class="pcoded-mtext">Table</span></a>--}}
                    {{--                    </li>--}}
                    {{--                    <li class="nav-item pcoded-menu-caption">--}}
                    {{--                        <label>Chart & Maps</label>--}}
                    {{--                    </li>--}}
                    {{--                    <li data-username="Charts Morris" class="nav-item"><a href="chart-morris.html"--}}
                    {{--                                                                          class="nav-link "><span--}}
                    {{--                                class="pcoded-micon"><i class="feather icon-pie-chart"></i></span><span--}}
                    {{--                                class="pcoded-mtext">Chart</span></a></li>--}}
                    {{--                    <li data-username="Maps Google" class="nav-item"><a href="map-google.html" class="nav-link "><span--}}
                    {{--                                class="pcoded-micon"><i class="feather icon-map"></i></span><span class="pcoded-mtext">Maps</span></a>--}}
                    {{--                    </li>--}}
                    {{--                    <li class="nav-item pcoded-menu-caption">--}}
                    {{--                        <label>Pages</label>--}}
                    {{--                    </li>--}}
                    {{--                    <li data-username="Authentication Sign up Sign in reset password Change password Personal information profile settings map form subscribe"--}}
                    {{--                        class="nav-item pcoded-hasmenu">--}}
                    {{--                        <a href="javascript:" class="nav-link "><span class="pcoded-micon"><i--}}
                    {{--                                    class="feather icon-lock"></i></span><span--}}
                    {{--                                class="pcoded-mtext">Authentication</span></a>--}}
                    {{--                        <ul class="pcoded-submenu">--}}
                    {{--                            <li class=""><a href="auth-signup.html" class="" target="_blank">Sign up</a></li>--}}
                    {{--                            <li class=""><a href="auth-signin.html" class="" target="_blank">Sign in</a></li>--}}
                    {{--                        </ul>--}}
                    {{--                    </li>--}}
                    {{--                    <li data-username="Sample Page" class="nav-item active"><a href="sample-page.html" class="nav-link"><span--}}
                    {{--                                class="pcoded-micon"><i class="feather icon-sidebar"></i></span><span--}}
                    {{--                                class="pcoded-mtext">Sample page</span></a></li>--}}
                    {{--                    <li data-username="Disabled Menu" class="nav-item disabled"><a href="javascript:"--}}
                    {{--                                                                                   class="nav-link"><span--}}
                    {{--                                class="pcoded-micon"><i class="feather icon-power"></i></span><span--}}
                    {{--                                class="pcoded-mtext">Disabled menu</span></a></li>--}}
                </ul>
            </div>
        </div>
    </nav>
    <!-- [ navigation menu ] end -->

    <!-- [ Header ] start -->
    <header class="navbar pcoded-header navbar-expand-lg navbar-light">
        <div class="m-header">
            <a class="mobile-menu" id="mobile-collapse1" href="javascript:"><span></span></a>
            <a href="index.html" class="b-brand">
                <div class="b-bg">
                    <i class="feather icon-trending-up"></i>
                </div>
                <span class="b-title">Datta Able</span>
            </a>
        </div>
        <a class="mobile-menu" id="mobile-header" href="javascript:">
            <i class="feather icon-more-horizontal"></i>
        </a>
        <div class="collapse navbar-collapse">
            <ul class="navbar-nav mr-auto">
                <li><a href="javascript:" class="full-screen" onclick="javascript:toggleFullScreen()"><i
                            class="feather icon-maximize"></i></a></li>
                {{--                <li class="nav-item dropdown">--}}
                {{--                    <a class="dropdown-toggle" href="javascript:" data-toggle="dropdown">Dropdown</a>--}}
                {{--                    <ul class="dropdown-menu">--}}
                {{--                        <li><a class="dropdown-item" href="javascript:">Action</a></li>--}}
                {{--                        <li><a class="dropdown-item" href="javascript:">Another action</a></li>--}}
                {{--                        <li><a class="dropdown-item" href="javascript:">Something else here</a></li>--}}
                {{--                    </ul>--}}
                {{--                </li>--}}
                {{--                <li class="nav-item">--}}
                {{--                    <div class="main-search">--}}
                {{--                        <div class="input-group">--}}
                {{--                            <input type="text" id="m-search" class="form-control" placeholder="Search . . .">--}}
                {{--                            <a href="javascript:" class="input-group-append search-close">--}}
                {{--                                <i class="feather icon-x input-group-text"></i>--}}
                {{--                            </a>--}}
                {{--                            <span class="input-group-append search-btn btn btn-primary">--}}
                {{--                                <i class="feather icon-search input-group-text"></i>--}}
                {{--                            </span>--}}
                {{--                        </div>--}}
                {{--                    </div>--}}
                {{--                </li>--}}
            </ul>
            <ul class="navbar-nav ml-auto">
                <li>
                    <div class="dropdown drp-user">
                        <a href="javascript:" class="dropdown-toggle mr-2" data-toggle="dropdown">
                            <span>Hello, {{ Auth::user()->name }}</span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right profile-notification">
                            <div class="pro-head">
                                {{Auth::user()->name}}
                                <a href="{{ route('logout') }}"
                                   onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();"
                                   class="dud-logout" title="Logout">
                                    <i class="feather icon-log-out"></i>
                                </a>
                            </div>
                            <ul class="pro-body">
                                <li><a href="{{ route('logout') }}" class="dropdown-item"><i
                                            class="feather icon-lock"></i>
                                        Log Out</a></li>
                            </ul>
                        </div>
                    </div>
                </li>
            </ul>
        </div>
    </header>
    <!-- [ Header ] end -->

    <!-- [ Main Content ] start -->
    <div class="pcoded-main-container">
        <div class="pcoded-wrapper">
            <div class="pcoded-content">
                <div class="pcoded-inner-content">
                    <!-- [ breadcrumb ] start -->
                {{--                    <div class="page-header">--}}
                {{--                        <div class="page-block">--}}
                {{--                            <div class="row align-items-center">--}}
                {{--                                <div class="col-md-12">--}}
                {{--                                    <div class="page-header-title">--}}
                {{--                                        <h5 class="m-b-10">Sample Page</h5>--}}
                {{--                                    </div>--}}
                {{--                                    <ul class="breadcrumb">--}}
                {{--                                        <li class="breadcrumb-item"><a href="index.html"><i--}}
                {{--                                                    class="feather icon-home"></i></a></li>--}}
                {{--                                        <li class="breadcrumb-item"><a href="javascript:">Sample Page</a></li>--}}
                {{--                                    </ul>--}}
                {{--                                </div>--}}
                {{--                            </div>--}}
                {{--                        </div>--}}
                {{--                    </div>--}}
                <!-- [ breadcrumb ] end -->
                    <div class="main-body">
                        <div class="page-wrapper">
                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>

                                </div>
                            @endif
                            @if(session('success'))
                                <div class="alert alert-success" role="alert">
                                    {{session('success')}}
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                            @elseif(session('failed'))
                                <div class="alert alert-danger" role="alert">
                                    {{session('failed')}}
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                            @endif
                            <div id="errorMessage" class="alert alert-danger alert-dismissible fade show" role="alert">
                                <span id="contentMessage"></span>
                                <button type="button" class="close" id="closeMessage"><span
                                        aria-hidden="true">×</span></button>
                            </div>
                            <main class="py-4">
                                @yield('content')
                            </main>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="exampleModalCenter" class="modal fade" tabindex="-1" role="dialog"
         aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="titleModal"></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">×</span></button>
                </div>
                <div class="modal-body" id="contentModal">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
                    <button type="button" class="btn btn-primary" id="confirmButtonModal">Yes</button>
                </div>
            </div>
        </div>
    </div>
    <form id="logout-form" action="{{ route('logout') }}" method="POST"
          style="display: none;">
        @csrf
    </form>
    <script src="{{url('assets/js/vendor-all.min.js')}}"></script>
    <script src="{{url('assets/plugins/bootstrap/js/bootstrap.min.js')}}"></script>
    <script src="{{url('assets/js/pcoded.min.js')}}"></script>
    <script>
        $(document).ready(function () {
            $('#errorMessage').hide();
            $('#closeMessage').click(function () {
                $('#errorMessage').fadeOut();
            })
        });

        function showMessage(data) {
            $('#contentMessage').html(data);
            $('#errorMessage').show();
            $("html, body").animate({scrollTop: 0}, "slow");
        }

        function showModal(title, content) {
            $('#titleModal').html(title);
            $('#contentModal').html(content);
            $('#exampleModalCenter').modal('show');
        }

        function checkEmpty() {
            var isEmpty = true;
            var ids = "";
            table.$('.check-control').each(function () {
                if ($(this).is(":checked")) {
                    isEmpty = false;
                    ids += "," + $(this).attr('userid');
                }
            });
            if (isEmpty) {
                showMessage("Please Select One User");
            }
            return ids;
        }
    </script>
    @yield('injectscript')
    <style>
        .pointer {
            cursor: pointer;
        }
    </style>
</div>
</body>
</html>
