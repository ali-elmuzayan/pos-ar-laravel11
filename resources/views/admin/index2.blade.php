@extends('layouts.admin')

@section('title', 'الصفحة الرئيسية')
@section('content-title', 'الصفحة الرئيسية')
@section('content-page-name', 'الصفحة الرئيسية')

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <!-- Small Boxes -->
            <div class="row">
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-info">
                        <div class="inner">
{{--                            <h3>{{ $totalOrders }}</h3>--}}
                            <p>عدد الطلبات هذا الشهر</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-bag"></i>
                        </div>
                        <a href="{{ route('orders.index') }}" class="small-box-footer">
                            <i class="fas fa-arrow-circle-left"> جميع الطلبات</i>
                        </a>
                    </div>
                </div>
                <!-- Repeat for other small boxes -->
            </div>

            <!-- Charts -->
            <div class="card card-primary card-outline">
                <div class="card-header">
                    <h5 class="m-0">Total Orders and Profit by Month</h5>
                </div>
                <div class="card-body">
                    <canvas id="ordersChart" style="height: 250px;"></canvas>
                    <canvas id="profitChart" style="height: 250px; margin-top: 20px;"></canvas>
                </div>
            </div>
        </div>
    </div>
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
        });
    </script>
@endpush
