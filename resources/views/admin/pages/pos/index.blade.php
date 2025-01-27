@extends('layouts.admin')

@section('title', 'نظام البيع')
@section('prev-link', route('dashboard'))
@section('prev-link-title', 'الصفحة الرئيسية')
@section('content-title', 'نظام البيع')
@section('content-page-name', 'نظام البيع')

@section('content')



    <div class="row">
        <div class="col-12">
            <div class="card card-primary card-outline">
                <div class="card-header">
                    <h5 class="card-title">نظام البيع</h5>

                </div>


                <div class="card-body">
                        <form action="{{route('pos.store')}}" id="pos-form" method="post">
                            @csrf
                    <div class="row">
                        <div class="col-md-8">
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fa fa-barcode"></i></span>
                                </div>
                                <input type="text" class="form-control" id="txtbarcode_id" autocomplete="off" name="txtbarcode" autofocus placeholder="ادخل الباركود">
                            </div>

                            <select  style="width: 100%" class="form-control select2" data-dropdown-css-class="select2-purple">
                                <option  selected="selected" disabled>اختر منتج</option>
                                @if(!empty($products))
                                @foreach($products as $product)
                                    <option value="{{$product->id}}" >{{$product->name ?? ''}} ({{$product->code}})</option>

                                @endforeach
                                @else
                                    <option  selected="selected" disabled>لا يوجد منتجات</option>
                                    @endif
                            </select>
                            <br>
                            <div class="tableFixHead">
                                <table id="producttable" class="table table-bordered table-hover">
                                    <thead>
                                    <tr>
                                        <th>اسم المنتج</th>
                                        <th> الكمية المتاحة</th>
                                        <th>السعر (جنيه)</th>
                                        <th>الكمية المضافة</th>
                                        <th>المجموع</th>
                                        <th>حذف</th>
                                    </tr>
                                    </thead>
                                    <tbody class="details" id="itemtable">
                                    <tr data-widget="expandable-table" aria-expanded="false"></tr>
                                    </tbody>

                                </table>
                            </div>


                        </div>

                        <div class="col-md-4">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">الاجمالي (قبل الخصم)</span>
                                </div>
                                <input type="text" class="form-control" name="txtsubtotal"  id="txtsubtotal_id" tabindex="1" readonly >
                                <div class="input-group-append">
                                    <span class="input-group-text">{{$setting->currency ?? 'EGP'}}</span>
                                </div>
                            </div>

                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">الخصم(%)</span>
                                </div>
                                <select class="form-control" name="txtdiscount" id="txtdiscount_p">
                                    <option value="" disabled selected>اختر الخصم</option>
                                    @foreach($discounts as $discount)
                                        <option value="{{$discount->percent}}"
                                            >{{$discount->percent}}</option>
                                    @endforeach
                                </select>
                                <div class="input-group-append">
                                    <span class="input-group-text">%</span>
                                </div>
                            </div>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">الخصم</span>
                                </div>
                                <input type="text" class="form-control" id="txtdiscount_n" readonly >
                                <div class="input-group-append">
                                    <span class="input-group-text">{{$setting->currency ??'EGP'}}</span>
                                </div>
                            </div>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fa fa-phone"></i></span>
                                </div>
                                <input type="text" class="form-control" id="customer_phone" tabindex="2" autocomplete="off" name="customer_phone" placeholder="ادخل رقم الهاتف">
                            </div>
                            <div id="customer_name_container">
                                <!-- Customer name or new input will appear here -->
                            </div>

                            <hr >

                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">الاجمالي</span>
                                </div>
                                <input type="text" class="form-control form-control-lg total" name="txttotal" id="txttotal" readonly >
                                <div class="input-group-append">
                                    <span class="input-group-text">{{$setting->currency}}</span>
                                </div>
                            </div>

                            <hr >
