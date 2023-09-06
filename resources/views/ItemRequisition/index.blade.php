@extends('Template.template')

@section('title','Asset Monitoring System | Item Requisition')

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
                    <div class="breadcrumb-wrapper">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item">
                                    <a href="{{ route('dashboard.index')}}">Dashboard</a>
                                </li>
                                <li class="breadcrumb-item">
                                    <a href="#">Request</a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">
                                    Item Requisition
                                </li>
                            </ol>
                        </nav>
                    </div>
                    <div class="d-flex justify-content-end mb-3">
                        <a href="{{route('itemreq.create')}}" class="btn btn-primary">Add</a>
                    </div>
                </div>
            </div>
        </div>
        <!-- ========== title-wrapper end ========== -->

        <!-- Row -->
        <div class="row">
            <div class="col-md-12">
                <div class="card-style mb-30">
                    <div class="card-body">
                        <table class="table" id="itemrequisition">
                            <thead>
                                <tr class="text-center">
                                    <th>No</th>
                                    <th>Tanggal Dibuat</th>
                                    <th>Lokasi Tujuan</th>
                                    <th>Tanggal Request</th>
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


<!-- Change Status Requisition Modals -->
<div id="activateStatus" class="modal fade bd-example-modal-mb" tabindex="-1" role="dialog" aria-labelledby="add-categori" aria-hidden="true">
    <div class="modal-dialog modal-mb modal-dialog-centered">
      <div class="modal-content card-style ">
            <div class="modal-header px-0">
                <h5 class="text-bold" id="exampleModalLabel">Submit Requisition</h5>
            </div>
          <div class="modal-body px-0">
                <p class="mb-40">Apakah anda yakin ingin Mensubmit Data Requisition ini?</p>

                <div class="action d-flex flex-wrap justify-content-end">
                    <button class="btn btn-outline-danger" data-bs-dismiss="modal">Back</button>
                    <a href="" class="btn btn-primary ml-5" id="changeSubmit">Submit</a>
                </div>
            </form>
          </div>
      </div>
    </div>
</div>

<div id="modalDelete" class="modal fade bd-example-modal-mb" tabindex="-1" role="dialog" aria-labelledby="add-categori" aria-hidden="true">
    <div class="modal-dialog modal-mb modal-dialog-centered">
      <div class="modal-content card-style ">
            <div class="modal-header px-0">
                <h5 class="text-bold" id="exampleModalLabel">Delete Requisition</h5>
            </div>
          <div class="modal-body px-0">
                <p class="mb-40">Apakah anda yakin ingin menghapus data requisition ini?</p>
                
                <div class="action d-flex flex-wrap justify-content-end">
                    <button class="btn btn-outline-danger" data-bs-dismiss="modal">Back</button>
                    <a href="" class="btn btn-primary ml-5" id="deleteSubmit">Submit</a>
                </div>
            </form>
          </div>
      </div>
    </div>
</div>
@endsection

@push('js')
@include('sweetalert::alert')
<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.1/js/dataTables.bootstrap5.min.js"></script>
<script type="text/javascript">

function notificationBeforeChange(event, el) {
            event.preventDefault(); {
            $('#activateStatus').modal('show');
            // console.log($(el).attr('href'));
            $("#changeSubmit").attr('href', $(el).attr('href'));
            }
        }

    function notificationBeforeDelete(event, el) {
            event.preventDefault(); {
            $('#modalDelete').modal('show');
            // console.log($(el).attr('href'));
            $("#deleteSubmit").attr('href', $(el).attr('href'));
        }
    }

    $(document).ready(function() {
        var table = $('#itemrequisition').DataTable({
            processing: true,
            serverSide: true,
            ajax: "",
            columns: [{
                    data: 'No',
                    render: function(data, type, row, meta) {
                        var startIndex = meta.settings._iDisplayStart;
                        var index = meta.row + startIndex + 1;

                        return index;
                    },
                    orderable: false,
                    searchable: false
                },
                {
                    'name': 'dibuat',
                    'data': {
                        '_': 'dibuat.display',
                        'sort': 'dibuat.timestamp'
                    },

                },
                {
                    data: 'Lokasi',
                    name: 'Lokasi',
                },
                {
                    data: 'Tanggal',
                    name: 'Tanggal',
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
                }
            ],
            order: [
                [1, "DESC"]
            ],
        });
    });
</script>
@endpush