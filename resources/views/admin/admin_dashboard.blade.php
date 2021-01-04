@extends('layouts.adminLayouts.admin_layout')
@section('header', 'Dashboard')
@section('title', 'Dashboard')
@section('content')
<div class="col-12 col-sm-6 col-md-4">
    <div class="info-box">
        <span class="info-box-icon bg-info elevation-1"><i class="fas fa-users"></i></span>

        <div class="info-box-content">
            <span class="info-box-text">Total User</span>
            <span class="info-box-number">{{ $infoUser }}</span>
        </div>
        <!-- /.info-box-content -->
    </div>
    <!-- /.info-box -->
</div>
<!-- /.col -->
<div class="col-12 col-sm-6 col-md-4">
    <div class="info-box mb-3">
        <span class="info-box-icon bg-danger elevation-1"><i class="fas fa-box"></i></span>

        <div class="info-box-content">
            <span class="info-box-text">Total Product</span>
            <span class="info-box-number">{{ $infoProduct }}</span>
        </div>
        <!-- /.info-box-content -->
    </div>
    <!-- /.info-box -->
</div>
<!-- /.col -->

<!-- fix for small devices only -->
<div class="clearfix hidden-md-up"></div>

<div class="col-12 col-sm-6 col-md-4">
    <div class="info-box mb-3">
    <span class="info-box-icon bg-success elevation-1"><i class="fas fa-shopping-cart"></i></span>

    <div class="info-box-content">
        <span class="info-box-text">Sales</span>
        <span class="info-box-number">{{ $infoCart }}</span>
    </div>
    <!-- /.info-box-content -->
</div>
<!-- /.info-box -->
</div>
<!-- /.col -->
{{-- <div class="col-12 col-sm-6 col-md-3">
    <div class="info-box mb-3">
    <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-users"></i></span>

    <div class="info-box-content">
        <span class="info-box-text">New Members</span>
        <span class="info-box-number">2,000</span>
    </div>
    <!-- /.info-box-content -->
</div>
<!-- /.info-box -->
</div> --}}
<!-- /.col -->
@endsection