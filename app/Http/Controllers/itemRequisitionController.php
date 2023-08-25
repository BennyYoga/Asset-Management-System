<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\ItemRequisition;
use App\Models\Location;
use Illuminate\Contracts\Session\Session;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Symfony\Component\VarDumper\Cloner\Data;

class itemRequisitionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $req  = ItemRequisition::where('IsPermanentDelete', 0)
                ->orderBy('No', 'desc')
                ->get();
            return DataTables::of($req)
                ->addColumn('JumlahBarang', function ($row) {
                    $data = count(DB::table('ItemRequisitionDetail')->where('ItemRequisitionId', $row->ItemRequisitionId)->get());
                    return ($data . ' Item');
                })
                ->addColumn('Lokasi', function ($row) {
                    $lokasi = Location::where('LocationId', $row->LocationTo)->first();
                    return $lokasi->Name;
                })
                ->addColumn('dibuat', function ($row) {
                    $tanggal = date('d', strtotime($row->CreatedDate));
                    $namaBulan = date('F', strtotime($row->CreatedDate));
                    $tahun = date('Y', strtotime($row->CreatedDate));
                    $bulan = $tanggal . ' ' . $namaBulan . ' ' . $tahun;
                    return [
                        'display' => $bulan,
                        'timestamp' => strtotime($row->CreatedDate)
                    ];
                })
                ->addColumn('Tanggal', function ($row) {
                    $tanggal = date('d', strtotime($row->Tanggal));
                    $namaBulan = date('F', strtotime($row->Tanggal));
                    $tahun = date('Y', strtotime($row->Tanggal));
                    $bulan = $tanggal . ' ' . $namaBulan . ' ' . $tahun;
                    return $bulan;
                })
                ->addColumn('Active', function ($row) {
                    // $btn = '<button type="button" class="btn btn-primary btn-sm">' . $data . '</button>';
                    if ($row->Active == 0) {
                        $data = 'Submitted';
                        $btn = '<span class="status-btn success-btn" disabled
                        style="--bs-btn-padding-y: .25rem; --bs-btn-padding-x: .5rem; --bs-btn-font-size: .75rem;">
                        ' . $data . ' 
                        </span>';
                        return $btn;
                    } else if ($row->Active == 1) {
                        $data = 'UnSubmitted';
                        $btn = '<span class="status-btn warning-btn" disabled
                        style="--bs-btn-padding-y: .25rem; --bs-btn-padding-x: .5rem; --bs-btn-font-size: .75rem;">
                        ' . $data . ' 
                        </span>';
                        return $btn;
                    }
                })
                ->addColumn('Status', function ($row) {
                    if ($row->Status === 0) {
                        $data = 'Rejected';
                        $btn = '<span class="status-btn close-btn" disabled
                        style="--bs-btn-padding-y: .25rem; --bs-btn-padding-x: .5rem; --bs-btn-font-size: .75rem;">
                        ' . $data . ' 
                        </span>';
                        return $btn;
                    } else if ($row->Status == 1) {
                        $data = 'Approved';
                        $btn = '<span class="status-btn success-btn" disabled
                        style="--bs-btn-padding-y: .25rem; --bs-btn-padding-x: .5rem; --bs-btn-font-size: .75rem;">
                        ' . $data . ' 
                        </span>';
                        return $btn;
                    } else {
                        if ($row->Active == 0) {
                            $data = 'Pending';
                            $btn = '<span class="status-btn warning-btn" disabled
                            style="--bs-btn-padding-y: .25rem; --bs-btn-padding-x: .5rem; --bs-btn-font-size: .75rem;">
                            ' . $data . ' 
                            </span>';
                            return $btn;
                        } else {
                            return null;
                        }
                    }
                })
                ->addColumn('Action', function ($row) {
                    if ($row->Active == 1) {
                        $btn = '<a href=' . route('itemreq.activate', $row->ItemRequisitionId) . ' style="font-size:20px" class="text-danger mr-10"><i class="lni lni-power-switch"></i></a>';
                    } else if ($row->Active == 0) {
                        $btn = '<a href=' . route('itemreq.activate', $row->ItemRequisitionId) . ' style="font-size:20px" class="text-primary mr-10"><i class="lni lni-power-switch"></i></a>';
                    }

                    if ($row->Active == 1) {
                        $btn .= '<a href=' . route('itemreq.edit', $row->ItemRequisitionId) . ' style="font-size:20px" class="text-warning mr-10"><i class="lni lni-pencil-alt"></i></a>';
                        $btn .= '<a href=' . route('itemreq.delete', $row->ItemRequisitionId) . ' style="font-size:20px" class="text-danger mr-10" data-bs-toggle="modal" data-bs-target="#staticBackdrop" id="hapusBtn"><i class="lni lni-trash-can"></i></a>';
                        return $btn;
                    } else if ($row->Active == 0) {
                        return $btn;
                    }
                })
                ->rawColumns(['Action', 'Active', 'Status'])
                ->make(true);
        }

        return view('ItemRequisition.index');
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
        return view('ItemRequisition.create3', compact('item', 'location'));
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
            if ($request->itemId == null) {
                return response()->redirectToRoute('itemreq.create')->withToastWarning('Item Cannot be Empty');
            } else if ($request->Qty[0] == null) {
                return response()->redirectToRoute('itemreq.create')->withToastWarning('Qty Cannot be Empty');
            }
        }

        //Insert to Requisition
        $Uuid = (string) Str::uuid();
        $data = [
            'ItemRequisitionId' => $Uuid,
            'LocationFrom' => 'dari session',
            'LocationTo' => request('LocationTo'),
            'ProjectId' => "asdasdwasd",
            'No' => 1,
            'Tanggal' => request('Tanggal'),
            'Notes' => request('Notes'),
            'Active' => 1,
            'IsPermanentDelete' => 0,
            'CreatedBy' => 32,
            'UpdatedBy' => 32,
        ];
        ItemRequisition::create($data);

        // Insert to Detail
        for ($i = 0; $i < count($request->itemId); $i++) {
            $data = [
                'ItemRequisitionId' => $Uuid,
                'ItemId' => $request->itemId[$i],
                'ItemQty' => $request->Qty[$i],
            ];
            DB::table('ItemRequisitionDetail')->insert($data);
        }

        //Upload File
        $file = session('temp-file');
        $location = Location::where('LocationId', $request->LocationTo)->first();
        foreach ($file as $file) {
            $filepath = ('images/requisition/' . $location->Name . '/' . $file);
            $folderPath = public_path('images/requisition/' . $location->Name);
            if (!File::isDirectory($folderPath)) {
                File::makeDirectory($folderPath, $mode = 0777, true, true);
            }

            $dataFile = [
                "RequisitionUploadId" => (string) Str::uuid(),
                "ItemRequisitionId" => $Uuid,
                "FilePath" => $filepath,
                "UploadedBy" => "Benny",
                "UploadedDate" => date('Y-m-d H:i:s', time()),
            ];

            DB::table('ItemRequisitionUpload')->insert($dataFile);
            File::move(public_path('/images/temp/' . $file), public_path($filepath));
        }

        return response()->redirectToRoute('itemreq.index')->withToastSuccess('Item Requisition has been created');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
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
        //
        $item = Item::all();
        $location = Location::all();
        $itemreq = ItemRequisition::where('ItemRequisitionId', $id)->first();
        $detailreq = DB::table('ItemRequisitionDetail')->where('ItemRequisitionId', $id)->get();
        $uploaditem = DB::table('ItemRequisitionUpload')->where('ItemRequisitionId', $id)->get();
        session()->pull('temp-file', 'default');
        session(['temp-file' => []]);
        $data = [
            'item' => $item,
            'location' => $location,
            'itemreq' => $itemreq,
            'detailreq' => $detailreq,
            'uploaditem' => $uploaditem
        ];
        for ($i = 0; $i < count($data['detailreq']); $i++) {
            $data['detailreq'][$i] = [
                'ItemRequisitionId' => $data['detailreq'][$i]->ItemRequisitionId,
                'ItemId' => $data['detailreq'][$i]->ItemId,
                'ItemQty' => $data['detailreq'][$i]->ItemQty,
                'NameItem' => Item::where('ItemId', $data['detailreq'][$i]->ItemId)->first()->Name,
            ];
        }
        session(['upload-file' => $data['uploaditem']]);
        return view('ItemRequisition.edit', compact('data'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $data = [
            "LocationTo" => $request->LocationTo,
            "Tanggal" => $request->Tanggal,
            "Notes" => $request->Notes,
            "UpdatedBy" => 32,
        ];
        $checkedItem = DB::table('ItemRequisitionDetail')->where('ItemRequisitionId', $id)->get();

        $item = [];
        for ($i = 0; $i < count($request->itemId); $i++) {
            $item[$i] = [
                'ItemRequisitionId' => $id,
                'ItemId' => $request->itemId[$i],
                'ItemQty' => $request->Qty[$i],
            ];
        }
        if (count($checkedItem) != 0) {
            DB::table('ItemRequisitionDetail')->whereNotIn('ItemId', $request->itemId)->delete();
            foreach ($item as $IdItem) {
                DB::table('ItemRequisitionDetail')->updateOrInsert(
                    ['ItemId' => $IdItem['ItemId']],
                    ['ItemRequisitionId' => $id, 'ItemQty' => $IdItem['ItemQty']]
                );
            }
        } else {
            foreach ($item as $item) {
                DB::table('ItemRequisitionDetail')->insert($item);
            }
        }

        ItemRequisition::where('ItemRequisitionId', $id)->update($data);

        //Upload File
        $file = session('temp-file');
        $location = Location::where('LocationId', $request->LocationTo)->first();
        foreach ($file as $file) {
            $filepath = ('images/requisition/' . $location->Name . '/' . $file);
            $folderPath = public_path('images/requisition/' . $location->Name);
            if (!File::isDirectory($folderPath)) {
                File::makeDirectory($folderPath, $mode = 0777, true, true);
            }

            $UuidFile = (string) Str::uuid();
            $dataFile = [
                "RequisitionUploadId" => $UuidFile,
                "ItemRequisitionId" => $id,
                "FilePath" => $filepath,
                "UploadedBy" => "Benny",
                "UploadedDate" => date('Y-m-d H:i:s', time()),
            ];

            DB::table('ItemRequisitionUpload')->insert($dataFile);
            File::move(public_path('/images/temp/' . $file), public_path($filepath));

            $getFile = DB::table('ItemRequisitionUpload')->where('RequisitionUploadId', $UuidFile)->first();
            session()->push('upload-file', $getFile);
        }

        //Delete and Update File
        $fileUpload = session('upload-file')->pluck('RequisitionUploadId');
        $dataFile = DB::table('ItemRequisitionUpload')->where('ItemRequisitionId', $id)->pluck('RequisitionUploadId');
        foreach ($dataFile as $data) {
            $found = false;
            foreach ($fileUpload as $file) {
                if ($file == $data) {
                    $found = true;
                    break;
                }
            }
            if (!$found) {
                $Unlink = DB::table('ItemRequisitionUpload')->where('RequisitionUploadId', $data)->first();
                if ($Unlink) {
                    DB::table('ItemRequisitionUpload')->where('RequisitionUploadId', $data)->delete();
                    unlink(public_path($Unlink->FilePath));
                }
            }
        }


        return redirect()->route('itemreq.index')->withToastSuccess('Item Requisition has been updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data = ItemRequisition::where('ItemRequisitionId', $id);
        $data->update(['IsPermanentDelete' => 1]);
        return redirect()->route('itemreq.index')->withToastSuccess('Item has been deleted');
    }

    public function activate($id)
    {
        $data = ItemRequisition::where('ItemRequisitionId', $id)->first();
        if ($data->Active == 1) {
            ItemRequisition::where('ItemRequisitionId', $id)->update(['Active' => 0]);
        } else {
            ItemRequisition::where('ItemRequisitionId', $id)->update(['Active' => 1]);
        }
        return redirect()->route('itemreq.index')->withToastSuccess('Status has been updated');
    }

    public function dropzoneExample()
    {
        return view('ItemRequisition.create2');
    }

    public function dropzoneStore(Request $request)
    {
        $image = $request->file('file');
        session()->push('temp-file', $image->getClientOriginalName());
        // $imageName = time().'.'.$image->extension();
        $image->move(public_path('images/temp/'), $image->getClientOriginalName());

        return response()->json(['success' => $image->getClientOriginalName()]);
    }

    public function dropzoneGet($id)
    {
        $data = DB::table('ItemRequisitionUpload')->where('ItemRequisitionId', $id)->get();
        return response()->json(['success' => pathinfo($data[0]->FilePath)]);
    }

    public function dropzoneDestroy(Request $request)
    {
        $filename = $request->filename;
        $path = public_path() . '/images/temp/' . $filename;
        if (file_exists($path)) {
            unlink($path);
        }
        return $filename;
    }

    public function deleteFile($id)
    {
        foreach (session('upload-file') as $key => $element) {
            if ($element->RequisitionUploadId == $id) {
                unset(session('upload-file')[$key]);
            }
        }

        return response()->json(['message' => 'File deleted successfully'], 200);
    }
}
