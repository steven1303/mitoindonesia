<header class="main-header">
    <!-- Logo -->
    <a href="#" class="logo">
        <!-- mini logo for sidebar mini 50x50 pixels -->
        <span class="logo-mini"><b>M</b>ito</span>
        <!-- logo for regular state and mobile devices -->
        <span class="logo-lg"><b>SIM</b>ito</span>
    </a>
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top">
        <!-- Sidebar toggle button -->
        <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </a>

        <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
                <!-- User Account: style can be found in dropdown.less -->
                <li class="dropdown user user-menu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <!-- <img src="{{asset(' ')}}" class="user-image" alt="User Image"> -->
                        <span class="hidden-xs">{{ Auth::user()->branch->name }} - {{ Auth::user()->username }}</span>
                    </a>
                    <ul class="dropdown-menu">
                    <!-- User image -->
                        <li class="user-header">
                            <img src="{{asset('dist/img/user2-160x160.jpg')}}" class="img-circle" alt="User Image">
                            <p>
                                 {{ Auth::user()->name }}
                                <small>{{ Auth::user()->created_at }}</small>
                            </p>
                        </li>
                        <!-- Menu Footer-->
                        <li class="user-footer">
                            <div class="pull-left">
                                <a href="javascript:ajaxLoad('{{route('local.admin.profile')}}')" class="btn btn-default btn-flat">Profile</a>
                            </div>
                            <div class="pull-right">
                                <a href="{{ route('local.admin.logout') }}" class="btn btn-default btn-flat">Sign out</a>
                            </div>
                        </li>
                    </ul>
                </li>
                <!-- Control Sidebar Toggle Button
                <li>
                    <a href="#" data-toggle="control-sidebar"><i class="fa fa-gears"></i></a>
                </li>-->
            </ul>
        </div>
    </nav>
</header>
