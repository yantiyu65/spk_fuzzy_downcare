@extends('admin.layouts.admin')

@section('title', 'Dashboard')

@section('content')
<div class="container py-4">
  <div class="row">

    <div class="col-md-3">
      <a href="{{ route('admin.datauser') }}" class="text-decoration-none">
        <div class="card bg-primary text-white text-center mb-3">
          <div class="card-body">
            <p class="card-text">Total Users</p>
            <h5 class="card-title mt-2">{{ $totalUser }}</h5>
          </div>
        </div>
      </a>
    </div>
  
    
  
    <div class="col-md-3">
      <a href="{{ route('admin.kriteria') }}" class="text-decoration-none">
        <div class="card bg-warning text-white text-center mb-3">
          <div class="card-body">
            <p class="card-text">Total Kriteria</p>
            <h5 class="card-title mt-2">{{ $totalKriteria }}</h5>
          </div>
        </div>
      </a>
    </div>
  
    <div class="col-md-3">
      <a href="{{ route('admin.subkriteria') }}" class="text-decoration-none">
        <div class="card bg-danger text-white text-center mb-3">
          <div class="card-body">
            <p class="card-text">Total Sub Kriteria</p>
            <h5 class="card-title mt-2">{{ $totalSubKriteria }}</h5>
          </div>
        </div>
      </a>
    </div>
  
  </div>

</div>
  
@endsection
