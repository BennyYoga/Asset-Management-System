@extends('Template.template')

@section('title','Assets Management System | List Item')

@push('css')
    <link href="https://cdn.datatables.net/1.13.1/css/dataTables.bootstrap5.min.css" rel="stylesheet">
    <style>
        {!! Table::Center("item",[
            "head" => "all",
            "body" => [1,3,5,6,7]
        ]) !!}
        {!! Table::PaddingRight("item",[1,3,5,6]) !!}
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
                                        <th>Name</th>
                                        <th>Unit</th>
                                        <th>Item Behavior</th>
                                        <th>Alert</th>
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
                    { data: 'Name', name: 'Name', },
                    { data: 'Unit', name: 'Unit', },
                    { data: 'ItemBehavior', name: 'ItemBehavior', },
                    { data: 'Alert', name: 'Alert', },
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
        });
    </script>
@endpush
