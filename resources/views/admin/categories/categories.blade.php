@extends('layouts.adminLayouts.admin_layout')
@section('header', 'Catalogues')
@section('title', 'Categories')
@section('content')
<div class="col-12">
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
            <th>Name</th>
            <th>URL</th>
            <th>Status</th>
          </tr>
          </thead>
          <tbody>
          @foreach ($categories as $cat)
          <tr>
            <td>{{ $cat->id }}</td>
            <td>{{ $cat->category_name }}</td>
            <td>{{ $cat->url }}</td>
            <td>
                @if ($cat->status == 1)
                    <a href="javascript:void(0)" class="updateCategoryStatus" id="category-{{ $cat->id }}" category_id="{{ $cat->id }}">Active</a>
                @else
                    <a href="javascript:void(0)" class="updateCategoryStatus" id="category-{{ $cat->id }}" category_id="{{ $cat->id }}">Inactive</a>
                @endif
            </td>
          </tr>
          @endforeach
          </tbody>
          <tfoot>
          <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Status</th>
          </tr>
          </tfoot>
        </table>
      </div>
      <!-- /.card-body -->
    </div>
    <!-- /.card -->
</div>
@endsection