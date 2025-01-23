@extends('layouts.admin')

@section('title', 'منتج جديد')
@section('prev-link', route('products.index'))
@section('prev-link-title', 'المنتجات')
@section('content-title', 'اضافة منتج')
@section('content-page-name', 'اضافة منتج')

@section('content')



    <div class="row">
        <div class="col-12">
             <div class="card card-primary card-outline">
                <div class="card-header">
                    <h5 class="card-title">اضافة منتج جديد</h5>

                </div>
                 <form action="{{route('products.store')}}" method="post" enctype="multipart/form-data">
                    <div class="card-body">
                            @csrf

                        <div class="row">
                            <div class="col-md-6">

                                <div class="form-group">
                                    <label >الباركود</label>
                                    <input type="text" class="form-control" placeholder="Enter Barcode" value="{{$barcode}}" name="code" readonly autocomplete="off">
                                    @error('code') <p class="text-danger">{{ $message }}</p> @enderror
                                </div>

                                <div class="form-group">
                                    <label >اسم المنتج</label>
                                    <input type="text" class="form-control" placeholder="ادخل اسم المنتج" name="name" value="{{old('name')}}" required>
                                    @error('name') <p class="text-danger">{{ $message }}</p> @enderror
                                </div>

                                <div class="form-group">
                                    <label>الفئة</label>
                                    <select class="form-control" name="category_id" required>
                                        <option value="" disabled selected>اختر الفئة</option>
                                        @foreach($categories as $category)
                                            <option value="{{$category->id}}"
                                            @selected($category->id == old('description'))>{{$category->name}}</option>
                                        @endforeach
                                    </select>
                                    @error('category_id') <p class="text-danger">{{ $message }}</p> @enderror
                                </div>
                                <div class="form-group">
                                    <label>الموزع (اختياري</label>
                                    <select class="form-control" name="supplier_id">
                                        @foreach($suppliers as $supplier)
                                            <option value="{{$supplier->id}}"
                                                @selected($supplier->id == old('supplier_id'))>{{$supplier->name}}</option>
                                        @endforeach
                                            @error('supplier_id') <p class="text-danger">{{ $message }}</p> @enderror
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>الوصف (اختياري)</label>
                                    <textarea class="form-control" placeholder="اضف وصف للمنتج" name="description" rows="4">{{old('description')}}</textarea>
                                </div>
                                @error('description') <p class="text-danger">{{ $message }}</p> @enderror
                            </div>
                            <div class="col-md-6">


                                <div class="form-group">
                                    <label >الكمية في المخزن</label>
                                    <input type="number" min="1" step="1" class="form-control" placeholder="الكمية الموجودة في المخزن" name="stock" value="{{old('stock')}}" required>
                                    @error('stock') <p class="text-danger">{{ $message }}</p> @enderror
                                </div>


                                <div class="form-group">
                                    <label >سعر الشراء</label>
                                    <input type="number" min="1" step="1" class="form-control" placeholder="سعراء شراء المنتج (لحساب المكسب لاحقا)" name="buying_price" value="{{old('buying_price')}}" autocomplete="off" required>
                                    @error('buying_price') <p class="text-danger">{{ $message }}</p> @enderror

                                </div>

                                <div class="form-group">
                                    <label >سعر البيع</label>
                                    <input type="number" min="1" step="1" class="form-control" placeholder="سعراء بيع المنتج" name="selling_price" value="{{old('selling_price')}}" autocomplete="off" required>
                                    @error('selling_price') <p class="text-danger">{{ $message }}</p> @enderror
                                </div>


                                <div class="row align-items-center">
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label for="image" >اضافة صورة(اختياري)</label>
                                            <input type="file" class="input-group"  name="image" id="image" >
                                            <p>ارفع الصورة</p>
                                        </div>
                                    </div>

                                    <div class="col-6">
                                        <img id="showImage" src="{{url('uploads/no_image.jpg')}}" alt="product image" class="rounded-circle p-1 bg-primary" width="120">
                                    </div>
                                    @error('image') <p class="text-danger">{{ $message }}</p> @enderror

                                </div>

                            </div>
                        </div>
                    </div>
                     <div class="card-footer text-center">
                         <button type="submit" class="btn btn-primary" id="formButton">اضف منتج جديد</button>
                     </div>
                 </form>
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

    </script>
@endpush
