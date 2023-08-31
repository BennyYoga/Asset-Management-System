@extends('Template.template')

@section('title','Assets Management System | Add Location')

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

        @include('Template.title',[
            "title" => "Create New Location",
            "breadcrumb" => [
                "Master Data" => "#",
                "Loction" => route('location.index'),
                "Create" => "#",
            ],
        ])

    <form action="{{route('location.store')}}" method="post" id="location">
        @csrf
        <div class="form-elements-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <!-- input style start -->
                    <div class="card-style mb-30">
                        <div class="row">
                        <div class="input-style-1 col-lg-6">
                            <label>Location Name</label>
                            <input type="text" placeholder="Location Name" name="Name" required/>
                        </div>
                        <!-- end input -->
                        <div class="select-style-1 col-lg-6">
                            <label>Have Procurement Process</label>
                            <div class="select-position">
                                <select class="light-bg" name="HaveProcurementProcess" required>
                                  <option value="" disabled selected>Select contidion</option>
                                  <option value="1" >Yes</option>
                                  <option value="0" >No</option>
                                </select>
                              </div>
                       </div>
                        <!-- end input -->
                        </div>
                        <div class="row">
                        <!-- end input -->
                        <div class="select-style-1 col-lg-6">
                            <label>Select Parent</label>
                            <div class="select-position">
                                <select class="light-bg" name="ParentId" id="ParentId" required>
                                  <option value="" disabled selected>Select location</option>
                                  <option value="">Root</option>
                                  @foreach ($location as $loc)
                                  <option value="{{ $loc->LocationId }}" >{{$loc->Name}}</option>
                                  @endforeach
                                </select>
                              </div>
                        </div>
                        <!-- end input -->
                        </div>
                        <div class="row">
                            <div class="col-lg-12 text-end">
                                <a href="{{route('location.index')}}" class="btn btn-secondary">Back</a>
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </div>
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
