@extends('Template.template')

@section('title','Assets Management System | Create Category')

{{-- kalau ada css tambahan selain dari template.blade --}}
@push('css')
<link href="https://cdn.datatables.net/1.13.1/css/dataTables.bootstrap5.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" />
<link rel="stylesheet"
    href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />
@endpush

@section('content')
<section class="tab-components">
    <div class="container-fluid">
        <!-- ========== title-wrapper start ========== -->
        <div class="title-wrapper pt-30">
            <div class="row align-items-center">
                <div class="col-md-6">
                    {{-- @if (session('success'))
                    <div class="alert alert-success" role="alert">
                        {{ session('success') }}
                    </div>
                    @endif --}}
                    <div class="title mb-30">
                        <h2>Add Location</h2>
                    </div>
                </div>
                <!-- end col -->
                <div class="col-md-6">
                    <div class="breadcrumb-wrapper mb-30">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item">
                                    <a href="location.index">Category</a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">
                                    Create
                                </li>
                            </ol>
                        </nav>
                    </div>
                    {{-- <div>
                        <button class="btn btn-primary w3-right">Add</button>
                    </div> --}}
                </div>
                <!-- end col -->
            </div>
            <!-- end row -->
        </div>
    
    <form action="{{route('category.store')}}" method="post" id="category">
        @csrf
        @method('POST')
        <div class="form-elements-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <!-- input style start -->
                    <div class="card-style mb-30">
                        <div class="row">
                        <div class="input-style-1 col-lg-6">
                            <label>Name</label>
                            <input type="text" placeholder="Category Name" name="Name" required/>
                        </div>
                        <!-- end input -->
                        <!-- end input -->
                        <div class="select-style-1 col-lg-6">
                            <label>Choose Head</label>
                            <div class="select-position">
                                <select name="ParentId" id="ParentId" style="width:100%">
                                  <option value="" selected disabled> Select Category Parent</option>
                                  <option value="">Root</option>  
                                  @foreach($categories as $category)
                                  <option value="<?= $category->CategoryId?>">
                                  <?= $category->Name?>
                                  </option>
                                  @endforeach
                                </select>
                              </div>
                        </div>
                        <!-- end input -->
                        </div>
                            <div class="card-footer mb">
                                <button type="submit" class="btn btn-primary">Submit</button>
                                <a href="{{route('category.index')}}" class="btn btn-outline-danger">Back</a>
                            </div>
                    </div>
                    <!-- end card -->
                </div>
                <!-- end col -->
            </div>
            <!-- end row -->
        </div>
        <!-- end wrapper -->
</section>
@endsection