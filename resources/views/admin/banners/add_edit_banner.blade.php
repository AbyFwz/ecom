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
    <form @if(!empty($brand['id'])) @else action="{{ url('admin/add-edit-brand') }}" @endif method="post" name="brandForm" id="brandForm" enctype="multipart/form-data">
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
                            <div class="form-group">
                                <label>Banner Image</label>
                                <div class="input-group">
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input" accept="image/*" name="main_image">
                                        <label class="custom-file-label" for="main_image">Choose File</label>
                                    </div>
                                </div>
                                @if (!empty($banners['image']))
                                    <div class="mt-2">
                                        <img src="{{ asset('img/banner/small/'.$banners['image']) }}" alt="banner Image" class="img-thumbnail">
                                    </div>
                                @endif
                            </div>
                            <div class="form-group">
                                <label for="product_discount">Banner Link</label>
                                <input type="text" class="form-control" id="link" name="link" @if(!empty($productData['product_discount'])) value="{{ $productData['product_discount'] }}" @else value="{{ old('product_discount') }}"  @endif>
                            </div>
                        </div>
                    </div>
                    <!-- /.col -->
                    <div class="col-md-6">
                            
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