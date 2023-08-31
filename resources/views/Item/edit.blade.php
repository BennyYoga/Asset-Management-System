@extends('Template.template')

@section('title','Assets Management System | Edit Item')

{{-- kalau ada css tambahan selain dari template.blade --}}
@push('css')
    <link href="https://cdn.datatables.net/1.13.1/css/dataTables.bootstrap5.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.3/dropzone.min.css" type="text/css" />
    <style>
        .input-tags {
            width: 100%;
            border-radius: 4px;
            padding: 0px;
            color: #5d657b;
            resize: none;
            transition: all 0.3s;
        }
        .input-tags .selection {
            width: 100%;
            background: rgba(239, 239, 239, 0.5);
        }
        .input-tags input {
            display: none;
        }
        .input-tags .selection > span {
            border: 1px solid #e5e5e5;
            padding: 16px !important;
            background: transparent;
        }
    </style>
@endpush

@section('content')
    <section class="tab-components">
        <div class="container-fluid">
            @include('Template.title',[
                "title" => "Edit Item",
                "breadcrumb" => [
                    "Master Data" => "#",
                    "Item" => route('item.index'),
                    "Edit" => "#",
                ],
            ])
            <form action="{{ route('item.update', $item->ItemId) }}" id="ItemForm" method="post">
                @csrf
            </form>
            <div class="form-elements-wrapper">
                <div class="row">
                    <div class="col-lg-12">
                        <!-- input style start -->
                        <div class="card-style mb-30">
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="input-style-1">
                                        <label>Item Code</label>
                                        <input type="text" placeholder="Item Code" name="Code" value="{{$item->Code}}" form="ItemForm" required />
                                        @error('Code') <span class="text-danger">{{$message}}</span> @enderror
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="input-style-1">
                                        <label>Item Name</label>
                                        <input type="text" placeholder="Item Name" name="Name" value="{{$item->Name}}" form="ItemForm" required />
                                        @error('Name') <span class="text-danger">{{$message}}</span> @enderror
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="input-style-1">
                                        <label>Unit</label>
                                        <input type="number" placeholder="Unit" name="Unit" value="{{$item->Unit}}" form="ItemForm" />
                                        @error('Unit') <span class="text-danger">{{$message}}</span> @enderror
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="select-sm select-style-1">
                                        <label>Item Type</label>
                                        <div class="select-position">
                                            <select class="light-bg" name="UseType" form="itemForm" required>
                                                <option disabled>Choose Item Type</option>
                                                <option @if($item->UseType=="single") selected @endif value="single">Single</option>
                                                <option @if($item->UseType=="group") selected @endif value="group">Group</option>
                                            </select>
                                            @error('UseType') <span class="text-danger">{{$message}}</span> @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="select-sm select-style-1">
                                        <label>Item Behavior</label>
                                        <div class="select-position">
                                            <select class="light-bg" id="Filter-Item" name="ItemBehavior" form="ItemForm">
                                                <option value="1" @if($item->ItemBehavior==1) selected @endif >Hour Usage Monitor</option>
                                                <option value="2" @if($item->ItemBehavior==2) selected @endif >Costumable</option>
                                                {{-- <option value="3" @if($item->ItemBehavior==3) selected @endif >Non Costumable</option> --}}
                                            </select>
                                            @error('ItemBehavior') <span class="text-danger">{{$message}}</span> @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="input-style-1 d-none" id="Alert-Hour">
                                        <label>Alert Hour Maintenance</label>
                                        <input type="number" id="alert-input" placeholder="Hour Usage Monitor (in Hour)" name="AlertHourMaintenance" value="{{$item->AlertHourMaintenance}}" form="ItemForm" />
                                    </div>
                                    <div class="input-style-1 d-none" id="Alert-Consumable">
                                        <label>Consumable</label>
                                        <input type="number" id="alert-input" placeholder="Consumable (in Unit)" name="AlertConsumable" value="{{$item->AlertConsumable}}" form="ItemForm" />
                                    </div>
                                </div>

                                <div class="col-lg-12">
                                    <div class="select-sm select-style-1">
                                        <label>Category Item</label>
                                        <div class="select-position input-tags">
                                            <select class="js-example-basic-single form-" id="tags" multiple name="Category[]" form="ItemForm">
                                                @for($i =0; $i < count($unselectedCategory); $i++)
                                                    <option value="{{$unselectedCategory[$i]['CategoryId']}}">{{$unselectedCategory[$i]['Name']}}</option>
                                                @endfor
                                                @for($i =0; $i < count($selectedCategory); $i++)
                                                    <option selected="selected" value="{{$selectedCategory[$i]['CategoryId']}}">{{$selectedCategory[$i]['Name']}}</option>
                                                @endfor
                                            </select>
                                            @error('Category') <span class="text-danger">{{$message}}</span> @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-12">
                                    <div>
                                        <label>Your File</label>
                                        @foreach ($uploads as $key => $val)
                                        <div class="card mb-3">
                                            <div class="card-body">
                                                <div class="row align-items-center">
                                                    <div class="col-lg-1">
                                                        <i class="lni lni-empty-file fs-2 text-body-secondary"></i>
                                                    </div>
                                                    <div class="col-lg-9">
                                                        <a href="{{ asset($val->FilePath) }}" target="_blank">
                                                            <p class="fs-6 text-body-secondary">{{basename($val->FilePath)}}</p>
                                                        </a>
                                                    </div>
                                                    <div class="col-lg-2">
                                                        <a href="#" class="deleteFile" data-item-id="{{$val->ItemUploadId}}">
                                                            <i class="lni lni-trash-can fs-3 m-auto text-danger"></i>
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        @endforeach
                                    </div>
                                    <div class="input-style-1">
                                        <label>Upload Your File</label>
                                        <form action="{{route('dropzone.store')}}" method="post" name="file" files="true" enctype="multipart/form-data" class="dropzone" id="image-upload">
                                            @csrf
                                        </form>
                                    </div>
                                </div>

                            </div>
                            <!-- End Row -->
                            <div class="row">
                                <div class="col-lg-12 text-end">
                                    <a href="{{route('item.index')}}" class="btn btn-secondary">Back</a>
                                    <button type="submit" class="btn btn-primary" form="ItemForm">Submit</button>
                                </div>
                            </div>
                        </div>
                        <!-- end card -->
                    </div>
                    <!-- end col -->
                </div>
                <!-- end row -->
            </div>
        </div>
    </section>
