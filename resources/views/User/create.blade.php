    @extends('Template.template')

    @section('title','Trash Monitoring System | Create Pegawai')

    {{-- kalau ada css tambahan selain dari template.blade --}}
    @push('css')
    <link href="https://cdn.datatables.net/1.13.1/css/dataTables.bootstrap5.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" />
    <link rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />
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
                            <h2>Tambah Data Pegawai</h2>
                        </div>
                    </div>
                    <!-- end col -->
                    <div class="col-md-6">
                        <div class="breadcrumb-wrapper mb-30">
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item">
                                        <a href="Pegawai.index">Pegawai</a>
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
                            <div class="input-style-1 col-lg-6">
                                <label>User Name</label>
                                <input type="text" placeholder="UserName" name="Username" required value="{{ old('Username') }}"/>
                            </div>
                            <!-- end input -->
                            <div class="input-style-1 col-lg-6">
                                <label>Nama lengkap</label>
                                <input type="text" placeholder="FullName" name="Fullname" value="{{ old('Fullname') }}"required/>
                            </div>
                            <div class="select-style-1 col-lg-6">
                                <label>Choose Role</label>
                                <div class="select-position">
                                    <select name="RoleId" id="RoleId" style="width:100%">
                                    <option value="" selected disabled> Select Role</option>
                                    <!-- <option value="">Root</option> -->
                                    @foreach($location as $locations)
                                    <option value="<?= $locations->RoleId?>">
                                    <?= $locations->RoleName?>
                                    </option>
                                    @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-6">
                        <!-- input style start -->
                            <div class="input-style-1 col-lg-12">
                                <label>Password</label>
                                <input type="password" placeholder="Password" id="password1" name="Password" title="" value="{{ old('Password') }}"/>
                            </div>
                            <!-- end input -->
                            <div class="input-style-1 col-lg-12">
                                <label>Konfirmasi Password</label>
                                <input type="password" placeholder="Konfirmasi Password" name="Confirm" id="password2" required/>
                            </div>
                            <!-- end input -->
                            </div>
                            <!-- end row -->
                            <div class="card-footer mb">
                                <button type="submit" class="btn btn-success">Simpan</button>
                                <a href="/user" class="btn btn-deactive">
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
    <script>
        function checkPassword(event) {
            let password1 = document.getElementById('password1').value;
            let password2 = document.getElementById('password2').value;
            let message = document.getElementById('message');

            if(password1.length != 0){
                if (password1 != password2) {
                    message.textContent = 'Password Tidak Sesuai';
                    message.style.color = 'red';
                    event.preventDefault();
                }
            }
        }
        const form = document.getElementById('pegawai');
        form.addEventListener('submit', checkPassword);
    </script>
    @endpush