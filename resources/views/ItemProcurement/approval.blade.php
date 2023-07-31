@extends('Template.template')

@section('title','Assets Management System | Add Item Procurement')

{{-- kalau ada css tambahan selain dari template.blade --}}
@push('css')
<link href="https://cdn.datatables.net/1.13.1/css/dataTables.bootstrap5.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" />
<link rel="stylesheet"
    href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.3/dropzone.min.css" type="text/css" />
<meta name="csrf-token" content="{{ csrf_token() }}">
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
                        <h2>Add Item Procurement</h2>
                    </div>
                </div>
                <!-- end col -->
                <div class="col-md-6">
                    <div class="breadcrumb-wrapper mb-30">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item">
                                    <a href="procurement.index">Item Procurement</a>
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
        <form action="{{ route('itemproc.store') }}" id="ItemProcForm" method="post">
            @csrf
        </form>
        <div class="form-elements-wrapper">
            <input type="hidden" id="itemHidden" value="{{$item}}">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card-style mb-30">
                        <div class="row mt-3">
                            <!-- Left column -->
                            <div class="col-lg-6">
                            <div class="col-lg-6">
                                <div class="select-style-1">
                                    <label>Ref Item Requisition</label>
                                    <div class="select-position">
                                        <select name="LocationId" id="LocationId" form="ItemProcForm" required>
                                            <option value="" disabled selected>Choose requisition</option>
                                            @foreach ($location as $location)
                                            <option value="{{ $location->LocationId }}">{{$location->Name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="input-style-1">
                                    <label>Transaction Date</label>
                                    <input type="date" id="Tanggal" name="Tanggal" form="ItemProcForm">
                                </div>
                            </div>
                                <div class="input-style-1">
                                    <label>Notes</label>
                                    <textarea class="input-tags" rows="4" id="Notes" name="Notes" placeholder="Notes"
                                        form="ItemProcForm"></textarea>
                                    @error('Notes') <span class="text-danger">{{$message}}</span> @enderror
                                </div>
                                <div class="input-style-1">
                                    <label>Upload Your File</label>
                                    <form action="{{ route('itemproc.dropzoneStore') }}" method="post" name="file"
                                        files="true" enctype="multipart/form-data" class="dropzone" id="image-upload">
                                        @csrf
                                    </form>
                                </div>
                            </div>
                            <!-- End Left column -->

                            <!-- Right column -->
                            <div class="col-lg-6">
                                <div id="item-container">
                                    <div class="row item">
                                        <!-- Your item content goes here -->
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-12 text-start">
                                        <button type="button" class="btn btn-primary" id="add-item">Tambah Item</button>
                                    </div>
                                </div>
                            </div>
                            <!-- End Right column -->
                        </div>
                    </div>
                </div>
            </div>


        </div>
        <!-- ========== title-wrapper start ========== -->
        <div class="title-wrapper pt-30">
            <div class="row"> <!-- Menambahkan class "align-items-center" untuk membuat elemen berada pada garis vertikal yang sama -->
                <div class="col-md-6">
                    <div class="title mb-30">
                        <h2>Approver</h2>
                    </div>
                </div>
                <!-- end col -->
                <div class="col-md-6 d-flex justify-content-end align-items-center"> <!-- Menggunakan class "d-flex justify-content-end" untuk meletakkan elemen pada ujung kanan -->
                    <div class="form-check checkbox-style mb-20">
                        <label for="checkbox-1">Select All</label>
                        <input type="checkbox" class="form-check-input" value id="checkbox-1" form="ItemProcForm">
                    </div>
                </div>
                <!-- end col -->
            </div>
            <!-- end row -->
        </div>
        
        <!-- ========== Approval ========== -->
        <div class="form-elements-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card-style mb-30">
                        <div class="row mt-3">
                            <!-- Left column -->
                            <div class="col-lg-6">
                                <h6 class="mb-10">Approval 1</h6>
                                <div class="form-check checkbox-style mb-30">
                                    <input type="checkbox" class="form-check-input" id="checkbox-2" form="ItemProcForm">
                                    <label for="checkbox-2">Nama Pegawai/Jabatan</label>
                                </div>
                                <div class="form-check checkbox-style mb-30">
                                    <input type="checkbox" class="form-check-input" id="checkbox-3" form="ItemProcForm">
                                    <label for="checkbox-3">Nama Pegawai/Jabatan</label>
                                </div>
                                <h6 class="mb-10">Approval 2</h6>
                                <div class="form-check checkbox-style mb-30">
                                    <input type="checkbox" class="form-check-input" id="checkbox-4" form="ItemProcForm">
                                    <label for="checkbox-4">Nama Pegawai/Jabatan</label>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12 text-end">
                                <input type="submit" class="btn btn-primary" form="ItemProcForm" value="Request Approval"></input>
                                <a href="{{route('itemproc.index')}}" class="btn btn-outline-danger">Back</a>
                            </div>
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

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.3/min/dropzone.min.js"></script>
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
        acceptedFiles: ".jpeg,.jpg,.png,.gif,.pdf,.docx,.doc,.xlsx,.xls,.pptx,.ppt,.txt,.zip,.rar",
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
                url: '{{ url("/itemprocurement/dropzone/delete") }}',
                data: {filename: name},
                success: function (data){
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
            <div class="col-lg-6">
                <div class="select-style-1 col-lg-12">
                    <label>Choose Name Item</label>
                    <div class="select-position">
                        <select name="itemId[]" id="itemId" form="ItemProcForm" required>
                            <option value="" disabled selected>Choose Item</option>
                            ${dataObject.map(dataObject => `<option value="${dataObject.ItemId}">${dataObject.Name}</option>`).join("")}
                        </select>
                    </div>
                </div>
                <!-- end input -->
            </div>
            <div class="col-lg-3">
                <div class="input-style-1">
                    <label>Quantity</label>
                    <input type="number" placeholder="Qty" name="Qty[]" min="1" form="ItemProcForm" required/>
                    @error('Qty') <span class="text-danger">{{$message}}</span> @enderror
                </div>
                <!-- end input -->
            </div>
            <div class="col-lg-1 m-auto">
                <button class="btn btn-danger">Delete</button>
            </div>
        `);

        $("#item-container").append(itemDiv);

        itemDiv.find(".btn-danger").click(function() {
            $(this).closest(".item").remove();
        });
    });
</script>
@endpush