@endsection

@push('js')
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/4.2.0/min/dropzone.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.1/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.min.js"></script>
    <script type="text/javascript">
        $(document).ready(function() {

            $('.js-example-basic-single').select2({
                theme: "classic",
            }, 'val', ['1', '2']);

            let Hourly = $('#Alert-Hour');
            let Consumable = $('#Alert-Consumable');
            let placeholder = $('#alert-input');

            $("#Filter-Item").on('change', function() {
                var Pilihan = $(this).val();
                placeholder.val("")

                if (Pilihan == 1) {
                    Consumable.addClass('d-none');
                    Hourly.removeClass('d-none');
                    $("[name=AlertHourMaintenance]").val({{$item->ItemBehavior}}==1 ? {{$item->AlertHourMaintenance ?? 0}} : 0)
                } else if (Pilihan == 2) {
                    Hourly.addClass('d-none');
                    Consumable.removeClass('d-none');
                    $("[name=AlertConsumable]").val({{$item->ItemBehavior}}==2 ? {{$item->AlertConsumable ?? 0}} : 0)
                } else if (Pilihan == 3) {
                    Consumable.addClass('d-none');
                    Hourly.addClass('d-none');
                }
            });

            // Set tampilan awal berdasarkan nilai default pada dropdown "Item Behavior"
            let defaultBehavior = $("#Filter-Item").val();
            if (defaultBehavior == 1) {
                Consumable.addClass('d-none');
                Hourly.removeClass('d-none');
            } else if (defaultBehavior == 2) {
                Hourly.addClass('d-none');
                Consumable.removeClass('d-none');
            } else if (defaultBehavior == 3) {
                Consumable.addClass('d-none');
                Hourly.addClass('d-none');
            }

            $('#tags').on("select2:open",()=>{
                $(".input-tags .selection").css("background","rgba(0,0,0,0)")
            }).on("select2:close",()=>{
                $(".input-tags .selection").css("background","rgba(239, 239, 239, 0.5)")
            })

            Dropzone.options.imageUpload = {
                maxFilesize: 100,
                renameFile: function(file) {
                    var dt = new Date();
                    var time = dt.getTime();
                    return time + file.name;
                },
                acceptedFiles: ".jpeg,.jpg,.png,.gif,.pdf,.zip",
                addRemoveLinks: true,
                timeout: 50000,
                removedfile: function(file) {
                    var name = file.name;
                    console.log(file.name);
                    $.ajaxSetup({
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            }
                        }),
                        $.ajax({
                            type: 'POST',
                            url: '{{url("dropzone/delete")}}',
                            data: {
                                filename: name
                            },
                            success: function(data) {
                                console.log("File has been successfully removed!!");
                            },
                            error: function(xhr, ajaxOptions, thrownError) {
                                console.log(xhr.responseText);
                            },
                        });
                    var fileRef;
                    return (fileRef = file.previewElement) != null ?
                        fileRef.parentNode.removeChild(file.previewElement) : void 0;
                },
            };

            $(".deleteFile").click(function(e) {
                e.preventDefault();
                var id = $(this).data("item-id");
                var card = $(e.target).closest('.card');
                $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    }),
                    $.ajax({
                        url: `/item/file/delete/${id}`,
                        type: 'DELETE',
                        success: function(response) {
                            var card = $(e.target).closest('.card');
                            card.remove();
                            alert(response.message);
                        },
                        error: function(xhr, status, error) {
                            var errorMessage = xhr.responseJSON.message || 'An error occurred while deleting the item.';
                            alert(errorMessage);
                        }
                    })
            });
        });
    </script>
@endpush
