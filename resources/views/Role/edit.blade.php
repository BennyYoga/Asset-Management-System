@extends('Template.template')

@section('title', 'Asset Management System | Role Access Edit')

@push('css')
<link href="https://cdn.datatables.net/1.13.1/css/dataTables.bootstrap5.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" />
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />
<link href="{{ asset('vendor/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/css/bootstrap.min.css" />
<link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">
@endpush
@section('content')

<section class="section">
    <div class="container-fluid">
        <!-- ========== title-wrapper start ========== -->
        <style>
            span.nonactive {
            color: red;
            }

/* Ganti warna teks menjadi hijau untuk status "Active" */
            span.active {
            color: green;
            }         
        </style>
        <div class="title-wrapper pt-30">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <div class="title mb-30">
                        <h2>Role</h2>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="breadcrumb-wrapper mb-30">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item">
                                    <a href="#">Role</a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">
                                    Page
                                </li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <table class="table table-striped" id="table">
                                <thead>
                                    <tr>
                                        <th>Menu Name</th>
                                        <th>ParentMenu</th>
                                        <th>Description</th>
                                        <th>Allow Access</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($menu as $item)
                                    <tr>
                                        <td>{{ $item->MenuName }}</td>
                                        <td>{{$item->ParentId}}</td>
                                        <td>{{ $item->MenuDesc }}</td>
                                        <td>
                                            <input data-menuid="{{ $item->MenuId }}" class="toggle-class" type="checkbox"
                                                data-onstyle="success" data-offstyle="danger" data-toggle="toggle"
                                                data-on="YES" data-off="NO"
                                                data-onurl="{{ route('role.update', ['menuId' => $item->MenuId, 'roleId' => $role->RoleId]) }}"
                                                data-offurl="{{ route('role.update', ['menuId' => $item->MenuId, 'roleId' => $role->RoleId]) }}"
                                                {{ $roleMenus->contains('RoleId', $item->RoleId) ? '' : 'checked' }}>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
</section>
<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.1/js/dataTables.bootstrap5.min.js"></script>
<script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>
<script type="text/javascript">

    $(document).ready(function () {
        $('#table').DataTable(
            {
                "iDisplayLength": 100
            }
        );
    });

    $('.toggle-class').change(function () {
    var MenuId = $(this).data('menuid');
    var RoleId =  <?php echo $role->RoleId; ?>;
    var url = $(this).prop('checked') ?
        $(this).data('onurl') :
        $(this).data('offurl');

    var postData = {
        '_token': '{{ csrf_token() }}', // Include Laravel CSRF token for security
        'MenuId': MenuId,
        'RoleId': RoleId,
    };

    $.ajax({
        type: "POST",
        dataType: "json",
        url: url,
        data: postData, // Send the data object
        success: function (data) {
            console.log(data.success);
        }
    });
});
</script>
</html>
@endsection
