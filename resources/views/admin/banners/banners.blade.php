@extends('layouts.adminLayouts.admin_layout')
@section('header', 'Catalogues')
@section('title', 'banners')
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
        <h3 class="card-title">banner</h3>
        <a href="{{ url('admin/add-edit-banner') }}" class="btn btn-block btn-success" style="max-width: 150px; float: right; display: inline-block">Add banner</a>
      </div>
      <!-- /.card-header -->
      <div class="card-body">
        <table id="banners" class="table table-bordered table-hover">
          <thead>
          <tr>
            <th>ID</th>
            <th>Image</th>
            <th>Link</th>
            <th>Title</th>
            <th>Alt</th>
            <th>Status</th>
            <th>Action</th>
          </tr>
          </thead>
          <tbody>
          @foreach ($banners as $banner)
          <tr>
            <td>{{ $banner['id'] }}</td>
            <td>
                {{-- @if (!empty($banner['image'])) --}}
                    <img style="max-width: 150px" src="{{ asset('img/banner/'.$banner['image']) }}" alt="{{ $banner['alt'] }}" class="img-thumbnail">
                {{-- @else --}}
                    {{-- <img style="max-width: 150px" src="{{ asset('img/product/small/no-image.jpg') }}" alt="Product Image" class="img-thumbnail"> --}}
                {{-- @endif --}}
            </td>   
            <td>{{ $banner['link'] }}</td>
            <td>{{ $banner['title'] }}</td>
            <td>{{ $banner['alt'] }}</td>
            <td>
                @if ($banner['status'] == 1)
                    <a href="javascript:void(0)" class="updateBannerStatus" id="banner-{{ $banner['id'] }}" banner_id="{{ $banner['id'] }}"><i class="fas fa-toggle-on" status="Active" aria-hidden="true"></i></a>
                @else
                    <a href="javascript:void(0)" class="updateBannerStatus" id="banner-{{ $banner['id'] }}" banner_id="{{ $banner['id'] }}"><i class="fas fa-toggle-off" status="Inactive" aria-hidden="true"></i></a>
                @endif
            </td>
            <td>
              <a title="Edit banner" href="{{ url('admin/add-edit-banner/'.$banner['id']) }}"><i class="fas fa-edit"></i></a>
              <a title="Delete banner" href="javascript:void(0)" class="confirmDelete" record="banner" recordid="{{ $banner['id'] }}"><i class="fas fa-trash" aria></i></a>
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