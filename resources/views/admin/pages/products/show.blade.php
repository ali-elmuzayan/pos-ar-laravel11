@extends('layouts.admin')

@section('title', 'عرض المنتجات')
@section('main-color', 'info')
@section('prev-link', route('products.index'))
@section('prev-link-title', 'المنتجات')
@section('content-title', 'عرض المنتج')
@section('content-page-name', 'عرض المنتج')

@section('content')



    <div class="row">
        <div class="col-12">
             <div class="card card-info card-outline">
                <div class="card-header">
                    <h5 class="card-title">عرض المنتج</h5>

                </div>
                 <div class="card-body">

                     @if(!empty($product))
                         <div class="row">
                             <div class="col-md-6">

                                 <ul class="list-group">

                                     <center><p class="list-group-item list-group-item-info"><b>تفاصيل المنتج</b></p></center>

                                     <li class="list-group-item"><b>الباركود</b> <span class="badge badge-light float-right">{!! $barcode !!}<br>{{$product->code}}</span></li>
                                     <li class="list-group-item"><b>اسم المنتج</b><span class="badge badge-light float-right">{{$product->name}}</span></li>
                                     <li class="list-group-item"><b>الفئة التابع لها</b> <span class="badge badge-light float-right">{{$product->category->name}}</span></li>
                                     <li class="list-group-item"><b>الموزع</b> <span class="badge badge-light float-right">{{$product->supplier->name}}</span></li>
                                     <li class="list-group-item"><b>الوصف</b><span id="show-description" class=" float-right">{{$product->description ?? 'لا يوجد وصف لهذا لامنتج'}}</span></li>
                                     <li class="list-group-item"><b>الكمية المتاحة</b> <span  class="badge @if($product->stock > 5)badge-success @else badge-danger @endif float-right">{{$product->stock}}</span></li>
                                     @isAdmin
                                     <li class="list-group-item"><b>سعر الشراء</b><span class="badge  badge-secondary float-right">{{$product->buying_price}}</span></li>
                                     @endIsAdmin
                                     <li class="list-group-item"><b>سعر البيع</b> <span class="badge badge-secondary float-right">{{$product->selling_price}}</span></li>
                                     @isAdmin
                                     <li class="list-group-item"><b>المكسب</b> <span class="badge @if($profit > 20)badge-success @else badge-danger @endif float-right">{{$profit}}</span></li>
                                     <li class="list-group-item"><b>المكسب الكلي</b> <span class="badge @if($product->totalProfit() < 0)badge-success @else badge-danger @endif float-right">{{$product->totalProfit()}}</span></li>
                                     <li class="list-group-item"><b>تم انشاءه في</b> <span class="badge badge-dark float-right">{{$created_at}}</span></li>
                                     <li class="list-group-item"><b>اخر تعديل في</b> <span class="badge badge-dark float-right">{{$updated_at}}</span></li>
                                     @endIsAdmin
                                 </ul>
                             </div>

                             <div class="col-md-6">
                                 <ul class="list-group">
                                     <center><p class="list-group-item list-group-item-info"><b>صورة المنتج</b></p></center>
                                     <img src="{{$product->image ? asset($product->image) : url('uploads/no_image.jpg') }}" class="img-thumbnail"/>
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

