<!DOCTYPE html>
<html>
@include('admin.components.header')
<body class="hold-transition skin-blue sidebar-mini">
    <div class="wrapper">

        @include('admin.components.navbar')
        @include('admin.components.sidebar')
        <div class="content-wrapper">
            <div id="content">
                @include('admin.content.dashboard')
            </div>
        </div>
        <footer class="main-footer">
            <div class="pull-right hidden-xs">
                <b>Version</b> 2.4.18
            </div>
            <strong>Copyright &copy; 2014-2019
        </footer>
        <aside class="control-sidebar control-sidebar-dark">
            <div class="tab-content">
                <div class="tab-pane" id="control-sidebar-home-tab"></div>
            </div>
        </aside>
        <div class="control-sidebar-bg"></div>
    </div>
    @include('admin.components.footer')
</body>
</html>
