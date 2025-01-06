<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="index3.html" class="brand-link">
        <img src="{{asset("dist")}}/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
             style="opacity: .8">
        <span class="brand-text font-weight-light"><strong>7star</strong> POS</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image ">
                <img src="{{asset("dist/img/user2-160x160.jpg")}}" class="img-circle elevation-2" alt="User Image">
            </div>
            <div class="info">
                <a href="#" class="d-block">مرحبا  @isset(\Auth::user()->name){{Auth::user()->name}} @else user @endif</a>
            </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <!-- Add icons to the links using the .nav-icon class
                     with font-awesome or any other icon font library -->
                <li class="nav-item">
                    <a href="{{route('dashboard')}}" class="nav-link">
                        <i class="nav-icon fas fa-th"></i>
                        <p>
                            الضبط العام
                            {{--                            <span class="right badge badge-danger">New</span>--}}
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>
                            الصفحة الرئيسة

                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="category.php" class="nav-link">
                        <i class="nav-icon fas fa-table"></i>
                        <p>
                            الفئات

                        </p>
                    </a>
                </li>


                <li class="nav-item">
                    <a href="addproduct.php" class="nav-link">
                        <i class="nav-icon fas fa-edit"></i>
                        <p>
                            اضافة منتج

                        </p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="productlist.php" class="nav-link">
                        <i class="nav-icon fas fa-list"></i>
                        <p>
                           المنتجات

                        </p>
                    </a>
                </li>





                <li class="nav-item">
                    <a href="pos.php" class="nav-link">
                        <i class="nav-icon fas fa-book"></i>
                        <p>
                            نقطة البيع

                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="orderlist.php" class="nav-link">
                        <i class="nav-icon fas fa-list"></i>
                        <p>
                            قائمة الطلبات

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
                            <a href="tablereport.php" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Table Report</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="graphreport.php" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Graph Report</p>
                            </a>
                        </li>
                    </ul>
                </li>



                <li class="nav-item">
                    <a href="taxdis.php" class="nav-link">
                        <i class="nav-icon fas fa-calculator"></i>
                        <p>
                            الضرائب والقيمة المضافة

                        </p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="registration.php" class="nav-link">
                        <i class="nav-icon far fa-plus-square"></i>
                        <p>
                            اضافة مستخدم

                        </p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="changepassword.php" class="nav-link">
                        <i class="nav-icon fas fa-user-lock"></i>
                        <p>
                            تغيير الباسورد

                        </p>
                    </a>
                </li>


                <li class="nav-item">
                    <a href="logout.php" class="nav-link">
                        <i class="nav-icon fas fa-sign-out-alt"></i>
                        <p>
                            تسجيل الخروج

                        </p>
                    </a>
                </li>
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
