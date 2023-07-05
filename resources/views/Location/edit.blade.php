@extends('Template.template')

@section('title','Trash Monitoring System | Create Pegawai')

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
                        <h2>Edit Data Lokasi</h2>
                    </div>
                </div>
                <!-- end col -->
                <div class="col-md-6">
                    <div class="breadcrumb-wrapper mb-30">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item">
                                    <a href="location.index">Lokasi</a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">
                                    Edit
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
    
    <form action="{{route('location.update', ['id'=>$location->LocationId])}}" method="post" id="location">
        @csrf
        @method('POST')
        <div class="form-elements-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <!-- input style start -->
                    <div class="card-style mb-30">
                        <div class="row">
                        <div class="input-style-1 col-lg-6">
                            <label>Nama Lokasi</label>
                            <input type="text" placeholder="Nama Lokasi" id="Name" name="Name" required autofocus value="{{$location->Name}}"/>
                        </div>
                        <!-- end input -->
                        <div class="select-style-1 col-lg-6">
                            <label>Proses Procurement</label>
                            <div class="select-position">
                                <select name="HaveProcurementProcess" required>
                                    <option value="0" <?php echo (isset($location->HaveProcurementProcess) && $location->HaveProcurementProcess == 0) ? "selected" : ""; ?>>Tidak ada</option>  
                                    <option value="1" <?php echo (isset($location->HaveProcurementProcess) && $location->HaveProcurementProcess == 1) ? "selected" : ""; ?>>Ada</option>  
                                </select>
                              </div>
                       </div>
                        <!-- end input -->
                        </div>
                        <div class="row">
                        <div class="select-style-1 col-lg-6">
                            <label>Status</label>
                            <div class="select-position">
                                <select name="Active" required>
                                    <option value="0" <?php echo (isset($location->Active) && $location->Active == 0) ? "selected" : ""; ?>>Nonaktif</option>  
                                    <option value="1" <?php echo (isset($location->Active) && $location->Active == 1) ? "selected" : ""; ?>>Aktif</option>  
                                </select>
                              </div>
                        </div>
                        <!-- end input -->
                        <div class="select-style-1 col-lg-6">
                            <label>Pilih Kantor Pusat</label>
                            <div class="select-position">
                                <select name="ParentId" required>
                                  <option value=" ">None</option>
                                  {{-- @foreach ($location as $location)
                                  <option value="<?= $location->LocationId ?>" >{{$location->Name}}</option>
                                  @endforeach --}}
                                </select>
                              </div>
                        </div>
                        <!-- end input -->
                        </div>
                            <div class="card-footer mb">
                                <button type="submit" class="btn btn-success">Simpan</button>
                                <a href="/location" class="btn btn-deactive">
                                    Batal
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