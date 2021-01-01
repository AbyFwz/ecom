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
    @elseif(Session::has('error_message'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ Session::get('error_message') }}
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
    <form action="{{ url('/admin/add-images/'.$productData['id']) }}" method="post" name="attributForm" id="attributForm" enctype="multipart/form-data">
    @csrf
        <input type="hidden" name="product_id" value="{{ $productData['id'] }}">
        <div class="card card-default">
            <div class="card-header">
                <h3 class="card-title">{{ $title }}</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">          
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="product_name">Product Name</label>
                            <input type="text" class="form-control" id="product_name" name="product_name" placeholder="Enter product Name" @if(!empty($productData['product_name'])) value="{{ $productData['product_name'] }}" @else value="{{ old('product_name') }}"  @endif readonly>
                        </div>
                        <div class="form-group">
                            <label for="product_code">Product Code</label>
                            <input type="text" class="form-control" id="product_code" name="product_code" placeholder="Enter product Code" @if(!empty($productData['product_code'])) value="{{ $productData['product_code'] }}" @else value="{{ old('product_code') }}"  @endif readonly>
                        </div>
                        <div class="form-group">
                            <label for="product_color">Product Color</label>
                            <input type="text" class="form-control" id="product_color" name="product_color" placeholder="Enter product Color" @if(!empty($productData['product_color'])) value="{{ $productData['product_color'] }}" @else value="{{ old('product_color') }}"  @endif readonly>
                        </div>
                    </div>
                    <!-- /.col -->
                    <div class="col-md-6">
                        
                        @if (!empty($productData['main_image']))
                            <div class="form-group">
                                <img src="{{ asset('img/product/small/'.$productData['main_image']) }}" alt="product Image" class="img-thumbnail">
                            </div>
                        @else
                            <div class="form-group">
                                <img src="{{ asset('img/product/small/no-image.jpg') }}" alt="product Image" class="img-thumbnail">
                            </div>
                        @endif
                    </div>
                    <!-- /.col -->
                </div>
                    <!-- /.row -->
                <div class="attr-form">
                    <div class="form-row mb-2">
                        <div class="col-auto">
                            <input id="images" name="images[]" type="file" class="form-control" value="" required multiple>    
                        </div>
                    </div>
                </div>
                <!-- /.row -->
            </div>
            <!-- /.card-body -->
            <div class="card-footer">
                <button type="submit" class="btn btn-primary float-right">Submit</button>
            </div>
        </div>
    </form>
    <form name="editImageForm" name="editImageForm" action="{{ url('admin/edit-images/'.$productData['id']) }}" method="post" enctype="multipart/form-data">
        @csrf
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Added Product Images</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <table id="productsimage" class="table table-bordered table-hover">
                    <thead>
                        <tr>
                        <th>ID</th>
                        <th>Image</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                        @foreach ($productData['images'] as $img)
                        <input style="display:none" type="text" name="attrId[]" id="attrId[]" value="{{ $img['id'] }}" >
                        <tr>
                            <td>{{ $img['id'] }}</td>
                            <td>
                                <img src="{{ asset('img/product/small/'.$img['image']) }}" alt="product Image" class="img-thumbnail">
                            </td>
                            <td>
                                @if ($img['status'] == 1)
                                    <a href="javascript:void(0)" class="updateImageStatus" id="image-{{ $img['id'] }}" image_id="{{ $img['id'] }}"><i class="fas fa-toggle-on" status="Active" aria-hidden="true"></i></a>
                                @else
                                    <a href="javascript:void(0)" class="updateImageStatus" id="image-{{ $img['id'] }}" image_id="{{ $img['id'] }}"><i class="fas fa-toggle-off" status="Inactive" aria-hidden="true"></i></a>
                                @endif
                            </td>
                            <td>
                                <a title="Delete Product" href="javascript:void(0)" class="confirmDelete" record="image" recordid="{{ $img['id'] }}"><i class="fas fa-trash" aria></i></a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <th>ID</th>
                            <th>Image</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </tfoot>
                </table>
            </div>
            <!-- /.card-body -->
            <div class="card-footer">
                <button type="submit" class="btn btn-primary float-right">Update</button>
            </div>
        </div>
    </form>
</div>
@endsection