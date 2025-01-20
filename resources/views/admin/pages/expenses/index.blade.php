@extends('layouts.admin')

@section('title', '7Star system')
@section('prev-link', route('dashboard'))
@section('main-color', 'info'))
@section('prev-link-title', 'الصفحة الرئيسية')
@section('content-title', 'النفقات')
@section('content-page-name', 'النفقات')

@section('content')



    <div class="row">
        <div class="col-12">
             <div class="card card-info card-outline">
                <div class="card-header">
                    <h5 class="card-title">النفقات</h5>

                </div>


                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4">
{{--
                            <div class="card">
                                <form id="expenseForm" action="{{ route('expenses.store') }}" method="post">
                                    @csrf
                                    <input type="hidden" id="expenseId" name="id">
                                    <div class="card-header">
                                        <h5 class="card-title" id="formTitle">اضاف نفقة جديدة</h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="form-group">
                                            <label for="name">المبلغ</label>
                                            <input type="number" class="form-control" placeholder="ادخل المبلغ" name="amount" id="expenseAmount" value="amount" required>
                                            @error('amount') <p class="text-danger">{{ $message }}</p> @enderror
                                        </div>
                                        <div class="form-group">
                                            <label for="expenseDetail">التفاصيل</label>
                                            <textarea class="form-control" name="details" id="expenseDetails" cols="30" rows="10" >{{old('detail')}}</textarea>
                                            @error('details') <p class="text-danger">{{ $message }}</p> @enderror
                                        </div>
                                    </div>
                                    <div class="card-footer text-center">
                                        <button type="submit" class="btn btn-info" id="formButton">اضف النفقة</button>
                                    </div>
                                </form>
                            </div>
                       --}}
                            <div class="card">
                                <form id="expenseForm" action="{{ route('expenses.store') }}" method="post">
                                    @csrf
                                    <input type="hidden" id="expenseId" name="id">
                                    <div class="card-header">
                                        <h5 class="card-title" id="formTitle">اضاف نفقة جديدة</h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="form-group">
                                            <label for="name">المبلغ</label>
                                            <input type="number" class="form-control" placeholder="ادخل المبلغ" name="amount" id="expenseAmount" value="{{ old('amount') }}" required>
                                            @error('amount') <p class="text-danger">{{ $message }}</p> @enderror
                                        </div>
                                        <div class="form-group">
                                            <label for="expenseDetail">التفاصيل</label>
                                            <textarea class="form-control" name="details" id="expenseDetails" cols="30" rows="10">{{ old('details') }}</textarea>
                                            @error('details') <p class="text-danger">{{ $message }}</p> @enderror
                                        </div>
                                    </div>
                                    <div class="card-footer text-center">
                                        <button type="submit" class="btn btn-info" id="formButton">اضف النفقة</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="col-md-8">

                            @if(!empty($data))
                                <h2 class="text-center text-secondary mb-3" style="font-size: 30px;">{{'المجموع: ' . $total . 'LE'}}</h2>
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
                                    {{--                            show all the data--}}
                                    @foreach($data as $info)
                                        <tr>
                                            <td>{{$info->id}}</td>
                                            <td>{{$info->amount}}</td>
                                            <td>{{$info->details}}</td>
                                            <td>{{$info->date}}</td>
                                            <td>
                                                <a href="#" class="ml-2 text-info edit-expense" data-id="{{ $info->id }}" data-details="{{ $info->details }}" data-amount="{{ $info->amount }}">
                                                    <i class="nav-icon fas fa-edit"></i>
                                                </a>
                                           <button  id="{{$info->id}}" style="border:0; background-color:inherit; " class=" btndelete ml-2 text-danger" ><i class="nav-icon fas fa-trash" title="Delete Product"  data-toggle="tooltip"></i></button>

                                            </td>

                                        </tr>
                                    @endforeach



                                    </tbody>
                                </table>

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
                        const url = "{{ route('categories.destroy', ':id') }}".replace(':id', id);
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
    <script src="{{asset('plugins')}}/sweetalert2/sweetalert2.min.js"></script>


{{--    for updateing the request --}}
    <!-- JavaScript to Handle Edit Click -->
    <script>
    expenseEditUrl = "{{ route('expenses.update', ['expense' => ':id']) }}"
    console.log()
    </script>
    <script src="{{asset('js/expenses.js')}}"></script>
@endpush
