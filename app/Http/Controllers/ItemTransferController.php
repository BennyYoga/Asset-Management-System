<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\ItemTransfer;
use App\Models\Location;
use App\Models\Role;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;


class ItemTransferController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $itemtransfer = ItemTransfer::where("IsPermanentDelete", 0)
            ->orderBy('No', 'desc')
            ->get();
            return DataTables::of($itemtransfer)
                ->addIndexColumn()
                ->addColumn('JumlahBarang', function ($row) {
                    $data = count(DB::table('ItemTransferDetail')->where('ItemTransferId', $row->ItemTransferId)->get());
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
                        $btn = '<span class="status-btn success-btn" disabled
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
                        $btn = '<a href=' . route('itemtransfer.activate', $row->ItemTransferId) . ' style="font-size:20px" class="text-danger mr-10"><i class="lni lni-power-switch"></i></a>';
                    } else if ($row->Active == 0) {
                        $btn = '<a href=' . route('itemtransfer.activate', $row->ItemTransferId) . ' style="font-size:20px" class="text-primary mr-10"><i class="lni lni-power-switch"></i></a>';
                    }
                
                    if ($row->Active == 1) {
                        $btn .= '<a href=' . route('itemtransfer.edit', $row->ItemTransferId) . ' style="font-size:20px" class="text-warning mr-10"><i class="lni lni-pencil-alt"></i></a>';
                        return $btn;
                    } else if ($row->Active == 0) {
                        $btn .= '<a href=' . route('itemtransfer.destroy', $row->ItemTransferId) . ' style="font-size:20px" class="text-danger mr-10" data-bs-toggle="modal" data-bs-target="#staticBackdrop" id="hapusBtn"><i class="lni lni-trash-can"></i></a>';
                        return $btn;
                    }
                })
                ->rawColumns(['Action', 'Active', 'Status'])
                ->make(true);
        }
        return view('ItemTransfer.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $item = Item::all();
        $location = Location::all();
        session()->pull('temp-file', 'default');
        session(['temp-file' => []]);
        return view('ItemTransfer.create', compact('item', 'location'));
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
                return response()->redirectToRoute('itemtransfer.create')->withToastWarning('Item Cannot be Empty');
            }
            else if($request->Qty[0] == null){
                return response()->redirectToRoute('itemtransfer.create')->withToastWarning('Qty Cannot be Empty');
            }
        }
        $Uuid = (string) Str::uuid();
        $nextNo = DB::table('ItemTransfer')->max('No') + 1;

         //insert ke table ItemTransfer
        $data = [
            'ItemTransferId' => $Uuid,
            'LocationId' => request('LocationId'),
            'ProjectId' => 1,
            'IsPermanentDelete' => 0,
            'Status' => null,
            'Active' => 1,
            'Tanggal' => $request->Tanggal,
            'Notes' => request('Notes'),
            'No' => $nextNo,
            'CreatedBy' => 123,
            'UpdatedBy' => 123,
        ];
        ItemTransfer::create($data);

        //insert ke table ItemTransferDetail
        for ($i = 0; $i < count($request->itemId); $i++) {
                $data = [
                    'ItemTransferId' => $Uuid,
                    'ItemId' => $request->itemId[$i],
                    'ItemQty' => $request->Qty[$i],
                ];
                DB::table('ItemTransferDetail')->insert($data);


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

        //insert ke table ItemTransferUpload
        $file = session('temp-file');
        $location = Location::where('LocationId', $request->LocationId)->first();
        foreach ($file as $file) {
            $filepath = ('images/transfer/'.$location->Name.'/'.$file);
            $folderPath = public_path('images/transfer/'.$location->Name);
            if (!File::isDirectory($folderPath)) {
                File::makeDirectory($folderPath, $mode = 0777, true, true);
            }

            $dataFile = [
                'TransferUploadId' => (string) Str::uuid(),
                'ItemTransferId' => $Uuid,
                'FilePath' => $filepath,
                'UploadedBy' => "Rezky",
            ];

            DB::table('ItemTransferUpload')->insert($dataFile);
            File::move(public_path('/images/temp/'.$file), public_path($filepath));
        }

        return response()->redirectToRoute('itemtransfer.index')->withToastSuccess('Item Transfer has been created');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ItemTransfer  $itemTransfer
     * @return \Illuminate\Http\Response
     */
    public function show(ItemTransfer $itemTransfer)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ItemTransfer  $itemTransfer
     * @return \Illuminate\Http\Response
     */
    public function edit(ItemTransfer $itemTransfer)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ItemTransfer  $itemTransfer
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ItemTransfer $itemTransfer)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ItemTransfer  $itemTransfer
     * @return \Illuminate\Http\Response
     */
    public function destroy($ItemTransferId)
    {
        $itemtransfer = ItemTransfer::find($ItemTransferId);
        $itemtransfer->update(['IsPermanentDelete'=> 1]);
        return redirect()->route('itemtransfer.index')->with('success', 'Proses berhasil dihapus.');
    }

    public function activate($ItemTransferId)
    {
        $data = ItemTransfer::where('ItemTransferId', $ItemTransferId)->first();
        if ($data->Active == 1) {
            ItemTransfer::where('ItemTransferId', $ItemTransferId)->update(['Active' => 0]);
        } else {
            ItemTransfer::where('ItemTransferId', $ItemTransferId)->update(['Active' => 1]);
        }
        return redirect()->route('itemtransfer.index')->withToastSuccess('Status has been updated');
    }

    public function dropzoneStore(Request $request){
        $image = $request->file('file');
        session()->push('temp-file', $image->getClientOriginalName());
        $image->move(public_path('images/temp/'), $image->getClientOriginalName());

        return response()->json(['success' => $image->getClientOriginalName()]);
    }

    public function dropzoneGet($id)
    {
        $data = DB::table('ItemTransferUpload')->where('ItemTransferId', $id)->get();
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
}
