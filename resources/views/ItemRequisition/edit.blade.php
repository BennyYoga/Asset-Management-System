@extends('Template.template')

@section('title','Asset Monitoring System | Edit Item Requisition')

{{-- kalau ada css tambahan selain dari template.blade --}}
@push('css')
<link href="https://cdn.datatables.net/1.13.1/css/dataTables.bootstrap5.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" />
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.4.0/min/dropzone.min.css">
<meta name="csrf-token" content="{{ csrf_token() }}" />
<style>
    #image-upload {
        border-radius: 5px;
        border: 3px dashed #e5e5e5;
        background-color: #f7f7f7;
    }
</style>
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
                    <h2>Edit Requisition</h2>
                </div>
            </div>
            <!-- end col -->
            <div class="col-md-6">
                <div class="breadcrumb-wrapper mb-30">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="item.index">Requisition</a>
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
    <form action="{{ route('itemreq.update', $data['itemreq']->ItemRequisitionId) }}" id="ItemReqForm" method="post">
        @csrf
        @method('PUT')
    </form>
    <div class="form-elements-wrapper">
        <div class="row">
            <div class="col-sm-12">
                <!-- input style start -->
                <div class="card-style mb-30">

                    <div class="invoice-header mb-4">
                        <h3>Main Data Requisition</h3>
                        <hr class="border-2">
                    </div>

                    <div class="row mt-3">
                        <div class="col-lg-6">

                            <input type="hidden" id="ReqId" form="ItemReqForm" value="{{$data['itemreq']->ItemRequisitionId}}">
                            <input type="hidden" id="itemHidden" value="{{$data['item']}}">
                            <input type="hidden" id="detailHidden" value="{{$data['detailreq']}}">

                            <div class="select-style-1">
                                <label>Select Location</label>
                                <div class="select-position">
                                    <select name="LocationTo" id="LocationId" form="ItemReqForm" required>
                                        @foreach ($data['location'] as $loc)
                                        @if($data['itemreq']->LocationTo == $loc->LocationId)
                                        <option value="{{ $loc->LocationId }}" selected>{{$loc->Name}}</option>
                                        @else if
                                        <option value="{{ $loc->LocationId }}">{{$loc->Name}}</option>
                                        @endif
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <!-- end input -->

                            <div class="input-style-1">
                                <label>Transaction Date</label>
                                <input type="date" id="Tanggal" name="Tanggal" form="ItemReqForm" value="{{ date('Y-m-d', strtotime($data['itemreq']->Tanggal)) }}">
                                @error('Tanggal') <span class="text-danger">{{$message}}</span> @enderror
                            </div>
                            <!-- end input -->

                            <div class="input-style-1">
                                <label>Notes</label>
                                <textarea class="input-tags" rows="4" id="Notes" name="Notes" placeholder="Notes" form="ItemReqForm">{{$data['itemreq']->Notes}}</textarea>
                                @error('Notes') <span class="text-danger">{{$message}}</span> @enderror
                            </div>
                            <!-- end input -->
                        </div>


                        <div class="col-lg-6">
                            <div class="input-style-1">
                                <label>Your File</label>
                                @foreach (session('upload-file') as $key => $item)
                                <div class="card mb-3">
                                    <div class="card-body">
                                        <div class="row align-items-center">
                                            <div class="col-lg-1">
                                                <i class="lni lni-empty-file fs-2 text-body-secondary"></i>
                                            </div>
                                            <div class="col-lg-9">
                                                <a href="{{ asset($item->FilePath) }}" target="_blank">
                                                    <p class="fs-6 text-body-secondary">{{basename($item->FilePath)}}</p>
                                                </a>
                                            </div>
                                            <div class="col-lg-2">
                                                <a href="#" class="deleteFile" data-item-id="{{$item->RequisitionUploadId}}">
                                                    <i class="lni lni-trash-can fs-3 m-auto text-danger"></i>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>


                            <div class="input-style-1">
                                <label>Upload Your File</label>
                                <form action="{{route('dropzone.store')}}" method="post" name="file" files="true" enctype="multipart/form-data" class="dropzone" id="image-upload">
                                    @csrf
                                </form>
                            </div>
                        </div>
                        <!-- End Col -->
                    </div>

                    <!-- Section Add Item -->
                    <div class="invoice-header mb-4">
                        <div class="row">
                            <div class="col-lg-6">
                                <h3>Data Of Item</h3>
                            </div>
                            <div class="col-lg-6 text-end">
                                <button type="button" class="btn btn-primary" id="add-item">Tambah Item</button>
                            </div>
                        </div>
                        <hr class="border-2">
                    </div>


                    <div class="row">
                        <div id="item-container">
                            <div class="row item">

                            </div>
                        </div>
                        <!-- End Row -->
                    </div>
                    <!-- End Section Add Item -->

                    <!-- Section Approval -->                    
                    <div class="invoice-header mb-4">
                        <div class="row">
                            <div class="col-lg-11">
                                <h3>Approver</h3>

                            </div>
                            <div class="col-lg-1 text-end">
                                <div class="form-check checkbox-style mb-10">
                                    <input class="form-check-input"type="checkbox" id="checkAll">
                                </div>
                            </div>
                        </div>

                        <hr class="border-2">
                        @foreach ($dataOrder as $key => $app)
                            <h5 class="mb-2">Order Ke-{{$key+1}}</h5>
                                @foreach ($app as $jabatan)
                                    @foreach($jabatan as $personal)
                                    <div class="form-check checkbox-style mb-10">
                                        @if($approverChecked->whereIn('UserId', $personal->UserId)->count() > 0)
                                        <input
                                        class="form-check-input"type="checkbox" id="toggleSwitch1"
                                        name="approver[]" value="{{$personal->UserId}}_{{$key+1}}" form="ItemReqForm" checked
                                        />
                                        @else
                                        <input
                                        class="form-check-input"type="checkbox" id="toggleSwitch1"
                                        name="approver[]" value="{{$personal->UserId}}_{{$key+1}}" form="ItemReqForm"
                                        />
                                        @endif
                                        <label class="form-check-label" for="toggleSwitch1">{{$personal->Fullname}} - {{$personal->fk_role->RoleName}}</label>
                                    </div>
                                    @endforeach
                                @endforeach
                                <div class="mb-20"></div>
                        @endforeach
                    </div>
                    <!-- End Section Approval -->


                    <div class="row">
                        <div class="col-lg-12 text-end">
                            <a href="{{route('itemreq.index')}}" class="btn btn-outline-danger">Back</a>
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modal">Submit</button>
                        </div>
                    </div>

                </div>
                <!-- end card -->
            </div>
        </div>
        <!-- end col -->
    </div>
    <!-- end row -->
    </div>
    <!-- end wrapper -->
