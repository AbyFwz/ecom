@extends('layouts.adminLayouts.admin_layout')
@section('header', 'Catalogues')
@section('title', 'Products')
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
        <h3 class="card-title">Product</h3>
        <a href="{{ url('admin/add-edit-product') }}" class="btn btn-block btn-success" style="max-width: 150px; float: right; display: inline-block">Add product</a>
      </div>
      <!-- /.card-header -->
      <div class="card-body">
        <table id="products" class="table table-bordered table-hover">
          <thead>
          <tr>
            <th>ID</th>
            <th>Product Name</th>
            <th>Product Code</th>
            <th>Product Color</th>
            <th>Product Image</th>
            <th>Category</th>
            <th>Section</th>
            <th>Status</th>
            <th>Action</th>
          </tr>
          </thead>
          <tbody>
          @foreach ($products as $prod)
          <tr>
            <td>{{ $prod->id }}</td>
            <td>{{ $prod->product_name }}</td>
            <td>{{ $prod->product_code }}</td>
            <td>{{ $prod->product_color }}</td>
            <td>
              @if (!empty($prod->main_image))
                <img style="max-width: 150px" src="{{ asset('img/product/small/'.$prod->main_image) }}" alt="Product Image" class="img-thumbnail">
              @else
                <img style="max-width: 150px" src="{{ asset('img/product/small/no-image.jpg') }}" alt="Product Image" class="img-thumbnail">
              @endif
            </td>
            <td>{{ $prod->category->category_name }}</td>
            <td>{{ $prod->section->name }}</td>
            <td>
              @if ($prod->status == 1)
                <a href="javascript:void(0)" class="updateProductStatus" id="product-{{ $prod->id }}" product_id="{{ $prod->id }}"><i class="fas fa-toggle-on" status="Active" aria-hidden="true"></i></a>
              @else
                <a href="javascript:void(0)" class="updateProductStatus" id="product-{{ $prod->id }}" product_id="{{ $prod->id }}"><i class="fas fa-toggle-off" status="Inactive" aria-hidden="true"></i></a>
              @endif
            </td>
            <td>
              <a title="Add/Edit Atributes" href="{{ url('admin/add-attributes/'.$prod->id) }}"><i class="fas fa-plus"></i></a>
              <a title="Add/Edit Images" href="{{ url('admin/add-images/'.$prod->id) }}"><i class="fas fa-plus-circle"></i></a>
              <a title="Edit Product" href="{{ url('admin/add-edit-product/'.$prod->id) }}"><i class="fas fa-edit"></i></a>
              <a title="Delete Product" href="javascript:void(0)" class="confirmDelete" record="product" recordid="{{ $prod->id }}"><i class="fas fa-trash" aria></i></a>
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