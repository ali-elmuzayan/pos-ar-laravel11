@extends('layouts.admin')

@section('title', 'طباعة الباركود')
@section('main-color', 'info')
@section('prev-link', route('products.index'))
@section('prev-link-title', 'المنتجات')
@section('content-title', 'طباعة الباركود')
@section('content-page-name', 'طباعة الباركود')

@section('content')



    <div class="row">
        <div class="col-12">
            <div class="card card-info card-outline">
                <div class="card-header">
                    <h5 class="card-title">طباعة البركود</h5>

                </div>
                <div class="card-body">

                    @if(!empty($product))
                        <div class="row">
                            <div class="col-md-6">

                                <ul class="list-group">

                                    <center><p class="list-group-item list-group-item-info"><b>تفاصيل المنتج</b></p></center>
                                    <form action="{{route('barcode.print')}}" method="post">
                                        @csrf
                                    <div class="form-group">
                                        <label class="control-label col-sm-2" for="product">المنتج</label>
                                        <div class="col-sm-10">
                                            <input autocomplete="OFF" type="text" class="form-control" value="{{$product->name}}" id="product" name="product" readonly>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label col-sm-2" for="product_id">الباركود</label>
                                        <div class="col-sm-10">
                                            <input autocomplete="OFF" type="text" class="form-control" value="{{$product->code}}" id="barcode" name="barcode" readonly>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label col-sm-2" for="rate">السعر</label>
                                        <div class="col-sm-10">
                                            <input autocomplete="OFF" type="text" class="form-control" value="{{$product->selling_price}}" id="rate"  name="rate" readonly>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label col-sm-2" for="rate">الكمية المتاحة</label>
                                        <div class="col-sm-10">
                                            <input autocomplete="OFF" type="text" class="form-control" value="{{$product->stock}}" id="stock"  name="stock" readonly>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label col-sm-2" for="print_qty">كمية التي تريد طباعتها</label>
                                        <div class="col-sm-10">
                                            <input autocomplete="OFF" type="number" placeholder="بحد اقصى 50 باركود" min="1" max="50" class="form-control" id="print_qty"  name="amount" required>
                                        </div>
                                        @error('amount')<span class="text-danger">{{$message}}</span>@enderror
                                    </div>
                                    <div class="form-group">
                                        <div class="col-sm-offset-2 col-sm-10">
                                            <button type="submit" class="btn btn-info">انشاء الباركود</button>
                                        </div>
                                    </div>
                                    </form>
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
