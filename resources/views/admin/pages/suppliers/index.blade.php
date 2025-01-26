@extends('layouts.admin')

@section('title', 'الموزعون')
@section('prev-link', route('dashboard'))
@section('main-color', 'info')
@section('prev-link-title', 'الصفحة الرئيسية')
@section('content-title', 'بيانات الموزعون')
@section('content-page-name', 'الموزعون')

@section('content')



    <div class="row">
        <div class="col-12">
            <div class="card card-info card-outline">
                <div class="card-header">
                    <h5 class="card-title">بيانات الموزعون</h5>

                </div>


                <div class="card-body">
                    <div class="row">

                        <div class="col-md-4">

                            <div class="card ">

                                <form id="supplierForm" action="{{route('suppliers.store')}}" method="post">

                                    @csrf
                                    <div class="card-header ">
                                        <h5 class="card-title " id="FormTitle">اضاف موزع جديد</h5>
                                    </div>
                                    <div class="card-body">

                                        <div class="form-group">
                                            <label for="name">اسم الموزع</label>
                                            <input type="text" id="supplierName" class="form-control" placeholder="ادخل اسم الموزع" name="name" value="{{old('name')}}"  required>
                                            @error('name') <p class="text-danger">{{$message}}</p> @enderror
                                        </div>
                                        <div class="form-group">
                                            <label for="phone">رقم الهاتف</label>
                                            <input type="text" class="form-control" placeholder="رقم الهاتف" name="phone" id="supplierPhone" value="{{old('phone')}}" required>
                                            @error('phone') <p class="text-danger">{{$message}}</p> @enderror

                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">البريد الاكتروني</label>
                                            <input type="email" class="form-control"  placeholder="البريد الاكتروني" id="supplierEmail" name="email" value="{{old('email')}}" >
                                            @error('email') <p class="text-danger">{{$message}}</p> @enderror
                                        </div>
                                        <div class="form-group">
                                            <label for="address">العنوان</label>
                                            <input type="text" class="form-control"  placeholder="عنوان الموزع" name="address" id="supplierAddress" value="{{old('address')}}" >
                                            @error('address') <p class="text-danger">{{$message}}</p> @enderror
                                        </div>

                                    </div>
                                    <div class="card-footer text-center ">
                                        <button class="btn btn-outline-info" id="formButton">اضف موزع جديد</button>
                                    </div>
                                </form>

                            </div>
                        </div>
                        <div class="col-md-8">
                            @if(!empty($suppliers))
                                <table id="example2" class="table table-striped table-hover ">
                                    <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>اسم الموزع</th>
                                        <th>رقم الهاتف </th>
                                        <th>عدد منتجات الموزع</th>
                                        <th>الايميل</th>
                                        <th>العنوان </th>
                                        <th>النشاط </th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    {{--                            show all the data--}}
                                    @foreach($suppliers as $supplier)
                                        <tr>
                                            <td>{{$supplier->id}}</td>
                                            <td>{{$supplier->name}}</td>
                                            <td>{{$supplier->phone}}</td>
                                            <td>{{$supplier->countOfProducts()}}</td>
                                            <td>{{$supplier->email ?? 'لا يوجد ايميل'}}</td>
                                            <td>{{$supplier->address ?? 'لا يوجد عنوان'}}</td>
                                            <td class="btn-group">
{{--                                                <a href="{{route('suppliers.edit', $supplier->id)}}" class="btn btn-success btn-xs pr-btn" role="button"><span class="fa fa-edit" style="color:#ffffff" data-toggle="tooltip" title="تعديل بيانات العميل"></span></a>--}}
                                                <a href="#" class="ml-2 text-info edit-supplier" data-id="{{ $supplier->id }}" data-name="{{ $supplier->name }}" data-phone="{{ $supplier->phone }}" data-email="{{ $supplier->email }}" data-image="{{ $supplier->image }}" data-address="{{ $supplier->address }}">
                                                    <i class="nav-icon fas fa-edit"></i>
                                                </a>
                                                <button id='{{$supplier->id}}' style="border:0; background-color:inherit; "  class="text-danger ml-2 btndelete"><span class="nav-icon fa fa-trash text-danger"  style="color:#ffffff" data-toggle="tooltip" title="ازالة المنتج"></span></button>

                                            </td>

                                        </tr>
                                    @endforeach

                                    </tbody>
                                </table>
                                <br>
                                {{$suppliers->links()}}
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

    {{--  data that need to delete tht customer  --}}
    <script>
        // destroying url
        const url = "{{ route('suppliers.destroy') }}";
        const csrf = "{{ csrf_token() }}";
    </script>

    {{--    delete the Customer--}}
    <script src="{{asset('js/message/destroy.js')}}"></script>

    <!-- SweetAlert2 -->
    <script src="{{asset('plugins/sweetalert2/sweetalert2.min.js')}}"></script>


    {{--    for updating the request --}}
    <!-- JavaScript to Handle Edit Click -->
    <script>
        supplierEditUrl = "{{ route('suppliers.update', ['supplier' => ':id']) }}"
    </script>
    <script src="{{asset('js/edit-form/supplier.js')}}"></script>

@endpush
