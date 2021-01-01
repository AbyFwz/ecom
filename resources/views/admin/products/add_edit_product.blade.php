@extends('layouts.adminLayouts.admin_layout')
@section('header', 'Catalogue')
@section('title', $title)
@section('content')
<!-- SELECT2 EXAMPLE -->
<div class="col-12">
    @if(Session::has('success_message'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ Session::get('success_message') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif
    @if ($errors->any())
        <div class="alert alert-dismissible fade show" role="alert">
            <ul class="list-group">
                <li class="list-group-item list-group-item-danger">
                    <ol>
                        @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                        
                    </ol>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </li>
            </ul>
        </div>
    @endif
    <form @if(empty($productData['id'])) action="{{ url('admin/add-edit-product') }}" @else action="{{ url('admin/add-edit-product/'.$productData['id']) }}" @endif method="post" name="productForm" id="productForm" enctype="multipart/form-data">
    @csrf
        <div class="card card-default">
            <div class="card-header">
                <h3 class="card-title">{{ $title }}</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body"> 
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Select Category</label>
                            <select name="category_id" id="category_id" class="form-control" style="width: 100%;">
                                <option value="">Select</option>
                                @foreach ($categories as $sec)
                                    <optgroup label="{{ $sec['name'] }}">
                                        @foreach ($sec['categories'] as $cat)
                                            <option value="{{ $cat['id'] }}" @if(!empty($productData['category_id']) && $productData['category_id'] == $cat['id']) selected @endif>&nbsp;&raquo;&nbsp;{{ $cat['category_name'] }}</option>
                                            @foreach ($cat['subcategories'] as $subcat)
                                                <option value="{{ $subcat['id'] }}" @if(!empty($productData['category_id']) && $productData['category_id'] == $subcat['id']) selected @endif>&nbsp;&nbsp;&nbsp;&raquo;&nbsp;{{ $subcat['category_name'] }}</option>
                                            @endforeach
                                        @endforeach
                                    </optgroup>
                                @endforeach
                            </select>
                        </div>
                    </div> 
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Select Brands</label>
                            <select name="brand_id" id="brand_id" class="form-control" style="width: 100%;">
                                <option value="">Select</option>
                                @foreach ($brands as $brand)
                                    <option value="{{ $brand['id'] }}" @if(!empty($productData['brand_id']) && $productData['brand_id'] == $brand['id']) selected @endif>{{ $brand['name'] }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>   
                </div>           
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="product_name">Product Name</label>
                            <input type="text" class="form-control" id="product_name" name="product_name" placeholder="Enter product Name" @if(!empty($productData['product_name'])) value="{{ $productData['product_name'] }}" @else value="{{ old('product_name') }}"  @endif>
                        </div>
                        <div class="form-group">
                            <label for="product_price">product Price</label>
                            <input type="number" class="form-control" id="product_price" name="product_price" @if(!empty($productData['product_price'])) value="{{ $productData['product_price'] }}" @else value="{{ old('product_price') }}"  @endif>
                        </div>
                        <div class="form-group">
                            <label for="product_discount">product Discount</label>
                            <input type="text" class="form-control" id="product_discount" name="product_discount" @if(!empty($productData['product_discount'])) value="{{ $productData['product_discount'] }}" @else value="{{ old('product_discount') }}"  @endif>
                        </div>
                    </div>
                    <!-- /.col -->
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="product_code">Product Code</label>
                            <input type="text" class="form-control" id="product_code" name="product_code" placeholder="Enter product Code" @if(!empty($productData['product_code'])) value="{{ $productData['product_code'] }}" @else value="{{ old('product_code') }}"  @endif>
                        </div>
                        <div class="form-group">
                            <label for="product_color">Product Color</label>
                            <input type="text" class="form-control" id="product_color" name="product_color" placeholder="Enter product Color" @if(!empty($productData['product_color'])) value="{{ $productData['product_color'] }}" @else value="{{ old('product_color') }}"  @endif>
                        </div>
                        <div class="form-group">
                            <label for="product_weight">Product Weight</label>
                            <input type="text" class="form-control" id="product_weight" name="product_weight" placeholder="Enter product Weight" @if(!empty($productData['product_weight'])) value="{{ $productData['product_weight'] }}" @else value="{{ old('product_weight') }}"  @endif>
                        </div>
                    </div>
                    <!-- /.col -->
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Product Video</label>
                            <div class="input-group">
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" accept="video/*" name="product_video">
                                    <label class="custom-file-label" for="product_image">Choose File</label>
                                </div>
                                <div class="input-group-append">
                                    <span class="input-group-text" id="">Upload</span>
                                </div>
                            </div>
                            @if (!empty($productData['product_video']))
                                <div class="mt-2">
                                    <a href="{{ url('videos/product/'.$productData['product_video']) }}">Download</a>
                                    &nbsp; | &nbsp;
                                    <a record="product-video" recordid="{{ $productData['id'] }}" href="javascript:void(0)" class="confirmDelete">Delete video</a>
                                </div>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Product Image</label>
                            <div class="input-group">
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" accept="image/*" name="main_image">
                                    <label class="custom-file-label" for="main_image">Choose File</label>
                                </div>
                                <div class="input-group-append">
                                    <span class="input-group-text" id="">Upload</span>
                                </div>
                            </div>
                            @if (!empty($productData['main_image']))
                                <div class="mt-2">
                                    <img src="{{ asset('img/product/small/'.$productData['main_image']) }}" alt="product Image" class="img-thumbnail">
                                    <a record="product-image" recordid="{{ $productData['id'] }}" href="javascript:void(0)" class="btn btn-primary mx-auto d-block mt-1 confirmDelete">Delete image</a>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="product_description">Product Description</label>
                            <textarea name="description" id="description" rows="3" class="form-control" placeholder="Enter description">@if(!empty($productData['description'])) {{ $productData['description'] }} @else {{ old('description') }} @endif</textarea>
                        </div>
                        <div class="form-group">
                            <label>Select Fabric</label>
                            <select name="fabric" id="fabric" class="form-control" style="width: 100%;">
                                <option value="">Select</option>
                                @foreach ($fabricArray as $fabric)
                                    <option value="{{ $fabric }}" @if(!empty($productData['fabric']) && $productData['fabric'] == $fabric) selected @endif>{{ $fabric }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Select Sleeve</label>
                            <select name="sleeve" id="sleeve" class="form-control" style="width: 100%;">
                                <option value="">Select</option>
                                @foreach ($sleeveArray as $sleeve)
                                    <option value="{{ $sleeve }}" @if(!empty($productData['sleeve']) && $productData['sleeve'] == $sleeve) selected @endif>{{ $sleeve }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Select Pattern</label>
                            <select name="pattern" id="pattern" class="form-control" style="width: 100%;">
                                <option value="">Select</option>
                                @foreach ($patternArray as $pattern)
                                    <option value="{{ $pattern }}" @if(!empty($productData['pattern']) && $productData['pattern'] == $pattern) selected @endif>{{ $pattern }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="wash_care">Wash Care</label>
                            <textarea name="wash_care" id="wash_care" rows="3" class="form-control" placeholder="Enter meta title">@if(!empty($productData['wash_care'])) {{ $productData['wash_care'] }} @else {{ old('wash_care') }} @endif</textarea>
                        </div>
                        <div class="form-group">
                            <label>Select Fit</label>
                            <select name="fit" id="fit" class="form-control" style="width: 100%;">
                                <option value="">Select</option>
                                @foreach ($fitArray as $fit)
                                    <option value="{{ $fit }}" @if(!empty($productData['fit']) && $productData['fit'] == $fit) selected @endif>{{ $fit }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Select Occasion</label>
                            <select name="occasion" id="occasion" class="form-control" style="width: 100%;">
                                <option value="">Select</option>
                                @foreach ($occasionArray as $occasion)
                                    <option value="{{ $occasion }}" @if(!empty($productData['occasion']) && $productData['occasion'] == $occasion) selected @endif>{{ $occasion }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="is_featured">Is Featured Product?</label>
                            <select name="is_featured" id="is_featured" class="form-control" style="width: 100%">
                                <option value="">Select</option>
                                <option value="yes" @if(!empty($productData['is_featured']) && $productData['is_featured'] == 'Yes') selected @endif>Yes</option>
                                <option value="no" @if(!empty($productData['is_featured']) && $productData['is_featured'] == 'No') selected @endif>No</option>
                            </select>
                        </div>
                    </div>
                </div>
                    <!-- /.row -->
                <div class="row">
                    <div class="col-12 col-sm-6">
                        <div class="form-group">
                            <label for="meta_title">Meta Title</label>
                            <textarea name="meta_title" id="meta_title" rows="3" class="form-control" placeholder="Enter meta title">@if(!empty($productData['meta_title'])) {{ $productData['meta_title'] }} @else {{ old('meta_title') }} @endif</textarea>
                        </div>
                        <div class="form-group">
                            <label for="meta_description">Meta Description</label>
                            <textarea name="meta_description" id="meta_description" rows="3" class="form-control" placeholder="Enter meta description">@if(!empty($productData['meta_description'])) {{ $productData['meta_description'] }} @else {{ old('meta_description') }} @endif</textarea>
                        </div>
                    </div>
                    <!-- /.col -->
                    <div class="col-12 col-sm-6">
                        <div class="form-group">
                            <label for="meta_keywords">Meta Keyword</label>
                            <textarea name="meta_keywords" id="meta_keywords" rows="3" class="form-control" placeholder="Enter meta description" >@if(!empty($productData['meta_keywords'])) {{ $productData['meta_keywords'] }} @else {{ old('meta_keywords') }} @endif</textarea>
                        </div>
                    </div>
                    <!-- /.col -->
                </div>
                <!-- /.row -->
            </div>
            <!-- /.card-body -->
            <div class="card-footer">
                <button type="submit" class="btn btn-primary float-right">Submit</button>
            </div>
        </div>
    </form>
</div>
@endsection