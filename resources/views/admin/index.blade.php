@extends('layouts.admin')

@section('title', 'الصفحة الرئيسية')
@section('main-color', 'info')
@section('content-title', 'الصفحة الرئيسية')
@section('content-page-name', 'الصفحة الرئيسية')

@section('content')

    <div class="row">
        <div class="col-lg-12">



            <div class="row">
                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-card">
                        <div class="inner  text-center">
                            <h3>{{$currentMonthOrders}}</h3>

                            <p>عدد الطلبات هذا الشهر</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-bag"></i>
                        </div>
                        <a href="{{route('orders.index')}}" class="small-box-footer"><i class="fas fa-arrow-circle-left">  جميع الطلبات</i></a>
                    </div>
                </div>
                <!-- ./col -->
                <div class="col-lg-3 col-6 ">
                    <!-- small box -->
                    <div class="small-box bg-card">
                        <div class="inner  text-center">
                        {{--                            <h3><?php echo number_format($grand_total,2); ?></h3>--}}
                            <h3>{{$newCustomers}}</h3>
                            <p>عدد الزبائن الجدد</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-stats-bars"></i>
                        </div>
                        <a href="{{route('customers.index')}}" class="small-box-footer"><i class="fas fa-arrow-circle-left"> الزبائن الجدد </i></a>
                    </div>
                </div>
                <!-- ./col -->
                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-card">
                        <div class="inner text-center" >
                            <h3 >{{$totalProducts}}</h3>

                            <p>عدد المنتجات التي تم بيعها اليوم</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-person-add"></i>
                        </div>
                        <a href="{{route('products.index')}}" class="small-box-footer"><i class="fas fa-arrow-circle-left">  جميع المنتجات </i></a>
                    </div>
                </div>
                <!-- ./col -->
                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-card">
                        <div class="inner  text-center">
                            <h3 >{{$profitAmount}}</h3>

                            <p>الارباح اليوم</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-pie-graph"></i>
                        </div>
                        <a href="{{route('reports.orders')}}" class="small-box-footer"><i class="fas fa-arrow-circle-left"> رؤية التقارير </i></a>
                    </div>
                </div>
                <!-- ./col -->
            </div>
            <!-- /.row -->

                <!-- Charts -->
            <div class="card mt-3">

                <h2 class="ml-5 font-weight-light mt-3 mb-2">الاحصائيات الشهرية والسنوية ({{ date('Y') }})</h2>
                <div class="card-body">
                    <div class=" mt-2 row justify-content-between align-items-center">
                        <div class="col-md-6  ">
                            <canvas id="ordersChart" class="w-100"></canvas>
                        </div>
                        <div class=" col-md-6 text-center">
                            <h5 class="font-weight-light mb-3">الطلبات و المرتجعات الحالية</h5>
                            <canvas id="customerChart" class="w-100 h-100"></canvas>
                        </div>
                    </div>
                    <div class="mt-2 row justify-content-between align-items-center mb-4">
                        <div class="col-md-6   mt-5 text-center">
                            <h5 class="font-weight-light mb-3">اجمالي الارباح والنفقات الشهرية</h5>
                            <canvas id="expensesProfitChart" class="w-100 h-100"></canvas>
                        </div>
                        <div class="col-md-6  mt-5">
                            <canvas id="profitChart" class="w-100"></canvas>
                        </div>
                    </div>
                </div>
            </div>


        </div>

    </div>

<!-- /.row -->
@endsection
@push('js')
    <!-- ChartJS -->
    <script src="{{ asset('plugins/chart.js/Chart.min.js') }}"></script>

    <script>
        $(document).ready(function () {
            // Data for the charts
            const months = @json($months);
            const totalOrders = @json($totalOrders);
            const totalProfit = @json($totalProfit);

            // Total Orders Chart
            const ordersCtx = document.getElementById('ordersChart').getContext('2d');
            new Chart(ordersCtx, {
                type: 'bar',
                data: {
                    labels: months,
                    datasets: [{
                        label: 'إجمالي الطلبات', // Arabic label
                        backgroundColor: 'rgba(54, 162, 235, 0.2)',
                        borderColor: 'rgba(54, 162, 235, 1)',
                        borderWidth: 1,
                        data: totalOrders,
                    }]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true,
                            title: {
                                display: true,
                                text: 'إجمالي الطلبات' // Arabic title
                            }
                        },
                        x: {
                            title: {
                                display: true,
                                text: 'الشهر' // Arabic title
                            }
                        }
                    }
                }
            });

            // Total Profit Chart
            const profitCtx = document.getElementById('profitChart').getContext('2d');
            new Chart(profitCtx, {
                type: 'line',
                data: {
                    labels: months,
                    datasets: [{
                        label: 'إجمالي الأرباح', // Arabic label
                        backgroundColor: 'rgba(255, 99, 132, 0.2)',
                        borderColor: 'rgba(255, 99, 132, 1)',
                        borderWidth: 1,
                        data: totalProfit,
                    }]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true,
                            title: {
                                display: true,
                                text: 'إجمالي الأرباح' // Arabic title
                            }
                        },
                        x: {
                            title: {
                                display: true,
                                text: 'الشهر' // Arabic title
                            }
                        }
                    }
                }
            });

            // Customer Orders and Returns Pie Chart
            const customerCtx = document.getElementById('customerChart').getContext('2d');
            new Chart(customerCtx, {
                type: 'pie',
                data: {
                    labels: ['الطلبات', 'المرتجعات'], // Arabic labels
                    datasets: [{
                        label: 'الطلبات والمرتجعات', // Arabic label
                        data: [@json($currentMonthOrders), @json($currentMonthReturns)], // Data for orders and returns
                        backgroundColor: [
                            'rgb(54, 162, 235)', // Blue for orders
                            'rgb(255, 99, 132)'  // Red for returns
                        ],
                        hoverOffset: 4
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            position: 'top',
                        },
                        title: {
                            display: true,
                            text: 'الطلبات والمرتجعات لهذا الشهر' // Arabic title
                        }
                    }
                }
            });
            // Expenses and Profit Doughnut Chart
            const expensesProfitCtx = document.getElementById('expensesProfitChart').getContext('2d');
            new Chart(expensesProfitCtx, {
                type: 'doughnut',
                data: {
                    labels: ['المصروفات', 'الأرباح'], // Arabic labels
                    datasets: [{
                        label: 'المصروفات والأرباح', // Arabic label
                        data: [@json($currentMonthExpenses), @json($currentMonthProfit)], // Data for expenses and profit
                        backgroundColor: [
                            'rgb(63, 167, 178)', // Green for profit
                            'rgb(75, 84, 92)'// Red for expenses
                        ],
                        hoverOffset: 4
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            position: 'top',
                        },
                        title: {
                            display: true,
                            text: 'المصروفات والأرباح لهذا الشهر' // Arabic title
                        }
                    }
                }
            });
        });
    </script>
@endpush



