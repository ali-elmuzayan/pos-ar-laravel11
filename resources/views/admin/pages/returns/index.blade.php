@extends('layouts.admin')

@section('title', 'المرتجعات')
@section('prev-link', route('dashboard'))
@section('prev-link-title', 'الصفحة الرئيسية')
@section('content-title', 'بيانات المرتجعات')
@section('content-page-name', 'بيانات المرتجعات')

@section('content')



    <div class="row">
        <div class="col-12">
             <div class="card card-primary card-outline">
                <div class="card-header">
                    <h5 class="card-title">عمليات الاسترجاع</h5>
                </div>
                 <div class="card-body">

                     @if(!empty($returns))
                         <div>

                         </div>
                         <table class="table table-bordered table-hover w-100" id="table_product">
                             <thead>
                             <tr>
                                 <td>#</td>
                                 <td>المنتج</td>
                                 <td>رقم الاوردر</td>
                                 <td>العميل</td>
                                 <td>الكمية</td>
                                 <td>المبلغ المستحق</td>
                                 <td>بواسطة المستخدم</td>
                                 @isAdmin
                                 <td>النشاط</td>
                                 @endIsAdmin
                             </tr>
                             </thead>
                             <tbody>
                             @foreach($returns as $return)
                                 <tr>
                                 <td>{{$return->id}}</td>
                                 <td>{{$return->orderDetails->product->name}}</td>
                                 <td>{{$return->order->invoice_no}}</td>
                                 <td>{{$return->order->customer->name ?? $return->order->customer->phone}}</td>
                                 <td>{{$return->total_quantity}}</td>
                                 <td>{{$return->refund_amount}}</td>
                                 <td>{{$return->user->name}}</td>
                                     @isAdmin
                                <td>
                                     <div class="btn-group">
                                         <button id='{{$return->id}}'  class="btn btn-danger btn-xs btndelete pr-btn"><span class="fa fa-trash" style="color:#ffffff" data-toggle="tooltip" title="ازالة المرتجع"></span></button>
                                     </div>
                                 </td>
                                     @endIsAdmin
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

    {{--  data that need to delete tht customer  --}}
    <script>
        // destroying url
        const url = "{{ route('returns.destroy') }}";
        const csrf = "{{ csrf_token() }}";
    </script>

    {{--    delete the Customer--}}
    <script src="{{asset('js/message/destroy.js')}}"></script>



    <!-- SweetAlert2 -->
    <script src="{{asset('plugins/sweetalert2/sweetalert2.min.js')}}"></script>

@endpush
