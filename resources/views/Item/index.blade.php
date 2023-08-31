@extends('Template.template')

@section('title','Assets Management System | List Item')

@push('css')
    <link href="https://cdn.datatables.net/1.13.1/css/dataTables.bootstrap5.min.css" rel="stylesheet">
    <style>
        {!! Table::Center("item",[
            "head" => "all",
            "body" => [1,4,5,6,7]
        ]) !!}
        {!! Table::PaddingRight("item",[1,4,5,6,7]) !!}
        {!! Table::Gap("item","10px") !!}
    </style>
@endpush

@section('content')
    <section class="section">
        <div class="container-fluid">
            @include('Template.title',[
                "title" => "List Item",
                "breadcrumb" => [
                    "Master Data" => "#",
                    "Item" => "#",
                    "List" => "#",
                ],
                "create" => [
                    "url" => route('item.create'),
                    "text" => "Add New Item",
                    "dropdown" => [
                        "<i class='fas fa-file-download'></i> Download Template" => route("item.template"),
                        "<i class='fas fa-file-arrow-up'></i> Import Items" => "",
                    ],
                ],
            ])
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <table class="table" id="item">
                                <thead>
                                    <tr class="text-center">
                                        <th>No</th>
                                        <th>Code</th>
                                        <th>Name</th>
                                        <th>Unit</th>
                                        <th>Behavior</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('js')
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.1/js/dataTables.bootstrap5.min.js"></script>
    <script src="{{asset('vendor/sweetalert/sweetalert.all.js')}}"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            $('#item').DataTable({
                processing: true,
                serverSide: true,
                ajax: "",
                columns: [
                    {
                        data: 'id',
                        name: 'id',
                        render: (data, type, row, meta) => meta.row + meta.settings._iDisplayStart + 1,
                    },
                    { data: 'Code', name: 'Code', },
                    { data: 'Name', name: 'Name', },
                    { data: 'Unit', name: 'Unit', },
                    { data: 'ItemBehavior', name: 'ItemBehavior', },
                    { data: 'Status', name: 'Status', },
                    { data: 'Action', name: 'Action', }
                ],
                order: [ [1,'asc',], ],
            })
            $(document).on("click","#item button[title=Activate]",(e)=>{
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
            }).on("click","#item button[title=Deactivate]",(e)=>{
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
            }).on("click","#item button[title=Delete]",(e)=>{
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
            $(".title-wrapper .fa-file-arrow-up").parent().on("click",(e)=>{
                e.preventDefault()
                const s = Swal.mixin({
                    buttonsStyling: false,
                    customClass: {
                        confirmButton: 'btn btn-primary btn-md me-1',
                        cancelButton: 'btn btn-danger btn-md'
                    },
                })
                s.fire({
                    title: 'Import Items',
                    html: `
                        <form action="{{route('item.import')}}" method="post" files="true" enctype="multipart/form-data" id="form-import">
                            @csrf
                            <input type="file" class="form-control" name="file" id="file-import">
                        </form>
                        <p class="text-sm"><b class="text-danger">*</b> please upload a file that has a format like the template we provide.</p>`,
                    confirmButtonText: 'Submit',
                    focusConfirm: false,
                    showCloseButton: true,
                    showCancelButton: true,
                    preConfirm: () => {
                        const file = $('#file-import')[0].files
                        if(file.length<1) return Swal.showValidationMessage("File is required")
                        return true
                    }
                }).then((result) => {
                    if (!result.isConfirmed) return
                    $("#form-import").submit()
                })
            })
        });
    </script>
@endpush
