@extends('Template.template')

@section('title','Assets Management System | Locations')

{{-- kalau ada css tambahan selain dari template.blade --}}
@push('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.1/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />
    <style>
        {!! Table::Center("location",[
            "head" => "all",
            "body" => [1,3,4]
        ]) !!}
        {!! Table::PaddingRight("location",[1,3]) !!}
        {!! Table::Gap("location","10px") !!}
    </style>
@endpush

@section('content')
<section class="section">
    <div class="container-fluid">

        @include('Template.title',[
            "title" => "List Location",
            "breadcrumb" => [
                "Master Data" => "#",
                "Location" => "#",
                "List" => "#",
            ],
            "create" => [
                "url" => route('location.create'),
                "text" => "Add New Location",
            ],
        ])

        <div class="row">
            <div class="col-lg-12">
                <div class="card-style mb-30">
                    <div class="table-wrapper">
                        <div class="title d-flex flex-wrap align-items-center justify-content-between">
                            {{-- <div class="left">
                                <a href="{{ route('pegawai.document') }}" class="btn btn-danger mb-5">Download PDF</a>
                            </div> --}}
                            {{-- <div class="right">
                                <div class="row">
                                    <div class="col-sm-6 contain">
                                        <div class="select-style-1">
                                            <div class="select-position select-sm">
                                                <select class="light-bg" id="filter-kota" name="option">
                                                    <option value="default">Semua Kota</option>
                                                    @foreach($kab_kota as $option)
                                                    <option value="{{$option->id_kab_kota}}">{{$option->nama_kab_kota}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- end select -->
                            </div> --}}
                        </div>
                        <table class="table" id="location">
                            <thead>
                                <tr class="text-left">
                                    <th>No</th>
                                    <th>Location Name</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            {{-- <tbody>
                                @foreach($location as $key => $location)
                                <tr>
                                    <td>{{$key+1}}</td>
                                    <td>{{$location->Name}}</td>
                                    <td class="{{ $location->Active ? 'text-success' : 'text-danger' }}">{{$location->Active ? 'Aktif' : 'Nonaktif'}}</td>
                                    <td>
                                        <a href="{{ route('location.edit', $location->LocationId) }}" style="font-size:20px" class="text-warning mr-10"><i class="lni lni-pencil-alt"></i></a>
                                        <a href="{{ route('location.destroy', $location->LocationId) }}" style="font-size:20px" class="text-danger mr-10"><i class="lni lni-trash-can"></i></a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody> --}}
                        </table>
                    </div>
                </div>
                <!-- end col -->
            </div>
            <!-- end row -->
        </div>
    </div>
</section>
@endsection

@push('js')
@include('sweetalert::alert')
<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.1/js/dataTables.bootstrap5.min.js"></script>
<script src="{{asset('vendor/sweetalert/sweetalert.all.js')}}"></script>
<form action="" id="delete-form" method="post">
    @method('get')
    @csrf
</form>
<script>
    $(document).ready(function () {
        // Menggunakan event click untuk button dengan id hapusBtn
        $('#location').on('click', '#hapusBtn', function (e) {
            e.preventDefault();

            // Simpan URL hapus pada atribut data-hapus pada tombol hapus
            var deleteUrl = $(this).attr('href');
            $('#hapusBtn').attr('data-hapus', deleteUrl);

            // Menampilkan modal
            $('#staticBackdrop').modal('show');
        });

        // Menggunakan event click untuk button hapus pada modal
        $('#hapusBtnModal').on('click', function () {
            // Mengambil URL hapus dari atribut data-hapus pada tombol hapus
            var deleteUrl = $('#hapusBtn').attr('data-hapus');

            // Mengubah action pada form hapus sesuai dengan URL hapus
            $('#delete-form').attr('action', deleteUrl);

            // Submit form hapus
            $("#delete-form").submit();
        });
    });
</script>
<script type="text/javascript">
    $(document).ready(function () {
    var table = $('#location').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('location.index') }}",
        columns: [
            {
            data: null,
            render: function (data, type, row, meta) {
                // Menghitung nomor urut berdasarkan halaman dan jumlah baris yang ditampilkan
                var startIndex = meta.settings._iDisplayStart;
                var index = meta.row + startIndex + 1;

                return index;
            },
            orderable: false,
            searchable: false
            },
            {data: 'Name', name: 'Name'},
            {data: 'Status', name: 'Status'},
            {data: 'Action', name: 'Action', orderable: false, searchable: false},
        ]
    });

    $(document).on("click","#location button[title=Activate]",(e)=>{
        const btn = $(e.currentTarget)
        const name = btn.parents("tr").find("td:nth-child(2)").html()
        Swal.fire({
            title: `Activate <b>${name}</b> ?`,
            icon: 'question',
            showCloseButton: true,
            showCancelButton: true,
            focusConfirm: false,
            focusCancel: true,
        }).then((result) => {
            if (!result.isConfirmed) return
            window.location.href = btn.attr("href")
        })
    }).on("click","#location button[title=Deactivate]",(e)=>{
        const btn = $(e.currentTarget)
        const name = btn.parents("tr").find("td:nth-child(2)").html()
        Swal.fire({
            title: `Deactivate <b>${name}</b> ?`,
            icon: 'question',
            showCloseButton: true,
            showCancelButton: true,
            focusConfirm: false,
            focusCancel: true,
        }).then((result) => {
            if (!result.isConfirmed) return
            window.location.href = btn.attr("href")
        })
    }).on("click","#location button[title=Delete]",(e)=>{
        const btn = $(e.currentTarget)
        const name = btn.parents("tr").find("td:nth-child(2)").html()
        Swal.fire({
            title: `Delete <b>${name}</b> ?`,
            icon: 'question',
            showCloseButton: true,
            showCancelButton: true,
            focusConfirm: false,
            focusCancel: true,
        }).then((result) => {
            if (!result.isConfirmed) return
            window.location.href = btn.attr("href")
        })
    })
  });
</script>
@endpush
