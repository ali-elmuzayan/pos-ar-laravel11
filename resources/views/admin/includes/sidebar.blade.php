<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="{{route('dashboard')}}" class="brand-link">
        <img src="{{asset("dist/img/AdminLTELogo.png")}}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
             style="opacity: .8">
        <span class="brand-text font-weight-light"><strong>7star</strong> POS</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image ">
                <img src="{{auth()->user()->image ? asset(auth()->user()->image) :asset("uploads/no-user.jpg")}}" class="img-circle elevation-2" alt="User Image">
            </div>
            <div class="info">
                <a href="@isAdmin{{route('profile.edit')}} @else # @endIsAdmin" class="d-block">مرحبا  @isset(\Auth::user()->name){{Auth::user()->name}} @else user @endif</a>
            </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <!-- Add icons to the links using the .nav-icon class
                     with font-awesome or any other icon font library -->

                <li class="nav-item">
                    <a href="{{route('dashboard')}}" class="nav-link">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>
                            الصفحة الرئيسة

                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{route('categories.index')}}" class="nav-link">
                        <i class="nav-icon fas fa-table"></i>
                        <p>
                            الفئات

                        </p>
                    </a>
                </li>
                @isAdmin
                <li class="nav-item">
                    <a href="{{route('expenses.index')}}" class="nav-link">
                        <i class="nav-icon fas fa-university"></i>
                        <p>
                            النفقات

                        </p>
                    </a>
                </li>
@endIsAdmin
                <li class="nav-item">
                    <a href="{{route('products.index')}}" class="nav-link">
                        <i class="nav-icon fas fa-archive"></i>
                        <p>
                           المنتجات

                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{route('orders.index')}}" class="nav-link">
                        <i class="nav-icon fas fa-list"></i>
                        <p>
                            الطلبات

                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{route('pos.index')}}" class="nav-link">
                        <i class="nav-icon fas fa-book"></i>
                        <p>
                            نقطة البيع

                        </p>
                    </a>
                </li>
@isAdmin
                <li class="nav-item">
                    <a href="{{route('dashboard')}}" class="nav-link">
                        <i class="nav-icon fas fa-calculator"></i>
                        <p>
                            الضرائب والقيمة المضافة

                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-chart-pie"></i>
                        <p>
                            التقارير
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{route('reports.orders')}}" class="nav-link">
                                <i class="fas nav-icon fa-chart-area "></i>
                                <p>تقارير الطلبات</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('expenses.index')}}" class="nav-link">
                                <i class="far fa-chart-bar nav-icon"></i>
                                <p>تقارير النفقات</p>
                            </a>
                        </li>
                    </ul>
                </li>


                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-cog"></i>
                        <p>
                            الاعدادات
                            {{--                            <span class="right badge badge-danger">New</span>--}}
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{route('profile.edit')}}" class="nav-link">
                                <i class="far fa-user nav-icon"></i>
                                <p>تعديل الملف الشخصي</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('profile.edit')}}" class="nav-link">
                                <i class="nav-icon fas fa-user-lock"></i>
                                <p>تغيير الباسورد</p>
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="nav-item">
                    <a href="{{route('users.index')}}" class="nav-link">
                        <i class="nav-icon far fa-plus-square"></i>
                        <p>
                            اضافة مستخدم

                        </p>
                    </a>
                </li>
@endIsAdmin
                <li class="nav-item">
                    <form action="{{ route('logout') }}" method="post" class="d-inline">
                        @csrf
                        <button type="submit" class="nav-link btn btn-link" style="cursor: pointer;">
                            <i class="nav-icon fas fa-sign-out-alt"></i>
                            تسجيل الخروج
                        </button>
                    </form>
                </li>
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
