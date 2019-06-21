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

    <link href="/css/main.css?v=3.0" rel="stylesheet">


    @yield('css')
</head>

<body class="nav-md" >
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
                        <h2 style="text-transform: capitalize;">{{Auth::user()->name}} <span
                                    style="color: white; text-transform: uppercase;">{{Auth::user()->surname}}</span>
                        </h2>
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

                <br/>

                <!-- sidebar menu -->
                <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
                    <div class="menu_section">
                        <ul class="nav side-menu">
                            <li><a style="color: {{$settings->message_color}};" href="/"><i class="fa fa-home"></i> Bildirişlər</a></li>
                            <li><a href="/chat"><i class="fa fa-mail-reply"></i> Chat</a></li>

                            @if(Auth::user()->delivered_person() == 1)
                                <li><a href="/warehouseman/orders"><i class="fa fa-briefcase"></i> Anbar</a></li>
                                <li><a href="/warehouseman/delivered"><i class="fa fa-align-justify"></i> Təslim edilənlər</a></li>
                            @endif

                            @if(Auth::user()->authority() == 1)
                                {{--admin--}}
                                <li><a href="/settings"><i class="fa fa-cogs"></i> Ayarlar</a></li>
                                <li><a href="/admins"><i class="fa fa-user-secret"></i> Adminlər</a></li>
                                <li><a href="/chiefs"><i class="fa fa-user"></i> Rəhbərlər</a></li>
                                <li><a href="/directors"><i class="fa fa-user-plus"></i> Direktorlar</a></li>
                                <li><a href="/supply-users"><i class="fa fa-user-times"></i> Təchizatçılar</a></li>
                                <li><a href="/departments"><i class="fa fa-building"></i> Departmentlər</a></li>
                                <li><a href="/companies"><i class="fa fa-building-o"></i> Şirkətlər</a></li>
                                <li><a href="/admin/vehicles"><i class="fa fa-car"></i> Texnikalar </a></li>
                                <li><a href="/situations"><i class="fa fa-bars"></i> Statuslar</a></li>
                                <li><a href="/authorities"><i class="fa fa-lock"></i> Səlahiyyətlər</a></li>
                                <li><a href="/deadlines"><i class="fa fa-user-times"></i> Bitmə vaxtı (deadline)</a>
                                </li>

                            @elseif(Auth::user()->authority() == 3  && Auth::user()->chief() == 1)
                                {{--Chief--}}
                                <li><a href="/chief/delivered"><i class="fa fa-align-justify"></i> Təslim edilənlər</a></li>
                                <li><a href="/chief/warehouse"><i class="fa fa-briefcase"></i> Anbar</a></li>

                                @php($orders_for_chief_total_count = 0)
                                @php($li_for_orders_chief = '')
                                @foreach($categories_for_chief as $category)
                                    @if($category->orders_count > 0)
                                        @php($li_for_orders_chief .= '<li class="cat-li"><a class="cat-select" href="#" cat_id="'.$category->id.'">'.$category->process.'  <span style="color: #4CF632; font-weight: bold;">('.$category->orders_count.')<span></a></li>')
                                        @php($orders_for_chief_total_count += $category->orders_count)
                                    @else
                                        @php($li_for_orders_chief .= '<li class="cat-li"><a class="cat-select" href="#" cat_id="'.$category->id.'">'.$category->process.'</a></li>')
                                    @endif
                                @endforeach
                                <li><a href="/chief/orders"><i class="fa fa-folder-open"></i> Sifarişlər <span
                                                style="color: #4CF632; font-weight: bold;">({{$orders_for_chief_total_count}})<span></a>
                                </li>
                                <li class="active">
                                    <ul class="nav child_menu show-categories">
                                        {!! $li_for_orders_chief !!}
                                    </ul>
                                </li>

                            @elseif(Auth::user()->authority() == 3)
                                {{--User--}}

                                @if(Auth::user()->delivered_person() != 1)
                                    <li><a href="/users/delivered"><i class="fa fa-align-justify"></i> Təslim edilənlər</a></li>
                                    <li><a href="/users/warehouse"><i class="fa fa-briefcase"></i> Anbar</a></li>

                                    @if(Auth::user()->DepartmentID() == 2)
                                        <li><a href="/vehicles"><i class="fa fa-car"></i> Texnikalar </a></li>
                                    @endif

                                    <li><a href="/orders"><i class="fa fa-folder-open"></i> Sifarişlər </a></li>
                                    <li class="active">
                                        <ul class="nav child_menu show-categories">
                                            @foreach($categories as $category)
                                                <li class="cat-li"><a class="cat-select" href="#"
                                                                      cat_id="{{$category->id}}">{{$category->process}}</a>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </li>
                                @endif

                            @elseif(Auth::user()->authority() == 4)

                                @if(Auth::user()->chief() == 1)
                                    {{--Supply Chief--}}
                                    <li><a href="/supply/users"><i class="fa fa-user"></i> Təchizatçılar</a></li>
                                @endif

                                {{--SupplyUser--}}
                                <li><a href="/supply/companies"><i class="fa fa-building"></i> Şirkətlər</a></li>
                                <li><a href="/supply/accounts"><i class="fa fa-money"></i> Hesablar</a></li>
                                <li><a href="/supply/demand"><i class="fa fa-file"></i> Tələbnamələr</a></li>
                                <li><a href="/supply/delivered"><i class="fa fa-align-justify"></i> Təslim edilənlər</a></li>
                                <li><a href="/supply/warehouse"><i class="fa fa-briefcase"></i> Anbar</a></li>
                                <li><a href="/supply/purchases"><i class="fa fa-shopping-bag"></i> Alımlar</a></li>

                                @php($alts_for_supply_total_count = 0)
                                @php($li_for_alts_supply = '')
                                @foreach($categories_for_supply as $category)
                                    @if($category->alts_count > 0)
                                        @php($li_for_alts_supply .= '<li class="cat-li"><a class="cat-select" href="#" cat_id="'.$category->id.'">'.$category->process.'  <span style="color: #4CF632; font-weight: bold;">('.$category->alts_count.')<span></a></li>')
                                        @php($alts_for_supply_total_count += $category->alts_count)
                                    @else
                                        @php($li_for_alts_supply .= '<li class="cat-li"><a class="cat-select" href="#" cat_id="'.$category->id.'">'.$category->process.'</a></li>')
                                    @endif
                                @endforeach
                                <li><a href="/supply/alternatives/"><i class="fa fa-list-alt"></i> Alternativlər <span
                                                style="color: #4CF632; font-weight: bold;">({{$alts_for_supply_total_count}})<span></a>
                                </li>
                                <li class="active">
                                    <ul class="nav child_menu show-categories-for-alts-supply">
                                        {!! $li_for_alts_supply !!}
                                    </ul>
                                </li>

                                @if(Auth::user()->chief() == 1)
                                    @php($orders_for_supply_chief_total_count = 0)
                                    @php($li_supply_chief = '')
                                    @foreach($categories_for_supply as $category)
                                        @if($category->orders_count > 0)
                                            @php($li_supply_chief .= '<li class="cat-li"><a class="cat-select" href="#" cat_id="'.$category->id.'">'.$category->process.'  <span style="color: #4CF632; font-weight: bold;">('.$category->orders_count.')<span></a></li>')
                                            @php($orders_for_supply_chief_total_count += $category->orders_count)
                                        @else
                                            @php($li_supply_chief .= '<li class="cat-li"><a class="cat-select" href="#" cat_id="'.$category->id.'">'.$category->process.'</a></li>')
                                        @endif
                                    @endforeach
                                    <li><a href="/supply/chief/orders/"><i class="fa fa-folder-open"></i> Daxili
                                            sifarişlər <span style="color: #4CF632; font-weight: bold;">({{$orders_for_supply_chief_total_count}})<span></a>
                                    </li>
                                    <li class="active">
                                        <ul class="nav child_menu show-categories">
                                            {!! $li_supply_chief !!}
                                        </ul>
                                    </li>
                                    @if(Auth::user()->chief() == 1)
                                        {{--Supply Chief--}}
                                        <li><a href="/supply/alternatives-list"><i class="fa fa-list-ul"></i> Alternativ siyahısı</a></li>
                                    @endif
                                @else
                                    <li><a href="/supply/orders/"><i class="fa fa-folder-open"></i> Daxili
                                            sifarişlər</a></li>
                                    <li class="active">
                                        <ul class="nav child_menu show-categories">
                                            @foreach($categories as $category)
                                                <li class="cat-li"><a class="cat-select" href="#"
                                                                      cat_id="{{$category->id}}">{{$category->process}}</a>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </li>
                                @endif

                            @elseif(Auth::user()->authority() == 5)
                                {{--Director--}}
                                <li><a href="/director/purchases"><i class="fa fa-shopping-bag"></i> Alımlar</a></li>
                                <li><a href="/director/delivered"><i class="fa fa-align-justify"></i> Təslim edilənlər</a></li>
                                <li><a href="/director/warehouse"><i class="fa fa-briefcase"></i> Anbar</a></li>

                                @php($alts_for_law_total_count = 0)
                                @php($lis = '')
                                @foreach($categories as $category)
                                    @if($category->orders_count > 0)
                                        @php($lis .= '<li class="cat-li"><a class="cat-select" href="#" cat_id="'.$category->id.'">'.$category->process.'  <span style="color: #4CF632; font-weight: bold;">('.$category->orders_count.')<span></a></li>')
                                        @php($alts_for_law_total_count += $category->orders_count)
                                    @else
                                        @php($lis .= '<li class="cat-li"><a class="cat-select" href="#" cat_id="'.$category->id.'">'.$category->process.'</a></li>')
                                    @endif
                                @endforeach
                                <li><a href="/director/alternatives/"><i class="fa fa-list-alt"></i> Alternativlər <span
                                                style="color: #4CF632; font-weight: bold;">({{$alts_for_law_total_count}})<span></a>
                                </li>
                                <li class="active">
                                    <ul class="nav child_menu show-categories-for-alts">
                                        {!! $lis !!}
                                    </ul>
                                </li>

                                @if(Auth::user()->auditor() == 8)
                                    @if(count($accounts) > 0)
                                        @php($accounts_menu_color = 'green')
                                    @else
                                        @php($accounts_menu_color = 'red')
                                    @endif
                                    <li><a style="color: {{$accounts_menu_color}};" href="/director/pending/orders/"><i
                                                    class="fa fa-folder-open"></i> Hesablar (şirkətlər)</a></li>
                                    <li class="active">
                                        <ul class="nav child_menu show-accounts">
                                            @foreach($accounts as $account)
                                                <li class="account-li" title="{{$account->account_no}}"><a
                                                            class="account-select"
                                                            href="/director/pending/orders?account_id={{$account->id}}">{{$account->company}}</a>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </li>
                                @endif

                            @elseif(Auth::user()->authority() == 6)
                                {{--Lawyer--}}
                                @if(Auth::user()->chief() == 1)
                                    {{--Lawyer Chief--}}
                                    <li><a href="/law/users"><i class="fa fa-user"></i> İşçilər</a></li>
                                    <li><a href="/law/delivered"><i class="fa fa-align-justify"></i> Təslim edilənlər</a></li>
                                    <li><a href="/law/warehouse"><i class="fa fa-briefcase"></i> Anbar</a></li>
                                    <li><a href="/law/chief/purchases"><i class="fa fa-shopping-bag"></i> Alımlar</a>
                                    </li>

                                    @php($orders_for_chief_total_count = 0)
                                    @php($li_for_orders_chief = '')
                                    @foreach($categories_for_chief as $category)
                                        @if($category->orders_count > 0)
                                            @php($li_for_orders_chief .= '<li class="cat-li"><a class="cat-select" href="#" cat_id="'.$category->id.'">'.$category->process.'  <span style="color: #4CF632; font-weight: bold;">('.$category->orders_count.')<span></a></li>')
                                            @php($orders_for_chief_total_count += $category->orders_count)
                                        @else
                                            @php($li_for_orders_chief .= '<li class="cat-li"><a class="cat-select" href="#" cat_id="'.$category->id.'">'.$category->process.'</a></li>')
                                        @endif
                                    @endforeach
                                    <li><a href="/law/chief/orders/"><i class="fa fa-folder-open"></i> Daxili sifarişlər <span
                                                    style="color: #4CF632; font-weight: bold;">({{$orders_for_chief_total_count}})<span></a>
                                    </li>
                                    <li class="active">
                                        <ul class="nav child_menu show-categories">
                                            {!! $li_for_orders_chief !!}
                                        </ul>
                                    </li>
                                @else
                                    <li><a href="/law/delivered"><i class="fa fa-align-justify"></i> Təslim edilənlər</a></li>
                                    <li><a href="/law/warehouse"><i class="fa fa-briefcase"></i> Anbar</a></li>
                                    <li><a href="/law/purchases"><i class="fa fa-shopping-bag"></i> Alımlar</a></li>
                                    <li><a href="/law/orders/"><i class="fa fa-folder"></i> Daxili sifarişlər</a></li>
                                    <li class="active">
                                        <ul class="nav child_menu show-categories">
                                            @foreach($categories as $category)
                                                <li class="cat-li"><a class="cat-select" href="#"
                                                                      cat_id="{{$category->id}}">{{$category->process}}</a>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </li>
                                @endif

                                @if(count($accounts) > 0)
                                    @php($accounts_menu_color = 'green')
                                @else
                                    @php($accounts_menu_color = 'red')
                                @endif
                                @if(Auth::user()->chief() == 1)
                                    <li><a style="color: {{$accounts_menu_color}};" href="/law/chief/pending/orders/"><i
                                                    class="fa fa-money"></i> Hesablar (şirkətlər)</a></li>
                                @else
                                    <li><a style="color: {{$accounts_menu_color}};" href="/law/pending/orders/"><i
                                                    class="fa fa-money"></i> Hesablar (şirkətlər)</a></li>
                                @endif
                                <li class="active">
                                    <ul class="nav child_menu show-accounts">
                                        @foreach($accounts as $account)
                                            @if(Auth::user()->chief() == 1)
                                                <li class="account-li" title="{{$account->account_no}}"><a
                                                            class="account-select"
                                                            href="/law/chief/pending/orders?account_id={{$account->id}}">{{$account->company}}</a>
                                                </li>
                                            @else
                                                <li class="account-li" title="{{$account->account_no}}"><a
                                                            class="account-select"
                                                            href="/law/pending/orders?account_id={{$account->id}}">{{$account->company}}</a>
                                                </li>
                                            @endif
                                        @endforeach
                                    </ul>
                                </li>

                            @elseif(Auth::user()->authority() == 7)
                                {{--Finance--}}
                                @if(Auth::user()->chief() == 1)
                                    {{--Lawyer Chief--}}
                                    <li><a href="/finance/users"><i class="fa fa-user"></i> İşçilər</a></li>
                                    <li><a href="/finance/delivered"><i class="fa fa-align-justify"></i> Təslim edilənlər</a></li>
                                    <li><a href="/finance/warehouse"><i class="fa fa-briefcase"></i> Anbar</a></li>
                                    <li><a href="/finance/chief/purchases"><i class="fa fa-shopping-bag"></i>
                                            Alımlar</a></li>
                                    @php($orders_for_chief_total_count = 0)
                                    @php($li_for_orders_chief = '')
                                    @foreach($categories_for_chief as $category)
                                        @if($category->orders_count > 0)
                                            @php($li_for_orders_chief .= '<li class="cat-li"><a class="cat-select" href="#" cat_id="'.$category->id.'">'.$category->process.'  <span style="color: #4CF632; font-weight: bold;">('.$category->orders_count.')<span></a></li>')
                                            @php($orders_for_chief_total_count += $category->orders_count)
                                        @else
                                            @php($li_for_orders_chief .= '<li class="cat-li"><a class="cat-select" href="#" cat_id="'.$category->id.'">'.$category->process.'</a></li>')
                                        @endif
                                    @endforeach
                                    <li><a href="/finance/chief/orders/"><i class="fa fa-folder-open"></i> Daxili sifarişlər <span
                                                    style="color: #4CF632; font-weight: bold;">({{$orders_for_chief_total_count}})<span></a>
                                    </li>
                                    <li class="active">
                                        <ul class="nav child_menu show-categories">
                                            {!! $li_for_orders_chief !!}
                                        </ul>
                                    </li>
                                @else
                                    <li><a href="/finance/delivered"><i class="fa fa-align-justify"></i> Təslim edilənlər</a></li>
                                    <li><a href="/finance/warehouse"><i class="fa fa-briefcase"></i> Anbar</a></li>
                                    <li><a href="/finance/purchases"><i class="fa fa-shopping-bag"></i> Alımlar</a></li>
                                    <li><a href="/finance/orders/"><i class="fa fa-folder-open"></i> Daxili
                                            sifarişlər</a></li>
                                    <li class="active">
                                        <ul class="nav child_menu show-categories">
                                            @foreach($categories as $category)
                                                <li class="cat-li"><a class="cat-select" href="#"
                                                                      cat_id="{{$category->id}}">{{$category->process}}</a>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </li>
                                @endif

                                @if(count($accounts) > 0)
                                    @php($accounts_menu_color = 'green')
                                @else
                                    @php($accounts_menu_color = 'red')
                                @endif
                                @if(Auth::user()->chief() == 1)
                                    <li><a style="color: {{$accounts_menu_color}};"
                                           href="/finance/chief/pending/orders/"><i class="fa fa-folder-open"></i>
                                            Hesablar (Şirkətlər)</a></li>
                                @else
                                    <li><a style="color: {{$accounts_menu_color}};" href="/finance/pending/orders/"><i
                                                    class="fa fa-folder-open"></i> Hesablar (Şirkətlər)</a></li>
                                @endif
                                <li class="active">
                                    <ul class="nav child_menu show-accounts">
                                        @foreach($accounts as $account)
                                            @if(Auth::user()->chief() == 1)
                                                <li class="account-li" title="{{$account->account_no}}"><a
                                                            class="account-select"
                                                            href="/finance/chief/pending/orders?account_id={{$account->id}}">{{$account->company}}</a>
                                                </li>
                                            @else
                                                <li class="account-li" title="{{$account->account_no}}"><a
                                                            class="account-select"
                                                            href="/finance/pending/orders?account_id={{$account->id}}">{{$account->company}}</a>
                                                </li>
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
                            <a href="javascript:;" class="user-profile dropdown-toggle" data-toggle="dropdown"
                               aria-expanded="false">
                                <span style="text-transform: capitalize;">{{Auth::user()->name}} <span
                                            style="text-transform: uppercase;">{{Auth::user()->surname}}</span></span>
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
