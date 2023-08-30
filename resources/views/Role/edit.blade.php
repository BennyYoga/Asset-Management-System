@extends('Template.template')

@section('title', 'Asset Management System | Role Access Edit')

@push('css')
<link href="https://cdn.datatables.net/1.13.1/css/dataTables.bootstrap5.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" />
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />\
<link href="{{ asset('vendor/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet">
@endpush

@section('content')
<section class="section">
    <div class="container-fluid">
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
                                    <a href="{{route('role.index')}}">Role</a>
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
                            <table class="table" id="table">
                            <div class="sub-title mb-30">
                                <h3>{{$role->RoleName}}</h3>
                            </div>
                                <thead>
                                    <tr>
                                        <th data-sort="menu-id" hidden>Menu ID</th>
                                        <th>Menu Name</th>
                                        <th>Parent Menu</th>
                                        <th>Description</th>
                                        <th class="text-center">Allow Access</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($menu as $item)
                                    <tr>
                                        <td data-sort-value="{{ $item->MenuId }}" hidden>{{ $item->MenuId }}</td>
                                        <td>{{ $item->MenuName }}</td>
                                        <td>
                                            @if ($parentMenus->has($item->ParentId))
                                                {{ $parentMenus[$item->ParentId]->MenuName }}
                                            @endif
                                        </td>
                                        <td>{{ $item->MenuDesc }}</td>
                                        <td>
                                            <div class="form-check form-switch d-flex justify-content-center align-items-center">
                                                <input
                                                    data-menuid="{{ $item->MenuId }}"
                                                    class="toggle-class form-check-input "
                                                    type="checkbox"
                                                    data-onurl="{{ route('role.update', ['menuId' => $item->MenuId, 'roleId' => $role->RoleId]) }}"
                                                    data-offurl="{{ route('role.update', ['menuId' => $item->MenuId, 'roleId' => $role->RoleId]) }}"
                                                    {{ $roleMenus->contains('RoleId', $item->RoleId) ? '' : 'checked' }}
                                                />
                                                <label class="form-check-label" for="{{ 'toggle-'.$item->MenuId }}"></label>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>

                        <div class="row">
                            <div class="col-lg-12">
                            <a href="{{route('role.index')}}" class="btn btn-outline-danger">Back</a>
                        </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>
@endsection

@push('js')
@include('sweetalert::alert')
<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<link href="path/to/toggle-switch.css" rel="stylesheet">
<script src="path/to/toggle-switch.js"></script>
<script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.1/js/dataTables.bootstrap5.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/plainadmin@5.0.0/dist/js/plain.min.js"></script>
<script type="text/javascript">
    $(document).ready(function () {
        $('#table').DataTable({
            "pageLength": 100,
            "order": [[0, "asc"]],
            "columnDefs": [
                { "targets": 'no-sort', "orderable": false },
                { "targets": 'data-sort', "orderable": true }
            ]
        });
        Plain.toggle.init('.toggle-class');
    });

    $('.toggle-class').change(function () {
        var MenuId = $(this).data('menuid');
        var RoleId = <?php echo $role->RoleId; ?>;
        var url = $(this).prop('checked') ? $(this).data('onurl') : $(this).data('offurl');

        var postData = {
            '_token': '{{ csrf_token() }}',
            'MenuId': MenuId,
            'RoleId': RoleId,
        };

        $.ajax({
            type: "POST",
            dataType: "json",
            url: url,
            data: postData,
            success: function (data) {
                console.log(data.success);
            }
        });
    });
</script>
@endpush
