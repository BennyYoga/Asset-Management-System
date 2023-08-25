@extends('Template.template')

@section('title','Asset Management System | Create Category')

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
                    <h2>Add Role</h2>
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

    <form action="{{route('roleLocation.store')}}" method="post">
        @csrf
        <div class="form-elements-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <!-- input style start -->
                    <div class="card-style mb-30">
                        <div class="row">

                            <div class="col-lg-6">
                                <div class="input-style-1">
                                    <label>Role Name</label>
                                    <input type="text" placeholder="Role Name" name="RoleName" required />
                                    @error('Name') <span class="text-danger">{{$message}}</span> @enderror
                                </div>
                                @if(session('user')->RoleId == 1)
                                <div class="select-style-1">
                                <div class="input-tags">
                                <select class="js-example-basic-single" name="LocationId" id="LocationId" style="width:100%">
                                  <option value="" selected disabled> Select Location</option>
                                  @foreach($location as $lc)
                                  <option value="<?= $lc->LocationId?>">
                                  <?= $lc->Name?>
                                  </option>
                                  @endforeach
                                </select>
                              </div>
                                </div>
                              @endif
                                <!-- end input -->
                            </div>
                        </div>
                        <!-- End Row -->
                        <div class="row">
                            <div class="col-lg-12">
                                <button type="submit" class="btn btn-primary">Submit</button>
                                <a href="{{route('role.index')}}" class="btn btn-outline-danger">Back</a>
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
@include('sweetalert::alert')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/tagmanager/3.0.2/tagmanager.min.js"></script>
<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.1/js/dataTables.bootstrap5.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.min.js"></script>
<script type="text/javascript">

    let placeholder = document.getElementById('alert-input');

    $('.js-example-basic-single').select2({
        theme: "classic",
    });

    $('#access').on('change', function() {
        var categorySelect = document.querySelector('.select-sm.select-style-1 .js-example-basic-single');
        var selectedOptions = Array.from(categorySelect.selectedOptions).map(option => option.value);
        console.log(selectedOptions);
    });
</script>
@endpush