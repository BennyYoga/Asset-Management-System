<?php

namespace App\Http\Controllers;

use App\Models\Item;
use Illuminate\Support\Facades\DB;
use App\Models\m_category;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Str;

class itemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //
        if ($request->ajax()) {
            $item  = Item::all();
            return DataTables::of($item)
                ->addColumn('Status', function ($row) {
                    return $row->Active == 0 ? 'Nonactive' : 'Active';
                })
                ->addColumn('ItemBehavior', function ($row) {
                    if ($row['ItemBehavior'] == 1) {
                        return 'Hour Usage Monitor';
                    } else if ($row['ItemBehavior'] == 2) {
                        return 'Consumable';
                    } else if ($row['ItemBehavior'] == 3) {
                        return 'Non Consumable';
                    }
                })
                ->addColumn('Alert', function ($row) {
                    if ($row['ItemBehavior'] == 1) {
                        return ($row['AlertHourMaintenance'] . ' Hour');
                    } else if ($row['ItemBehavior'] == 2) {
                        return ($row['AlertConsumable'] . ' Item');
                    } else if ($row['ItemBehavior'] == 3) {
                        return '-';
                    }
                })
                ->addColumn('Action', function ($row) {
                    $btn = '<a href=' . route('item.edit', $row->ItemId) . ' style="font-size:20px" class="text-warning mr-10"><i class="lni lni-pencil-alt"></i></a>';
                    $btn .= '<a href=' . route('item.delete', $row->ItemId) . ' style="font-size:20px" class="text-danger mr-10" data-bs-toggle="modal" data-bs-target="#staticBackdrop" id="hapusBtn"><i class="lni lni-trash-can"></i></a>';
                    return $btn;
                })
                ->rawColumns(['Action'])
                ->make(true);
        }

        return view('item.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $category = m_category::all();
        return view('item.create', compact('category'));
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
        $request->validate(
            [
                'Name' => 'required',
                'Unit' => 'required',
                'Status' => 'required',
            ]
        );

        $Uuid = (string) Str::uuid();
        $data = [
            'ItemId' => (string) Str::uuid(),
            'Name' => request('Name'),
            'Unit' => (int) request('Unit'),
            'ItemBehavior' => (int) request('ItemBehavior'),
            'AlertHourMaintenance' => (int) request('AlertHourMaintenance'),
            'AlertConsumable' => (int) request('AlertConsumable'),
            'Active' => (int) request('Status'),
            'IsPermanentDelete' => 0,
            'CreatedBy' => 32,
            'CreatedByLocation' => 11,
            'UpdatedBy' => 32
        ];

        // dd($data);

        Item::create($data);
        foreach ($request->Category as $category) {
            $data = [
                'Uuid' => (string) Str::uuid(),
                'ItemId' => $data['ItemId'],
                'CategoryId' => $category,
            ];
            DB::table('CategoryItem')->insert($data);
        }

        return view('item.index',);
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
        //
        $item = Item::where('ItemId', $id)->first();
        return view('Item.edit', compact('item'));
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
