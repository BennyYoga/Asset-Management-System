<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\ItemProcurement;
use App\Models\Location;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class ItemProcurementController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $itemproc = ItemProcurement::where("IsPermanentDelete", 0)
            ->orderBy('No', 'desc')
            ->get();
            return DataTables::of($itemproc)
                ->addIndexColumn()
                ->addColumn('JumlahBarang', function ($row) {
                    $data = count(DB::table('ItemProcurementDetail')->where('ItemProcurementId', $row->ItemProcurementId)->get());
                    return ($data . ' Item');
                })
                ->addColumn('Lokasi', function ($row) {
                    $location = Location::where('LocationId', $row->LocationId)->first();
                    return $location->Name;
                })
                ->addColumn('Status', function ($row) {
                    if ($row->Status === null) {
                        $data = 'Pending';
                        $btn = '<span class="status-btn warning-btn" disabled
                            style="--bs-btn-padding-y: .25rem; --bs-btn-padding-x: .5rem; --bs-btn-font-size: .75rem;">
                            ' . $data . ' 
                            </span>';
                    } else if ($row->Status == 0) {
                        $data = 'Rejected';
                        $btn = '<span class="status-btn close-btn" disabled
                            style="--bs-btn-padding-y: .25rem; --bs-btn-padding-x: .5rem; --bs-btn-font-size: .75rem;">
                            ' . $data . ' 
                            </span>';
                    } else {
                        $data = 'Approved';
                        $btn = '<span class="status-btn active-btn" disabled
                            style="--bs-btn-padding-y: .25rem; --bs-btn-padding-x: .5rem; --bs-btn-font-size: .75rem;">
                            ' . $data . ' 
                            </span>';
                    }
                    return $btn;
                })
                ->addColumn('Active', function ($row) {
                    if ($row->Active == 0) {
                        $data = 'Nonactive';
                        $btn = '<span class="status-btn close-btn" disabled
                        style="--bs-btn-padding-y: .25rem; --bs-btn-padding-x: .5rem; --bs-btn-font-size: .75rem;">
                        ' . $data . ' 
                        </span>';
                        return $btn;
                    } else if ($row->Active == 1) {
                        $data = 'Active';
                        $btn = '<span class="status-btn active-btn" disabled
                        style="--bs-btn-padding-y: .25rem; --bs-btn-padding-x: .5rem; --bs-btn-font-size: .75rem;">
                        ' . $data . ' 
                        </span>';
                        return $btn;
                    }
                })
                ->addColumn('Action', function ($row) {
                    if ($row->Active == 1) {
                        $btn = '<a href=' . route('itemproc.activate', $row->ItemProcurementId) . ' style="font-size:20px" class="text-danger mr-10"><i class="lni lni-power-switch"></i></a>';
                    } else if ($row->Active == 0) {
                        $btn = '<a href=' . route('itemproc.activate', $row->ItemProcurementId) . ' style="font-size:20px" class="text-primary mr-10"><i class="lni lni-power-switch"></i></a>';
                    }
                
                    if ($row->Active == 1) {
                        $btn .= '<a href=' . route('itemproc.edit', $row->ItemProcurementId) . ' style="font-size:20px" class="text-warning mr-10"><i class="lni lni-pencil-alt"></i></a>';
                        return $btn;
                    } else if ($row->Active == 0) {
                        $btn .= '<a href=' . route('itemproc.destroy', $row->ItemProcurementId) . ' style="font-size:20px" class="text-danger mr-10" data-bs-toggle="modal" data-bs-target="#staticBackdrop" id="hapusBtn"><i class="lni lni-trash-can"></i></a>';
                        return $btn;
                    }
                })
                ->rawColumns(['Action', 'Active', 'Status'])
                ->make(true);
        }
        return view('ItemProcurement.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $item = Item::all();
        $location = Location::all();
        session()->pull('temp-file', 'default');
        session(['temp-file' => []]);
        return view('ItemProcurement.create', compact('item', 'location'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (($request->itemId == null) || ($request->Qty[0] == null)) {
            if($request->itemId == null){
                return response()->redirectToRoute('itemproc.create')->withToastWarning('Item Cannot be Empty');
            }
            else if($request->Qty[0] == null){
                return response()->redirectToRoute('itemproc.create')->withToastWarning('Qty Cannot be Empty');
            }
        }
        $Uuid = (string) Str::uuid();
        $nextNo = DB::table('ItemProcurement')->max('No') + 1;
         //insert ke table ItemProcurement
        $data = [
            'ItemProcurementId' => $Uuid,
            'LocationId' => request('LocationId'),
            'ProjectId' => 1,
            'ItemRequisitionId' => 123123,
            'IsPermanentDelete' => 0,
            'Status' => null,
            'Active' => 1,
            'Tanggal' => $request->Tanggal,
            'Notes' => request('Notes'),
            'No' => $nextNo,
            'CreatedBy' => 123,
            'UpdatedBy' => 123,
        ];
        ItemProcurement::create($data);

        //insert ke table ItemProcurementDetail
        for ($i = 0; $i < count($request->itemId); $i++) {
                $data = [
                    'ItemProcurementId' => $Uuid,
                    'ItemId' => $request->itemId[$i],
                    'ItemQty' => $request->Qty[$i],
                ];
                DB::table('ItemProcurementDetail')->insert($data);


            //Insert Ke table Inventory
            // $dataitem = Item::where('ItemId', $request->itemId[$i])->first();
            // $inventory = [
            //     'LocationId' => $request->LocationId,
            //     'ItemId' => $request->itemId[$i],
            //     'ItemName' => $dataitem->Name,
            //     'HourMaintenance' => 11,
            //     'ProjectId' => 1,
            // ];
            // if(DB::table('Inventory')->where([['LocationId', $request->LocationId], ['ItemId', $request->itemId[$i]]])->exists()){
            //     DB::table('Inventory')->where([['LocationId', $request->LocationId], ['ItemId', $request->itemId[$i]]])->increment('ItemQty', $request->Qty[$i]);
            // }
            // else{
            //     $inventory['ItemQty'] = $request->Qty[$i];
            //     DB::table('Inventory')->insert($inventory);
            // }
        }

        //insert ke table ItemProcurementUpload
        $file = session('temp-file');
        $location = Location::where('LocationId', $request->LocationId)->first();
        foreach ($file as $file) {
            $filepath = ('images/procurement/'.$location->Name.'/'.$file);
            $folderPath = public_path('images/procurement/'.$location->Name);
            if (!File::isDirectory($folderPath)) {
                File::makeDirectory($folderPath, $mode = 0777, true, true);
            }

            $dataFile = [
                'ProcurementUploadId' => (string) Str::uuid(),
                'ItemProcurementId' => $Uuid,
                'FilePath' => $filepath,
                'UploadedBy' => "Rezky",
            ];

            DB::table('ItemProcurementUpload')->insert($dataFile);
            File::move(public_path('/images/temp/'.$file), public_path($filepath));
        }

        return response()->redirectToRoute('itemproc.index')->withToastSuccess('Item Procurement has been created');
    }
    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ItemProcurement  $itemProcurement
     * @return \Illuminate\Http\Response
     */
    public function show(ItemProcurement $itemProcurement)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $item = Item::all();
        $location = Location::all();
        $itemproc = ItemProcurement::where('ItemProcurementId', $id)->first();
        $detailproc = DB::table('ItemProcurementDetail')->where('ItemProcurementId', $id)->get();
        $uploaditem = DB::table('ItemProcurementUpload')->where('ItemProcurementId', $id)->get();
        session()->pull('temp-file', 'default');
        session(['temp-file' => []]);
        $data = [
            'item' => $item,
            'location' => $location,
            'itemproc' => $itemproc,
            'detailproc' => $detailproc,
            'uploaditem' => $uploaditem
        ];

        for ($i = 0; $i < count($data['detailproc']); $i++) {
            $data['detailproc'][$i] = [
                'ItemProcurementId' => $data['detailproc'][$i]->ItemProcurementId,
                'ItemId' => $data['detailproc'][$i]->ItemId,
                'ItemQty' => $data['detailproc'][$i]->ItemQty,
                'NameItem' => Item::where('ItemId', $data['detailproc'][$i]->ItemId)->first()->Name,
            ];
        }
        return view('ItemProcurement.edit', compact('data'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $data = [
            "LocationId" => $request->LocationId,
            "Tanggal" => $request->Tanggal,
            "Notes" => $request->Notes,
            "UpdatedBy" => 32,
        ];


        $checkedItem = DB::table('ItemProcurementDetail')->where('ItemProcurementId', $id)->get();

        $item = [];
        for ($i = 0; $i < count($request->itemId); $i++) {
            $item[$i] = [
                'ItemProcurementId' => $id,
                'ItemId' => $request->itemId[$i],
                'ItemQty' => $request->Qty[$i],
            ];
        }
        if (count($checkedItem) != 0) {
            DB::table('ItemProcurementDetail')->whereNotIn('ItemId', $request->itemId)->delete();
            foreach ($item as $IdItem) {
                DB::table('ItemProcurementDetail')->updateOrInsert(
                    ['ItemId' => $IdItem['ItemId']],
                    ['ItemProcurementId' => $id, 'ItemQty' => $IdItem['ItemQty']]
                );
            }
        } else {
            foreach ($item as $item) {
                DB::table('ItemProcurementDetail')->insert($item);
            }
        }

        ItemProcurement::where('ItemProcurementId', $id)->update($data);

        //Upload File
        $file = session('temp-file');
        $location = Location::where('LocationId', $request->LocationId)->first();
        foreach ($file as $file) {
            $filepath = ('images/procurement/' . $location->Name . '/' . $file);
            $folderPath = public_path('images/procurement/' . $location->Name);
            if (!File::isDirectory($folderPath)) {
                File::makeDirectory($folderPath, $mode = 0777, true, true);
            }

            $dataFile = [
                "ProcurementUploadId" => (string) Str::uuid(),
                "ItemProcurementId" => $id,
                "FilePath" => $filepath,
                "UploadedBy" => "Rezky",
                "UploadedDate" => date('Y-m-d H:i:s', time()),
            ];

            DB::table('ItemProcurementUpload')->insert($dataFile);
            File::move(public_path('/images/temp/' . $file), public_path($filepath));
        }

        return redirect()->route('itemproc.index')->withToastSuccess('Item Procurement has been updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ItemProcurement  $itemProcurement
     * @return \Illuminate\Http\Response
     */
    public function destroy($ItemProcurementId)
    {
        $itemproc = ItemProcurement::find($ItemProcurementId);
        $itemproc->update(['IsPermanentDelete'=> 1]);
        return redirect()->route('itemproc.index')->withToastSuccess('Proses berhasil dihapus.');
    }

    public function activate($ItemProcurementId)
    {
        $data = ItemProcurement::where('ItemProcurementId', $ItemProcurementId)->first();
        if ($data->Active == 1) {
            ItemProcurement::where('ItemProcurementId', $ItemProcurementId)->update(['Active' => 0]);
        } else {
            ItemProcurement::where('ItemProcurementId', $ItemProcurementId)->update(['Active' => 1]);
        }
        return redirect()->route('itemproc.index')->withToastSuccess('Status has been updated');
    }

    public function dropzoneStore(Request $request){
        $image = $request->file('file');
        session()->push('temp-file', $image->getClientOriginalName());
        $image->move(public_path('images/temp/'), $image->getClientOriginalName());

        return response()->json(['success' => $image->getClientOriginalName()]);
    }

    public function dropzoneGet($id)
    {
        $data = DB::table('ItemProcurementUpload')->where('ItemProcurementId', $id)->get();
        return response()->json(['success' => pathinfo($data[0]->FilePath)]);
    }


    public function dropzoneDestroy(Request $request){
        $filename = $request->filename;
        $path = public_path().'/images/temp/'.$filename;
        if (file_exists($path)) {
            unlink($path);
        }
        return $filename;
    }
    public function deleteFile($id)
    {
        $file = DB::table('ItemProcurementUpload')->where('ProcurementUploadId', $id)->first();
        unlink(public_path($file->FilePath));
        DB::table('ItemProcurementUpload')->where('ProcurementUploadId', $id)->delete();
        return response()->json(['message' => 'File deleted successfully'], 200);
    }
}
