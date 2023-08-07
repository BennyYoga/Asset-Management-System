@extends('Template.template')

@section('title', 'Asset Management System | Category')

@push('css')
<link href="https://cdn.datatables.net/1.13.1/css/dataTables.bootstrap5.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" />
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />
<link href="{{ asset('vendor/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/css/bootstrap.min.css" />
<link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">
@endpush


@section('content')
<body>
    <h1>Menu Access</h1>
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
</body>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.11.3/js/dataTables.bootstrap4.min.js"></script>
<script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>
    <script>
    $(document).ready(function () {
        $('#table').DataTable();
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
