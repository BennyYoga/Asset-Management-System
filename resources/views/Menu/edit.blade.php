@extends('Template.template')

@section('title', 'Assets Management System | Edit Menu')

@push('css')
<!-- Tambahkan link CSS tambahan jika diperlukan -->
@endpush

@section('content')
<section class="tab-components">
    <div class="container-fluid">
        <!-- ========== title-wrapper start ========== -->
        <div class="title-wrapper pt-30">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <div class="title mb-30">
                        <h2>Edit Menu</h2>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="breadcrumb-wrapper mb-30">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item">
                                    <a href="{{ route('project.index') }}">Project</a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">
                                    Edit
                                </li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
        </div>

        <div class="form-elements-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card-style mb-30">
                        <div class="row">
                            <div class="input-style-1 col-lg-6">
                                <label>Menu Name</label>
                                <input type="text" id="menuName" placeholder="Menu Name" name="MenuName" required value="{{ $menu->MenuName }}" />
                            </div>
                        </div>
                        <div class="input-style-1 col-lg-6">
                            <label>Menu Description</label>
                            <input type="text" id="menuDesc" placeholder="Menu Description" name="MenuDesc" value="{{ $menu->MenuDesc }}" />
                        </div>
                        <div class="input-style-1 col-lg-6">
                            <label>Menu Icon</label>
                            <input type="text" id="menuIcon" placeholder="Menu Icon" name="MenuIcon" value="{{ $menu->MenuIcon }}" />
                        </div>
                    </div>
                    <div class="card-footer mb">
                        <a href="#" class="btn btn-primary edit-btn" data-toggle="modal" data-target="#editModal">Edit</a>
                        <a href="{{ route('menu.index') }}" class="btn btn-outline-danger">Back</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Modal -->
<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel">Edit Menu</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <label>Menu Name</label>
                <input type="text" id="editMenuName" placeholder="Menu Name" name="MenuName" required value="{{ $menu->MenuName }}" />
                <!-- ... (input fields lainnya) -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="edit-submit-btn">Save Changes</button>
            </div>
        </div>
    </div>
</div>

@push('js')
<script>
$(document).ready(function() {
    // Ketika tombol submit di modal diklik
    $('#edit-submit-btn').click(function() {
        var menuId = "{{ $menu->MenuId }}"; // Ambil MenuId dari variabel PHP
        var menuName = $('#editMenuName').val();
        var menuDesc = $('#menuDesc').val();
        var menuIcon = $('#menuIcon').val();

        var formData = {
            MenuName: menuName,
            MenuDesc: menuDesc,
            MenuIcon: menuIcon,
            _method: 'PUT', // Metode untuk update
            _token: "{{ csrf_token() }}", // Token CSRF
        };

        $.ajax({
            url: "/menu/" + menuId + "/update", // Ganti dengan URL sesuai kebutuhan
            type: 'POST',
            data: formData,
            success: function(response) {
                // Sukses - lakukan tindakan setelah berhasil disimpan
                $('#editModal').modal('hide'); // Tutup modal
                // Lakukan tindakan lain seperti memperbarui tampilan atau pesan sukses
            },
            error: function(xhr, status, error) {
                // Tangani kesalahan, misalnya tampilkan pesan error
                console.error(error);
            }
        });
    });
});
</script>
@endpush

@endsection
