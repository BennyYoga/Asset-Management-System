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

                <!-- modals -->
                <div class="warning-modal">
                    <div class="modal fade" id="staticBackdrop" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content card-style warning-card text-center">
                                <div class="modal-body">
                                    <div class="icon text-danger mb-20">
                                        <i class="lni lni-warning" style="font-size: 120px"></i>
                                    </div>
                                    <div class="content mb-30">
                                        <h2 class="mb-15">Warning!</h2>
                                        <p class="text-sm text-medium">
                                            Are you sure to delete this data?
                                        </p>
                                    </div>
                                    <div class="action d-flex flex-wrap justify-content-center">
                                        <button type="submit" class="main-btn danger-btn rounded-full btn-hover m-1"
                                            id="hapusBtnModal">Yes, delete</button>
                                        <button data-bs-dismiss="modal"
                                            class="main-btn light-btn rounded-full btn-hover m-1">Close</button>
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
<form action="" id="delete-form" method="post">
    @method('get')
    @csrf
</form>
<script>
    $(document).ready(function () {
        // Menggunakan event click untuk button dengan id hapusBtn
        $('#appreq').on('click', '#hapusBtn', function (e) {
            e.preventDefault();

            // Simpan URL hapus pada atribut data-hapus pada tombol hapus
            var deleteUrl = $(this).attr('href');
            $('#hapusBtn').attr('data-hapus', deleteUrl);

            // Menampilkan modal
            $('#staticBackdrop').modal('show');
        });

        // Menggunakan event click untuk button hapus pada modal
        $('#hapusBtnModal').on('click', function () {
            // Mengambil URL hapus dari atribut data-hapus pada tombol hapus
            var deleteUrl = $('#hapusBtn').attr('data-hapus');

            // Mengubah action pada form hapus sesuai dengan URL hapus
            $('#delete-form').attr('action', deleteUrl);

            // Submit form hapus
            $("#delete-form").submit();
        });
    });
</script>
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
            {data: 'Approver1', name: 'Approver1'},
            {data: 'Approver2', name: 'Approver2'},
            {data: 'combined_info', name: 'combined_info'},
            {data: 'UpdatedDate', name: 'UpdatedDate'},
            {data: 'Action', name: 'Action', orderable: false, searchable: false},
        ],
    });    
  });
</script>
@endpush