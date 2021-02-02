<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
      <!-- Sidebar user panel -->
        <div class="user-panel">
            <div class="pull-left image">
                <img src="{{asset('dist/img/user2-160x160.jpg')}}" class="img-circle" alt="User Image">
            </div>
            <div class="pull-left info">
                <p>Alexander Pierce</p>
                <a href="#">
                    <i class="fa fa-circle text-success"></i> Online
                </a>
            </div>
        </div>
        <!-- /.search form -->
        <!-- sidebar menu: : style can be found in sidebar.less -->
        <ul class="sidebar-menu" data-widget="tree">
            <li class="header">MAIN NAVIGATION</li>
            <li>
                <a href="{{route('local.admin.dashboard')}}">
                    <i class="fa fa-th"></i> <span>Dashboard</span>
                </a>
            </li>
            <li class="treeview">
                <a href="#">
                  <i class="fa fa-folder"></i> <span>Tools</span>
                  <span class="pull-right-container">
                    <i class="fa fa-angle-left pull-right"></i>
                  </span>
                </a>
                <ul class="treeview-menu">
                    <li>
                        <a href="javascript:ajaxLoad('{{route('local.branch.index')}}')">
                            <i class="fa fa-th"></i> <span>Branch</span>
                        </a>
                    </li>
                    <li>
                        <a href="javascript:ajaxLoad('{{route('local.admin.index')}}')">
                            <i class="fa fa-th"></i> <span>Admin</span>
                        </a>
                    </li>
                    <li>
                        <a href="javascript:ajaxLoad('{{route('local.role.index')}}')">
                            <i class="fa fa-th"></i> <span>Roles</span>
                        </a>
                    </li>
                    <li>
                        <a href="javascript:ajaxLoad('{{route('local.permission.index')}}')">
                            <i class="fa fa-th"></i> <span>Permission</span>
                        </a>
                    </li>
                </ul>
            </li>
            <li class="treeview">
                <a href="#">
                  <i class="fa fa-folder"></i> <span>Settings</span>
                  <span class="pull-right-container">
                    <i class="fa fa-angle-left pull-right"></i>
                  </span>
                </a>
                <ul class="treeview-menu">
                    <li>
                        <a href="javascript:ajaxLoad('{{route('local.customer.index')}}')">
                            <i class="fa fa-th"></i> <span>Customer</span>
                        </a>
                    </li>
                    <li>
                        <a href="javascript:ajaxLoad('{{route('local.vendor.index')}}')">
                            <i class="fa fa-th"></i> <span>Vendor</span>
                        </a>
                    </li>
                </ul>
            </li>
            <li class="treeview">
                <a href="#">
                  <i class="fa fa-folder"></i> <span>Inventory</span>
                  <span class="pull-right-container">
                    <i class="fa fa-angle-left pull-right"></i>
                  </span>
                </a>
                <ul class="treeview-menu">
                    <li>
                        <a href="javascript:ajaxLoad('{{route('local.stock_master.index')}}')">
                            <i class="fa fa-th"></i> <span>Stock Master</span>
                        </a>
                    </li>
                    <li>
                        <a href="javascript:ajaxLoad('{{route('local.vendor.index')}}')">
                            <i class="fa fa-th"></i> <span>Vendor</span>
                        </a>
                    </li>
                </ul>
            </li>
        </ul>
    </section>
    <!-- /.sidebar -->
</aside>
