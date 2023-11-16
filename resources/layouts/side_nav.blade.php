
<aside class="main-sidebar" style="background-color: #222d32;">

    <a href="{{ route('home') }}" class="brand-link" style="background-color: #367fa9 !important; height: 56px">
        <img src="{{ asset('images/logo.jpg') }}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
             style="opacity: .8">
        <span class="brand-text font-weight-light" style="color: #ffffff !important;"><h4>User Automation</h4></span>
    </a>
    <!-- Brand Logo -->
    {{--<a href="../../index3.html" class="brand-link">
        <img src="../../dist/img/AdminLTELogo.png"
             alt="User Automation Logo"
             class=""
             style="opacity: .8">
        <!--            <span class="brand-text font-weight-light">User Automation</span>-->
    </a>--}}
    <!-- Sidebar -->

    <section class="sidebar">
        <!-- Sidebar user (optional) -->
        <!--  <div class="user-panel mt-3 pb-3 mb-3 d-flex">
              <div class="image">
                  <img src="../../dist/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">
              </div>
              <div class="info">
                  <a href="#" class="d-block">Alexander Pierce</a>
              </div>
          </div>-->

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                data-accordion="false">
                <!-- Add icons to the links using the .nav-icon class
                     with font-awesome or any other icon font library -->
                <li class="nav-item has-treeview">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-gifts"></i>
                        <p>
                            Packages
{{--                            <i class="right fas fa-angle-left"></i>--}}
                        </p>
                    </a>
                    <ul class="nav nav-treeview"  style="display: block !important;">
                        {{--<li class="nav-item">
                            <a href="{{ route('create.package') }}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Create Package</p>
                            </a>
                        </li>--}}
                        <li class="nav-item">
                            <a href="{{ route('package.index') }}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Packages</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('package.history') }}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Package History</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <ul>
                <li class="nav-item">
                    <a href="{{ route('content-group.index') }}" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Content Groups</p>
                    </a>
                </li>
                </ul>
                {{--<li class="nav-item has-treeview">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-users"></i>
                        <p>
                            Users
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="../layout/top-nav.html" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Create User</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="../layout/top-nav-sidebar.html" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>List of Users</p>
                            </a>
                        </li>
                    </ul>
                </li>--}}
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </section>
    <!-- /.sidebar -->
</aside>

