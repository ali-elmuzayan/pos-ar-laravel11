<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="{{route('dashboard')}}" class="brand-link">
        <img src="{{asset($setting->logo)}}" alt="pos Logo" class="brand-image img-circle elevation-3"
             style="opacity: .8">
        <span class="brand-text font-weight-light"><strong>{{$setting->name}}</strong></span>
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

                @isAdmin
                <li class="nav-item">
                    <a href="{{route('dashboard')}}" class="nav-link">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>
                            الصفحة الرئيسة

                        </p>
                    </a>
                </li>
                @endIsAdmin
                <li class="nav-item">
                    <a href="{{route('pos.index')}}" class="nav-link">
                        <i class="nav-icon fas fa-book"></i>
                        <p>
                            نقطة البيع

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
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-shopping-cart"></i>
                        <p>
                           ادارة المبيعات
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{route('orders.index')}}" class="nav-link">
                                <i class="nav-icon fas fa-list"></i>
                                <p>
                                    الطلبات

                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('returns.index')}}" class="nav-link">
                                <i class="nav-icon fas fa-retweet"></i>
                                <p>
                                    المرتجعات

                                </p>
                            </a>
                        </li>
                    </ul>
                </li>




@isAdmin

                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-shopping-bag"></i>
                        <p>
                            بيانات المتجر
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{route('discounts.index')}}" class="nav-link">
                                <i class="nav-icon fas fa-percentage"></i>
                                <p>
                                    الخصومات

                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('products.index')}}" class="nav-link">
                                <i class="nav-icon fas fa-archive"></i>
                                <p>
                                    المنتجات

                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('expenses.index')}}" class="nav-link">
                                <i class="nav-icon fas fa-university"></i>
                                <p>
                                    النفقات

                                </p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-users"></i>
                        <p>
                            بيانات الافراد
                            {{--                            <span class="right badge badge-danger">New</span>--}}
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{route('users.index')}}" class="nav-link">
                                <i class="nav-icon fas fa-user"></i>
                                <p>
                                    المستخدمين

                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('customers.index')}}" class="nav-link">
                                <i class="nav-icon fas fa-user"></i>
                                <p>
                                    العملاء

                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('suppliers.index')}}" class="nav-link">
                                <i class="nav-icon fas fa-user"></i>
                                <p>الموزعون</p>
                            </a>
                        </li>
                    </ul>
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
                        <li class="nav-item">
                            <a href="{{route('expenses.index')}}" class="nav-link">
                                <i class="far fa-chart-bar nav-icon"></i>
                                <p>تقارير عامة</p>
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
                            <a href="{{route('settings.index')}}" class="nav-link">
                                <i class="fas fa-server nav-icon"></i>
                                <p>اعدادات عامة</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('profile.edit.password')}}" class="nav-link">
                                <i class="nav-icon fas fa-user-lock"></i>
                                <p>تغيير كلمة المرور</p>
                            </a>
                        </li>
                    </ul>
                </li>

@endIsAdmin
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
