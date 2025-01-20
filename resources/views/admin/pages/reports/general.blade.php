@extends('layouts.admin')

@section('title', 'تقارير الطلبات')
@section('prev-link', route('dashboard'))
@section('prev-link-title', 'الصفحة الرئيسية')
@section('main-color', 'warning')
@section('content-title', 'تقارير العامة')
@section('content-page-name', 'التقارير العامة')

@section('content')



    <div class="row">
        <div class="col-12">
            <div class="card card-warning card-outline">
                <div class="card-header">
                    <h5 class="card-title">التقارير العامة</h5>

                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-5">
                            <div class="form-group">
                                <!-- <label>Date:</label> -->
                                <div class="input-group date" id="date_1" data-target-input="nearest">
                                    <input type="text" class="form-control date_1" data-target="#date_1" name="date_1"/>
                                    <div class="input-group-append" data-target="#date_1" data-toggle="datetimepicker">
                                        <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                    </div>
                                </div>
                            </div>

                        </div>

                        <div class="col-md-5">
                            <div class="form-group">
                                <!-- <label>Date:</label> -->
                                <div class="input-group date" id="date_2" data-target-input="nearest">
                                    <input type="text" class="form-control date_2" data-target="#date_2"  name="date_2"/>
                                    <div class="input-group-append" data-target="#date_2" data-toggle="datetimepicker">
                                        <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                    </div>
                                </div>
                            </div>



                        </div>

                        <div class="col-md-2">

                            <div class="text-center">
                                <button type="submit" class="btn btn-warning" name="btnfilter">اظهر النتائج</button></div>
                        </div>
                    </div>

                    @if(!empty($data))
                        <table class="table table-bordered table-hover " id="table_product">
                            <thead>
                            <tr>
                                <td>رقم الاوردر</td>
                                <td>التكلفة</td>
                                <td>الربح</td>
                                <td>المبلغ كامل</td>
                                <td>عدد المنتجات</td>
                                <td>العميل</td>
                                <td>المبلغ المخصوم</td>
                                <td>طريقة البيع</td>
                                <td>تاريخ الاوردر</td>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($data as $info)
                                <tr>
                                    <td>{{$info->id}}</td>
                                    <td>{{$info->code}}</td>
                                    <td>{{$info->name}}</td>
                                    <td>{{$info->category->name}}</td>
                                    <td><div>
                                            {{ Str::limit($info->description, 20, '...') ?? 'لا يوجد وصف' }}
                                        </div></td>
                                    <td>{{$info->stock}}</td>
                                    <td>{{$info->buying_price}}</td>
                                    <td>{{$info->selling_price}}</td>
                                    <td><img src="{{ $info->image ? asset('uploads/' . $info->image) : url('uploads/no_image.jpg')}}" alt="" width="30" height="30"></td>
                                    <td>
                                        <div class="btn-group">
                                            <a href="{{route('barcode.product.show', $info->id)}}" class="btn btn-dark btn-xs pr-btn" role="button"><span class="fa fa-barcode" style="color:#ffffff" data-toggle="tooltip" title="PrintBarcode"></span></a>
                                            <a href="{{route('products.show', $info->id)}}" class="btn btn-warning btn-xs pr-btn" role="button"><span class="fa fa-eye" style="color:#ffffff" data-toggle="tooltip" title="View Product"></span></a>
                                            <a href="{{route('products.edit', $info->id)}}" class="btn btn-success btn-xs pr-btn" role="button"><span class="fa fa-edit" style="color:#ffffff" data-toggle="tooltip" title="Edit Product"></span></a>
                                            <button id='{{$info->id}}'  class="btn btn-danger btn-xs btndelete pr-btn"><span class="fa fa-trash" style="color:#ffffff" data-toggle="tooltip" title="Delete Product"></span></button>


                                        </div>

                                    </td>
                                </tr>
                            @endforeach
                            </tbody>

                        </table>

                        <br>
                        {{--                         {{$data->links()}}--}}
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

@push('css')


    <!-- daterange picker -->
    <link rel="stylesheet" href="{{asset("plugins")}}/daterangepicker/daterangepicker.css">

    <!-- Tempusdominus Bootstrap 4 -->
    <link rel="stylesheet" href="{{asset("plugins")}}/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">


    <!-- DataTables -->
    <link rel="stylesheet" href="{{asset("plugins")}}/datatables-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="{{asset("plugins")}}/datatables-responsive/css/responsive.bootstrap4.min.css">
    <link rel="stylesheet" href="{{asset("plugins")}}/datatables-buttons/css/buttons.bootstrap4.min.css">

    <!-- SweetAlert2 -->
    <link rel="stylesheet" href="{{asset("plugins/sweetalert2/sweetalert2.min.css")}}">

@endpush

@push('js')

    <!-- DataTables  & Plugins -->
    <script src="{{asset("plugins")}}/datatables/jquery.dataTables.min.js"></script>
    <script src="{{asset("plugins")}}/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
    <script src="{{asset("plugins")}}/datatables-responsive/js/dataTables.responsive.min.js"></script>
    <script src="{{asset("plugins")}}/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
    <script src="{{asset("plugins")}}/datatables-buttons/js/dataTables.buttons.min.js"></script>
    <script src="{{asset("plugins")}}/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
    <script src="{{asset("plugins")}}/jszip/jszip.min.js"></script>
    <script src="{{asset("plugins")}}/pdfmake/pdfmake.min.js"></script>
    <script src="{{asset("plugins")}}/pdfmake/vfs_fonts.js"></script>
    <script src="{{asset("plugins")}}/datatables-buttons/js/buttons.html5.min.js"></script>
    <script src="{{asset("plugins")}}/datatables-buttons/js/buttons.print.min.js"></script>
    <script src="{{asset("plugins")}}/datatables-buttons/js/buttons.colVis.min.js"></script>


    <!-- InputMask -->
    <script src="{{asset("plugins")}}/moment/moment.min.js"></script>

    <!-- date-range-picker -->
    <script src="{{asset("plugins")}}/daterangepicker/daterangepicker.js"></script>

    <!-- Tempusdominus Bootstrap 4 -->
    <script src="{{asset("plugins")}}/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>




    <script>
        $(document).ready(function() {
            $('#table_product').DataTable();
        });
    </script>

    <script>
        $(document).ready(function() {
            $('[data-toggle="tooltip"], .tooltip-container').tooltip();
        });
    </script>

    <script>

        //Date picker
        $('#date_1').datetimepicker({
            format: 'YYYY-MM-DD'
        });



        //Date picker
        $('#date_2').datetimepicker({
            format: 'YYYY-MM-DD'
        });




    </script>

@endpush
