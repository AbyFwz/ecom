@extends('layouts.adminLayouts.admin_layout')
@section('header', 'Catalogues')
@section('title', 'Categories')
@section('content')
<div class="col-12">
    @if(Session::has('error_message'))
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
    <div class="card">
      <div class="card-header">
        <h3 class="card-title">Category</h3>
        <a href="{{ url('admin/add-edit-category') }}" class="btn btn-block btn-success" style="max-width: 150px; float: right; display: inline-block">Add Category</a>
      </div>
      <!-- /.card-header -->
      <div class="card-body">
        <table id="category" class="table table-bordered table-hover">
          <thead>
          <tr>
            <th>ID</th>
            <th>Category</th>
            <th>Parent Category</th>
            <th>Section</th>
            <th>URL</th>
            <th>Status</th>
            <th>Action</th>
          </tr>
          </thead>
          <tbody>
          @foreach ($categories as $cat)
          @if (!isset($cat->parentcategory->category_name))
              <?php $parent_category = "Root"; ?>
          @else
              <?php $parent_category = $cat->parentcategory->category_name ?>
          @endif
          <tr>
            <td>{{ $cat->id }}</td>
            <td>{{ $cat->category_name }}</td>
            <td>{{ $parent_category }}</td>
            <td>{{ $cat->section->name }}</td>
            <td>{{ $cat->url }}</td>
            <td>
              @if ($cat->status == 1)
                <a href="javascript:void(0)" class="updateCategoryStatus" id="category-{{ $cat->id }}" category_id="{{ $cat->id }}"><i class="fas fa-toggle-on" status="Active" aria-hidden="true"></i></a>
              @else
                <a href="javascript:void(0)" class="updateCategoryStatus" id="category-{{ $cat->id }}" category_id="{{ $cat->id }}"><i class="fas fa-toggle-off" status="Inactive" aria-hidden="true"></i></a>
              @endif
            </td>
            <td>
              <a title="Edit Categories" href="{{ url('admin/add-edit-category/'.$cat->id) }}"><i class="fas fa-edit"></i></a>
              <a title="Delete Categories" href="javascript:void(0)" class="confirmDelete" record="category" recordid="{{ $cat->id }}"><i class="fas fa-trash"></i></a>
              {{-- href="{{ url('admin/delete-category/'.$cat->id) }}" --}}
            </td>
          </tr>
          @endforeach
          </tbody>
        </table>
      </div>
      <!-- /.card-body -->
    </div>
    <!-- /.card -->
</div>
@endsection 