<div class="row ml-3">
    <div class="icheck-success ">
        <input type="radio" name="rb" value="Cash" checked id="radioSuccess1" >
        <label for="radioSuccess1">
            كاش
        </label>
    </div>
    <div class="icheck-primary ml-4">
        <input type="radio" name="rb" value="Card" id="radioSuccess2">
        <label for="radioSuccess2" >
            بطاقة
        </label>
    </div>
</div>

                            <hr >


                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">المتبقي</span>
                                </div>
                                <input type="text" class="form-control" name="txtdue" id="txtdue" readonly >
                                <div class="input-group-append">
                                    <span class="input-group-text">{{$setting->currency ?? 'EGP'}}</span>
                                </div>
                            </div>

                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">المبلغ المدفوع</span>
                                </div>
                                <input type="text" class="form-control"  name="txtpaid" tabindex="4" id="txtpaid">
                                <div class="input-group-append">
                                    <span class="input-group-text">{{$setting->currency ?? 'EGP'}}</span>
                                </div>
                            </div>
                            <hr>

                            <div class="card-footer">



                                <div class="text-center">
                                    <button type="submit" tabindex="5" class="btn btn-primary" name="btnsaveorder" id="submit-button">انشئ فاتورة</button></div>
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

    <!-- Select2 -->
    <link rel="stylesheet" href="{{asset('plugins/select2/css/select2.min.css')}}">
    <link rel="stylesheet" href="{{asset('plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css')}}">

    <!-- iCheck for checkboxes and radio inputs -->
{{--    <link rel="stylesheet" href="{{asset('plugins/icheck-bootstrap/icheck-bootstrap.min.css')}}">--}}
    <!-- SweetAlert2 -->
    <link rel="stylesheet" href="{{asset("plugins/sweetalert2/sweetalert2.min.css")}}">


    {{--    pos special styles--}}
    <link rel="stylesheet" href="{{asset('css/pos.css')}}">
@endpush

@push('js')

    <!-- Select2 -->
    <script src="{{asset('plugins/select2/js/select2.full.min.js')}}"></script>

    <!-- SweetAlert2 -->
    <script src="{{asset('plugins/sweetalert2/sweetalert2.min.js')}}"></script>


{{--    json product --}}
    <script>
        var productRoute = "{{ route('pos.product', ['code' => ':code']) }}";
    </script>
    <script src="{{asset('js/pos/pos.js')}}"></script>
    <script src="{{asset('js/pos/paid.js')}}"></script>
    <script src="{{asset('js/pos/action.js')}}"></script>

    <script>
        // initialize select2
        $('.select2').select2()

        // Initialize select 2 elements
            $('.select2bs4').select2({
                theme: 'bootstrap4'
            })

    </script>



{{--     to check the customer --}}
    <script>
        $(document).ready(function() {
            $('#customer_phone').on('input', function() {
                var phone = $(this).val();

                if (phone.length >= 10) { // Assuming phone numbers are at least 10 digits
                    $.ajax({
                        url: "{{ route('customer.check') }}",
                        type: "GET",
                        data: { phone: phone },
                        success: function(response) {
                            if (response.exists) {
                                $('#customer_name_container').html('<div class="input-group mb-3">' +
                                    '<div class="input-group-prepend">' +
                                    '<span class="input-group-text"><i class="fa fa-user"></i></span>' +
                                    '</div>' +
                                    '<input type="text" class="form-control" id="customer_name" name="customer_name" value="' + response.name + '" readonly>' +
                                    '</div>');
                            } else {
                                $('#customer_name_container').html('<div class="input-group mb-3">' +
                                    '<div class="input-group-prepend">' +
                                    '<span class="input-group-text"><i class="fa fa-user"></i></span>' +
                                    '</div>' +
                                    '<input type="text" class="form-control" id="customer_name" name="customer_name" placeholder="ادخل اسم العميل">' +
                                    '</div>');
                            }
                        },
                        error: function(xhr) {
                            console.log(xhr.responseText);
                        }
                    });
                }
            });
        });
    </script>




@endpush
