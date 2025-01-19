{{--<x-app-layout>--}}
{{--    <x-slot name="header">--}}
{{--        <h2 class="font-semibold text-xl text-gray-800 leading-tight">--}}
{{--            {{ __('Profile') }}--}}
{{--        </h2>--}}
{{--    </x-slot>--}}

{{--    <div class="py-12">--}}
{{--        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">--}}
{{--            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">--}}
{{--                <div class="max-w-xl">--}}
{{--                    @include('profile.partials.update-profile-information-form')--}}
{{--                </div>--}}
{{--            </div>--}}

{{--            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">--}}
{{--                <div class="max-w-xl">--}}
{{--                    @include('profile.partials.update-password-form')--}}
{{--                </div>--}}
{{--            </div>--}}

{{--        </div>--}}
{{--    </div>--}}
{{--</x-app-layout>--}}
@extends('layouts.admin')
@section('title', '7Star system')
@section('prev-link', route('dashboard'))
@section('prev-link-title', 'الصفحة الرئيسية')
@section('content-title', 'تعديل البيانات')
@section('content-page-name', 'تعديل البيانات الشخصية')

@section('content')



    <div class="row">
        <div class="col-12">
            <div class="card card-info card-outline">
                <div class="card-header">
                    <h5 class="card-title">تعديل البيانات</h5>
                </div>


                <div class="card-body">
                    <div class="row">

                        <div class="col-md-6">

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
                        <div class="col-md-6">

                            <div class="card ">
                                <form action="{{route('password.update')}}" method="post">

                                    @csrf
                                    @method('put')
                                    <div class="card-header">
                                        <h5 class="card-title ">تغير كلمة المرور </h5>

                                    </div>
                                    <div class="card-body">

                                        <div class="form-group">
                                            <label for="exampleInputEmail1">كلمة المرور الحالية</label>
                                            <input type="password" class="form-control" placeholder="كلمة المرور الحالية" name="current-password" required>
                                        </div>


                                        <div class="form-group">
                                            <label for="exampleInputEmail1">كلمة المرور الجديدة</label>
                                            <input type="password" class="form-control"  placeholder="كلمة المرور الجديدة" name="password" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="" >تاكيد كلمة المرور الجديدة</label>
                                            <input type="password" class="form-control"  placeholder="تاكيد كلمة المرور الجديدة" name="conformation_password" required>
                                        </div>



                                    </div>
                                    <div class="card-footer text-center ">
                                        <button class="btn btn-outline-primary">تغير كلمة المرور</button>
                                    </div>
                                </form>

                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
