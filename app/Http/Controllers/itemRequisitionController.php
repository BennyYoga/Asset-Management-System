<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\ItemRequisition;
use App\Models\Location;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;




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
            $req  = ItemRequisition::where('IsPermanentDelete', 0)->get();
            return DataTables::of($req)
                ->addColumn('JumlahBarang', function ($row) {
                    $data = count(DB::table('ItemRequisitionDetail')->where('ItemRequisitionId', $row->ItemRequisitionId)->get());
                    return ($data . ' Item');
                })
                ->addColumn('Lokasi', function ($row) {
                    $lokasi = Location::where('LocationId', $row->LocationId)->first();
                    return $lokasi->Name;
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
                ->addColumn('Status', function ($row) {
                    if ($row->Status === 0) {
                        $data = 'Rejected';
                        $btn = '<button type="button" class="btn btn-danger" disabled
                        style="--bs-btn-padding-y: .25rem; --bs-btn-padding-x: .5rem; --bs-btn-font-size: .75rem;">
                        ' . $data . ' 
                        </button>';
                        return $btn;
                    } else if ($row->Status == 1) {
                        $data = 'Approved';
                        $btn = '<button type="button" class="btn btn-success" disabled
                        style="--bs-btn-padding-y: .25rem; --bs-btn-padding-x: .5rem; --bs-btn-font-size: .75rem;">
                        ' . $data . ' 
                        </button>';
                        return $btn;
                    } else {
                        $data = 'Pending';
                        $btn = '<button type="button" class="btn btn-warning" disabled
                        style="--bs-btn-padding-y: .25rem; --bs-btn-padding-x: .5rem; --bs-btn-font-size: .75rem;">
                        ' . $data . ' 
                        </button>';
                        return $btn;
                    }
                })
                ->addColumn('Action', function ($row) {
                    if ($row->Active == 1) {
                        $btn = '<a href=' . route('itemreq.activate', $row->ItemRequisitionId) . ' style="font-size:20px" title="Deactivate Requisition" class="text-danger mr-10"><i class="lni lni-power-switch"></i></a>';
                        return $btn;
                    } else if ($row->Active == 0) {
                        $btn = '<a href=' . route('itemreq.activate', $row->ItemRequisitionId) . ' style="font-size:20px" title="Activate Requisition" class="text-primary mr-10"><i class="lni lni-power-switch"></i></a>';
                        $btn .= '<a href=' . route('itemreq.delete', $row->ItemRequisitionId) . ' style="font-size:20px" title="Deleted Requisition" class="text-danger mr-10"><i class="lni lni-trash-can"></i></a>';
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
        return view('ItemRequisition.create', compact('item', 'location'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        dd($request);
        if (($request->itemId == null) || ($request->Qty[0] == null)) {
            if($request->itemId == null){
                return response()->redirectToRoute('itemreq.create')->with('error', 'Item Cannot be Empty');
            }
            else if($request->Qty[0] == null){
                return response()->redirectToRoute('itemreq.create')->with('error', 'Qty Cannot be Empty');
            }
        }
        $Uuid = (string) Str::uuid();
        $data = [
            'ItemRequisitionId' => $Uuid,
            'LocationId' => request('LocationId'),
            'No' => 1,
            'Tanggal' => date('Y-m-d H:i:s', time()),
            'Notes' => request('Notes'),
            'Active' => 1,
            'IsPermanentDelete' => 0,
            'CreatedBy' => 32,
            'UpdatedBy' => 32
        ];
        ItemRequisition::create($data);

        for ($i = 0; $i < count($request->itemId); $i++) {
            $data = [
                'ItemRequisitionId' => $Uuid,
                'ItemId' => $request->itemId[$i],
                'ItemQty' => $request->Qty[$i],
            ];
            DB::table('ItemRequisitionDetail')->insert($data);


            //Menambahkan Ke Inventory
            $dataitem = Item::where('ItemId', $request->itemId[$i])->first();
            $inventory = [
                'LocationId' => $request->LocationId,
                'ItemId' => $request->itemId[$i],
                'ItemName' => $dataitem->Name,
                'HourMaintenance' => 11,
            ];
            if(DB::table('Inventory')->where([['LocationId', $request->LocationId], ['ItemId', $request->itemId[$i]]])->exists()){
                DB::table('Inventory')->where([['LocationId', $request->LocationId], ['ItemId', $request->itemId[$i]]])->increment('ItemQty', $request->Qty[$i]);
            }
            else{
                $inventory['ItemQty'] = $request->Qty[$i];
                DB::table('Inventory')->insert($inventory);
            }

        }

        return response()->redirectToRoute('itemreq.index')->with('success', 'Item Requisition has been created');
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
        //
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
        return redirect()->route('itemreq.index')->with('success', 'Item has been deleted');
    }

    public function activate($id)
    {
        $data = ItemRequisition::where('ItemRequisitionId', $id)->first();
        if ($data->Active == 1) {
            ItemRequisition::where('ItemRequisitionId', $id)->update(['Active' => 0]);
        } else {
            ItemRequisition::where('ItemRequisitionId', $id)->update(['Active' => 1]);
        }
        return redirect()->route('itemreq.index')->with('success', 'Status has been updated');
    }
}
