@extends('layouts.admin')
@section('title', 'تعديل بيانات العميل')
@section('main-color', 'info')
@section('prev-link', route('customers.index'))
@section('prev-link-title', 'بيانات العملاء')
@section('content-title', 'بيانات العميل')
@section('content-page-name', ' تعديل بيانات العميل ')

@section('content')



    <div class="row">
        <div class="col-12">
            <div class="card card-info card-outline">
                <div class="card-header">
                    <h5 class="card-title">تعديل بيانات العميل</h5>
                </div>


                <div class="card-body">
                    <div class="row">
                        <div class="col-md-8 ml-auto">
                                <div class="card-body box-profile">
                                    <div class="text-center">

                                        <img class="profile-user-img img-fluid img-circle" id="showImage"
                                             src="{{asset("uploads/no-user.jpg")}}"
                                             alt="User profile picture">
                                    <h3 class="profile-username text-center">{{$customer->name}}</h3>

                                    <p class="text-muted text-center">{{$customer->address}}</p>
                                    </div>
                                    <div>
                                        <form action="{{route('customers.update', $customer->id)}}" method="post">
                                            @csrf
                                            @method('put')
                                                <div class="form-group">
                                                    <label for="name">اسم العميل</label>
                                                    <input type="text" class="form-control" id="name" placeholder="اسم العميل"  name="name" value="{{$customer->name ?? old('name')}}"  required>
                                                    @error('name') <p class="text-danger">{{ $message }}</p> @enderror
                                                </div>
                                            <div class="form-group">
                                                <label for="phone">رقم الهاتف</label>
                                                <input type="text" class="form-control" id="phone" placeholder="010101010"  name="phone" value="{{$customer->phone ?? old('name')}}" >
                                                @error('phone') <p class="text-danger">{{ $message }}</p> @enderror
                                            </div>
                                            <div class="form-group">
                                                <label for="address">عنوان العميل</label>
                                                <input type="text" class="form-control" id="address" placeholder="المحافظة - المركز - الشارع ( او منطقة مشهورة)"  name="address" value="{{$customer->address ?? old('address')}}" >
                                                @error('address') <p class="text-danger">{{ $message }}</p> @enderror
                                            </div>

                                                <div class="form-group text-center">
                                                <button class="btn btn-outline-info">تعديل</button>
                                                </div>
                                        </form>
                                    </div>
                             </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection


