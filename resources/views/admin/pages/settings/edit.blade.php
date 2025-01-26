@extends('layouts.admin')
@section('title', 'البيانات العامة')
@section('main-color', 'info')
@section('prev-link', route('settings.index'))
@section('prev-link-title', 'البيانات العامة')
@section('content-title', 'تعديل البيانات')
@section('content-page-name', 'تعديل البيانات العامة')

@section('content')



    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title card_title_center">بيانات الضبط العام</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">

                    @if(!empty($setting))

                        <form action="{{route('settings.update', $setting->id)}}" method="post" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="form-group">
                                <label for="name"> اسم الشركة </label>
                                <input type="text" name="name" id="name" class="form-control" value="{{old('name') ?? $setting->name}}" required
                                       placeholder="ادخل اسم الشركة" oninvalid="setCustomValidity('من فضلك ادخل بعض البيانات')" onchange="try{setCustomValidity('')}catch(e){}">
                                @error('name') <span class="text-danger">{{$message}}</span> @enderror
                            </div>

                            <div class="form-group">
                                <label for="address"> عنوان الشركة </label>
                                <input type="text" name="address" id="address" class="form-control" value="{{old('address') ?? $setting->address}}" required
                                       placeholder="ادخل عنوان الشركة" oninvalid="setCustomValidity('من فضلك ادخل بعض البيانات')" onchange="try{setCustomValidity('')}catch(e){}">
                                @error('address') <span class="text-danger">{{$message}}</span> @enderror
                            </div>

                            <div class="form-group">
                                <label for="phone"> هاتف الشركة </label>
                                <input type="text" name="phone" id="phone" class="form-control" value="{{old('phone') ?? $setting->phone}}" required
                                       placeholder="ادخل هاتف الشركة" oninvalid="setCustomValidity('من فضلك ادخل بعض البيانات')" onchange="try{setCustomValidity('')}catch(e){}">
                                @error('phone') <span class="text-danger">{{$message}}</span> @enderror
                            </div>
                            <div class="form-group">
                                <label for="return_period"> اقصى مدة لعملة الاسترجاع </label>
                                <input type="number" name="return_period" min="1" max="30" id="return_period" class="form-control" value="{{old('return_period') ?? $setting->return_period}}" required
                                       placeholder="7">
                                @error('return_period') <span class="text-danger">{{$message}}</span> @enderror
                            </div>
                            <div class="form-group">
                                <label for="exchange_period"> اقصى مدة لعملة الاستبدال </label>
                                <input type="number" name="exchange_period" min="1" max="30" id="exchange_period" class="form-control" value="{{old('exchange_period') ?? $setting->exchange_period}}" required
                                       placeholder="14"  >
                                @error('exchange_period') <span class="text-danger">{{$message}}</span> @enderror
                            </div>

                            <div class="form-group">
                                <label for="description">وصف </label>
                                <input type="text" name="description" id="description" class="form-control" value="{{old('description') ?? $setting->description}}"
                                       placeholder="قم باضافة وصف للشركة" oninvalid="setCustomValidity('من فضلك ادخل بعض البيانات')" onchange="try{setCustomValidity('')}catch(e){}">
                                @error('description') <span class="text-danger">{{$message}}</span> @enderror

                            </div>

                            <div class="form-group">
                                <label for="img">شعار الشركة </label>
                                <div class="image" >
                                    <img src="{{asset($setting->logo)}}" alt="logo" class="custom_img" id="showImage" >
                                    <button type="button" id="updateImg" class="btn btn-sm btn-danger">تغير الصورة</button>
                                    <button type="button" id="cancelUpdateImg" style="display:none;" class="btn btn-sm btn-success">الغاء التغيير</button>
                                    @error('logo') <span class="text-danger">{{$message}}</span> @enderror
                                </div>
                                <div id="oldImg">

                                </div>


                            </div>
                            <div class="form-group text-center">
                                <button type="submit" class="btn btn-info">حفظ التعديلات</button>

                            </div>



                        </form>


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

@push('js')
    <script src="{{asset('js/image.js')}}"></script>
    @endpush
