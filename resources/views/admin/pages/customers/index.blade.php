@extends('layouts.admin')

@section('title', 'العملاء')
@section('prev-link', route('dashboard'))
@section('prev-link-title', 'الصفحة الرئيسية')
@section('content-title', 'بيانات العملاء')
@section('content-page-name', 'بيانات العملاء')

@section('content')



    <div class="row">
        <div class="col-12">
             <div class="card card-primary card-outline">
                <div class="card-header">
                    <h5 class="card-title">بيانات العملاء</h5>
                </div>
                 <div class="card-body">

                     @if(!empty($customers))
                         <div>

                         </div>
                         <table class="table table-bordered table-hover w-100" id="table_product">
                             <thead>
                             <tr>
                                 <td>#</td>
                                 <td>اسم العميل</td>
                                 <td>رقم الهاتف</td>
                                 <td>العنوان</td>
                                 <td>عدد الاوردرات</td>
                                 <td>المبلغ المدفوع</td>
                                 <td>اول عملية شراء</td>
                                 <td>النشاط</td>
                             </tr>
                             </thead>
                             <tbody>
                             @foreach($customers as $customer)
                                 <tr>
                                 <td>{{$customer->id}}</td>
                                 <td>{{$customer->name ?? 'بدون اسم'}}</td>
                                 <td>{{$customer->phone}}</td>
                                 <td>{{$customer->address ?? 'لا يوجد عنوان'}}</td>
                                 <td>{{$customer->getOrderCount()}}</td>
                                 <td>{{$customer->getTotalAmountPaid()}}</td>
                                 <td>{{$customer->getFormatedCreatedAt()}}</td>
                                <td>
                                     <div class="btn-group">
                                         <a href="{{route('customers.edit', $customer->id)}}" class="btn btn-success btn-xs pr-btn" role="button"><span class="fa fa-edit" style="color:#ffffff" data-toggle="tooltip" title="Edit customer"></span></a>
                                     </div>

                                 </td>
                                 </tr>
                             @endforeach
                             </tbody>

                         </table>

                         <br>
{{--                         {{$customers->links()}}--}}
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
    <!-- DataTables -->
    <link rel="stylesheet" href="{{asset("plugins")}}/datatables-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="{{asset("plugins")}}/datatables-responsive/css/responsive.bootstrap4.min.css">
    <link rel="stylesheet" href="{{asset("plugins")}}/datatables-buttons/css/buttons.bootstrap4.min.css">

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


@endpush
