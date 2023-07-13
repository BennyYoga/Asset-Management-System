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

    <form action="{{route('item.store')}}" method="post">
        @csrf
        <div class="form-elements-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <!-- input style start -->
                    <div class="card-style mb-30">
                        <div class="row">

                            <div class="col-lg-6">
                                <div class="input-style-1">
                                    <label>Item Name</label>
                                    <input type="text" placeholder="Item Name" name="Name" required />
                                    @error('Name') <span class="text-danger">{{$message}}</span> @enderror
                                </div>
                                <!-- end input -->

                                <div class="input-style-1">
                                    <label>Unit</label>
                                    <input type="text" placeholder="Unit" name="Unit" required />
                                    @error('Unit') <span class="text-danger">{{$message}}</span> @enderror
                                </div>
                                <!-- end input -->

                                <div class="select-sm select-style-1">
                                    <label>Category Item</label>
                                    <div class="select-position input-tags">
                                        <select class="js-example-basic-single form-" id="tags" multiple name="Category[]">
                                            @foreach($category as $c)
                                            <option value="{{$c->CategoryId}}">{{$c->Name}}</option>
                                            @endforeach
                                        </select>
                                        @error('Category') <span class="text-danger">{{$message}}</span> @enderror
                                    </div>
                                </div>
                                <!-- end input -->
                            </div>
                            <!-- end col -->

                            <div class="col-lg-6">
                                <div class="select-sm select-style-1">
                                    <label>Status of Item </label>
                                    <div class="select-position">
                                        <select class="light-bg" name="Status" required>
                                            <option selected disabled>Choose Status Item</option>
                                            <option value="1">Active</option>
                                            <option value="0">Nonactive</option>
                                        </select>
                                        @error('Status') <span class="text-danger">{{$message}}</span> @enderror
                                    </div>
                                </div>
                                <!-- end input -->

                                <div class="select-sm select-style-1">
                                    <label>Item Behavior</label>
                                    <div class="select-position">
                                        <select class="light-bg" id="Filter-Item" name="ItemBehavior" required>
                                            <option selected disabled>Choose Item Behavior</option>
                                            <option value="1">House Usage Monitor</option>
                                            <option value="2">Consumable</option>
                                            <option value="3">Non Consumable</option>
                                        </select>
                                        @error('ItemBehavior') <span class="text-danger">{{$message}}</span> @enderror
                                    </div>
                                </div>
                                <!-- end input -->

                                <div class="input-style-1 d-none" id="Alert-Hour">
                                    <label>Alert Hour Maintenance</label>
                                    <input type="number" id="alert-input" placeholder="Hour Usage Monitor (in Hour)" name="AlertHourMaintenance" />
                                </div>
                                <!-- end input -->

                                <div class="input-style-1 d-none" id="Alert-Consumable">
                                    <label>Consumable</label>
                                    <input type="number" id="alert-input" placeholder="Consumable (in Unit)" name="AlertConsumable" />
                                </div>
                                <!-- end input -->
                            </div>
                            <!-- end col -->
                        </div>
                        <!-- End Row -->
                        <div class="row">
                            <div class="col-lg-12">
                                <button type="submit" class="btn btn-primary">Submit</button>
                                <a href="{{route('item.index')}}" class="btn btn-outline-danger">Back</a>
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

@section('content')
@endsection

@push('js')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/tagmanager/3.0.2/tagmanager.min.js"></script>
<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.1/js/dataTables.bootstrap5.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.min.js"></script>
<script type="text/javascript">
    let Hourly = document.getElementById('Alert-Hour');
    let Consumable = document.getElementById('Alert-Consumable');

    let placeholder = document.getElementById('alert-input');

    $("#Filter-Item").on('change', function() {
        var Pilihan = $('#Filter-Item').val();
        // console.log(placeholder.placeholder);

        if (Pilihan == 1) {
            Consumable.classList.add('d-none');
            Hourly.classList.remove('d-none');
        } else if (Pilihan == 2) {
            Hourly.classList.add('d-none');
            Consumable.classList.remove('d-none');
        }
        if (Pilihan == 3) {
            Consumable.classList.add('d-none');
            Hourly.classList.add('d-none');
        }
    });
    $('.js-example-basic-single').select2({
        theme: "classic",
    });

    $('#tags').on('change', function() {
        var categorySelect = document.querySelector('.select-sm.select-style-1 .js-example-basic-single');
        var selectedOptions = Array.from(categorySelect.selectedOptions).map(option => option.value);
        console.log(selectedOptions);
    });
</script>
@endpush