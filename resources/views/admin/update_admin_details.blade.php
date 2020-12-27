@extends('layouts.adminLayouts.admin_layout')
@section('header', 'Settings')
@section('title', 'Update Admin Details')
@section('content')
    <!-- left column -->
    <div class="col-md-6">
      <!-- general form elements -->
      <div class="card card-primary">
        <div class="card-header">
          <h3 class="card-title">Update admin details</h3>
        </div>
        <!-- /.card-header -->
        @if (Session::has('error_message'))
          <div class="alert alert-danger alert-dissmissible fade show" role="alert" style="margin-top: 10px">
            {{ Session::get('error_message') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
        @elseif(Session::has('success_message'))
          <div class="alert alert-success alert-dissmissible fade show" role="alert" style="margin-top: 10px">
            {{ Session::get('success_message') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
        @endif
        @if ($errors->any())
        <div class="alert alert-danger fade show" role="alert" style="margin-top: 10px">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif
        <!-- form start -->
        <form role="form" method="post" action="{{ url('admin/update-admin-details') }}" name="updateAdminDetails" id="updateAdminDetails" enctype="multipart/form-data">
          @csrf
          <div class="card-body">
            <div class="form-group">
              <label for="admin_email">Email address</label>
              <input name="admin_email" class="form-control" id="admin_email" value="{{ Auth::guard('admin')->user()->email }}" readonly>
            </div>
            <div class="form-group">
              <label for="admin_type">User Type</label>
              <input name="admin_type" type="text" class="form-control" id="admin_type" value="{{ Auth::guard('admin')->user()->type }}" readonly>
            </div>
            <div class="form-group">
              <label for="admin_name">Name</label>
              <input name="admin_name" class="form-control" id="admin_name" value="{{ Auth::guard('admin')->user()->name }}" placeholder="Enter Name">
            </div>
            <div class="form-group">
              <label for="admin_mobile">Mobile</label>
              <input name="admin_mobile" class="form-control" id="admin_mobile" value="{{ Auth::guard('admin')->user()->mobile }}" placeholder="Enter Name">
            </div>
            <div class="form-group">
              <label for="admin_image">Image</label>
              <input type="file" name="admin_image" class="form-control" id="admin_image" accept="image/*">
              @if (!empty(Auth::guard('admin')->user()->image))
                  <a target="_blank" href="{{ url('img/admin/admin_photos/'.Auth::guard('admin')->user()->image) }}">View Image</a>
                  <input type="hidden" name="current_admin_image" value="{{ Auth::guard('admin')->user()->image }}">
              @endif
            </div>
          <!-- /.card-body -->

          <div class="card-footer">
            <button type="submit" class="btn btn-primary">Submit</button>
          </div>
        </form>
      </div>
      <!-- /.card -->
    </div>
    
@endsection