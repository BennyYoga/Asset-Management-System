@extends('Template.template')

@section('title','Asset Monitoring System | Create Item')

{{-- kalau ada css tambahan selain dari template.blade --}}
@push('css')
<link href="https://cdn.datatables.net/1.13.1/css/dataTables.bootstrap5.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" />
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />
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
                                <a href="Kantor.index">Kantor</a>
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
                                    <input type="text" placeholder="Item Name" name="Name" />
                                </div>

                                <div class="input-style-1">
                                    <label>Unit</label>
                                    <input type="number" placeholder="Unit" name="Unit" />
                                </div>
                                <!-- end input -->
                            </div>
                            <div class="col-lg-6">
                                <div class="select-sm select-style-1">
                                    <label>Item Behavior</label>
                                    <div class="select-position">
                                        <select class="light-bg" id="Filter-Item" name="ItemBehavior">
                                            <option selected disabled>Choose Item Behavior</option>
                                            <option value="1">House Usage Monitor</option>
                                            <option value="2">Costumable</option>
                                            <option value="3">Non Costumable</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="input-style-1 d-none" id="Alert-Item">
                                    <label id="Alert-Label"></label>
                                    <input type="number" id="alert-input" placeholder="" name="Alert" />
                                </div>
                                <!-- end input -->
                            </div>
                            <!-- end col -->
                        </div>
                        <!-- End Row -->
                        <div class="row">
                            <div class="col-lg-12">
                                <button type="submit" class="btn btn-success">Submit</button>
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
    let input = document.getElementById('Alert-Item');
    let placeholder = document.getElementById('alert-input');
    
    $("#Filter-Item").on('change', function() {
        var Pilihan = $('#Filter-Item').val();
        // console.log(placeholder.placeholder);
        
        if(Pilihan == 1 || Pilihan == 2){
            input.classList.remove('d-none');
            if (Pilihan == 1) {
                placeholder.setAttribute('placeholder', 'Alert Hour Maintenance');
                document.getElementById('Alert-Label').textContent = "Hour Usage Monitor (in Hour)";
            } else if (Pilihan == 2) {
                placeholder.setAttribute('placeholder', 'Alert Costumable');
                document.getElementById('Alert-Label').textContent = "Costumable (in Unit)";
            }
        }
        if (Pilihan == 3) {
            input.classList.add('d-none');
        }   
    });
</script>

@endpush