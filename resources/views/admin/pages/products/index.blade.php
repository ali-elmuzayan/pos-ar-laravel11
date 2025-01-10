@extends('layouts.admin')

@section('title', '7Star system')
@section('prev-link', route('dashboard'))
@section('prev-link-title', 'الصفحة الرئيسية')
@section('content-title', 'المنتجات')
@section('content-page-name', 'المنتجات')

@section('content')



    <div class="row">
        <div class="col-12">
             <div class="card card-primary card-outline">
                <div class="card-header">
                    <h5 class="card-title">بيانات المنتجات</h5>

                </div>
                 <div class="card-body">

                     @if(!empty($data))
                         <table class="table table-bordered table-hover " id="table_product">
                             <thead>
                             <tr>
                                 <td>المنتج</td>
                                 <td>الباركود</td>
                                 <td>المنتج</td>
                                 <td>الفئة</td>
                                 <td>الوصف</td>
                                 <td>الكمية</td>
                                 <td>سعر الشراء</td>
                                 <td>سعر البيع</td>
                                 <td>صورة</td>
                                 <td>النشاط</td>
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
                                         <a href="#" class="btn btn-dark btn-xs" role="button"><span class="fa fa-barcode" style="color:#ffffff" data-toggle="tooltip" title="PrintBarcode"></span></a>
                                         <a href="{{route('products.show', $info->id)}}" class="btn btn-warning btn-xs" role="button"><span class="fa fa-eye" style="color:#ffffff" data-toggle="tooltip" title="View Product"></span></a>
                                         <a href="{{route('products.edit', $info->id)}}" class="btn btn-success btn-xs" role="button"><span class="fa fa-edit" style="color:#ffffff" data-toggle="tooltip" title="Edit Product"></span></a>
                                         <button id='{{$info->id}}'  class="btn btn-danger btn-xs btndelete"><span class="fa fa-trash" style="color:#ffffff" data-toggle="tooltip" title="Delete Product"></span></button>


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
            $('#table_product').DataTable();
        });
    </script>

{{--    <script>--}}
{{--        $(document).ready(function() {--}}
{{--            $('[data-toggle="tooltip"]').tooltip();--}}
{{--        });--}}
{{--    </script>--}}
    <script>
        $(document).ready(function() {
        $('[data-toggle="tooltip"], .tooltip-container').tooltip();
        });
    </script>
    <script>
        $(document).ready(function() {
            $('.btndelete').click(function() {
                var tdh = $(this);
                var id = $(this).attr("id");


                Swal.fire({
                    title: 'هل تريد الحذف؟',
                    text: "لن يمكنك التراجع عن هذا الاجراء",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'نعم! احذف',
                    cancelButtonText: 'إلغاء'
                }).then((result) => {
                    if (result.isConfirmed) {



                        $.ajax({
                            url: 'productdelete.php',
                            type: 'post',
                            data: {
                                pidd: id
                            },
                            success: function(response) {
                                if (response.success) {
                                    tdh.parents('tr').fadeOut('fast');
                                    Swal.fire('تم الحذف!', response.message, 'success');
                                } else {
                                    Swal.fire('خطأ!', response.message, 'error');
                                }
                            },
                            error: function() {
                                Swal.fire('خطأ!', 'حدث خطأ أثناء الحذف.', 'error');
                            }


                        });

                        Swal.fire(
                            'Deleted!',
                            'Your Product has been deleted.',
                            'success'
                        )
                    }
                })
            });
        });
    </script>

    <!-- SweetAlert2 -->
    <script src="{{asset('plugins')}}/sweetalert2/sweetalert2.min.js"></script>
@endpush