</section>


<div id="modal" class="modal fade bd-example-modal-mb" tabindex="-1" role="dialog" aria-labelledby="add-categori" aria-hidden="true">
    <div class="modal-dialog modal-mb modal-dialog-centered">
      <div class="modal-content card-style ">
            <div class="modal-header px-0">
                <h5 class="text-bold" id="exampleModalLabel">Submit Requisition</h5>
            </div>
          <div class="modal-body px-0">
                <p class="mb-40">Apakah anda yakin ingin Mensubmit Data Requisition ini?</p>

                <div class="action d-flex flex-wrap justify-content-end">
                    <button class="btn btn-outline-danger" data-bs-dismiss="modal">Back</button>
                    <button type="submit" class="btn btn-primary ml-5" form="ItemReqForm">Submit</a>
                </div>
            </form>
          </div>
      </div>
    </div>
</div>

@endsection

@push('js')
@include('sweetalert::alert')

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/4.2.0/min/dropzone.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/tagmanager/3.0.2/tagmanager.min.js"></script>
<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.1/js/dataTables.bootstrap5.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.min.js"></script>


<script type="text/javascript">
    $("#checkAll").click(function(){
        $('input:checkbox').not(this).prop('checked', this.checked);
    });

    $(document).ready(function() {
        $('.select2').select2();
    });

    Dropzone.options.imageUpload = {
        maxFilesize: 100,
        renameFile: function(file) {
            var dt = new Date();
            var time = dt.getTime();
            return time + file.name;
        },
        acceptedFiles: ".jpeg,.jpg,.png,.gif,.pdf,.zip",
        addRemoveLinks: true,
        timeout: 50000,
        init: function() {
            var reqId = $('#ReqId').val();
            $.ajax({
                url: `/dropzone/get/${reqId}`,
                type: 'GET',
                dataType: 'json',
                success: function(data) {
                    console.log(data);
                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText);
                }
            });
        },
        removedfile: function(file) {
            var name = file.name;
            console.log(file.name);
            $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                }),
                $.ajax({
                    type: 'POST',
                    url: '{{url("dropzone/delete")}}',
                    data: {
                        filename: name
                    },
                    success: function(data) {
                        console.log("File has been successfully removed!!");
                    },
                    error: function(xhr, ajaxOptions, thrownError) {
                        console.log(xhr.responseText);
                    },
                });
            var fileRef;
            return (fileRef = file.previewElement) != null ?
                fileRef.parentNode.removeChild(file.previewElement) : void 0;
        },
    };

    $("#add-item").click(function() {

        var dataObject = $('#itemHidden').val();
        dataObject = JSON.parse(dataObject);

        var itemDiv = $("<div>").addClass("item row");
        itemDiv.html(`
            <div class="col-lg-8">
                <div class="select-style-1 col-lg-12">
                    <div class="select-position">
                        <select name="itemId[]" id="itemId" form="ItemReqForm" required>
                            <option value="" disabled selected>Choose Item</option>
                            ${dataObject.map(dataObject => `<option value="${dataObject.ItemId}">${dataObject.Name}</option>`).join("")}
                        </select>
                    </div>
                </div>
                <!-- end input -->
            </div>
            <div class="col-lg-3">
                <div class="input-style-1">
                    <input type="number" placeholder="Quantity  " name="Qty[]" min="1" required form="ItemReqForm"/>
                    @error('Qty') <span class="text-danger">{{$message}}</span> @enderror
                </div>
                <!-- end input -->
            </div>
            <div class="col-lg-1 mt-2">
                <button class="btn btn-danger">Delete</button>
            </div>
        `);

        $("#item-container").append(itemDiv);

        itemDiv.find(".btn-danger").click(function() {
            $(this).closest(".item").remove();
        });
    });

    $(document).ready(function() {
        var itemObject = $('#detailHidden').val();
        itemObject = JSON.parse(itemObject);
        var dataObject = $('#itemHidden').val();
        dataObject = JSON.parse(dataObject);

        var itemDiv = $("<div>").addClass("item row");

        if (itemObject != null) {
            itemObject.forEach(element => {
                var itemDiv = $("<div>").addClass("item row");
                var options = dataObject.map(dataItem => `<option value="${dataItem.ItemId}" ${dataItem.ItemId === element.ItemId ? 'selected' : ''}>${dataItem.Name}</option>`).join("");

                itemDiv.html(`
          <div class="col-lg-8">
            <div class="select-style-1 col-lg-12">
              
              <div class="select-position">
                <select name="itemId[]" id="itemId" form="ItemReqForm" required>
                  ${options}
                </select>
              </div>
            </div>
            <!-- end input -->
          </div>
          <div class="col-lg-3">
            <div class="input-style-1">
              
              <input type="number" value="${element.ItemQty}" placeholder="Quantity" name="Qty[]" min="1" required form="ItemReqForm"/>
              @error('Qty') <span class="text-danger">{{$message}}</span> @enderror
            </div>
            <!-- end input -->
          </div>
          <div class="col-lg-1 mt-2">
            <button class="btn btn-danger">Delete</button>
          </div>
        `);

                $("#item-container").append(itemDiv);
                itemDiv.find(".btn-danger").click(function() {
                    $(this).closest(".item").remove();
                });
            });
        }
    });

    $(".deleteFile").click(function(e) {
        e.preventDefault();

        var id = $(this).data("item-id");
        var card = $(e.target).closest('.card');

        var confirmDelete = confirm("Apakah Anda yakin ingin menghapus file ini?");
        if (!confirmDelete) {
            return;
        }

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            url: `/itemrequisition/file/delete/${id}`,
            type: 'DELETE',
            success: function(response) {
                card.remove();
                alert(response.message);
            },
            error: function(xhr, status, error) {
                var errorMessage = xhr.responseJSON.message || 'An error occurred while deleting the item.';
                alert(errorMessage);
            }
        });
    });
</script>
@endpush