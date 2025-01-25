@extends('layouts.admin')
@section('title', 'بيانات المستخدم')
@section('main-color', 'info')
@section('prev-link', route('users.index'))
@section('prev-link-title', 'الصفحة الرئيسية')
@section('content-title', 'بيانات المستخدم')
@section('content-page-name', 'تعديل بيانات المستخدم')

@section('content')



    <div class="row">
        <div class="col-12">
            <div class="card card-info card-outline">
                <div class="card-header">
                    <h5 class="card-title">تعديل بيانات المستخدم</h5>
                </div>


                <div class="card-body">
                    <div class="row">
                        <div class="col-md-8 ml-auto ">
                                <div class="card-body box-profile">
                                    <div class="text-center">

                                        <img class="profile-user-img img-fluid img-circle" id="showImage"
                                             src="{{ $user->image ? asset($user->image) : asset("uploads/no-user.jpg")}}"
                                             alt="User profile picture">
                                    <h3 class="profile-username text-center">{{$user->name}}</h3>

                                    <p class="text-muted text-center">{{$user->email}}</p>
                                    </div>
                                    <div class="mb-4">
                                        <form action="{{route('users.update', $user->id)}}" method="post" enctype="multipart/form-data">
                                            @csrf
                                            @method('put')
                                                <div class="form-group">
                                                    <label for="name">الاسم الشخصي</label>
                                                    <input type="text" class="form-control" id="name" placeholder="اسم المستخدم"  name="name" value="{{$user->name ?? old('name')}}" required>
                                                    @error('name') <p class="text-danger">{{ $message }}</p> @enderror
                                                </div>
                                                <div class="form-group">
                                                    <label for="username">اسم المستخدم</label>
                                                    <input type="text" class="form-control"  placeholder="اسم المستخدم" name="username" value="{{$user->username ?? old('username')}}"  required>
                                                    @error('username') <p class="text-danger">{{ $message }}</p> @enderror

                                                </div>
                                                <div class="form-group">
                                                    <label for="email">البريد الاكتروني</label>
                                                    <input type="email" class="form-control"  placeholder="البريد الاكتروني" name="email" value="{{$user->email ?? old('email')}}"  required>
                                                    @error('email') <p class="text-danger">{{ $message }}</p> @enderror
                                                </div>
                                                <div class="form-group">
                                                    <label>دور المستخدم</label>
                                                    <select class="form-control" name="role" required>
                                                        <option value="user" @selected($user->role === 'user')>مستخدم</option>
                                                        <option value="admin"  @selected($user->role === 'admin') >ادمن</option>
                                                    </select>
                                                    @error('role') <p class="text-danger">{{$message}}</p> @enderror
                                                </div>

                                                <div class="form-group">
                                                    <label for="image">الصورة الشخصية</label>
                                                    <div class="custom-file">
                                                        <input type="file" class="form-control" name="image" id="image">
                                                        <label class="custom-file-label" for="image">تحديث الصورةالشخصية</label>
                                                    </div>
                                                    @error('image') <p class="text-danger">{{ $message }}</p> @enderror
                                                </div>
                                                <div class="form-group text-center">
                                                <button class="btn btn-outline-info">تحديث ملف المستخدم</button>
                                                </div>
                                        </form>
                                    </div>
                                    <hr >
                                    <hr >
                                    <div class="mt-3">
                                        <form action="{{route('users.update.password', $user->id)}}" method="post">
                                            @csrf
                                            @method('put')
                                            <div class="form-group">
                                                <label for="password">كلمة المرور</label>
                                                <input type="password" class="form-control" id="password" placeholder="كلمة المرور (بحد ادنى 6احرف)"  name="password"  required>
                                                @error('password') <p class="text-danger">{{ $message }}</p> @enderror
                                            </div>
                                            <div class="form-group">
                                                <label for="password_confirmation">تأكيد كلمة المرور</label>
                                                <input type="password" class="form-control" id="password_confirmation" placeholder="اعد كتابة كلمة المرور"  name="password_confirmation"  required>
                                                @error('password_confirmation') <p class="text-danger">{{ $message }}</p> @enderror
                                            </div>

                                            <div class="form-group text-center">
                                                <button class="btn btn-outline-info">تغيير كلمة مرور المستخدم</button>
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

@push('js')
    <script type="text/javascript">
        $(document).ready(function() {
            $('#image').change(function(e){
                var reader = new FileReader();
                reader.onload = function (e) {
                    $('#showImage').attr('src',e.target.result)
                }
                reader.readAsDataURL(e.target.files['0']);
            });
        });

    </script>@endpush
