@extends('Template.template')

@section('title', 'Assets Management System | Menu')

@push('css')
<link href="https://cdn.datatables.net/1.13.1/css/dataTables.bootstrap5.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" />
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />\
<link href="{{ asset('vendor/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet">
@endpush

@section('content')
<section class="section">
    <div class="container-fluid">
        <!-- ========== title-wrapper start ========== -->
        <style>
            span.nonactive {
            color: red;
            }

/* Ganti warna teks menjadi hijau untuk status "Active" */
            span.active {
            color: green;
            }         
        </style>
        <div class="title-wrapper pt-30">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <div class="title mb-30">
                        <h2>Master Menu</h2>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="breadcrumb-wrapper mb-30">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item">
                                    <a href="{{ route('dashboard.index')}}">Dashboard</a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">
                                    Master Menu
                                </li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
        <!-- ========== title-wrapper end ========== -->

        <!-- Row -->
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <table class="table" id="category">
                            <thead>
                                <tr class="text-center">
                                    <th>#</th>
                                    <th style="width:120px;">Menu Name</th>
                                    <th> Parent </th>
                                    <th>Description</th>
                                    <th> Action </th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Row -->
    </div>
</section>
@endsection

@push('js')
@include('sweetalert::alert')
<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.1/js/dataTables.bootstrap5.min.js"></script>
<script type="text/javascript">
    $(document).ready(function() {
        var table = $('#category').DataTable({
            processing: true,
            serverSide: true,
            ajax: "",
            "order": [[0, "asc"]],
            "columnDefs": [
                { "targets": 'data-sort', "orderable": true },
                {
                    "targets": 'menu-id',
                    "orderData": [0], 
                    "orderable": true
                }
            ],
            columns: [
                {
                    data: 'id',
                    name: 'id',
                    render: function(data, type, row, meta) {
                        return meta.row + meta.settings._iDisplayStart + 1;
                    },
                    orderable: true,
                },
                {
                    data: 'MenuName',
                    name: 'MenuName',
                },
                {
                    data: 'Parent',
                    name: 'Parent',
                },
                {
                    data: 'MenuDesc',
                    name: 'MenuDesc',
                },
                // ... Kolom Action ...
                {
                    data:'action',
                    name:'action',
                    class:'text-center'
                },
            ],
        });
    });
</script>
@endpush
