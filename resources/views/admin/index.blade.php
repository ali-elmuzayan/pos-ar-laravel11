@extends('layouts.admin')

@section('title', '7Star system')
@section('content-title', 'الصفحة الرئيسية')
@section('content-page-name', 'الصفحة الرئيسية')

@section('content')

    <div class="row">
        <div class="col-lg-12">



            <div class="row">
                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-info">
                        <div class="inner">
                            <h3>{{$totalOrders}}</h3>

                            <p>عدد الطلبات هذا الشهر</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-bag"></i>
                        </div>
                        <a href="{{route('orders.index')}}" class="small-box-footer"><i class="fas fa-arrow-circle-left">  جميع الطلبات</i></a>
                    </div>
                </div>
                <!-- ./col -->
                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-success">
                        <div class="inner">
                        {{--                            <h3><?php echo number_format($grand_total,2); ?></h3>--}}
                            <h3>{{$newCustomers}}</h3>
                            <p>عدد الزبائن الجدد</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-stats-bars"></i>
                        </div>
                        <a href="{{route('orders.index')}}" class="small-box-footer"><i class="fas fa-arrow-circle-left"> الزبائن الجدد </i></a>
                    </div>
                </div>
                <!-- ./col -->
                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-warning">
                        <div class="inner">
                            <h3>{{$totalProducts}}</h3>

                            <p>عدد المنتجات التي تم بيعها</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-person-add"></i>
                        </div>
                        <a href="{{route('orders.index')}}" class="small-box-footer"><i class="fas fa-arrow-circle-left">  جميع المنتجات </i></a>
                    </div>
                </div>
                <!-- ./col -->
                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-danger">
                        <div class="inner">
                            <h3>{{$totalProfit}}</h3>

                            <p>صافي الارباح</p>
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










            <div class="card card-primary card-outline">
                <div class="card-header">
                    <h5 class="m-0">Earning By Date</h5>
                </div>
                <div class="card-body">
                        <canvas id="myChart" style="height: 250px"></canvas>
                </div>
            </div>

        </div>

    </div>

<!-- /.row -->
@endsection

@push('js')
    <!-- ChartJS -->
    <script src="{{asset('plugins/chart.js/Chart.min.js')}}"></script>

    <script>
        $(document).ready(function() {
            $('#table_recentorder').DataTable({

                "order":[[0,"desc"]]
            });
        });
    </script>
@endpush
{{--
       <script>
                    const ctx = document.getElementById('myChart');

                    new Chart(ctx, {
                        type: 'bar',
                        data: {
                            labels: <?php echo json_encode($date);?>,
                            datasets: [{
                                label: 'Total Earning',
                                backgroundColor:'rgb(255,99,132)',
                                borderColor:'rgb(255,99,132)',
                                data: <?php echo json_encode($ttl);?>,
                                borderWidth: 1
                            }]
                        },
                        options: {
                            scales: {
                                y: {
                                    beginAtZero: true

                                }
                            }
                        }
                    });
                </script>
--}}
