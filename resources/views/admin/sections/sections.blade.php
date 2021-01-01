@extends('layouts.adminLayouts.admin_layout')
@section('header', 'Catalogues')
@section('title', 'Sections')
@section('content')
<div class="col-12">
    <div class="card">
      <div class="card-header">
        <h3 class="card-title">Sections</h3>
      </div>
      <!-- /.card-header -->
      <div class="card-body">
        <table id="sections" class="table table-bordered table-hover">
          <thead>
          <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Status</th>
          </tr>
          </thead>
          <tbody>
          @foreach ($sections as $sec)
          <tr>
            <td>{{ $sec->id }}</td>
            <td>{{ $sec->name }}</td>
            <td>
              @if ($sec->status == 1)
                <a href="javascript:void(0)" class="updateSectionStatus" id="section-{{ $sec->id }}" section_id="{{ $sec->id }}"><i class="fas fa-toggle-on" status="Active" aria-hidden="true"></i></a>
              @else
                <a href="javascript:void(0)" class="updateSectionStatus" id="section-{{ $sec->id }}" section_id="{{ $sec->id }}"><i class="fas fa-toggle-off" status="Inactive" aria-hidden="true"></i></a>
              @endif
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