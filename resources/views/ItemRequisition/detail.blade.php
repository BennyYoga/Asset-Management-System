@extends('Template.template')

@section('title','Asset Monitoring System | Edit Item Requisition')

{{-- kalau ada css tambahan selain dari template.blade --}}
@push('css')
<link href="https://cdn.datatables.net/1.13.1/css/dataTables.bootstrap5.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" />
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.4.0/min/dropzone.min.css">
<meta name="csrf-token" content="{{ csrf_token() }}" />
@endpush

@section('content')
<section class="tab-components">
    <div class="container-fluid">
        <!-- ========== title-wrapper start ========== -->
        <div class="title-wrapper pt-30">
            <div class="row align-items-center">
                <div class="col-md-6">
                    {{-- @if (session('success'))
                    <div class="alert alert-success" role="alert">
                        {{ session('success') }}
                </div>
                @endif --}}
                <div class="title mb-30">
                    <h2>Detail Requisition</h2>
                </div>
            </div>
            <!-- end col -->
            <div class="col-md-6">
                <div class="breadcrumb-wrapper mb-30">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="item.index">Requisition</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">
                                Detail
                            </li>
                        </ol>
                    </nav>
                </div>
            </div>
            <!-- end col -->
        </div>
        <!-- end row -->
    </div>
    <div class="form-elements-wrapper">
        <div class="row">
            <div class="col-sm-12">
                <!-- input style start -->
                <div class="card-style mb-30">

                    <!-- Header Main Requisition -->
                    <div class="invoice-header mb-4">
                        <h3>Main Data Requisition</h3>
                        <hr class="border-2">
                    </div>

                    <table class="w-100 table">
                        <tr>
                            <td>
                                <p>Untuk Lokasi</p>
                            </td>
                            <td>
                                <p>: {{$data['itemreq']->Location->Name}}</p>
                            </td>
                            <td>
                                <p>Tanggal Request</p>
                            </td>
                            <td>
                                <p>: {{ date('d F Y', strtotime($data['itemreq']->Tanggal)) }}</p>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <p>Dibuat Oleh</p>
                            </td>
                            <td>
                                <p>: {{$data['itemreq']->CreatedBy}}</p>
                            </td>
                            <td>
                                <p>Tanggal Dibuat</p>
                            </td>
                            <td>
                                <p>: {{ date('d F Y', strtotime($data['itemreq']->CreatedDate)) }}</p>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <p>Notes</p>
                            </td>
                            <td rowspan="3">
                                <p>: {{$data['itemreq']->Notes}}</p>
                            </td>
                        </tr>
                    </table>
                    <p class="mb-3">File Upload :</p>
                    <div class="row row-cols-3">
                        @foreach ($data['uploaditem'] as $key => $item)
                        <div class="col">
                            <div class="card mb-3">
                                <div class="card-body">
                                    <div class="row align-items-center">
                                        <div class="col-lg-2">
                                            <i class="lni lni-empty-file fs-2 text-body-secondary"></i>
                                        </div>
                                        <div class="col-lg-10">
                                            <a href="{{ asset($item->FilePath) }}" target="_blank">
                                                <p class="fs-6 text-body-secondary">{{basename($item->FilePath)}}</p>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>

                    <br>
                    <!-- End Main Requisition -->


                    <!-- Header Item Requisition -->
                    <div class="invoice-header mb-4">
                        <h3>Item Of Requisition</h3>
                        <hr class="border-2">
                    </div>
                    <div class="container mb-5">
                        <table class="table">
                            <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Item</th>
                                <th>Jenis Item</th>
                                <th>Quantity</th>
                            </tr>
                        </thead>
                        @foreach($data['detailreq'] as $key => $item)
                        <tbody>
                            <tr>
                                <td>{{$key+1}}</td>
                                <td>{{$item['NameItem']}}</td>
                                @if($item['TypeItem'] == 1)
                                <td>House Usage Monitor</td>
                                @elseif($item['TypeItem'] == 2)
                                <td>Consumable</td>
                                @elseif($item['TypeItem'] == 3)
                                <td>Non Consumable</td>
                                @endif
                                <td>{{$item['ItemQty']}}</td>
                            </tr>
                        </tbody>
                        @endforeach
                    </table>
                    </div>
                    <!-- End Main Requisition -->


                    <!-- Header Approval Requisition -->
                    <div class="invoice-header mb-4">
                        <h3>Approval</h3>
                        <hr class="border-2">
                    </div>
                    
                    <form action="{{ route('itemreq.approve.store') }}" id="approveRequisition"  method="post">
                        @csrf
                    </form>
                    @php $order = 0; @endphp
                    @foreach($approverChecked as $key => $app)
                        @if($order != $app->Order)
                            <h5 class="mb-2">Order Ke-{{$order+1}}</h5>
                        @endif
                        @php $order = $app->Order; @endphp
                        
                        <!-- Pengecekan Untuk Rejcet/Approve Requisition -->
                        @if(session('user')->UserId == $app->UserId)
                            <!-- Pengecekan ketika Approver Telah mengsubmit -->
                            @if(!$app->IsDeliced && !$app->IsApproved && !$app->Notes)
                            <div class="card mb-3">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-lg-1">
                                            <i class="lni lni-user fs-4"></i>
                                        </div>
                                        <div class="col-lg-7 mb-2">

                                            <input type="hidden" name="ItemRequisitionApproverId" form="approveRequisition" value="{{$app->ItemRequisitionApproverId}}">

                                            <p><b>{{$app->User->Fullname}} - {{$app->User->fk_role->RoleName}}</b></p>
                                        </div>
                                        <div class="form-check col-lg-2">
                                            <input class="form-check-input" type="radio" name="Approve" id="flexRadioDefault1" form="approveRequisition">
                                            <label class="form-check-label" for="flexRadioDefault1">
                                                Approve Requisition
                                            </label>
                                        </div>
                                        <div class="form-check col-lg-2">
                                            <input class="form-check-input" type="radio" name="Reject" id="flexRadioDefault2" form="approveRequisition">
                                            <label class="form-check-label" for="flexRadioDefault2">
                                                Reject Requisition
                                            </label>
                                        </div>
                                    </div>
                                                    
                                    <div class="input-style-3">
                                        <textarea placeholder="Notes" rows="5" form="approveRequisition" name="Notes"></textarea>
                                        <span class="icon"><i class="lni lni-text-format"></i></span>
                                    </div>
                                    @error('Notes') <span class="text-danger">{{$message}}</span> @enderror
                                </div>
                            </div>
                            @else
                            <div class="card mb-3">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-lg-1">
                                            <i class="lni lni-user fs-4"></i>
                                        </div>
                                        <div class="col-lg-9">
                                            <p><b>{{$app->User->Fullname}} - {{$app->User->fk_role->RoleName}}</b></p>
                                        </div>
                                        <div class="col-lg-2 text-end">
                                            @if($app->IsApproved)
                                            <button class="btn btn-primary" disabled>Approved</button>
                                            @elseif($app->IsDeliced)
                                            <button class="btn btn-danger" disabled>Rejected</button>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-1">
                                            <p><b>Notes :</b></p>
                                        </div>
                                        <div class="col-lg-11">
                                            <p>{{$app->Notes}}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endif
                        @else
                            <!-- Pengecekan User Lain Sudah mengaaprove atau belum -->
                            @if(!$app->IsDeliced && !$app->IsApproved && !$app->Notes)
                            <div class="card mb-3">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-lg-1">
                                            <i class="lni lni-user fs-4"></i>
                                        </div>
                                        <div class="col-lg-9">
                                            <p>{{$app->User->Fullname}} - {{$app->User->fk_role->RoleName}}</p>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-1">
                                            <p><b>Notes :</b></p>
                                        </div>
                                        <div class="col-lg-11">
                                            <p>{{$app->Notes}}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @else
                            <div class="card mb-3">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-lg-1">
                                            <i class="lni lni-user fs-4"></i>
                                        </div>
                                        <div class="col-lg-9">
                                            <p>{{$app->User->Fullname}} - {{$app->User->fk_role->RoleName}}</p>
                                        </div>
                                        <div class="col-lg-2 text-end">
                                            @if($app->IsApproved)
                                            <button class="btn btn-primary" disabled>Approved</button>
                                            @elseif($app->IsDeliced)
                                            <button class="btn btn-danger" disabled>Rejected</button>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-1">
                                            <p><b>Notes :</b></p>
                                        </div>
                                        <div class="col-lg-11">
                                            <p>{{$app->Notes}}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endif
                        @endif
                    @endforeach
                    <!-- End Approval Requisition -->

                    <div class="row">
                        <div class="col-lg-12 text-end">
                            <a href="{{route('itemreq.index')}}" class="btn btn-outline-danger">Back</a>
                            <button type="submit" class="btn btn-primary" form="approveRequisition">Submit</button>
                        </div>
                    </div>
                </div>
                <!-- end card -->
            </div>
        </div>
        <!-- end col -->
    </div>
    <!-- end row -->
    </div>
    <!-- end wrapper -->
</section>

@endsection

@push('js')
@include('sweetalert::alert')

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/4.2.0/min/dropzone.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/tagmanager/3.0.2/tagmanager.min.js"></script>
<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.1/js/dataTables.bootstrap5.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.min.js"></script>
<script type="text/javascript"></script>
@endpush