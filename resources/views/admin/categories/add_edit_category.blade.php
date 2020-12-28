@extends('layouts.adminLayouts.admin_layout')
@section('header', 'Catalogue')
@section('title', $title)
@section('content')
<!-- SELECT2 EXAMPLE -->
<div class="col-12">
    @if (Session::has('error_message'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ Session::get('error_message') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @elseif(Session::has('success_message'))
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
    <form action="{{ url('admin/add-edit-category') }}" method="post" name="categoryForm" id="categoryForm" enctype="multipart/form-data">
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
                            <input type="text" class="form-control" id="category_name" name="category_name" placeholder="Enter Category Name">
                        </div>
                        
                        <!-- /.form-group -->
                        <div class="form-group">
                            <label>Category Level</label>
                            <select name="parent_id" id="parent_id" class="form-control" style="width: 100%;">
                                <option value="0">Main Categories</option>
                                @foreach ($getCategory as $cat)
                                    @if ($cat->parent_id == 0)
                                        <option value="{{ $cat->id }}">{{ $cat->category_name }}</option>
                                    @endif
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="category_discount">Category Discount</label>
                            <input type="text" class="form-control" id="category_discount" name="category_discount">
                        </div>
                        <div class="form-group">
                            <label for="category_description">Category Description</label>
                            <textarea name="description" id="description" rows="3" class="form-control" placeholder="Enter description"></textarea>
                        </div>
                        <!-- /.form-group -->
                    </div>
                    <!-- /.col -->
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Select Section</label>
                            <select name="section_id" id="section_id" class="form-control" style="width: 100%;">
                                @foreach ($getSections as $sec)
                                    <option value="{{ $sec->id }}">{{ $sec->name }}</option>
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
                        </div>
                        <div class="form-group">
                            <label for="category_url">Category URL</label>
                            <input type="text" class="form-control" id="url" name="url">
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
                                <textarea name="meta_title" id="meta_title" rows="3" class="form-control" placeholder="Enter meta title"></textarea>
                            </div>
                            <div class="form-group">
                                <label for="meta_description">Meta Description</label>
                                <textarea name="meta_description" id="meta_description" rows="3" class="form-control" placeholder="Enter meta description"></textarea>
                            </div>
                        </div>
                        <!-- /.col -->
                        <div class="col-12 col-sm-6">
                            <div class="form-group">
                                <label for="meta_keywords">Meta Keyword</label>
                                <textarea name="meta_keywords" id="meta_keywords" rows="3" class="form-control" placeholder="Enter meta description"></textarea>
                            </div>
                        </div>
                        <!-- /.col -->
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
</div>
@endsection