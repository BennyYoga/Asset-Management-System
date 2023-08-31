@extends('Template.template')

@section('title','Assets Monitoring System | Inventory')

{{-- kalau ada css tambahan selain dari template.blade --}}
@push('css')
    <link href="https://cdn.datatables.net/1.13.1/css/dataTables.bootstrap5.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/tagmanager/3.0.2/tagmanager.min.js"></script>
    <style>
        {!! Table::Center("location",[
            "head" => "all",
            "body" => [1,4,5,6]
        ]) !!}
        {!! Table::PaddingRight("location",[1,4,5,6]) !!}
        {!! Table::Gap("location","10px") !!}
    </style>
@endpush

@section('content')
<section class="section">
    <div class="container-fluid">

        @include('Template.title',[
            "title" => "Inventory",
            "breadcrumb" => array_merge(
                request()->loc ? ["Location"=>route("location.index")] : [],
                [ "Inventory"=>"#", "List"=>"#", ]
            ),
            "create" => [
                "url" => "",
                "text" => "Add New Inventory",
                "dropdown" => [
                    "<i class='fas fa-file-download'></i> Download Template" => route("inventory.template") . (Request()->loc ? "?loc=".Request()->loc : ""),
                    "<i class='fas fa-file-arrow-up'></i> Import Inventory" => "",
                ],
            ],
        ])

        <!-- Row -->
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <table class="table" id="location">
                            <thead>
                                <tr class="text-center">
                                    <th>No</th>
                                    <th>Location Name</th>
                                    <th>Item Name</th>
                                    <th>Hour Maintenance</th>
                                    <th>Quantity</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Row -->
    </div>
</section>
@endsection

@section('content')
@endsection

@push('js')
@include('sweetalert::alert')
<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.1/js/dataTables.bootstrap5.min.js"></script>
<script src="{{asset('vendor/sweetalert/sweetalert.all.js')}}"></script>
<script type="text/javascript">
    $(document).ready(function() {
        var table = $('#location').DataTable({
            processing: true,
            serverSide: true,
            ajax: "",
            columns: [
                { data:'id', name:'id', render:(data,type,row,meta)=>meta.row+meta.settings._iDisplayStart+1},
                { data:'Location', name:'Location', },
                { data:'Item', name:'Item', },
                { data:'Maintenance', name:'Maintenance', },
                { data:'Qty', name:'Qty', },
            ],
            order: [ [1,'asc'], ],
        });
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
                title: 'Import Inventory',
                html: `
                    <form action="{{route('inventory.import')}}" method="post" files="true" enctype="multipart/form-data" id="form-import">
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

