@extends('layouts.admin')

@section('title', 'نظام المرتجع')
@section('prev-link', route('dashboard'))
@section('prev-link-title', 'الصفحة الرئيسية')
@section('content-title', 'نظام المرتجع')
@section('content-page-name', 'نظام البيع')

@section('content')



    <div class="row">
        <div class="col-12">
            <div class="card card-primary card-outline">
                <div class="card-header">
                    <h5 class="card-title">نظام البيع</h5>

                </div>

                <div class="card-body">
                    <form action="{{route('pos.update', $order->id)}}" id="pos-form" method="post">
                        @method('PUT')
                        @csrf
                        <div class="row">
                            <div class="col-md-8">
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fa fa-barcode"></i></span>
                                    </div>
                                    <input type="text" class="form-control" id="barcodeScanner" autocomplete="off" name="barcodeScanner" autofocus placeholder="ادخل الباركود">
                                </div>

                                <br>
                                <div class="tableFixHead">
                                    <table id="producttable" class="table table-bordered table-hover">
                                        <thead>
                                        <tr>
                                            <th>اسم المنتج</th>
                                            <th>الباركود</th>
                                            <th>السعر (جنيه)</th>
                                            <th>الكمية المضافة</th>
                                            <th>المجموع</th>
                                            <th>حذف</th>
                                        </tr>
                                        </thead>
                                        <tbody class="details" id="itemtable">
                                        <tr data-widget="expandable-table" aria-expanded="false">

                                        </tr>
                                        @foreach($order->orderDetails as $orderDetails)
                                            @if($orderDetails->validToReturn())
                                            <tr class="text-center">
                                                <input type="hidden" class="form-control barcode" name="barcode_arr[]" value="{{ $orderDetails->product->code }}">

                                                <td class="product-input">
                                                    <span class="badge product_c">{{$orderDetails->product->name ?? 'بدون اسم'}}</span>
                                                    <input type="hidden" name="product_id[]" class="form-control pid" value="{{$orderDetails->product->id}}">
                                                    <input type="hidden" name="returnQty[]" class="returnQty" value="0">
                                                    <input type="hidden"  id="order-detail_id" value="{{$orderDetails->id}}">
                                                </td>

                                                <td class="product-input">
                                                    <span class="badge ">{{$orderDetails->product->code}}</span>
                                                </td>

                                                <td class="product-input">
                                                    <span class="badge price">{{$orderDetails->unit_cost}}</span>
                                                </td>

                                                <td>
                                                    <input type="number" class="form-control qty" readonly value="{{$orderDetails->validQtyToReturn()}}">
                                                </td>

                                                <td style="text-align:left; vertical-align:middle; font-size:17px;">
                                                    <span class="badge totalAmount">{{$orderDetails->total_cost}}</span>
                                                    <input type="hidden" class="form-control saleprice" name="saleprice_arr[]" value="{{$orderDetails->total_cost}}">
                                                </td>

                                                <td>
                                                    <button type="button" name="remove" class="btn btn-danger btn-sm btnremove">
                                                        <span class="fas fa-trash"></span>
                                                    </button>
                                                </td>
                                            </tr>
                                            @endif
                                        @endforeach
                                        <tr>
                                            <td>
                                                <input type="hidden" name="return_details[]" id="returnDetailsInput">
                                                <input type="hidden" name="return_quantities" id="returnQuantities">
                                            </td>
                                        </tr>


                                        </tbody>

                                    </table>
                                </div>


                            </div>

                            <div class="col-md-4">
                                @if($order->order_status)
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" style="width:160px">مبلغ مسترد مسبقا</span>
                                    </div>
                                    <input type="text" class="form-control" id="subtotalInput" value="{{$order->returnedMoney()}}" readonly >
                                    <div class="input-group-append">
                                        <span class="input-group-text">{{$setting->currency ?? 'EGP'}}</span>
                                    </div>
                                </div>
                                @endif
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" style="width:160px">الاجمالي (قبل الخصم)</span>
                                    </div>
                                    <input type="text" class="form-control" name="subtotalInput"  id="subtotalInput" value="{{$order->sub_total}}" tabindex="1" readonly >
                                    <div class="input-group-append">
                                        <span class="input-group-text">{{$setting->currency ?? 'EGP'}}</span>
                                    </div>
                                </div>

                                <div class="input-group">
                                    <div class="input-group-prepend " >
                                        <span class="input-group-text" style="width:160px">الخصم(%)</span>
                                    </div>
                                    <input class="form-control" name="discount" id="discountInput" value="%{{(int)$order->discount}}" readonly>
                                    <div class="input-group-append">
                                        <span class="input-group-text">%</span>
                                    </div>
                                </div>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" style="width:160px">الخصم</span>
                                    </div>
                                    <input type="text" class="form-control" id="discountInputValue" value="{{($order->discount != 0) ? ($order->sub_total / $order->discount) : 0}}" readonly >
                                    <div class="input-group-append">
                                        <span class="input-group-text">{{$setting->currency ??'EGP'}}</span>
                                    </div>
                                </div>
                                <div class="input-group">
                                    <div class="input-group-prepend ">
                                        <span class="input-group-text " style="width:160px" >خصم اضافي (كاش)</span>
                                    </div>
                                    <input type="number" class="form-control" id="cashDiscountInput"  value="{{$order->cash_discount}}"  name="cash_discount" readonly>
                                    <div class="input-group-append">
                                        <span class="input-group-text">{{$setting->currency ??'EGP'}}</span>
                                    </div>
                                </div>

                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" style="width:160px;"><i class="fa fa-phone"></i></span>
                                    </div>
                                    <input type="text" class="form-control" value="{{$order->customer->phone ?? 'بدون عميل'}}" readonly id="customer_phone" tabindex="2" autocomplete="off" name="customer_phone" placeholder="ادخل رقم الهاتف">
                                </div>
                                <div id="customer_name_container">
                                    <!-- Customer name or new input will appear here -->
                                </div>

                                <hr >

                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" style="width:160px;">الاجمالي</span>
                                    </div>
                                    <input type="text" class="form-control form-control-lg total" name="totalInput" id="totalInput" value="{{$order->total_price}}" readonly >
                                    <div class="input-group-append">
                                        <span class="input-group-text">{{$setting->currency}}</span>
                                    </div>
                                </div>

                                <hr >

                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" style="width:160px;">المبلغ المسترد</span>
                                    </div>
                                    <input type="text" class="form-control" id="returnedMoney" readonly  name="returnedMoney" tabindex="4">
                                    <div class="input-group-append">
                                        <span class="input-group-text">{{$setting->currency ?? 'EGP'}}</span>
                                    </div>
                                </div>
                                <hr>

                                <div class="card-footer">



                                    <div class="text-center">
                                        <button type="submit" tabindex="5" class="btn btn-primary" name="btnsaveorder" id="submit-button">انشئ  المرتجع</button></div>
                                </div>


                            </div>

                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>

@endsection
@push('css')

    <!-- SweetAlert2 -->
    <link rel="stylesheet" href="{{asset("plugins/sweetalert2/sweetalert2.min.css")}}">


    {{--    pos special styles--}}
    <link rel="stylesheet" href="{{asset('css/pos.css')}}">
    <link rel="stylesheet" href="{{asset('css/mycustomstyle.css')}}">
@endpush

@push('js')
    <script>
        const returnsUrl = {{route('pos.return', $order->id)}};
    </script>

    <!-- SweetAlert2 -->
    <script src="{{asset('plugins/sweetalert2/sweetalert2.min.js')}}"></script>
    <script src="{{asset('js/returns/add-return-item.js')}}"></script>
@endpush
