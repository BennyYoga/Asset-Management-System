@extends('Template.template')

@section('title','Asset Monitoring System | Create Item')

{{-- kalau ada css tambahan selain dari template.blade --}}
@push('css')
<link href="https://cdn.datatables.net/1.13.1/css/dataTables.bootstrap5.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" />
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />
<meta name="csrf-token" content="{{ csrf_token() }}" />
<style>
    .preview-image {
        width: 50px;
        height: 50px;
        object-fit: cover;
        margin: 5px;
        border-radius: 5px;
    }

    #announ {
        padding: 20px;
        text-align: center;
    }

    #title-file {
        margin: auto 0;
    }

    #deleted-btn {
        height: 40px;
        margin: auto 0;
    }

    .preview-item {
        display: flex;
        justify-content: space-between;
        width: 100%;
        padding: 0px 10px;
        margin-bottom: 5px;
        border-bottom: 1px solid #e5e5e5;
    }


    #preview {
        width: 100%;
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
                    <h2>Add Data Item</h2>
                </div>
            </div>
            <!-- end col -->
            <div class="col-md-6">
                <div class="breadcrumb-wrapper mb-30">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="item.index">Item</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">
                                Create
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

    <form data-action="{{ route('itemreq.store') }}" enctype="multipart/form-data" method="post">
        @csrf
        <div class="form-elements-wrapper">
            <input type="hidden" id="itemHidden" value="{{$item}}">
            <div class="row">
                <div class="col-sm-12">
                    <!-- input style start -->
                    <div class="card-style mb-30">
                        <div class="row mt-3">
                            <div class="col-lg-6">
                                <div class="select-style-1">
                                    <label>Select Location</label>
                                    <div class="select-position">
                                        <select name="LocationId" id="LocationId" required>
                                            <option value="" disabled selected>Choose location</option>
                                            @foreach ($location as $loc)
                                            <option value="{{ $loc->LocationId }}">{{$loc->Name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <!-- end input -->

                                <div class="input-style-1">
                                    <label>Notes</label>
                                    <textarea class="input-tags" rows="4" id="Notes" name="Notes" placeholder="Notes"></textarea>
                                    @error('Notes') <span class="text-danger">{{$message}}</span> @enderror
                                </div>
                                <!-- end input -->
                            </div>

                            <!-- End Col -->
                            <div class="col-sm-1"></div>
                            <div class="col-sm-4">
                                <div class="input-style-1">
                                    <label>Requisition Letter</label>
                                    <input type="file" class="form-control-file" value="file" id="input-file" accept="image/*" multiple placeholder="Upload Your File" />
                                </div>
                                <div>
                                    <div class="input-style-1">
                                        <label>Your File</label>
                                        <div id="preview">
                                            <p id="announ">
                                                No File Attached!!
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div id="item-container">
                            <div class="row item">

                            </div>
                        </div>
                        <!-- End Row -->
                        <div class="row">
                            <div class="col-lg-12">
                                <button type="button" class="btn btn-success" id="add-item">Tambah Item</button>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12 text-end">
                                <button type="submit" class="btn btn-primary">Submit</button>
                                <a href="{{route('itemreq.index')}}" class="btn btn-outline-danger">Back</a>
                            </div>
                        </div>
                    </div>
                    <!-- end card -->
                </div>
                <!-- end col -->
            </div>
            <!-- end row -->
        </div>
        <button id="check" type="button">
            check
        </button>
        <button id="reset" type="button">
            reset
        </button>
        <!-- end wrapper -->
    </form>
</section>
@endsection

@push('js')
@include('sweetalert::alert')

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/tagmanager/3.0.2/tagmanager.min.js"></script>
<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.1/js/dataTables.bootstrap5.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.min.js"></script>
<script type="text/javascript">
    $(document).ready(function() {
        var inputImage = [];
        $('#input-file').on('change', handleFileUpload);

        function handleFileUpload(event) {
            var files = event.target.files;
            var output = $('#preview');

            for (var i = 0; i < files.length; i++) {
                var file = files[i];
                var reader = new FileReader();
                reader.onload = function(e) {
                    var previewItem = createPreviewItem(e.target.result);
                    output.append(previewItem);
                    inputImage.push(e.target.result);
                };
                file = reader.readAsDataURL(file);
            }
        }

        function createPreviewItem(src) {
            var previewItem = $('<div class="preview-item"></div>');

            var image = $('<img class="preview-image">');
            var text = $(`<span id="title-file"> File Data Absen </span>`);
            image.attr('src', src);
            previewItem.append(image);
            previewItem.append(text);

            var deleteButton = $('<button id="deleted-btn" class="btn btn-danger btn-sm">Hapus</button>');
            deleteButton.click(function() {
                var previewItem = $(this).closest('.preview-item');
                var src = image.attr('src');
                inputImage = inputImage.filter(e => e != src)
                previewItem.remove();
            });
            previewItem.append(deleteButton);

            return previewItem;
        }

        $("form").on('submit', function(e) {
            e.preventDefault();
            var locationId = $('#LocationId').val();
            var notes = $('#Notes').val();
            var item = $('#itemId').val();
            var url = $(this).attr('data-action');
            var formData = {
                locationId: locationId,
                notes: notes,
                inputImage: inputImage,
                item: item
            };

            console.log(formData);
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }

            });
            $.ajax({
                url: url,
                type: "POST",
                data: {
                    "_token": "{{ csrf_token() }}",
                    "data": formData
                },
                dataType: "json",
                contentType: "application/json; charset=utf-8",
            });
        })
    });

    $("#add-item").click(function() {
        var dataObject = $('#itemHidden').val();
        dataObject = JSON.parse(dataObject);

        var itemDiv = $("<div>").addClass("item row");
        console.log(itemDiv);
        itemDiv.html(`
            <div class="col-lg-8">
                <div class="select-style-1 col-lg-12">
                    <label>Choose Name Item</label>
                    <div class="select-position">
                        <select name="itemId[]" id="itemId" required>
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
                    <input type="number" placeholder="Quantity of Item" name="Qty[]" min="1" required/>
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