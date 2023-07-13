<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\ItemProcurement;
use App\Models\Location;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Str;

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
            $procurement = ItemProcurement::where("IsPermanentDelete", 0)->get();
            return DataTables::of($procurement)
                ->addIndexColumn()
                ->addColumn('Status', function ($row) {
                    if ($row->Status === null) {
                        $data = 'Pending';
                        $btn = '<button type="button" class="btn btn-warning" disabled
                            style="--bs-btn-padding-y: .25rem; --bs-btn-padding-x: .5rem; --bs-btn-font-size: .75rem;">
                            ' . $data . ' 
                            </button>';
                    } else if ($row->Status == 0) {
                        $data = 'Declined';
                        $btn = '<button type="button" class="btn btn-danger" disabled
                            style="--bs-btn-padding-y: .25rem; --bs-btn-padding-x: .5rem; --bs-btn-font-size: .75rem;">
                            ' . $data . ' 
                            </button>';
                    } else {
                        $data = 'Accepted';
                        $btn = '<button type="button" class="btn btn-primary" disabled
                            style="--bs-btn-padding-y: .25rem; --bs-btn-padding-x: .5rem; --bs-btn-font-size: .75rem;">
                            ' . $data . ' 
                            </button>';
                    }
                    return $btn;
                })
                ->addColumn('Active', function ($row) {
                    // $btn = '<button type="button" class="btn btn-primary btn-sm">' . $data . '</button>';
                    if ($row->Active == 0) {
                        $data = 'Nonactive';
                        $btn = '<button type="button" class="btn btn-danger" disabled
                        style="--bs-btn-padding-y: .25rem; --bs-btn-padding-x: .5rem; --bs-btn-font-size: .75rem;">
                        ' . $data . ' 
                        </button>';
                        return $btn;
                    } else if ($row->Active == 1) {
                        $data = 'Active';
                        $btn = '<button type="button" class="btn btn-primary" disabled
                        style="--bs-btn-padding-y: .25rem; --bs-btn-padding-x: .5rem; --bs-btn-font-size: .75rem;">
                        ' . $data . ' 
                        </button>';
                        return $btn;
                    }
                })
                ->addColumn('Action', function ($row) {
                    $btn = '<a href=' . route('procurement.edit', $row->ItemProcurementId) . ' style="font-size:20px" class="text-warning mr-10"><i class="lni lni-pencil-alt"></i></a>';
                    if ($row->Active == 1) {
                        $btn = '<a href=' . route('procurement.edit', $row->ItemProcurementId) . ' style="font-size:20px" class="text-warning mr-10"><i class="lni lni-pencil-alt"></i></a>';
                        $btn .= '<a href=' . route('procurement.activate', $row->ItemProcurementId) . ' style="font-size:20px" class="text-danger mr-10"><i class="lni lni-power-switch"></i></a>';
                        return $btn;
                    } else if ($row->Active == 0) {
                        $btn .= '<a href=' . route('procurement.activate', $row->ItemProcurementId) . ' style="font-size:20px" class="text-primary mr-10"><i class="lni lni-power-switch"></i></a>';
                        $btn .= '<a href=' . route('procurement.destroy', $row->ItemProcurementId) . ' style="font-size:20px" class="text-danger mr-10" data-bs-toggle="modal" data-bs-target="#staticBackdrop" id="hapusBtn"><i class="lni lni-trash-can"></i></a>';
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
        $request->validate([
            // 'Tanggal' => 'required',
            'Notes' => 'required',
        ]);

        $data = [
            'ItemProcurementId' => (String)Str::uuid(),
            'LocationId' => $request->LocationId,
            'ProjectId' => 1,
            'IsPermanentDelete' => 0,
            'Status' => null,
            'Active' => 1,
            // 'Tanggal' => $request->Tanggal,
            'Notes' => $request->Notes,
            'No' => 1,
        ];
    
        $data['CreatedBy'] = 'lala';
        $data['UpdatedBy'] = 'lala';
        // dd($data);
        ItemProcurement::create($data);


        return redirect()->route('procurement.index')->with('success', 'Lokasi berhasil ditambahkan.');
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
     * @param  \App\Models\ItemProcurement  $itemProcurement
     * @return \Illuminate\Http\Response
     */
    public function edit(ItemProcurement $itemProcurement)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ItemProcurement  $itemProcurement
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ItemProcurement $itemProcurement)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ItemProcurement  $itemProcurement
     * @return \Illuminate\Http\Response
     */
    public function destroy($ItemProcurementId)
    {
        $procurement = ItemProcurement::find($ItemProcurementId);
        if (!$procurement) {
            return redirect()->back()->with('error', 'Proses tidak ditemukan.');
        }
        $procurement['IsPermanentDelete'] = 1;
        $procurement->update();
        // $location->delete();
        return redirect()->route('procurement.index')->with('success', 'Proses berhasil dihapus.');
    }

    public function activate($ItemProcurementId)
    {
        $data = ItemProcurement::where('ItemProcurementId', $ItemProcurementId)->first();
        if ($data->Active == 1) {
            ItemProcurement::where('ItemProcurementId', $ItemProcurementId)->update(['Active' => 0]);
        } else {
            ItemProcurement::where('ItemProcurementId', $ItemProcurementId)->update(['Active' => 1]);
        }
        return redirect()->route('procurement.index');
    }
}
