@extends('layouts.admin')

@section('title', 'المستخدمين')
@section('prev-link', route('dashboard'))
@section('main-color', 'info')
@section('prev-link-title', 'الصفحة الرئيسية')
@section('content-title', 'اضافة مستخدم جديد')
@section('content-page-name', 'اضافة مستخدم جديد')

@section('content')



    <div class="row">
        <div class="col-12">
            <div class="card card-info card-outline">
                <div class="card-header">
                    <h5 class="card-title">المستخدمين</h5>

                </div>


                <div class="card-body">
                    <div class="row">

                        <div class="col-md-4">

                            <div class="card ">

                                <form action="{{route('users.store')}}" method="post">

                                    @csrf
                                    <div class="card-header ">
                                        <h5 class="card-title ">اضاف مستخدم جديد</h5>
                                    </div>
                                    <div class="card-body">

                                        <div class="form-group">
                                            <label for="exampleInputEmail1">اسم المستخدم</label>
                                            <input type="text" class="form-control" placeholder="ادخل اسم الموظف" name="name"  required>
                                            @error('name') <p class="text-danger">{{$message}}</p> @enderror
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">اسم المستخدم</label>
                                            <input type="text" class="form-control" placeholder="ادخل اسم المستخدم للتسجيل الدخول به" name="username" required>
                                            @error('username') <p class="text-danger">{{$message}}</p> @enderror

                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">البريد الاكتروني</label>
                                            <input type="email" class="form-control"  placeholder="البريد الاكتروني" name="email" required>
                                            @error('email') <p class="text-danger">{{$message}}</p> @enderror
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputPassword1">الرقم السري</label>
                                            <input type="password" class="form-control"  placeholder="الرقم السري" name="password" required>
                                            @error('password') <p class="text-danger">{{$message}}</p> @enderror
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputPassword1">الرقم السري</label>
                                            <input type="password" class="form-control"  placeholder="تاكيد الرقم السري" name="password_confirmation" required>
                                            @error('password_confirmation') <p class="text-danger">{{$message}}</p> @enderror

                                        </div>

                                        <div class="form-group">
                                            <label>دور المستخدم</label>
                                            <select class="form-control" name="role" required>
                                                <option value="user" selected>مستخدم</option>
                                                <option value="admin" >ادمن</option>
                                            </select>
                                            @error('role') <p class="text-danger">{{$message}}</p> @enderror
                                        </div>

                                    </div>
                                    <div class="card-footer text-center ">
                                        <button class="btn btn-outline-info">اضف مستخدم جديد</button>
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
                                        <th>الاسم</th>
                                        <th>اسم المستخدم</th>
                                        <th>الايميل</th>
                                        <th>حذف المستخدم</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    {{--                            show all the data--}}
                                    @foreach($data as $info)
                                        <tr>
                                            <td>{{$counter++}}</td>
                                            <td>{{$info->name}}</td>
                                            <td>{{$info->username}}</td>
                                            <td>{{$info->email}}</td>
                                            <td class="text-center"><a href="#" ><i class="nav-icon fas fa-trash text-danger" ></i></a></td>

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
