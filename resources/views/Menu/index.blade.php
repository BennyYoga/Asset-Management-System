@extends('Template.template')

@section('title', 'Assets Management System | Menu')

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
        <div class="modal fade bd-example-modal-mb" id="ajaxModel" aria-hidden="true">
            <div class="modal-dialog modal-mb modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="modelHeading"></h4>
                    </div>
                    <div class="modal-body">
                    <form class="form-horizontal" action="{{route('menu.update')}}" method="POST" enctype="multipart/form-data">
                        @csrf
                            <input type="hidden" name="MenuId" id="MenuId">
                            <div class="form-group">
                                <label for="MenuName" class="col-sm-6 control-label">Menu Name</label>
                                <div class="col-sm-12">
                                    <input type="text" class="form-control" id="MenuName" name="MenuName" placeholder="Enter Name" value="" maxlength="255" required="">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-6 control-label">Menu Description</label>
                                <div class="col-sm-12">
                                    <textarea id="MenuDesc" name="MenuDesc" required="" placeholder="Enter Details" class="form-control"></textarea>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-6 control-label">Menu Icon</label>
                                <div class="col-sm-12">
                                    <textarea id="MenuIcon" name="MenuIcon" required="" placeholder="Enter Details" class="form-control"></textarea>
                                </div>
                            </div>
                            <div class="col-sm-2 col-sm-10">
                                <button type="submit" class="btn btn-primary" value="edit-menu">Save Changes</button>
                                <a href="" class="btn btn-secondary" id ="cancel">Cancel</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

        <!-- End Row -->
    </div>
</section>
@endsection

@push('js')
@include('sweetalert::alert')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.1/js/dataTables.bootstrap5.min.js"></script>
<script type="text/javascript">
    $(document).ready(function() {
        var table = $('#category').DataTable({
            processing: true,
            serverSide: true,
            ajax: "",
            "order": [[0, "asc"]],
            columns: [
                {data: 'id',name: 'id',
                    render: function(data, type, row, meta) {
                        return meta.row + meta.settings._iDisplayStart + 1;
                    },orderable: true,
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
                {
                    data:'action',
                    name:'action',
                    class:'text-center'
                },
            ],
        });
    $('body').on('click', '.editProduct', function () {
        var MenuId = $(this).data('id');
        $.get("{{ url('menu/edit') }}/" + MenuId, function (data) {
            $('#modelHeading').html("Edit Menu");
            $('#ajaxModel').modal('show');
            $('#MenuId').val(data.MenuId);
            $('#MenuName').val(data.MenuName);
            $('#MenuDesc').val(data.MenuDesc);
            $('#MenuIcon').val(data.MenuIcon);
        });
    });
    $('#cancel').click(function() {
            $('#ajaxModel').modal('hide');
        });

    });
</script>
@endpush
