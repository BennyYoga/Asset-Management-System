@extends('Template.template')

@section('title','Assets Management System | Create Item')

{{-- kalau ada css tambahan selain dari template.blade --}}
@push('css')
    <link href="https://cdn.datatables.net/1.13.1/css/dataTables.bootstrap5.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />
    <style>
        .input-tags {
            width: 100%;
            border-radius: 4px;
            padding: 0px;
            color: #5d657b;
            resize: none;
            transition: all 0.3s;
        }
        .input-tags .selection {
            width: 100%;
            background: rgba(239, 239, 239, 0.5);
        }
        .input-tags input {
            display: none;
        }
        .input-tags .selection > span {
            border: 1px solid #e5e5e5;
            padding: 16px !important;
            background: transparent;
        }
    </style>
@endpush

@section('content')
<section class="tab-components">
    <div class="container-fluid">
        @include('Template.title',[
            "title" => "Create New Item",
            "breadcrumb" => [
                "Master Data" => "#",
                "Item" => route('item.index'),
                "Create" => "#",
            ],
        ])
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
                                        <label>Item Code</label>
                                        <input type="text" placeholder="Item Code" name="Code" required />
                                        @error('Code') <span class="text-danger">{{$message}}</span> @enderror
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="input-style-1">
                                        <label>Item Name</label>
                                        <input type="text" placeholder="Item Name" name="Name" required />
                                        @error('Name') <span class="text-danger">{{$message}}</span> @enderror
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="input-style-1">
                                        <label>Unit</label>
                                        <input type="text" placeholder="Unit" name="Unit" required />
                                        @error('Unit') <span class="text-danger">{{$message}}</span> @enderror
                                    </div>
                                </div>

                                <div class="col-lg-6">
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
                                </div>

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
                                </div>

                                <div class="col-lg-6">
                                    <div class="select-sm select-style-1">
                                        <label>Item Behavior</label>
                                        <div class="select-position">
                                            <select class="light-bg" id="Filter-Item" name="ItemBehavior" required>
                                                <option selected disabled>Choose Item Behavior</option>
                                                <option value="1">Hour Usage Monitor</option>
                                                <option value="2">Consumable</option>
                                                {{-- <option value="3">Non Consumable</option> --}}
                                            </select>
                                            @error('ItemBehavior') <span class="text-danger">{{$message}}</span> @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="input-style-1 d-none" id="Alert-Hour">
                                        <label>Alert Hour Maintenance</label>
                                        <input type="number" id="alert-input" placeholder="Hour Usage Monitor (in Hour)" name="AlertHourMaintenance" />
                                    </div>
                                    <div class="input-style-1 d-none" id="Alert-Consumable">
                                        <label>Consumable</label>
                                        <input type="number" id="alert-input" placeholder="Consumable (in Unit)" name="AlertConsumable" />
                                    </div>
                                </div>
                            </div>
                            <!-- End Row -->
                            <div class="row">
                                <div class="col-lg-12 text-end">
                                    <a href="{{route('item.index')}}" class="btn btn-secondary">Back</a>
                                    <button type="submit" class="btn btn-primary">Submit</button>
                                </div>
                            </div>
                        </div>
                        <!-- end card -->
                    </div>
                    <!-- end col -->
                </div>
                <!-- end row -->
            </div>
        </form>
    </div>
</section>
@endsection


@section('content')

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
        let Hourly = $('#Alert-Hour');
        let Consumable = $('#Alert-Consumable');
        let placeholder = $('#alert-input');

        $("#Filter-Item").on('change', function() {
            var Pilihan = $('#Filter-Item').val();
            placeholder.val("")
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

        $('.js-example-basic-single').select2({
            theme: "classic",
        });

        $('#tags').on("select2:open",()=>{
            $(".input-tags .selection").css("background","rgba(0,0,0,0)")
        }).on("select2:close",()=>{
            $(".input-tags .selection").css("background","rgba(239, 239, 239, 0.5)")
        })
    })
</script>
@endpush
