    @extends('Template.template')

    @section('title','Assets Management System | Create Pegawai')

    {{-- kalau ada css tambahan selain dari template.blade --}}
    @push('css')
    <link href="https://cdn.datatables.net/1.13.1/css/dataTables.bootstrap5.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />
    @endpush
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
                            <h2>Tambah Data Pegawai</h2>
                        </div>
                    </div>
                    <!-- end col -->
                    <div class="col-md-6">
                        <div class="breadcrumb-wrapper mb-30">
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item">
                                        <a href="{{ route('dashboard.index')}}">Dashboard</a>
                                    </li>
                                    <li class="breadcrumb-item">
                                        <a href="{{ route('user.index')}}">User</a>
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
        
        <form action="{{route('user.store')}}" method="post" id="user">
            @csrf
            <div class="form-elements-wrapper">
                <div class="row">
                    <div class="col-lg-12">
                        <!-- input style start -->
                        <div class="card-style mb-30">
                            <div class="row">
                                <div class="input-style-1 col-lg-6">
                                    <label>User Name</label>
                                    <input type="text" placeholder="UserName" name="Username" required value="{{ old('Username') }}"/>
                                </div>
                                <div class="input-style-1 col-lg-6">
                                    <label>Nama lengkap</label>
                                    <input type="text" placeholder="FullName" name="Fullname" required value="{{ old('Fullname') }}" />
                                </div>
                                <!-- end input -->

                            </div>
                            <div class="row">
                                <div class="input-style-1 col-lg-6">
                                    <label>Password</label>
                                    <input type="password" placeholder="Password" id="password1" name="Password" title=""/>
                                </div>
                        <!-- input style start -->
                            <div class="input-style-1 col-lg-6">
                                    <label>Konfirmasi Password</label>
                                    <input id="password" type="password" placeholder="Password confirm" name="password_confirmation" required autocomplete="current-password">
                                </div>
                            </div>
                            <!-- end input -->
                            <div class="row">
                                <div class="select-style-1 col-lg-6">
                                    <label>Choose Role</label>
                                    <div>
                                    <select class="js-example-basic-single" style ="width:100%">
                                        <option value="" selected disabled> Select Role</option>
                                        @foreach($location as $location)
                                        <option value="<?= $location->RoleId?>">
                                        <?= $location->RoleName?> - {{ $locations->where('LocationId', $location->LocationId)->first()->Name }}
                                        </option>
                                        @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            </div>
                            <!-- end input -->
                            </div>
                            <!-- end row -->
                            <div class="card-footer mb">
                                <button type="submit" class="btn btn-primary">Simpan</button>
                                <a href="/user" class="btn btn-outline-danger">
                                    Batal
                                </a>
                            </div>
                            <!-- end input -->
                        </div>
                        <!-- end card -->
                    </div>
                    <!-- end col -->
      

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
        $('.js-example-basic-single').select2({
            theme: "bootstrap-5",
        });
        const form = document.getElementById('pegawai');
        form.addEventListener('submit', checkPassword);
    </script>
    @endpush