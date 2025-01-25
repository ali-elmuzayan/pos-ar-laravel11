@extends('layouts.admin')

@section('title', 'بيانات الفئات')
@section('main-color', 'info')
@section('prev-link', route('dashboard'))
@section('prev-link-title', 'الصفحة الرئيسية')
@section('content-title', 'بيانات الفئات')
@section('content-page-name', 'بيانات الفئات')

@section('content')



    <div class="row">
        <div class="col-12">
             <div class="card card-info card-outline">
                <div class="card-header">
                    <h5 class="card-title">بيانات الفئات</h5>

                </div>


                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="card">
                                <form id="categoryForm" action="{{ route('categories.store') }}" method="post">
                                    @csrf
                                    <input type="hidden" id="categoryId" name="id">
                                    <div class="card-header">
                                        <h5 class="card-title" id="formTitle">اضاف فئة جديدة</h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="form-group">
                                            <label for="name">اسم الفئة</label>
                                            <input type="text" class="form-control" placeholder="ادخل اسم الفئة" name="name" id="categoryName" required>
                                            @error('name') <p class="text-danger">{{ $message }}</p> @enderror
                                        </div>
                                    </div>
                                    <div class="card-footer text-center">
                                        <button type="submit" class="btn btn-info" id="formButton">اضف فئة جديد</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="col-md-8">
                            @if(!empty($categories))
                                <table id="example2" class="table table-striped table-hover ">
                                    <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>اسم الفئة</th>
                                        <th>عدد المنتجات في هذه الفئة</th>
                                        <th>النشاط</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    {{--                            show all the data--}}
                                    @foreach($categories as $category)
                                        <tr>
                                            <td>{{$category->id}}</td>
                                            <td>{{$category->name}}</td>
                                            <td>{{$category->productCount()}}</td>
                                            <td>
                                                <a href="#" class="ml-2 text-info editCategory" data-id="{{ $category->id }}" data-name="{{ $category->name }}">
                                                    <i class="nav-icon fas fa-edit"></i>
                                                </a>
                                                @if($category->productCount() >= 1)
                                                <a href="{{route('categories.show', $category->id)}}" class="ml-2 text-success">
                                                    <i class="nav-icon fas fa-eye"></i>
                                                </a>
                                                @endif
                                              @if($category->productCount() <= 0)  <button  id="{{$category->id}}" style="border:0; background-color:inherit; " class=" btndelete ml-2 text-danger" ><i class="nav-icon fas fa-trash" title="حذف المنتج"  data-toggle="tooltip"></i></button>@endif

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
        document.addEventListener('DOMContentLoaded', function () {
            // Add event listeners to all edit icons
            const editButtons = document.querySelectorAll('.editCategory');
            editButtons.forEach(button => {
                button.addEventListener('click', function (e) {
                    e.preventDefault();

                    // Get category data from the clicked row
                    const categoryId = this.getAttribute('data-id');
                    const categoryName = this.getAttribute('data-name');

                    // Update the form
                    const form = document.getElementById('categoryForm');
                    const formTitle = document.getElementById('formTitle');
                    const formButton = document.getElementById('formButton');
                    const categoryIdInput = document.getElementById('categoryId');
                    const categoryNameInput = document.getElementById('categoryName');
                    const methodInput = document.createElement('input'); // Create a hidden input for the method

                    // Set attributes for the method input
                    methodInput.setAttribute('type', 'hidden');
                    methodInput.setAttribute('name', '_method');
                    methodInput.setAttribute('value', 'PUT');

                    // Append the method input to the form
                    form.appendChild(methodInput);

                    // Change form action to update route
                    form.action = "{{ route('categories.update', ['category' => ':id']) }}".replace(':id', categoryId);
                    formTitle.textContent = 'تعديل الفئة';
                    formButton.textContent = 'تحديث الفئة';

                    // Set category ID and name in the form
                    categoryIdInput.value = categoryId;
                    categoryNameInput.value = categoryName;
                });
            });
        });

    </script>
@endpush
