@extends('layouts.admin')

@section('title', 'عرض تفاصيل الطلب')
@section('main-color', 'success')
@section('prev-link', url()->previous())
@section('prev-link-title', 'الطلبات')
@section('content-title', 'عرض الطلب')
@section('content-page-name', 'عرض الطلب')

@section('content')



    <div class="row">
        <div class="col-12">
            <div class="card card-success card-outline">
                <div class="card-header">
                    <h5 class="card-title">عرض الطلب</h5>

                </div>
                <div class="card-body">

                    @if(!empty($order))
                        <div class="row">
                            <div class="col-md-6">

                                <ul class="list-group">

                                    <center><p class="list-group-item list-group-item-success"><b>بيانات الطلب</b></p></center>

                                    <li class="list-group-item"><b>الباركود</b> <span class="badge badge-light float-right">{!! $barcode !!}<br>{{$order->invoice_no}}</span></li>
                                    <li class="list-group-item"><b>عدد المنتجات المنتج</b><span class="badge badge-light float-right">{{$order->total_products}}</span></li>
                                    <li class="list-group-item"><b>رقم العميل </b> <span class="badge badge-light float-right">{{$order->customer->phone ?? 'بدون عميل'}}</span></li>
                                   @if(!empty($order->customer->phone)) <li class="list-group-item"><b>اسم العميل</b> <span class="badge badge-light float-right">{{$order->customer->name ?? 'بدون اسم'}}</span></li>@endif
                                    <li class="list-group-item"><b>حالة الطلب</b> <span class="badge badge-light float-right">{{$order->order_status ? 'تم الاسترجاع او الاستبدال' : 'لم يتم التعديل'}}</span></li>
                                    <li class="list-group-item"><b> المبلغ المدفوع</b> <span  class="badge float-right">{{$order->pay}}</span></li>
                                    <li class="list-group-item"><b>المبلغ المتبقي</b><span id="show-description" class=" float-right">{{$order->due}}</span></li>
                                    <li class="list-group-item"><b> السعر قبل الخصم</b> <span class="badge  float-right">{{$order->sub_total}}</span></li>
                                    <li class="list-group-item"><b>المبلغ المخصوم (الخصم)</b> <span class="badge  float-right">{{$order->sub_total - $order->total_price}} ({{(int) ($order->discount)}}%)</span></li>
                                    <li class="list-group-item"><b>المكسب الكلي</b> <span class="badge  float-right">{{$order->total_price}}</span></li>
                                    <li class="list-group-item"><b>تم انشاءه في</b> <span class="badge badge-dark float-right">{{$order->created_at->diffForHumans()}}</span></li>
                                    <li class="list-group-item"><b>اخر تعديل في</b> <span class="badge badge-dark float-right">{{$order->updated_at->diffForHumans()}}</span></li>
{{--                                 --}}
                                </ul>
                            </div>

                            <div class="col-md-6">
                                <ul class="list-group">
                                    <center><p class="list-group-item list-group-item-dark"><b>تفاصيل الطلب</b></p></center>
                                        <table class="table table-bordered table-hover w-100 ">
                                            <thead>
                                            <tr>
                                                <td>#</td>
                                                <td>اسم المنتج</td>
                                                <td>الكمية</td>
                                                <td>المكسب الكلي</td>
                                                <td>سعر القطعة</td>
                                                <td>صافي الربح</td>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @php $counter = 1; @endphp
                                            @foreach($order->orderDetails as $orderDetail)
                                                <tr>
                                                    <td>{{$counter++}}</td>
                                                    <td>{{$orderDetail->product->name}}</td>
                                                    <td>{{$orderDetail->quantity}}</td>
                                                    <td>{{$orderDetail->total_cost}}</td>
                                                    <td>{{$orderDetail->unit_cost}}</td>
                                                    <td>{{$orderDetail->total_profit}}</td>

                                                </tr>
                                            @endforeach
                                            </tbody>

                                        </table>


                                </ul>
                            </div>
                        </div>
                    @else
                        <div class="alert alert-danger" style="opacity:75%;">
                            عفوا لا يوجد بيانات لعرضها
                        </div>
                    @endif




                </div>


            </div>
        </div>
    </div>

@endsection

