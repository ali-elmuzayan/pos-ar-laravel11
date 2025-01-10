@extends('layouts.admin')

@section('title', '7Star system')
@section('prev-link', route('dashboard'))
@section('prev-link-title', 'الصفحة الرئيسية')
@section('content-title', 'نظام البيع')
@section('content-page-name', 'نظام البيع')

@section('content')



    <div class="row">
        <div class="col-12">
            <div class="card card-primary card-outline">
                <div class="card-header">
                    <h5 class="card-title">بيانات الفئات</h5>
                    <div class="col-sm-4">
                        <input type="text" id="search_by_text" class="form-control " placeholder="بحث بالاسم">
                        {{--                        <input type="hidden" id="ajax_search_url" value="{{route('treasuries.ajax_search')}} " >--}}
                        {{--                        <input type="hidden" id="ajax_token" value="{{csrf_token()}} " >--}}
                    </div>
                </div>


                <div class="card-body">
                    <div class="row">

                        <div class="col-md-4">

                            <div class="card ">
                                <form action="{{route('categories.store')}}" method="post">

                                    @csrf
                                    <div class="card-header">
                                        <h5 class="card-title "> اضافة فئة جديدة</h5>
                                        <button type="submit" class="btn btn-outline-primary" name="btnsave">اضف فئة</button>

                                    </div>
                                    <div class="card-body">

                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Name</label>
                                            <input type="text" class="form-control" placeholder="Enter Name" name="txtname" required>
                                        </div>


                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Email address</label>
                                            <input type="email" class="form-control"  placeholder="Enter email" name="txtemail" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputPassword1">Password</label>
                                            <input type="password" class="form-control"  placeholder="Password" name="txtpassword" required>
                                        </div>

                                        <div class="form-group">
                                            <label>Role</label>
                                            <select class="form-control" name="txtselect_option" required>
                                                <option value="" disabled selected>Select Role</option>
                                                <option>Admin</option>
                                                <option>User</option>

                                            </select>
                                        </div>

                                    </div>
                                </form>

                            </div>
                        </div>
                        <div class="col-md-8">
                            @if(!empty($data))
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
                                    @foreach($data as $info)
                                        <tr>
                                            <td>{{$counter++}}</td>
                                            <td>{{$info->name}}</td>
                                            <td>@if($info->is_master) رئيسية @else غير رئيسية @endif</td>
                                            <td><a href="#" ><i class="nav-icon fas fa-edit"></i></a></td>

                                        </tr>
                                    @endforeach



                                    </tbody>
                                </table>
                                <br>
                                {{$data->links()}}
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
