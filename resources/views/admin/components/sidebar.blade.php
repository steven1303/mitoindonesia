<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
      <!-- Sidebar user panel -->
        <div class="user-panel">
            <div class="pull-left image">
                <img src="{{asset('/img/PT_Mito_png.png')}}" class="img-circle" alt="User Image">
            </div>

            <div class="pull-left info">
                <p>Welcome</p>
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
                  <i class="fa fa-folder"></i> <span>Ordering</span>
                  <span class="pull-right-container">
                    <i class="fa fa-angle-left pull-right"></i>
                  </span>
                </a>
                <ul class="treeview-menu">
                    @can('spbd.view', Auth::user())
                    <li>
                        <a href="javascript:ajaxLoad('{{route('local.spbd.index')}}')">
                            <i class="fa fa-th"></i> <span>SPBD</span>
                        </a>
                    </li>
                    @endcan
                    @can('po.stock.view', Auth::user())
                    <li>
                        <a href="javascript:ajaxLoad('{{route('local.po_stock.index')}}')">
                            <i class="fa fa-th"></i> <span>PO Stock</span>
                        </a>
                    </li>
                    @endcan
                    @can('receipt.view', Auth::user())
                    <li>
                        <a href="javascript:ajaxLoad('{{route('local.rec.index')}}')">
                            <i class="fa fa-th"></i> <span>Receipt</span>
                        </a>
                    </li>
                    @endcan
                    @can('spb.view', Auth::user())
                    <li>
                        <a href="javascript:ajaxLoad('{{route('local.spb.index')}}')">
                            <i class="fa fa-th"></i> <span>SPB</span>
                        </a>
                    </li>
                    @endcan
                    @can('po.non.stock.view', Auth::user())
                    <li>
                        <a href="javascript:ajaxLoad('{{route('local.po_non_stock.index')}}')">
                            <i class="fa fa-th"></i> <span>PO Non Stock</span>
                        </a>
                    </li>
                    @endcan

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
                    @can('stock.master.view', Auth::user())
                    <li>
                        <a href="javascript:ajaxLoad('{{route('local.stock_master.index')}}')">
                            <i class="fa fa-th"></i> <span>Stock Master</span>
                        </a>
                    </li>
                    @endcan
                    @can('adjustment.old', Auth::user())
                    <li>
                        <a href="javascript:ajaxLoad('{{route('local.stock_adj.index')}}')">
                            <i class="fa fa-th"></i> <span>Old Adjustment</span>
                        </a>
                    </li>
                    @endcan
                    @can('adjustment.view', Auth::user())
                    <li>
                        <a href="javascript:ajaxLoad('{{route('local.adj.index')}}')">
                            <i class="fa fa-th"></i> <span>Adjustment</span>
                        </a>
                    </li>
                    @endcan
                    <li>
                        <a href="javascript:ajaxLoad('{{route('local.transfer.index')}}')">
                            <i class="fa fa-th"></i> <span>Transfer</span>
                        </a>
                    </li>
                    <li>
                        <a href="javascript:ajaxLoad('{{route('local.transfer_receipt.index')}}')">
                            <i class="fa fa-th"></i> <span>Transfer Receipt</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{route('local.print.stock_master')}}" target="_blank">
                            <i class="fa fa-th"></i> <span>Print SOH</span>
                        </a>
                    </li>
                </ul>
            </li>

            <li class="treeview">
                <a href="#">
                  <i class="fa fa-folder"></i> <span>Transaction</span>
                  <span class="pull-right-container">
                    <i class="fa fa-angle-left pull-right"></i>
                  </span>
                </a>
                <ul class="treeview-menu">
                    @can('pricelist.view', Auth::user())
                    <li>
                        <a href="javascript:ajaxLoad('{{route('local.pricelist.index')}}')">
                            <i class="fa fa-th"></i> <span>Pricelist</span>
                        </a>
                    </li>
                    @endcan
                    @can('po.internal.view', Auth::user())
                    <li>
                        <a href="javascript:ajaxLoad('{{route('local.po_internal.index')}}')">
                            <i class="fa fa-th"></i> <span>PO Internal</span>
                        </a>
                    </li>
                    @endcan
                    @can('sppb.view', Auth::user())
                    <li>
                        <a href="javascript:ajaxLoad('{{route('local.sppb.index')}}')">
                            <i class="fa fa-th"></i> <span>SPPB</span>
                        </a>
                    </li>
                    @endcan
                    @can('invoice.view', Auth::user())
                    <li>
                        <a href="javascript:ajaxLoad('{{route('local.inv.index')}}')">
                            <i class="fa fa-th"></i> <span>Invoice</span>
                        </a>
                    </li>
                    @endcan
                    @can('pelunasan.view', Auth::user())
                    <li>
                        <a href="javascript:ajaxLoad('{{route('local.pelunasan.index')}}')">
                            <i class="fa fa-th"></i> <span>Pelunasan</span>
                        </a>
                    </li>
                    @endcan
                    @can('pembatalan.view', Auth::user())
                    <li>
                        <a href="javascript:ajaxLoad('{{route('local.pembatalan.index')}}')">
                            <i class="fa fa-th"></i> <span>Pembatalan</span>
                        </a>
                    </li>
                    @endcan
                    <li><a href="javascript:ajaxLoad('{{route('local.stock_adj.index')}}')"><i class="fa fa-th"></i> <span>Report</span></a></li>

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
                    @can('customer.view', Auth::user())
                    <li>
                        <a href="javascript:ajaxLoad('{{route('local.customer.index')}}')">
                            <i class="fa fa-th"></i> <span>Customer</span>
                        </a>
                    </li>
                    @endcan
                    @can('vendor.view', Auth::user())
                    <li>
                        <a href="javascript:ajaxLoad('{{route('local.vendor.index')}}')">
                            <i class="fa fa-th"></i> <span>Vendor</span>
                        </a>
                    </li>
                    @endcan

                </ul>
            </li>

            <li class="treeview">
                <a href="#">
                  <i class="fa fa-folder"></i> <span>Tools</span>
                  <span class="pull-right-container">
                    <i class="fa fa-angle-left pull-right"></i>
                  </span>
                </a>
                <ul class="treeview-menu">
                    @can('branch.view', Auth::user())
                    <li>
                        <a href="javascript:ajaxLoad('{{route('local.branch.index')}}')">
                            <i class="fa fa-th"></i> <span>Branch</span>
                        </a>
                    </li>
                    @endcan
                    @can('admin.view', Auth::user())
                    <li>
                        <a href="javascript:ajaxLoad('{{route('local.admin.index')}}')">
                            <i class="fa fa-th"></i> <span>Admin</span>
                        </a>
                    </li>
                    @endcan
                    @can('role.view', Auth::user())
                    <li>
                        <a href="javascript:ajaxLoad('{{route('local.role.index')}}')">
                            <i class="fa fa-th"></i> <span>Roles</span>
                        </a>
                    </li>
                    @endcan
                    @can('permission.view', Auth::user())
                    <li>
                        <a href="javascript:ajaxLoad('{{route('local.permission.index')}}')">
                            <i class="fa fa-th"></i> <span>Permission</span>
                        </a>
                    </li>
                    @endcan
                </ul>
            </li>
            <li class="treeview">
                <a href="#">
                  <i class="fa fa-folder"></i> <span>Frontend</span>
                  <span class="pull-right-container">
                    <i class="fa fa-angle-left pull-right"></i>
                  </span>
                </a>
                <ul class="treeview-menu">
                    <li>
                        <a href="javascript:ajaxLoad('{{route('local.branch.index')}}')">
                            <i class="fa fa-th"></i> <span>Home</span>
                        </a>
                    </li>
                </ul>
            </li>
        </ul>
    </section>
    <!-- /.sidebar -->
</aside>
