@extends('layouts.admin')
@section('title', '7Star system')
@section('main-color', 'info')
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
                                        <form action="{{route('profile.update')}}" method="post" enctype="multipart/form-data">
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
                                                    <label for="image">الصورة الشخصية</label>
                                                    <div class="custom-file">
                                                        <input type="file" class="form-control" name="image" id="image">
                                                        <label class="custom-file-label" for="image">تحديث الصورةالشخصية</label>
                                                    </div>
                                                    @error('image') <p class="text-danger">{{ $message }}</p> @enderror
                                                </div>
                                                <div class="form-group text-center">
                                                <button class="btn btn-outline-info">تحديث الملف الشخصي</button>
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
