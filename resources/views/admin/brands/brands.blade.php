@extends('layouts.adminLayouts.admin_layout')
@section('header', 'Catalogues')
@section('title', 'Brands')
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
        <h3 class="card-title">brand</h3>
        <a href="{{ url('admin/add-edit-brand') }}" class="btn btn-block btn-success" style="max-width: 150px; float: right; display: inline-block">Add brand</a>
      </div>
      <!-- /.card-header -->
      <div class="card-body">
        <table id="brands" class="table table-bordered table-hover">
          <thead>
          <tr>
            <th>ID</th>
            <th>brand Name</th>
            <th>Status</th>
            <th>Action</th>
          </tr>
          </thead>
          <tbody>
          @foreach ($brands as $brand)
          <tr>
            <td>{{ $brand->id }}</td>
            <td>{{ $brand->name }}</td>
            <td>
                @if ($brand->status == 1)
                    <a href="javascript:void(0)" class="updateBrandStatus" id="brand-{{ $brand->id }}" brand_id="{{ $brand->id }}"><i class="fas fa-toggle-on" status="Active" aria-hidden="true"></i></a>
                @else
                    <a href="javascript:void(0)" class="updateBrandStatus" id="brand-{{ $brand->id }}" brand_id="{{ $brand->id }}"><i class="fas fa-toggle-off" status="Inactive" aria-hidden="true"></i></a>
                @endif
            </td>
            <td>
              <a title="Edit brand" href="{{ url('admin/add-edit-brand/'.$brand->id) }}"><i class="fas fa-edit"></i></a>
              <a title="Delete brand" href="javascript:void(0)" class="confirmDelete" record="brand" recordid="{{ $brand->id }}"><i class="fas fa-trash" aria></i></a>
            </td>
          </tr>
          @endforeach
          </tbody>
          <tfoot>
          <tr>
            <th>ID</th>
            <th>brand Name</th>
            <th>Status</th>
            <th>Action</th>
          </tr>
          </tfoot>
        </table>
      </div>
      <!-- /.card-body -->
    </div>
    <!-- /.card -->
</div>
@endsection 