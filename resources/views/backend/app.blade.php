<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{csrf_token()}}">

    <title>Reports</title>

    <!-- Bootstrap -->
    <link href="/backend/vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="/backend/vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <!-- NProgress -->
    <link href="/backend/vendors/nprogress/nprogress.css" rel="stylesheet">

    <!-- Custom Theme Style -->
    <link href="/backend/build/css/custom.min.css" rel="stylesheet">

    <link href="/css/main.css" rel="stylesheet">

    @yield('css')
</head>

<body class="nav-md">
<div class="container body">
    <div class="main_container">
        <div class="col-md-3 left_col">
            <div class="left_col scroll-view">
                <div class="navbar nav_title" style="border: 0;">
                    <a href="/" class="site_title"><i class="fa fa-paper-plane"></i> <span>Reports</span></a>
                </div>

                <div class="clearfix"></div>

                <!-- menu profile quick info -->
                <div class="profile clearfix">
                    <div class="profile_pic" style="padding: 15px;">
                        <i class="fa fa-user fa-5x"></i>
                    </div>
                    <div class="profile_info">
                        <span>Xoş gəlmisiniz,</span>
                        <h2 style="text-transform: capitalize;">{{Auth::user()->name}} <span style="color: white; text-transform: uppercase;">{{Auth::user()->surname}}</span></h2>
                        @if(Auth::user()->authority() == 1)
                            <small>Admin</small>
                        @elseif(Auth::user()->chief() == 1)
                            <small>Rəhbər</small>
                        @elseif(Auth::user()->authority() == 3)
                            <small>İstifadəçi</small>
                        @elseif(Auth::user()->authority() == 4)
                            <small>Təchizatçı</small>
                        @elseif(Auth::user()->authority() == 5)
                            <small>Direktor</small>
                        @endif

                    </div>
                    <div class="clearfix"></div>
                </div>
                <!-- /menu profile quick info -->

                <br />

                <!-- sidebar menu -->
                <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
                    <div class="menu_section">
                        <ul class="nav side-menu">
                            <li><a href="/"><i class="fa fa-home"></i> Əsas səhifə</a></li>

                            @if(Auth::user()->authority() == 1)
                                {{--admin--}}
                                <li><a href="/admins"><i class="fa fa-user-secret"></i> Adminlər</a></li>
                                <li><a href="/chiefs"><i class="fa fa-user"></i> Rəhbərlər</a></li>
                                <li><a href="/supply-users"><i class="fa fa-user-times"></i> Təchizatçılar</a></li>
                                <li><a href="/departments"><i class="fa fa-building"></i> Departmentlər</a></li>
                                <li><a href="/companies"><i class="fa fa-building-o"></i> Şirkətlər</a></li>
                                <li><a href="/situations"><i class="fa fa-bars"></i> Statuslar</a></li>
                                <li><a href="/authorities"><i class="fa fa-lock"></i> Səlahiyyətlər</a></li>
                                <li><a href="/deadlines"><i class="fa fa-user-times"></i> Bitmə vaxtı (deadline)</a></li>

                            @elseif(Auth::user()->authority() == 3  && Auth::user()->chief() == 1)
                                {{--Chief--}}
                                <li><a href="/users"><i class="fa fa-user"></i> İstifadəçilər</a></li>
                                <li><a href="/chief/orders"><i class="fa fa-folder-open"></i> Sifarişlər</a></li>
                                <li class="active">
                                    <ul class="nav child_menu show-categories">
                                        <!-- @php($cat_count = 0) -->
                                        @foreach($categories as $category)
                                            <!-- @php($cat_count++) -->
                                            <li class="cat-li"><a class="cat-select" href="#" cat_id="{{$category->id}}">{{$category->process}}</a></li>
                                        @endforeach
                                    </ul>
                                </li>

                            @elseif(Auth::user()->authority() == 3)
                                {{--User--}}
                                <li><a href="/orders"><i class="fa fa-folder-open"></i> Sifarişlər </a></li>
                                <li class="active">
                                    <ul class="nav child_menu show-categories">
                                        <!-- @php($cat_count = 0) -->
                                        @foreach($categories as $category)
                                            <!-- @php($cat_count++) -->
                                            <li class="cat-li"><a class="cat-select" href="#" cat_id="{{$category->id}}">{{$category->process}}</a></li>
                                        @endforeach
                                    </ul>
                                </li>

                            @elseif(Auth::user()->authority() == 4)

                                @if(Auth::user()->chief() == 1)
                                    {{--Supply Chief--}}
                                    <li><a href="/supply/users"><i class="fa fa-user"></i> Təchizatçılar</a></li>
                                @endif

                                {{--SupplyUser--}}
                                <li><a href="/supply/accounts"><i class="fa fa-money"></i> Hesablar</a></li>
                                <li><a href="/supply/purchases"><i class="fa fa-shopping-bag"></i> Alımlar</a></li>
                                <li><a href="/supply/orders/"><i class="fa fa-folder-open"></i> Sifarişlər</a></li>
                                <li class="active">
                                    <ul class="nav child_menu show-categories">
                                        <!-- @php($cat_count = 0) -->
                                        @foreach($categories as $category)
                                            <!-- @php($cat_count++) -->
                                            @if($category->orders_count > 0)
                                              <li class="cat-li"><a class="cat-select" href="#" cat_id="{{$category->id}}">{{$category->process}}  <span style="color: #4CF632; font-weight: bold;">({{$category->orders_count}})<span></a></li>
                                            @else
                                              <li class="cat-li"><a class="cat-select" href="#" cat_id="{{$category->id}}">{{$category->process}}</a></li>
                                            @endif
                                        @endforeach
                                    </ul>
                                </li>

                            @elseif(Auth::user()->authority() == 5)
                                {{--Director--}}
                                <li><a href="/director/purchases"><i class="fa fa-shopping-bag"></i> Alımlar</a></li>
                                <li><a href="/director/orders/"><i class="fa fa-folder-open"></i> Sifarişlər</a></li>
                                <li class="active">
                                    <ul class="nav child_menu show-categories">
                                        <!-- @php($cat_count = 0) -->
                                        @foreach($categories as $category)
                                            <!-- @php($cat_count++) -->
                                            @if($category->orders_count > 0)
                                              <li class="cat-li"><a class="cat-select" href="#" cat_id="{{$category->id}}">{{$category->process}}  <span style="color: #4CF632; font-weight: bold;">({{$category->orders_count}})<span></a></li>
                                            @else
                                              <li class="cat-li"><a class="cat-select" href="#" cat_id="{{$category->id}}">{{$category->process}}</a></li>
                                            @endif
                                        @endforeach
                                    </ul>
                                </li>
                            @endif

                        </ul>
                    </div>

                </div>
                <!-- /sidebar menu -->
            </div>
        </div>

        <!-- top navigation -->
        <div class="top_nav">
            <div class="nav_menu">
                <nav>
                    <div class="nav toggle">
                        <a id="menu_toggle"><i class="fa fa-bars"></i></a>
                    </div>

                    <ul class="nav navbar-nav navbar-right">
                        <li class="">
                            <a href="javascript:;" class="user-profile dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                <span style="text-transform: capitalize;">{{Auth::user()->name}} <span style="text-transform: uppercase;">{{Auth::user()->surname}}</span></span>
                                <span class=" fa fa-angle-down"></span>
                            </a>
                            <ul class="dropdown-menu dropdown-usermenu pull-right">
                                <li><a href="/users/update"><i class="fa fa-edit pull-right"></i> Düzəliş et</a></li>
                                <li><a href="/logout"><i class="fa fa-sign-out pull-right"></i> Çıxış</a></li>
                            </ul>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>
        <!-- /top navigation -->

    @yield('content')

    <!-- footer content -->
        <footer>
            <div class="pull-right">
                Created by <strong><a target="_blank" href="https://www.facebook.com/sahib.fermanli">Sahib Farmanli</a></strong>
            </div>
            <div class="clearfix"></div>
        </footer>
        <!-- /footer content -->
    </div>
</div>

<!-- jQuery -->
<script src="/backend/vendors/jquery/dist/jquery.min.js"></script>
<!-- Bootstrap -->
<script src="/backend/vendors/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- FastClick -->
<script src="/backend/vendors/fastclick/lib/fastclick.js"></script>
<!-- NProgress -->
<script src="/backend/vendors/nprogress/nprogress.js"></script>

<!-- Custom Theme Scripts -->
<script src="/backend/build/js/custom.min.js"></script>

<script src="/js/main.js"></script>

@yield('js')
</body>
</html>
