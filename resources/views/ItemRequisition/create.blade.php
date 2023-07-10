@extends('Template.template')

@section('title','Asset Monitoring System | Create Item')

{{-- kalau ada css tambahan selain dari template.blade --}}
@push('css')
<link href="https://cdn.datatables.net/1.13.1/css/dataTables.bootstrap5.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" />
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />
<style>
    .input-tags {
        width: 100%;
        background: rgba(239, 239, 239, 0.5);
        border: 1px solid #e5e5e5;
        border-radius: 4px;
        padding: 16px;
        color: #5d657b;
        resize: none;
        transition: all 0.3s;
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

    <form action="{{route('itemreq.store')}}" method="post">
        @csrf
        <div class="form-elements-wrapper">
            <input type="hidden" id="itemHidden" value="{{$item}}">
            <div class="row">
                <div class="col-sm-12">
                    <!-- input style start -->
                    <div class="card-style mb-30">
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
                        <div class="row mt-5">
                            <div class="col-lg-12">
                                <div class="input-style-1">
                                    <label>Notes</label>
                                    <textarea class="input-tags" rows="4" name="Notes" placeholder="Notes"></textarea>
                                    @error('Notes') <span class="text-danger">{{$message}}</span> @enderror
                                </div>
                                <!-- end input -->
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
        <!-- end wrapper -->
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
                <input type="number" placeholder="Quantity of Item" name="Qty[]" required/>
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