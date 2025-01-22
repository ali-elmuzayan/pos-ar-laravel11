@extends('layouts.admin')
@section('title', 'تعديل البيانات العامة')
@section('main-color', 'info')
@section('prev-link', route('dashboard'))
@section('prev-link-title', 'الصفحة الرئيسية')
@section('content-title', 'البيانات العامة')
@section('content-page-name', 'البيانات العامة')

@section('content')

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">بيانات الضبط العام</h3>
                    <a href="{{route('settings.edit', $setting->id)}}" class="btn btn-sm btn-outline-info">تعديل البيانات</a>
                </div>
                <!-- /.card-header -->
                <div class="card-body">

                    @if(!empty($setting))
                        <table id="example2" class="table table-bordered table-hover">
                            <tr>
                                <th class="width30">اسم الشركة</th>
                                <td>{{$setting->name}}</td>
                            </tr>
                            <tr>
                                <th class="width30">وصف الشركة</th>
                                <td>{{$setting->description ?? 'لا يوجد وصف للشركة'}}</td>
                            </tr>
                            <tr>
                                <th class="width30">عنوان الشركة</th>
                                <td>{{$setting->address}}</td>
                            </tr>
                            <tr>
                                <th class="width30">هاتف الشركة</th>
                                <td>{{$setting->phone}}</td>
                            </tr>
                            <tr>
                                <th class="width30">لوجو الشركة</th>
                                <td>
                                    <div class="image">
                                        <img src="{{asset($setting->logo)}}" alt="company logo" class="custom_img">
                                    </div>
                                </td>
                            </tr>

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
@endsection
