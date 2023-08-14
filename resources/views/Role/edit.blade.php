@extends('Template.template')

@section('title', 'Asset Management System | Edit Role')

@push('css')
<link href="https://cdn.datatables.net/1.13.1/css/dataTables.bootstrap5.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" />
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />
<link href="{{ asset('vendor/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet">
@endpush

@section('content')
<h1>Edit Role: {{ $role->RoleName }}</h1>
<ul>
<table>
  <tr>
    <th>Company</th>
    <th>Contact</th>
    <th>Country</th>
  </tr>
  @foreach ($roleMenus as $item)
  <tr>
    <td>{{$item->Name}}</td>
    <td>{{$item->Contact}}</td>
    <td>{{$item->Country}}</td>
  </tr>
  @endforeach
</table>

    <!-- @foreach ($menu as $item)
        <li>
            {{ $item->MenuId }} 
            <button class="toggle-menu" data-rolemenu-id="{{ $item->RoleId }}" data-menu-id="{{ $item->MenuId }}">
                {{ $roleMenus->contains('RoleId', $item->RoleId) ? 'OFF' : 'ON' }}
            </button>
        </li>
    @endforeach
</ul>
@endsection -->

@section('scripts')
    <script>
        $(document).ready(function() {
            $('.toggle-menu').click(function() {
                var rolemenus = $(this).data('rolemenu-id');
                var menuId = $(this).data('menu-id');

                $.ajax({
                    url: '/roles/{{ $role->RoleId }}/toggle-menu',
                    type: 'POST',
                    data: {
                        MenuId: menuId,
                        RoleId: rolemenus,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        rolemenus = response.roleMenus;
                        if (in_array(menuId, rolemenus)) {
                            $(this).text('OFF');
                        } else {
                            $(this).text('ON');
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error(error);
                    }
                });
            });
        });
    </script>
@endsection
