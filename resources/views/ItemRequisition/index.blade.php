@extends('Template.template')

@section('title','Asset Monitoring System | Dashboard')

{{-- kalau ada css tambahan selain dari template.blade --}}
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
        <div class="title-wrapper pt-30">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <div class="title mb-30">
                        <h2>Item Requisition</h2>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="breadcrumb-wrapper mb-30">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item">
                                    <a href="#">Item Requisition</a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">
                                    Page
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
                        <div class="d-flex justify-content-end mb-3">
                            <a href="{{route('itemreq.create')}}" class="btn btn-primary">Add</a>
                        </div>
                        <table class="table" id="itemrequisition">
                            <thead>
                                <tr class="text-center">
                                    <th>No</th>
                                    <th>Tanggal</th>
                                    <th>Lokasi</th>
                                    <th>Jumlah Barang</th>
                                    <th>Status</th>
                                    <th>Active</th>
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

@section('content')
@endsection

@push('js')
@include('sweetalert::alert')
<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.1/js/dataTables.bootstrap5.min.js"></script>
<script type="text/javascript">
    $(document).ready(function() {
        var table = $('#itemrequisition').DataTable({
            processing: true,
            serverSide: true,
            ajax: "",
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
                {
                    data: 'Tanggal',
                    name: 'Tanggal',
                    render: function (data, type, row) {
                        // Mengubah tampilan tanggal dari 'Y-m-d H:i:s' menjadi 'Y-m-d' (hanya tanggal)
                        var date = new Date(data);
                        var formattedDate = date.toLocaleDateString('en-US', {
                            year: 'numeric',
                            month: 'long',
                            day: 'numeric'
                        });
                        return formattedDate;
                    }
                },
                {
                    data: 'Lokasi',
                    name: 'Lokasi',
                },
                {
                    data: 'JumlahBarang',
                    name: 'JumlahBarang',
                },
                {
                    data: 'Status',
                    name: 'Status',
                },
                {
                    data: 'Active',
                    name: 'Active',
                },
                {
                    data: 'Action',
                    name: 'Action',
                    orderable: false,
                    searchable: false,
                }
            ],
        });
    });
</script>
@endpush