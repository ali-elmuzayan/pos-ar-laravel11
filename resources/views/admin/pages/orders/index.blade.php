@extends('layouts.admin')

@section('title', 'بيانات الاوردر')
@section('prev-link', route('dashboard'))
@section('prev-link-title', 'الصفحة الرئيسية')
@section('content-title', 'الطلبات')
@section('content-page-name', 'الطلبات')

@section('content')



    <div class="row">
        <div class="col-12">
             <div class="card card-primary card-outline">
                <div class="card-header">
                    @isAdmin
                    <h5 class="card-title">بيانات الطلبات</h5>
                    @endIsAdmin
                    @isUser
                    <h5 class="card-title">
                        <a  data-id="{{$wallet->id}}" class="withdraw btn btn-dark withdrawBtn button text-light"  role="button" >تفريغ الخزنة</a>

                    </h5>
                    <h5 class="balance">المبلغ في الخزنة: {{ $wallet->balance }}</h5>
                    @endIsUser
                </div>
                 <div class="card-body">

                     @if(!empty($data))
                         <table class="table table-bordered table-hover w-100 " id="table_product">
                             <thead>
                             <tr>
                                 <td>#</td>
                                 <td>الاوردر باركود</td>
                                 <td>عدد المنتجات</td>
                                 <td>السعر</td>
                                 <td>رقم العميل</td>
                                 <td>التاريخ</td>
                                 @isAdmin <td>المكسب</td>@endIsAdmin
                                 <td>النشاط</td>
                             </tr>
                             </thead>
                             <tbody>
                             @foreach($data as $info)
                                 <tr>
                                 <td>{{$info->id}}</td>
                                 <td>{{$info->invoice_no}}</td>
                                 <td>{{$info->total_products}}</td>
                                 <td>{{$info->total_price}}</td>
                                 <td>{{$info->customer->phone ?? 'العميل غير متاح'}}</td>
                                 <td>{{$info->created_at->diffForHumans()}}</td>
                                 @isAdmin<td>{{$info->profit()}}</td>@endIsAdmin
                                 <td>
                                     <div class="btn-group">
                                         <a href="{{route('orders.bill', $info->id)}}" class="btn btn-secondary btn-xs pr-btn" role="button"><span class="fa fa-money-bill" style="color:#ffffff" data-toggle="tooltip" title="طباعة الفاتورة"></span></a>
                                         @isAdmin<a href="{{route('orders.show', $info->id)}}" class="btn btn-dark btn-xs pr-btn" role="button"><span class="fa fa-eye" style="color:#ffffff" data-toggle="tooltip" title="تفاصيل الطلب"></span></a>@endIsAdmin
                                        @if($info->isValidToReturn()) <a href="{{route('pos.return', $info->id)}}" class="btn btn-dark btn-xs pr-btn" role="button"><span class="fa fa-edit" style="color:#ffffff" data-toggle="tooltip" title="تعديل الطلب"></span></a> @endif
{{--                                         <button id='{{$info->id}}'  class="btn btn-danger btn-xs btndelete pr-btn"><span class="fa fa-trash" style="color:#ffffff" data-toggle="tooltip" title="Delete Product"></span></button>--}}
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
    <!-- DataTables -->
    <link rel="stylesheet" href="{{asset("plugins")}}/datatables-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="{{asset("plugins")}}/datatables-responsive/css/responsive.bootstrap4.min.css">
    <link rel="stylesheet" href="{{asset("plugins")}}/datatables-buttons/css/buttons.bootstrap4.min.css">

    <!-- SweetAlert2 -->
    <link rel="stylesheet" href="{{asset("plugins")}}/sweetalert2/sweetalert2.min.css">

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
        $('[data-toggle="tooltip"], .tooltip-container').tooltip();
        });
    </script>


    <!-- SweetAlert2 -->
    <script src="{{asset('plugins')}}/sweetalert2/sweetalert2.min.js"></script>

    <script>
        $(document).ready(function() {
            $('#table_product').DataTable({
                "order": [[0, "desc"]]
            });
        });

    </script>
    <script>
        const walletEmptyingURL = "{{ route('wallets.emptying') }}";
        const csrfToken = "{{ csrf_token() }}";
        console.log(walletEmptyingURL)
    </script>


{{--    enter the password of the product --}}
    <script src="{{asset('js/ajax/wallet_password.js')}}"></script>
@endpush
