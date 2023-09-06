@extends('Template.template')

@section('title', 'Asset Management System | Project')


@push('css')
<link href="https://cdn.datatables.net/1.13.1/css/dataTables.bootstrap5.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" />
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/tagmanager/3.0.2/tagmanager.min.js"></script>
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
                        <h2>Project</h2>
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
                                    Project
                                </li>
                            </ol>
                        </nav>
                    </div>
                </div>
                <div class="d-flex justify-content-end mb-3">
                    <a href="{{route('project.create')}}" class="btn btn-primary">Add</a>
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
                                    <th>No</th>
                                    <th>Name</th>
                                    <th>Created By</th>
                                    <th>Start Date</th>
                                    <th>End Date</th>
                                    <th>Location Name</th>
                                    <th>Status</th>
                                    <th>Action</th>
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
            columns: [{
                    data: 'id',
                    name: 'id',
                    render: function(data, type, row, meta) {
                        return meta.row + meta.settings._iDisplayStart + 1;
                    }
                },
                {
                    data: 'Name',
                    name: 'Name',

                },
                {
                    data: 'CreatedBy',
                    name: 'CreatedBy',
                    orderable: true,

                },
                {
                    data: 'StartDate',
                    name: 'StartDate',

                },
                {
                    data: 'EndDate',
                    name: 'EndDate',

                },
                {
                    data: 'Location',
                    name: 'Location',

                },
                {
                    data: 'Active',
                    name: 'Active',
                    render: function (data, type, row) {
                        var status = data == 1 ? 'Active' : 'Nonactive';
                        var classColor = data == 1 ? 'btn-primary' : 'btn-danger';
                        return '<button type="button" class="btn ' + classColor + '" disabled style="--bs-btn-padding-y: .25rem; --bs-btn-padding-x: .5rem; --bs-btn-font-size: .75rem;">' + status + '</button>';
                    }
                },
                {
                    data: 'action',
                    name: 'action',
                },

            ],
            order: [
                [
                    6, 'desc'
                ]
            ]
        });
    });
    

</script>
 
@endpush
