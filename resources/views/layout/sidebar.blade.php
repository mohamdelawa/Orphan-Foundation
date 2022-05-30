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
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>
                            Dashboard
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="../../index.html" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Dashboard v1</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="../../index2.html" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Dashboard v2</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="../../index3.html" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Dashboard v3</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a href="{{route('users.list')}}" class="nav-link">
                        <i class="nav-icon fas fa-user-friends"></i>
                        <p>
                            المستخدمين
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{route('roles.list')}}" class="nav-link">
                        <i class="nav-icon fas fa-address-card"></i>
                        <p>
                            المناصب
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-user"></i>
                        <p>الأيتام
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{route('orphans.list')}}" class="nav-link">
                                <i class="fas fa-th nav-icon"></i>
                                <p>الأيتام</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('form.add.orphan')}}" class="nav-link">
                                <i class="nav-icon fas fa-plus"></i>
                                <p>اضافة يتيم</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('form.import.excel.orphans')}}" class="nav-link">
                                <i class="fas fa-file-excel nav-icon"></i>
                                <p>اضافة أيتام اكسل</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-coins"></i>
                        <p>
                            الصرفيات
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{route('payments.list')}}" class="nav-link">
                                <i class="fas fa-th nav-icon"></i>
                                <p>الصرفيات</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('paymentOrphans.list')}}" class="nav-link">
                                <i class="fas fa-th nav-icon"></i>
                                <p>صرفيات الأيتام</p>
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
