@extends('layouts.admin')

@section('title', 'المنتجات الخاصة بالفئة')
@section('prev-link', route('categories.index'))
@section('prev-link-title', 'بيانات الفئات')
@section('content-title', 'بيانات المنتجات')
@section('content-page-name', 'بيانات منتجات هذه الفئة')

@section('content')



    <div class="row">
        <div class="col-12">
             <div class="card card-primary card-outline">
                <div class="card-header">
                    <h5 class="card-title">بيانات المنتجات المتعلقة ب ال{{ $category->name }}</h5>

                </div>
                 <div class="card-body">

                     @if(!empty($products))
                         <table class="table table-bordered table-hover w-100" id="table_product">
                             <thead>
                             <tr>
                                 <td>المنتج</td>
                                 <td>الباركود</td>
                                 <td>اسم المنتج</td>
                                 <td>الوصف</td>
                                 <td>الكمية</td>
                                 @isAdmin
                                 <td>سعر الشراء</td>
                                 @endIsAdmin
                                 <td>سعر البيع</td>
                                 @isAdmin
                                 <td>المكسب الكلي</td>
                                 <td>الكمية المباعة</td>
                                 @endIsAdmin
                                 <td>صورة</td>
                                 <td>النشاط</td>
                             </tr>
                             </thead>
                             <tbody>
                             @foreach($products as $product)
                                 <tr>
                                 <td>{{$product->id}}</td>
                                 <td>{{$product->code}}</td>
                                 <td>{{$product->name}}</td>
                                 <td><div>
                                         {{ Str::limit($product->description, 20, '...') ?? 'لا يوجد وصف' }}
                                     </div></td>
                                 <td data-product-id="{{$product->id}}"  class="quantity">{{$product->stock}}</td>
                                 @isAdmin<td>{{$product->buying_price}}</td>@endIsAdmin
                                 <td>{{$product->selling_price}}</td>

                                     @isAdmin
                                     <td>{{$product->totalProfit()}}</td>
                                     <td>{{$product->totalAmountOfSoldProduct()}}</td>
                                     @endIsAdmin
                                 <td><img src="{{ $product->image ? asset( $product->image) : url('uploads/no_image.jpg')}}" alt="" width="30" height="30"></td>
                                 <td>
                                     <div class="btn-group">
{{--                                         <a id="{{$product->id}}" class="ml-2 text-secondary add-quantity" data-id="{{ $product->id }}" ><i class="nav-icon fas fa-plus-square"></i></a>--}}
                                         @isAdmin
                                         <a data-id="{{$product->id}}" class="btn btn-secondary btn-xs add-quantity pr-btn" role="button" ><span class="fa fa-plus-square" style="color:#ffffff" ></span></a>
                                         @endIsAdmin
                                         <a href="{{route('barcode.product.show', $product->id)}}" class="btn btn-dark btn-xs pr-btn" role="button"><span class="fa fa-barcode" style="color:#ffffff" data-toggle="tooltip" title="طباعة الباركود"></span></a>
                                         @isAdmin
                                         <a href="{{route('products.show', $product->id)}}" class="btn btn-warning btn-xs pr-btn" role="button"><span class="fa fa-eye" style="color:#ffffff" data-toggle="tooltip" title="رؤية المنتج"></span></a>
                                         <button id='{{$product->id}}'  class="btn btn-danger btn-xs btndelete pr-btn"><span class="fa fa-trash" style="color:#ffffff" data-toggle="tooltip" title="ازالة المنتج"></span></button>
                                         @endIsAdmin


                                     </div>

                                 </td>
                                 </tr>
                             @endforeach
                             </tbody>

                         </table>

                         <br>
{{--                         {{$products->links()}}--}}
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
        // for the datatable
        $(document).ready(function() {
            $('#table_product').DataTable();
        });
    </script>
    {{--  some necessary data to destory the products  --}}
    <script>
        // destroying url
        const url = "{{ route('products.destroy') }}";
        const csrf = "{{ csrf_token() }}";
    </script>

    {{--    delete the product--}}
    <script src="{{asset('js/message/destroy.js')}}"></script>


    <script>
        $(document).ready(function() {
        $('[data-toggle="tooltip"], .tooltip-container').tooltip();
        });
    </script>

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
                                if (response.success) {
                                    Swal.fire('تم الإضافة!', response.message, 'success');
                                    $(`.quantity[data-product-id="${id}"]`).text(response.quantity);

                                    // Optionally, you can update the UI here
                                } else {
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
