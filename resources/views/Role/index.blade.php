@extends('Template.template')

@section('title', 'Asset Management System | Role')

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
                        <h2>Role</h2>
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
                                    Role
                                </li>
                            </ol>
                        </nav>
                    </div>
                </div>
                <div class="d-flex justify-content-end mb-3">
                        <a href="{{ route('role.create') }}" class="btn btn-primary mr-2">Add</a>
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
                                    <th>Role Name</th>
                                    <th>Location Name</th>
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
                    <form class="form-horizontal" action="{{route('role.updates')}}" method="POST" enctype="multipart/form-data">
                        @csrf
                            <input type="hidden" name="RoleId" id="RoleId">
                            <div class="form-group">
                                <label for="RoleName" class="col-sm-6 control-label">Role Name</label>
                                <div class="col-sm-12">
                                    <input type="text" class="form-control" id="RoleName" name="RoleName" placeholder="Enter Name" value="" maxlength="50" required="">
                                </div>
                            </div>
                            @if(session('user')->RoleId == 1)
                            <div>
                            <label for="Location" class="col-sm-6 control-label">Location</label>
                                <div class="select-sm select-style-1">
                                    <div class="select-position">
                                    <select name="LocationId"  style="width:100%"   >
                                        <option value="" selected disabled> Select Location</option>
                                        @foreach($locations as $lc)
                                        <option value="{{$lc->LocationId}}">
                                        {{$lc->Name}}
                                        </option>
                                        @endforeach
                                    </select>
                                    </div>
                                </div>
                            </div>
                              @endif
                            <div class="col-sm-2 col-sm-10">
                                <button type="submit" class="btn btn-primary" value="edit-menu">Save</button>
                                <a href="" class="btn btn-secondary ml-5" data-bs-dismiss="modal">Cancel</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        <!-- End Row -->
    </div>
</section>
<div id="deleterole" class="modal fade bd-example-modal-mb" tabindex="-1" role="dialog" aria-labelledby="add-categori" aria-hidden="true">
    <div class="modal-dialog modal-mb modal-dialog-centered">
      <div class="modal-content card-style ">
            <div class="modal-header px-0">
                <h5 class="text-bold" id="exampleModalLabel">Delete Role</h5>
            </div>
          <div class="modal-body px-0">
                <p class="mb-40">Apakah kamu yakin delete Role?</p>
                <div class="action d-flex flex-wrap justify-content-end">
                    <button class="btn btn-outline-danger" data-bs-dismiss="modal">Back</button>
                    <a href="" class="btn btn-primary ml-5" id="changeSubmit">Submit</a>
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
            $('#deleterole').modal('show');
            console.log($(el).attr('href'));
            $("#changeSubmit").attr('href', $(el).attr('href'));
            }
        }
    
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
                    data: 'RoleName',
                    name: 'RoleName',
                },
                {
                    data: 'Location',
                    name: 'Location',
                },
                {
                    data: 'Action',
                    name: 'Action',
                    class: "text-center",
                    id:'printCategory',
                    orderable: false,
                    searchable: false
                },

            ],
            order: [
                [
                    0, 'asc'
                ]
            ]
        });
        $('#createNewProduct').click(function () {
        $('#saveBtn').val("create-product");
        $('#RoleId').val('');
        $('#RoleForm').trigger("reset");
        $('#modelHeading').html("Create New Role");
        $('#ajaxModel').modal('show');
    });
      
    /*------------------------------------------
    --------------------------------------------
    Click to Edit Button
    --------------------------------------------
    --------------------------------------------*/
    $('body').on('click', '.editProduct', function () {
      var RoleId = $(this).data('id');
      $.get("{{ url('role/edits') }}/" + RoleId, function (data) {
          $('#modelHeading').html("Edit Role");
          $('#saveBtn').val("edit-user");
          $('#ajaxModel').modal('show');
          $('#RoleId').val(data.RoleId);
          $('#RoleName').val(data.RoleName);
          $('#Location').val(data.LocationId);
      })
    });
      
    /*------------------------------------------
    --------------------------------------------
    Create Product Code
    --------------------------------------------
    --------------------------------------------*/

    $('body').on('click', '.deleteProduct', function () {
     
     var RoleId = $(this).data("id");
     confirm("Are You sure want to delete !");
     
     $.ajax({
         type: "DELETE",
         url: "{{ url('role/delete') }}"+'/'+RoleId,
         success: function (data) {
             table.draw();
         },
         error: function (data) {
             console.log('Error:', data);
         }
     });
     $('#cancel').click(function() {
            $('#ajaxModel').modal('hide');
        });
    });
    $('.js-example-basic-single').select2({
            theme: "bootstrap-5",
        });

    });
    

</script>
 
@endpush
