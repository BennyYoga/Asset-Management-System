@extends('Template.template')

@section('title','Trash Monitoring System | Dashboard')

{{-- kalau ada css tambahan selain dari template.blade --}}
@push('css')
<link href="https://cdn.datatables.net/1.13.1/css/dataTables.bootstrap5.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" />
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />
@endpush

@section('content')
<section class="section">
  <div class="container-fluid">
    <!--========== title-wrapper start ==========-->
    <div class="title-wrapper pt-30">
      <div class="row align-items-center">
        <div class="col-md-6">
          {{-- @if (session('success'))
            <div class="alert alert-success" role="alert">
          {{ session('success') }}
        </div>
        @endif --}}
        <div class="titlemb-30">
          <h2>Input Data Category</h2>
        </div>
      </div>
      <!-- end col -->
      <div class="col-md-6">
        <div class="breadcrumb-wrapper mb-30">
          <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
              <li class="breadcrumb-item active" aria-current="Add">
                Add
              </li>
            </ol>
          </nav>
        </div>
      </div>
      <!-- end col -->

      <form action="{{route('category.store')}}" method="POST">
        @csrf
        <div class="card-style mb-30">
          <div class="row">
            <div class="col-sm-6">
              <div class="input-style-1">
                <label>Name</label>
                <input type="text" placeholder="Name" id="Name" name="Name" required autofocus />
              </div>
            </div>
            <div class="col-sm-6">
              <div class="select-style-1">
                <label>Status</label>
                <div class="select-position">
                  <select name="Active" id="Active" style="width: 100%">
                  <option value="1" selected>Active</option>
                  <option value="0" selected>Non-Active</option>
                  </select>
                </div>
              </div>
          </div>
          <div class="col-sm-6">
              <div class="select-style-1">
                <label>Select Parent</label>
                <div class="select-position">
                  <select name="ParentId" id="ParentId" style="width:100%">
                  <option value="" selected disabled> Select Category Parent</option>
                  <option value="">Root</option>  
                    @foreach($category as $category)
                    <option value="<?= $category->CategoryId?>">
                      <?= $category->Name?>
                    </option>
                    @endforeach
                  </select>
                  <div class="card-footer">
                            <br>
                            <button type="submit" class="btn btn-success">Simpan</button>
                            <a href="{{route('category.index')}}" class="btn btn-light">
                                Batal
                            </a>
                        </div>
        </div>
    </div>
    <!-- end row -->
  </div>
</section>
@endsection

@push('js')
<script src="https://cdn.jsdelivr.net/npm/jquery/dist/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.min.js"></script>
<script type="text/javascript">
  $(document).ready(function() {
    $('.select2').select2();
  });
</script>
@endpush