@extends('Template.template')

@section('title','Asset Management System | Edit Category')

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

    <form action="{{route('item.update', $item->ItemId)}}" method="post">
        @method('PUT')
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
                                    <input type="text" placeholder="Item Name" name="Name" value="{{$item->Name}}" />
                                </div>

                                <div class="select-sm select-style-1">
                                    <label>Item Behavior</label>
                                    <div class="select-position">
                                        <select class="light-bg" id="Filter-Item" name="ItemBehavior">
                                            @if($item->ItemBehavior == 1)
                                            <option value="1" selected>House Usage Monitor</option>
                                            <option value="2">Costumable</option>
                                            <option value="3">Non Costumable</option>
                                            @elseif($item->ItemBehavior == 2)
                                            <option value="1">House Usage Monitor</option>
                                            <option value="2" selected>Costumable</option>
                                            <option value="3">Non Costumable</option>
                                            @elseif($item->ItemBehavior == 3)
                                            <option value="1">House Usage Monitor</option>
                                            <option value="2">Costumable</option>
                                            <option value="3" selected>Non Costumable</option>
                                            @endif
                                        </select>
                                    </div>
                                </div>

                                <div class="input-style-1 d-none" id="Alert-Hour">
                                    <label>Alert Hour Maintenance</label>
                                    <input type="number" id="alert-input" placeholder="Hour Usage Monitor (in Hour)" name="AlertHourMaintenance" value="{{$item->AlertHourMaintenance}}" />
                                </div>

                                <div class="input-style-1 d-none" id="Alert-Consumable">
                                    <label>Consumable</label>
                                    <input type="number" id="alert-input" placeholder="Consumable (in Unit)" name="AlertConsumable" value="{{$item->AlertConsumable}}" />
                                </div>

                                <!-- end input -->
                            </div>
                            <div class="col-lg-6">

                                <div class="input-style-1">
                                    <label>Unit</label>
                                    <input type="number" placeholder="Unit" name="Unit" value="{{$item->Unit}}" />
                                </div>

                                <div class="select-sm select-style-1">
                                    <label>Category Item</label>
                                    <div class="select-position input-tags">
                                        <select class="js-example-basic-single form-" id="tags" multiple name="Category[]">
                                            @for($i =0; $i < count($unselectedCategory); $i++) <option value="{{$unselectedCategory[$i]['CategoryId']}}">{{$unselectedCategory[$i]['Name']}}</option>
                                                @endfor
                                                @for($i =0; $i < count($selectedCategory); $i++) <option selected="selected" value="{{$selectedCategory[$i]['CategoryId']}}">{{$selectedCategory[$i]['Name']}}</option>
                                                    @endfor
                                        </select>
                                        @error('Category') <span class="text-danger">{{$message}}</span> @enderror
                                    </div>
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
<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.1/js/dataTables.bootstrap5.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.min.js"></script>
<script type="text/javascript">
    $(document).ready(function() {

        $('.js-example-basic-single').select2({
            theme: "classic",
        }, 'val', ['1', '2']);

        let Hourly = $('#Alert-Hour');
        let Consumable = $('#Alert-Consumable');
        let placeholder = $('#alert-input');

        $("#Filter-Item").on('change', function() {
            var Pilihan = $(this).val();

            if (Pilihan == 1) {
                Consumable.addClass('d-none');
                Hourly.removeClass('d-none');
            } else if (Pilihan == 2) {
                Hourly.addClass('d-none');
                Consumable.removeClass('d-none');
            } else if (Pilihan == 3) {
                Consumable.addClass('d-none');
                Hourly.addClass('d-none');
            }
        });

        // Set tampilan awal berdasarkan nilai default pada dropdown "Item Behavior"
        let defaultBehavior = $("#Filter-Item").val();
        if (defaultBehavior == 1) {
            Consumable.addClass('d-none');
            Hourly.removeClass('d-none');
        } else if (defaultBehavior == 2) {
            Hourly.addClass('d-none');
            Consumable.removeClass('d-none');
        } else if (defaultBehavior == 3) {
            Consumable.addClass('d-none');
            Hourly.addClass('d-none');
        }
    });
</script>
</script>

@endpush