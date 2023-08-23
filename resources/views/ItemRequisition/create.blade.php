@extends('Template.template')

@section('title', 'Asset Management System | Category')

@push('css')
<link href="https://cdn.datatables.net/1.13.1/css/dataTables.bootstrap5.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" />
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />
<link href="{{ asset('vendor/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet">
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js" ></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/css/bootstrap.min.css"  />
<link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">
<script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>
@endpush

@section('content')
  <h1>Edit Role: {{ $role->RoleName }}</h1>
  <ul>
    <table class="table table-striped" id="tableid">
      <thead>
        <tr>
          <th>MenuName</th>
          <th>Parent Menu</th>
          <th>Menu Description</th>
          <th>Allow Access</th>
        </tr>
      </thead>
      <tbody>
        @foreach ($menu as $item)
          <tr>
            <td>{{ $item->MenuName }}</td>
            <td>{{$item->ParentId}}</td>
            <td>{{ $item->MenuDesc }}</td>
            <td>
                <input data-id="{{$item->Roleid}}" class="toggle-class" type="checkbox" data-onstyle="success" data-offstyle="danger" data-toggle="toggle" data-on="Yes" data-off="No" {{ $roleMenus->contains('RoleId', $item->RoleId) ? '' : 'checked' }}>
            </td>
          </tr>
        @endforeach
      </tbody>
    </table>
  </ul>
  @endsection
  @section('scripts')
<script src="https://code.jquery.com/jquery-3.1.0.js"></script>
<script src="{{ asset('js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('js/dataTables.bootstrap.min.js') }}"></script>
<script>
  $(function() {
    $('.toggle-class').change(function() {
        var MenuId = $(this).prop('checked') == true ? 1 : 0; 
        var RoleId = $(this).data('RoleId'); 
         
        $.ajax({
            type: "POST",
            dataType: "json",
            url: '/role/update/',
            data: {'_token': CSRF_TOKEN, 'MenuId': MenuId, 'RoleId': RoleId},
            error: function(xhr, ajaxOptions, thrownError) {
                },
            success: function(data){
              console.log(data.success)
            }
        });
    })
  })
</script>

@endsection

