@extends('layouts.admin')

@section('title', 'المنتجات')
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
                    @isAdmin
                    <div class="float-left">
                        <a href="{{route("products.create")}}" class="btn btn-outline-secondary">اضف منتج جديد</a>
                    </div>
                    @endIsAdmin
                </div>
                 <div class="card-body">

                     @if(!empty($data))
                         <table class="table table-bordered table-hover w-100" id="table_product">
                             <thead>
                             <tr>
                                 <td>المنتج</td>
                                 <td>الباركود</td>
                                 <td>المنتج</td>
                                 <td>الفئة</td>
                                 <td>الوصف</td>
                                 <td>الكمية</td>
                                 @isAdmin<td>سعر الشراء</td>@endIsAdmin
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
                                 @isAdmin<td>{{$info->buying_price}}</td>@endIsAdmin
                                 <td>{{$info->selling_price}}</td>
                                 <td><img src="{{ $info->image ? asset( $info->image) : url('uploads/no_image.jpg')}}" alt="" width="30" height="30"></td>
                                 <td>
                                     <div class="btn-group">
{{--                                         <a id="{{$info->id}}" class="ml-2 text-secondary add-quantity" data-id="{{ $info->id }}" ><i class="nav-icon fas fa-plus-square"></i></a>--}}
                                         @isAdmin
                                         <a data-id="{{$info->id}}" class="btn btn-secondary btn-xs add-quantity pr-btn" role="button" ><span class="fa fa-plus-square" style="color:#ffffff" ></span></a>
                                         @endIsAdmin
                                         <a href="{{route('barcode.product.show', $info->id)}}" class="btn btn-dark btn-xs pr-btn" role="button"><span class="fa fa-barcode" style="color:#ffffff" data-toggle="tooltip" title="PrintBarcode"></span></a>
                                         <a href="{{route('products.show', $info->id)}}" class="btn btn-warning btn-xs pr-btn" role="button"><span class="fa fa-eye" style="color:#ffffff" data-toggle="tooltip" title="View Product"></span></a>
                                         @isAdmin
                                         <a href="{{route('products.edit', $info->id)}}" class="btn btn-success btn-xs pr-btn" role="button"><span class="fa fa-edit" style="color:#ffffff" data-toggle="tooltip" title="Edit Product"></span></a>
                                         @endIsAdmin
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
{{--    delete the product --}}
{{--    <script>--}}
{{--        $(document).ready(function() {--}}
{{--            $('.btndelete').click(function() {--}}
{{--                var tdh = $(this);--}}
{{--                var id = $(this).attr("id");--}}


{{--                Swal.fire({--}}
{{--                    title: 'هل تريد الحذف؟',--}}
{{--                    text: "لن يمكنك التراجع عن هذا الإجراء",--}}
{{--                    icon: 'warning',--}}
{{--                    showCancelButton: true,--}}
{{--                    confirmButtonColor: '#3085d6',--}}
{{--                    cancelButtonColor: '#d33',--}}
{{--                    confirmButtonText: 'نعم! احذف',--}}
{{--                    cancelButtonText: 'إلغاء'--}}
{{--                }).then((result) => {--}}
{{--                    if (result.value) {--}}
{{--                        // Construct the URL dynamically with the ID--}}
{{--                        const url = "{{ route('products.destroy', ':id') }}".replace(':id', id);--}}
{{--                        console.log(url);--}}
{{--                        $.ajax({--}}
{{--                            url: url, // Use the dynamically constructed URL--}}
{{--                            // url: '/test/1',--}}
{{--                            type: 'post', // Use DELETE method--}}
{{--                            data: {--}}
{{--                                _token: "{{ csrf_token() }}", // Add CSRF token--}}
{{--                                _method: 'DELETE' // Spoof the DELETE method--}}
{{--                            },--}}
{{--                            success: function(response) {--}}
{{--                                if (response.success) {--}}
{{--                                    tdh.parents('tr').fadeOut('fast');--}}
{{--                                    Swal.fire('تم الحذف!', response.message, 'success');--}}
{{--                                } else {--}}
{{--                                    Swal.fire('خطأ!', response.message, 'error');--}}
{{--                                }--}}
{{--                            },--}}
{{--                            error: function() {--}}
{{--                                Swal.fire('خطأ!', 'حدث خطأ أثناء الحذف.', 'error');--}}
{{--                            }--}}
{{--                        });--}}

{{--                    }--}}
{{--                });--}}
{{--            });--}}
{{--        });--}}
{{--    </script>--}}

{{--    add quantity to the product --}}
    <script>
        $(document).ready(function() {
            $('.add-quantity').click(function() {
                var tdh = $(this);
                var id = this.getAttribute('data-id');

                Swal.fire({
                    title: 'إضافة كمية',
                    input: 'number',
                    inputLabel: 'أدخل الكمية المطلوبة',
                    inputPlaceholder: 'الكمية',
                    showCancelButton: true,
                    confirmButtonText: 'إضافة',
                    cancelButtonText: 'إلغاء',
                    inputValidator: (value) => {
                        if (!value) {
                            return 'يجب إدخال كمية!';
                        }
                        if (value <= 0) {
                            return 'يجب ان تكون القيمة اكبر من او تساوي الصفر';
                        }

                    }
                }).then((result) => {
                    if (result.value) {
                        const quantity = result.value;
                        const url = "{{ route('products.add.quantity', ':id') }}".replace(':id', id);
                        console.log(url)

                        $.ajax({
                            url: url,
                            type: 'post',
                            data: {
                                _token: "{{ csrf_token() }}",
                                _method: 'PUT',
                                quantity: quantity // Send the quantity to the server
                            },

                            success: function(response) {
                                console.log(response);
                                if (response.success) {
                                    Swal.fire('تم الإضافة!', response.message, 'success');
                                    // Optionally, you can update the UI here
                                } else {
                                    console.log(quantity)
                                    Swal.fire('خطأ!', response.message, 'error');
                                }
                            },
                            error: function() {
                                Swal.fire('خطأ!', 'حدث خطأ أثناء الإضافة.', 'error');
                            }
                        });
                    }
                });
            });
        });
    </script>

    <!-- SweetAlert2 -->
    <script src="{{asset('plugins/sweetalert2/sweetalert2.min.js')}}"></script>
@endpush
