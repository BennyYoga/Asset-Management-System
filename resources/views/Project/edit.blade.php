@extends('Template.template')

@section('title','Assets Management System | Create Local Admin')

{{-- kalau ada css tambahan selain dari template.blade --}}
@push('css')
<link href="https://cdn.datatables.net/1.13.1/css/dataTables.bootstrap5.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" />
<link rel="stylesheet"
    href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />
<link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
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
                        <h2>Add Project</h2>
                    </div>
                </div>
                <!-- end col -->
                <div class="col-md-6">
                    <div class="breadcrumb-wrapper mb-30">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item">
                                    <a href="project.index">Project</a>
                                    <a href="{{ route('dashboard.index') }}">Dashboard</a>
                                </li>
                                <li class="breadcrumb-item">
                                    <a href="{{ route('role.index') }}">Role</a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">
                                    Create Local Admin
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
    
    <form action="{{route('project.update', $project->ProjectId)}}" method="post">
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
                            <input type="text" placeholder="Project Name" name="Name" required value="{{$project->Name}}"/>
                        </div>
                        </div>
                        <div class="input-style-1 col-lg-6">
                        <label>StartDate</label>
                        <input type="text" placeholder="Start Date" name="StartDate" required class="datepicker" value="{{$project->StartDate}}"/>
                        </div>
                        <div class="input-style-1 col-lg-6">
                            <label>EndDate</label>
                            <input type="text" placeholder="End Date" name="EndDate" required class="datepicker" value="{{$project->EndDate}}"/>
                        </div>
                        <!-- end input -->
                        <!-- end input -->

                        <div class="row">
                        </div>
                        <div class="select-style-1 col-lg-6">
                            <label>Choose Head</label>
                            <div class="select-position">
                                <select name="LocationId" id="LocationId" style="width:100%">
                                  <option value="" selected >Select Location</option>
                                  @foreach($location as $location)
                                  <option value="<?= $location->LocationId?>"@if($location->LocationId == $project->LocationId) selected @endif>
                                  <?= $location->Name?>
                                  </option>
                                  @endforeach
                                </select>
                              </div>
                        </div>
                        </div>
                        <!-- end input -->
                        </div>
                            <div class="card-footer mb">
                                <button type="submit" class="btn btn-primary">Submit</button>
                                <a href="{{route('project.index')}}" class="btn btn-outline-danger">Back</a>
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
<script>
  $(document).ready(function() {
    $('.datepicker').datepicker({
      dateFormat: 'yy-mm-dd' // Format tanggal yang diinginkan
    });
  });
</script>
@endsection