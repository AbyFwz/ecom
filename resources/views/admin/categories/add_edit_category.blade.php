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
    <form @if(empty($categoryData['id'])) action="{{ url('admin/add-edit-category') }}" @else action="{{ url('admin/add-edit-category/'.$categoryData['id']) }}" @endif method="post" name="categoryForm" id="categoryForm" enctype="multipart/form-data">
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
                            <label for="category_name">Category Name</label>
                            <input type="text" class="form-control" id="category_name" name="category_name" placeholder="Enter Category Name" @if(!empty($categoryData['category_name'])) value="{{ $categoryData['category_name'] }}" @else value="{{ old('category_name') }}" @endif>
                        </div>
                        
                        <!-- /.form-group -->
                        <div id="appendCategoriesLevel">
                            @include('admin.categories.append_categories_level')
                        </div>

                        <div class="form-group">
                            <label for="category_discount">Category Discount</label>
                            <input type="text" class="form-control" id="category_discount" name="category_discount" @if(!empty($categoryData['category_discount'])) value="{{ $categoryData['category_discount'] }}" @else value="{{ old('category_discount') }}" @endif>
                        </div>
                        <div class="form-group">
                            <label for="category_description">Category Description</label>
                            <textarea name="description" id="description" rows="3" class="form-control" placeholder="Enter description">@if(!empty($categoryData['description'])) {{ $categoryData['description'] }} @else {{ old('description') }} @endif</textarea>
                        </div>
                        <!-- /.form-group -->
                    </div>
                    <!-- /.col -->
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Select Section</label>
                            <select name="section_id" id="section_id" class="form-control" style="width: 100%;">
                                <option value="">Select</option>
                                @foreach ($getSections as $sec)
                                    <option value="{{ $sec->id }}" @if(!empty($categoryData['section_id']) && $categoryData['section_id'] == $sec->id) selected @endif>{{ $sec->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <!-- /.form-group -->
                        <div class="form-group">
                            <label>Category Image</label>
                            <div class="input-group">
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" accept="image/*" name="category_image">
                                    <label class="custom-file-label" for="category_image">Choose File</label>
                                </div>
                                <div class="input-group-append">
                                    <span class="input-group-text" id="">Upload</span>
                                </div>
                            </div>
                            @if (!empty($categoryData['category_image']))
                                <div class="mt-2">
                                    <img src="{{ asset('img/category/'.$categoryData['category_image']) }}" alt="Category Image" class="img-thumbnail">
                                    <a record="category-image" recordid="{{ $categoryData['id'] }}" href="javascript:void(0)" class="btn btn-primary mx-auto d-block mt-1 confirmDelete">Delete image</a>
                                </div>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="category_url">Category URL</label>
                            <input type="text" class="form-control" id="url" name="url" @if(!empty($categoryData['url'])) value="{{ $categoryData['url'] }}" @else value="{{ old('url') }}" @endif>
                        </div>
                        <!-- /.form-group -->
                    </div>
                    <!-- /.col -->
                </div>
                <!-- /.row -->
                <div class="row">
                    <div class="col-12 col-sm-6">
                        <div class="form-group">
                            <label for="meta_title">Meta Title</label>
                            <textarea name="meta_title" id="meta_title" rows="3" class="form-control" placeholder="Enter meta title">@if(!empty($categoryData['meta_title'])) {{ $categoryData['meta_title'] }} @else {{ old('meta_title') }} @endif</textarea>
                        </div>
                        <div class="form-group">
                            <label for="meta_description">Meta Description</label>
                            <textarea name="meta_description" id="meta_description" rows="3" class="form-control" placeholder="Enter meta description">@if(!empty($categoryData['meta_description'])) {{ $categoryData['meta_description'] }} @else {{ old('meta_description') }} @endif</textarea>
                        </div>
                    </div>
                    <!-- /.col -->
                    <div class="col-12 col-sm-6">
                        <div class="form-group">
                            <label for="meta_keywords">Meta Keyword</label>
                            <textarea name="meta_keywords" id="meta_keywords" rows="3" class="form-control" placeholder="Enter meta description" >@if(!empty($categoryData['meta_keywords'])) {{ $categoryData['meta_keywords'] }} @else {{ old('meta_keywords') }} @endif</textarea>
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