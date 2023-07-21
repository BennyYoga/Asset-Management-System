<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\ItemUse;
use App\Models\Location;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;


class ItemUseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $itemuse = ItemUse::where("IsPermanentDelete", 0)
            ->orderBy('No', 'desc')
            ->get();
            return DataTables::of($itemuse)
                ->addIndexColumn()
                ->addColumn('JumlahBarang', function ($row) {
                    $data = count(DB::table('ItemUseDetail')->where('ItemUseId', $row->ItemUseId)->get());
                    return ($data . ' Item');
                })
                ->addColumn('Lokasi', function ($row) {
                    $location = Location::where('LocationId', $row->LocationId)->first();
                    return $location->Name;
                })
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
                    $btn = '<a href=' . route('itemuse.edit', $row->ItemUseId) . ' style="font-size:20px" class="text-warning mr-10"><i class="lni lni-pencil-alt"></i></a>';
                    if ($row->Active == 1) {
                        $btn = '<a href=' . route('itemuse.edit', $row->ItemUseId) . ' style="font-size:20px" class="text-warning mr-10"><i class="lni lni-pencil-alt"></i></a>';
                        $btn .= '<a href=' . route('itemuse.activate', $row->ItemUseId) . ' style="font-size:20px" class="text-danger mr-10"><i class="lni lni-power-switch"></i></a>';
                        return $btn;
                    } else if ($row->Active == 0) {
                        $btn .= '<a href=' . route('itemuse.activate', $row->ItemUseId) . ' style="font-size:20px" class="text-primary mr-10"><i class="lni lni-power-switch"></i></a>';
                        $btn .= '<a href=' . route('itemuse.destroy', $row->ItemUseId) . ' style="font-size:20px" class="text-danger mr-10" data-bs-toggle="modal" data-bs-target="#staticBackdrop" id="hapusBtn"><i class="lni lni-trash-can"></i></a>';
                        return $btn;
                    }
                })
                ->rawColumns(['Action', 'Active', 'Status'])
                ->make(true);
        }
        return view('ItemUse.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ItemUse  $itemUse
     * @return \Illuminate\Http\Response
     */
    public function show(ItemUse $itemUse)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ItemUse  $itemUse
     * @return \Illuminate\Http\Response
     */
    public function edit(ItemUse $itemUse)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ItemUse  $itemUse
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ItemUse $itemUse)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ItemUse  $itemUse
     * @return \Illuminate\Http\Response
     */
    public function destroy(ItemUse $itemUse)
    {
        //
    }
}
