<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\ItemRequisition;
use App\Models\Location;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;


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
                    return "anjay";
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
                    if($row->Status === 0){
                        $data = 'Rejected';
                        $btn = '<button type="button" class="btn btn-danger" disabled
                        style="--bs-btn-padding-y: .25rem; --bs-btn-padding-x: .5rem; --bs-btn-font-size: .75rem;">
                        ' . $data . ' 
                        </button>';
                        return $btn;
                    }else if($row->Status == 1){
                        $data = 'Approved';
                        $btn = '<button type="button" class="btn btn-success" disabled
                        style="--bs-btn-padding-y: .25rem; --bs-btn-padding-x: .5rem; --bs-btn-font-size: .75rem;">
                        ' . $data . ' 
                        </button>';
                        return $btn;
                    }
                    else{
                        $data = 'Pending';
                        $btn = '<button type="button" class="btn btn-warning" disabled
                        style="--bs-btn-padding-y: .25rem; --bs-btn-padding-x: .5rem; --bs-btn-font-size: .75rem;">
                        ' . $data . ' 
                        </button>';
                        return $btn;
                    }
                    
                })
                ->addColumn('Action', function ($row) {
                    $btn = '<a href="" style="font-size:20px" class="text-warning mr-10"><i class="lni lni-pencil-alt"></i></a>';
                    return $btn;
                    // if ($row->Active == 1) {
                    //     $btn = '<a href=' . route('item.edit', $row->ItemId) . ' style="font-size:20px" class="text-warning mr-10"><i class="lni lni-pencil-alt"></i></a>';
                    //     $btn .= '<a href=' . route('item.activate', $row->ItemId) . ' style="font-size:20px" class="text-danger mr-10"><i class="lni lni-power-switch"></i></a>';
                    //     return $btn;
                    // } else if ($row->Active == 0) {
                    //     $btn .= '<a href=' . route('item.activate', $row->ItemId) . ' style="font-size:20px" class="text-primary mr-10"><i class="lni lni-power-switch"></i></a>';
                    //     $btn .= '<a href=' . route('item.delete', $row->ItemId) . ' style="font-size:20px" class="text-danger mr-10"><i class="lni lni-trash-can"></i></a>';
                    //     return $btn;
                    // }
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
        return view('ItemRequisition.create',compact('item'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        dd(request());
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
        //
    }
}
