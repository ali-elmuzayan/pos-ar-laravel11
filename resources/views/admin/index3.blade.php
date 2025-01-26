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


        </div>
    </div>
@endsection


