@extends('layouts.admin')
@section('title', '7Star system')
@section('main-color', 'info')
@section('prev-link', route('dashboard'))
@section('prev-link-title', 'الصفحة الرئيسية')
@section('content-title', 'تعديل البيانات')
@section('content-page-name', 'تغيير كلمة المرور')

@section('content')



    <div class="row">
        <div class="col-12">
            <div class="card card-info card-outline">
                <div class="card-header">
                    <h5 class="card-title">تغيير كلمة المرور</h5>
                </div>


                <div class="card-body">
                    <div class="row">
                        <div class="col-md-8 ml-auto">
                                <div class="card-body box-profile">
                                    <div class="text-center">

                                        <img class="profile-user-img img-fluid img-circle" id="showImage"
                                             src="{{ $user->image ? asset($user->image) : asset("uploads/no-user.jpg")}}"
                                             alt="User profile picture">
                                    <h3 class="profile-username text-center">{{$user->name}}</h3>

                                    <p class="text-muted text-center">{{$user->email}}</p>
                                    </div>
                                    <div>
                                        <form action="{{route('profile.update.password')}}" method="post">
                                            @csrf
                                            @method('put')
                                                <div class="form-group">
                                                    <label for="password">كلمة المرور</label>
                                                    <input type="password" class="form-control" id="password" placeholder="كلمة المرور"  name="password"  required>
                                                    @error('password') <p class="text-danger">{{ $message }}</p> @enderror
                                                </div>
                                            <div class="form-group">
                                                <label for="password_confirmation">تأكيد كلمة المرور</label>
                                                <input type="password" class="form-control" id="password_confirmation" placeholder="اعد كتابة كلمة المرور"  name="password_confirmation"  required>
                                                @error('password_confirmation') <p class="text-danger">{{ $message }}</p> @enderror
                                            </div>

                                                <div class="form-group text-center">
                                                <button class="btn btn-outline-info">تغيير كلمة المررور</button>
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


