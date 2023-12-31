@extends('Template.template')

@section('title','Assets Management System | Master Approval Setting: Requisition')

{{-- kalau ada css tambahan selain dari template.blade --}}
@push('css')
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.1/css/dataTables.bootstrap5.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" />
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />
<style>
    .input-tags {
        width: 100%;
        background: rgba(239, 239, 239, 0.5);
        border: 1px solid #e5e5e5;
        border-radius: 10px;
        padding: 16px;
        color: #5d657b;
        resize: none;
        transition: all 0.3s;
    }
</style>
@endpush

@section('content')
<section class="section">
    <div class="container-fluid">
        <!-- ========== title-wrapper start ========== -->
        <div class="title-wrapper pt-30">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <div class="title mb-30">
                        <h2>Setting Approval Requisition: {{$data['role']->RoleName}}</h2>
                    </div>
                </div>
                <!-- end col -->
                <div class="col-md-6">
                    <div class="breadcrumb-wrapper">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item">
                                    <a href="#">Approval Req</a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">
                                    Page
                                </li>
                            </ol>
                        </nav>
                    </div>                    
                </div>
                <!-- end col -->
            </div>
            <!-- end row -->

            <!-- start Row -->
            <div class="form-elements-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card-style mb-30">
                        <div class="row mt-3">
                            <!-- Left column -->
                            <div class="col-lg-5">
                                <span class="mb-25 status-btn primary-btn" style="--bs-btn-padding-y: .25rem; --bs-btn-padding-x: .5rem; --bs-btn-font-size: .75rem;" disabled>Setting</span>  
                                <div class="select-style-1">
                                    <label>Employee Level</label>
                                    <div class="select-position">
                                        <select name="RoleId" id="RoleId" required>
                                            <option value="" selected>{{$appreq->RoleName}}</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="select-style-1">
                                    <label>Approval Order</label>
                                    <div class="select-position">
                                        <select name="RoleId" id="RoleId" required>
                                            <option value="" selected>{{$appreq->RoleName}}</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="select-sm select-style-1">
                                    <label>Approval Level</label>
                                    <div class="select-position input-tags">
                                        <select class="js-example-basic-single form-" id="tags" multiple name="Role[]">
                                            <option value="">{{$appreq->RoleName}}</option>                                            
                                        </select>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-12 text-end">
                                        <input type="submit" class="btn btn-primary" value="Save"></input>
                                        <a href="{{route('master.req')}}" class="btn btn-outline-danger">Back</a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-1"></div>
                            <!-- Right column -->
                            <div class="col-lg-6">
                                <div class="tables-wrapper">
                                <span class="mb-25 status-btn primary-btn" style="--bs-btn-padding-y: .25rem; --bs-btn-padding-x: .5rem; --bs-btn-font-size: .75rem;" disabled>Approver List</span>  
                                <div class="table-wrapper table-responsive">
                                    <div class="title d-flex flex-wrap align-items-center justify-content-between">
                                    </div>
                                    <table class="table" id="applist">
                                        <thead>
                                            <tr class="text-left">
                                                <th>#</th>
                                                <th>Approval Order</th>
                                                <th>Approval Level</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>  

</section>
@endsection

@push('js')
@include('sweetalert::alert')
<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.1/js/dataTables.bootstrap5.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/tagmanager/3.0.2/tagmanager.min.js"></script>
<script type="text/javascript">
    $(document).ready(function () {
    var table = $('#appreq').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('master.req') }}",
        columns: [
            {   
            data: 'No',
            render: function (data, type, row, meta) {
                // Menghitung nomor urut berdasarkan halaman dan jumlah baris yang ditampilkan
                var startIndex = meta.settings._iDisplayStart;
                var index = meta.row + startIndex + 1;

                return index;
            },
            orderable: false,
            searchable: false
            },
            {data: 'RoleName', name: 'RoleName'},
            {data: 'RoleName', name: 'RoleName'},
            {data: 'Action', name: 'Action', orderable: false, searchable: false},
        ],
    });    
  });

  $('.js-example-basic-single').select2({
        theme: "classic",
    });

  $('#tags').on('change', function() {
        var roleSelect = document.querySelector('.select-sm.select-style-1 .js-example-basic-single');
        var selectedOptions = Array.from(roleSelect.selectedOptions).map(option => option.value);
        console.log(selectedOptions);
    });
</script>
@endpush