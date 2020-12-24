@extends('layouts.adminLayouts.admin_layout')
@section('header', 'Settings')
@section('content')
    <!-- left column -->
    <div class="col-md-6">
      <!-- general form elements -->
      <div class="card card-primary">
        <div class="card-header">
          <h3 class="card-title">Change Password</h3>
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
        <!-- form start -->
        <form role="form" method="post" action="{{ url('admin/update-pwd') }}" name="updatePasswordForm" id="updatePasswordForm">
          @csrf
          <div class="card-body">
            <div class="form-group">
              <label for="admin_name">Name</label>
              <input name="admin_name" class="form-control" id="admin_name" value="{{ $adminDetails->name }}" placeholder="Enter Name">
            </div>
            <div class="form-group">
              <label for="admin_email">Email address</label>
              <input name="admin_email" class="form-control" id="admin_email" value="{{ $adminDetails->email }}" readonly>
            </div>
            <div class="form-group">
              <label for="admin_type">User Type</label>
              <input name="admin_type" type="text" class="form-control" id="admin_type" value="{{ $adminDetails->type }}" readonly>
            </div>
            <div class="form-group">
              <label for="current-password">Current Password</label>
              <input name="current_pwd" type="password" class="form-control" id="current_pwd" placeholder="Password" required>
              <span id="chkCurrentPwd"></span>
            </div>
            <div class="form-group">
              <label for="new-password">New Password</label>
              <input name="new_pwd" type="password" class="form-control" id="new_pwd" placeholder="New Password" required>
            </div>
            <div class="form-group">
              <label for="confirm-pwd">Confirm Passwrod</label>
              <input name="confirm_pwd" type="password" class="form-control" id="confirm_pwd" placeholder="Confirm Password" required>
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