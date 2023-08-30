@extends('Template.template')

@section('title','Assets Management System | Master Approval: Requisition')

{{-- kalau ada css tambahan selain dari template.blade --}}
@push('css')
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.1/css/dataTables.bootstrap5.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" />
<link rel="stylesheet"
    href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />
@endpush

@section('content')
<section class="section">
    <div class="container-fluid">
        <!-- ========== title-wrapper start ========== -->
        <div class="title-wrapper pt-30">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <div class="title mb-30">
                        <h2>Approval Requisition List</h2>
                    </div>
                </div>
                <!-- end col -->
                <div class="col-md-6">
                    <div class="breadcrumb-wrapper">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item">
                                    <a href="#">Approval Requisition</a>
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
            <div class="tables-wrapper">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card-style mb-30">
                            <div class="table-wrapper table-responsive">
                                <div class="title d-flex flex-wrap align-items-center justify-content-between">
                                </div>
                                <table class="table" id="appreq">
                                    <thead>
                                        <tr class="text-left">
                                            <th>No</th>
                                            <th>Employee Level</th>
                                            <th>Approver 1</th>
                                            <th>Approver 2</th>
                                            <th>Updated By</th>
                                            <th>Updated Date</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                        <!-- end col -->
                    </div>
                    <!-- end row -->
                </div>
</section>
@endsection

@push('js')
@include('sweetalert::alert')
<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.1/js/dataTables.bootstrap5.min.js"></script>
<script type="text/javascript">
    $(document).ready(function () {
        var table = $('#appreq').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('master.req') }}",
            order: [[0, 'asc']],
            columns: [
                {
                    data: 'ApproverMasterId',
                    render: function (data, type, row, meta) {
                        var startIndex = meta.settings._iDisplayStart;
                        var index = meta.row + startIndex + 1;
                        return index;
                    },
                    searchable: false
                },
                { data: 'Requester', name: 'Requester' },
                { data: 'Approver1', name: 'Approver1', orderable: false, searchable: false },
                { data: 'Approver2', name: 'Approver2', orderable: false, searchable: false },
                { data: 'UpdatedBy', name: 'UpdatedBy' },
                { data: 'UpdatedDate', name: 'UpdatedDate' },
                { data: 'Action', name: 'Action', orderable: false, searchable: false },
            ]
        });
    });
</script>
@endpush