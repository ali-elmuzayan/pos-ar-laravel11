@extends('layouts.admin')

@section('title', 'الخصومات')
@section('prev-link', route('dashboard'))
@section('main-color', 'info')
@section('prev-link-title', 'الصفحة الرئيسية')
@section('content-title', 'بيانات الخصومات')
@section('content-page-name', 'الخصومات')

@section('content')



    <div class="row">
        <div class="col-12">
             <div class="card card-info card-outline">

                {{--      Card header     --}}
                <div class="card-header">
                    <h5 class="card-title">الخصومات</h5>
                </div>

                {{--      Card Body     --}}
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="card">
                                {{--     Create && Edit From (tranform to edit by js)    --}}
                                <form id="discountForm" action="{{ route('discounts.store') }}" method="post">
                                    @csrf
                                    <input type="hidden" id="discountId" name="id">
                                    <div class="card-header">
                                        <h5 class="card-title" id="formTitle">اضاف خصم جديد</h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="form-group">
                                            <label for="percent">الخصم</label>
                                            <input type="number" class="form-control" placeholder="ادخل الخصم" name="percent" id="discountPercent" value="{{ old('percent') }}" required>
                                            @error('percent') <p class="text-danger">{{ $message }}</p> @enderror
                                        </div>
                                        <div class="form-group">
                                            <!-- <label>Date:</label> -->
                                            <div class="input-group date" id="date_1" data-target-input="nearest">
                                                <input type="text" class="form-control date_1"  data-target="#date_1" id="discountDate"  name="end_date"/>
                                                <div class="input-group-append" data-target="#date_1" data-toggle="datetimepicker">
                                                    <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                                </div>
                                            </div>
                                            @error('end_date') <p class="text-danger">{{ $message }}</p> @enderror

                                        </div>
                                    </div>
                                    <div class="card-footer text-center">
                                        <button type="submit" class="btn btn-info" id="formButton">اضف خصم</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="col-md-8">

                            {{--     in case the data is valid show the data --}}
                            @if(!empty($discounts))
                                <table id="example2" class="table table-striped table-hover ">
                                    <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>المبلغ</th>
                                        <th>التفاصيل</th>
                                        <th>التاريخ</th>
                                        <th>النشاط</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($discounts as $discount)
                                        <tr>
                                            <td>{{$counter++}}</td>
                                            <td>{{$discount->percent}}</td>
                                            <td>@if($discount->valid())
                                                    <span class="text-green">يعمل</span>
                                                @else
                                                    <span class="text-red">انتهى</span>
                                            @endif
                                            </td>
                                            <td>{{$discount->end_date ?? 'لا يوجد تاريخ'}}</td>
                                            <td>
                                                <a href="#" class="ml-2 text-info edit-discount" data-id="{{ $discount->id }}" data-percent="{{ $discount->percent }}" data-end-date="{{ $discount->end_date }}">
                                                    <i class="nav-icon fas fa-edit"></i>
                                                </a>
                                           <button  id="{{$discount->id}}" style="border:0; background-color:inherit; " class=" btndelete ml-2 text-danger" ><i class="nav-icon fas fa-trash" title="Delete Product"  data-toggle="tooltip"></i></button>

                                            </td>

                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>

                            {{--  in case the data is not valid show the alert     --}}
                            @else
                                <div class="alert alert-danger" style="opacity:75%;">
                                    عفوا لا يوجد بيانات لعرضها
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('css')
    <!-- daterange picker -->
    <link rel="stylesheet" href="{{asset('plugins/daterangepicker/daterangepicker.css')}}">

    <!-- Tempusdominus Bootstrap 4 -->
    <link rel="stylesheet" href="{{asset('plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css')}}">

    <!-- SweetAlert2 -->
<link rel="stylesheet" href="{{asset("plugins/sweetalert2/sweetalert2.min.css")}}">

@endpush

@push('js')
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
                    text: "لن يمكنك التراجع عن هذا الإجراء",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'نعم! احذف',
                    cancelButtonText: 'إلغاء'
                }).then((result) => {
                    if (result.value) {
                        // Construct the URL dynamically with the ID
                        const url = "{{ route('discounts.destroy', ':id') }}".replace(':id', id);
                        console.log(url);
                        $.ajax({
                            url: url, // Use the dynamically constructed URL
                            // url: '/test/1',
                            type: 'post', // Use DELETE method
                            data: {
                                _token: "{{ csrf_token() }}", // Add CSRF token
                                _method: 'DELETE' // Spoof the DELETE method
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

                    }
                });
            });
        });
    </script>

    <!-- SweetAlert2 -->
    <script src="{{asset('plugins/sweetalert2/sweetalert2.min.js')}}"></script>


{{--    for updating the request --}}
    <!-- JavaScript to Handle Edit Click -->
    <script>
    discountEditUrl = "{{ route('discounts.update', ['discount' => ':id']) }}"
    </script>
    <script src="{{asset('js/discount.js')}}"></script>


    <!-- InputMask -->
    <script src="{{asset('plugins/moment/moment.min.js')}}"></script>

    <!-- date-range-picker -->
    <script src="{{asset('plugins//daterangepicker/daterangepicker.js')}}"></script>

    <!-- Tempusdominus Bootstrap 4 -->
    <script src="{{asset('plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js')}}"></script>


@endpush
