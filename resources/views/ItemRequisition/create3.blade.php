@extends('Template.template')

@section('title','Assets Monitoring System | Add Item Requisition')

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
                    <h2>Add Item Requisition</h2>
                </div>
            </div>
            <!-- end col -->
            <div class="col-md-6">
                <div class="breadcrumb-wrapper mb-30">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="requisition.index">Item Requisition</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">
                                Create
                            </li>
                        </ol>
                    </nav>
                </div>
            </div>
            <!-- end col -->
        </div>
        <!-- end row -->
    </div>
    <form action="{{ route('itemreq.store') }}" id="ItemReqForm" method="post">
        @csrf
    </form>
    <div class="form-elements-wrapper">
        <input type="hidden" id="itemHidden" value="{{$item}}">
        <div class="row">
            <div class="col-lg-12">
                <div class="card-style mb-30">

                    <!-- Header Requisition -->
                    <div class="invoice-header mb-4">
                        <h3>Main Data Requisition</h3>
                        <hr class="border-2">
                    </div>

                    <div class="row mt-3">
                        <div class="col-lg-6">

                            <div class="select-style-1">
                                <label>Select Location</label>
                                <div class="select-position">
                                    <select name="LocationTo" id="LocationTo" form="ItemReqForm" required>
                                        <option value="" disabled selected>Choose location</option>
                                        @foreach ($location as $loc)
                                        <option value="{{ $loc->LocationId }}">{{$loc->Name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="input-style-1">
                                <label>Transaction Date</label>
                                <input type="date" id="Tanggal" name="Tanggal" form="ItemReqForm">
                            </div>

                            <div class="input-style-1">
                                <label>Notes</label>
                                <textarea class="input-tags" rows="4" id="Notes" name="Notes" placeholder="Notes" form="ItemReqForm"></textarea>
                                @error('Notes') <span class="text-danger">{{$message}}</span> @enderror
                            </div>
                        </div>

                        <div class="col-lg-6">
                            <div class="input-style-1">
                                <label>Upload Your File</label>
                                <form action="{{ route('dropzone.store') }}" method="post" name="file" files="true" enctype="multipart/form-data" class="dropzone" id="image-upload">
                                    @csrf
                                </form>
                            </div>
                        </div>
                    </div>
                    <!-- End Main Requisition -->


                    <!-- Item Details Requisition -->
                    <div class="invoice-header mb-4">
                        <div class="row">
                            <div class="col-lg-6">
                                <h3>Data Of Item</h3>
                            </div>
                            <div class="col-lg-6 text-end">
                                <button type="button" class="btn btn-success" id="add-item">Tambah Item</button>
                            </div>
                        </div>
                        <hr class="border-2">
                    </div>
                    <div id="item-container">
                        <div class="row item">
                        </div>
                    </div>
                    <!-- End Item Details Requisition -->


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
                                        <input
                                        class="form-check-input"type="checkbox" id="toggleSwitch1"
                                        name="approver[]" value="{{$personal->UserId}}_{{$key+1}}" form="ItemReqForm"
                                        />
                                        <label class="form-check-label" for="toggleSwitch1">{{$personal->Fullname}} - {{$personal->fk_role->RoleName}}</label>
                                    </div>
                                    @endforeach
                                @endforeach
                                <div class="mb-20"></div>
                        @endforeach
                    </div>
                    <!-- End Section Approval -->

                    <!-- button Submit -->
                    <div class="row">
                        <div class="col-lg-12 text-end">
                            <input type="submit" class="btn btn-primary" form="ItemReqForm" />
                            <a href="{{route('itemreq.index')}}" class="btn btn-outline-danger">Back</a>
                        </div>
                    </div>
                    <!-- end button submit -->
                </div>
            </div>
        </div>
    </div>
</section>


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
        console.log(itemDiv);
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
                    <input type="number" placeholder="Qty" name="Qty[]" min="1" required form="ItemReqForm"/>
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
    
    $("#checkAll").click(function(){
        $('input:checkbox').not(this).prop('checked', this.checked);
    });
</script>
@endpush