@extends('Template.template')

@section('title','Assets Management System | Add Item Procurement')

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
                    <div class="title mb-30">
                        <h2>Add Item Procurement</h2>
                    </div>
                </div>
                <!-- end col -->
                <div class="col-md-6">
                    <div class="breadcrumb-wrapper mb-30">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item">
                                    <a href="procurement.index">Item Procurement</a>
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
    
    <form action="{{route('procurement.store')}}" method="post" id="procurement">
        @csrf
        <div class="form-elements-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <!-- input style start -->
                    <div class="card-style mb-30">
                    <h6 class="mb-25">Procurement</h6>
                        <div class="row">
                            <div class="select-style-1 col-lg-6">
                                <label>Select Location</label>
                                <div class="select-position">
                                    <select name="LocationId" id="LocationId" required>
                                      <option value="" disabled selected>Select location</option>
                                      @foreach ($location as $location)
                                      <option value="{{ $location->LocationId }}" >{{$location->Name}}</option>
                                      @endforeach
                                    </select>
                                  </div>
                            </div>
                        <!-- end input -->
                        {{-- <div class="input-style-1 col-lg-6">
                            <label>Date</label>
                            <input type="date" name="Tanggal" required>
                       </div> --}}
                        <!-- end input -->
                        </div>
                        <div class="row">
                        <div class="input-style-1 col-lg-12">
                            <label>Notes</label>
                            <div>
                                <textarea placeholder="Notes" name="Notes" cols="30" rows="5"></textarea>
                            </div>
                        </div>
                        <!-- end input -->
                    {{-- <h6 class="mb-25">Procurement Detail</h6>
                    <div class="row">
                        <div class="input-style-1 col-lg-12">
                            <label>Item</label>
                            <div>
                                <textarea placeholder="Notes" name="Notes" cols="30" rows="5"></textarea>
                            </div>
                        </div>
                        </div> --}}
                            <div class="card-footer mb">
                                <button type="submit" class="btn btn-primary">Submit</button>
                                <a href="/procurement" class="btn btn-outline-danger">
                                    Back
                                </a>
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