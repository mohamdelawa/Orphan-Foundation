<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="#" class="brand-link">
        <img src="{{asset('asset/dist/img/AdminLTELogo.png')}}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light">AdminLTE 3</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="{{asset('asset/dist/img/user2-160x160.jpg')}}" class="img-circle elevation-2" alt="User Image">
            </div>
            <div class="info">
                <a href="#" class="d-block">{{auth()->user()->name}}</a>
            </div>
        </div>



        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <li class="nav-item">
                    <a href="{{route('dashboard')}}" class="nav-link">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>
                            الرئيسية
                        </p>
                    </a>
                </li>
                @can('UsersPage')
                    <li class="nav-item">
                    <a href="{{route('users.list')}}" class="nav-link">
                        <i class="nav-icon fas fa-user-friends"></i>
                        <p>
                            المستخدمين
                        </p>
                    </a>
                </li>
                @endcan
                @can('RolesPage')
                    <li class="nav-item">
                    <a href="{{route('roles.list')}}" class="nav-link">
                        <i class="nav-icon fas fa-address-card"></i>
                        <p>
                            المناصب
                        </p>
                    </a>
                </li>
                @endcan
                @can('OrphansPage')
                    <li class="nav-item">
                    <a href="{{route('orphans.list')}}" class="nav-link">
                        <i class="nav-icon fas fa-user"></i>
                        <p>الأيتام
                        </p>
                    </a>
                </li>
                @endcan
                @can('Payments')
                    <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-coins"></i>
                        <p>
                            الصرفيات
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        @can('PaymentsPage')
                            <li class="nav-item">
                            <a href="{{route('payments.list')}}" class="nav-link">
                                <i class="fas fa-th nav-icon"></i>
                                <p>الصرفيات</p>
                            </a>
                        </li>
                        @endcan
                        @can('PaymentsOrphansPage')
                            <li class="nav-item">
                            <a href="{{route('paymentOrphans.list')}}" class="nav-link">
                                <i class="fas fa-th nav-icon"></i>
                                <p>صرفيات الأيتام</p>
                            </a>
                        </li>
                        @endcan
                    </ul>
                </li>
                @endcan
                @can('TypeImagesPage')
                    <li class="nav-item">
                    <a href="{{route('type.images.list')}}" class="nav-link">
                        <i class="nav-icon fas fa-image"></i>
                        <p>نوع الصور
                        </p>
                    </a>
                </li>
                @endcan
                @can('PermissionsPage')
                    <li class="nav-item">
                    <a href="{{route('permissions.list')}}" class="nav-link">
                        <i class="nav-icon fas fa-shield-alt"></i>
                        <p>الصلاحيات
                        </p>
                    </a>
                </li>
                @endcan
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
