<?php

namespace App\Http\Controllers;

use App\Models\Item;
use Illuminate\Support\Facades\DB;
use App\Models\Category;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Str;
Use Alert;
Use Button;

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
            $item  = Item::where('IsPermanentDelete', 0)->get();
            return DataTables::of($item)
                ->addColumn('Status', function ($row) {
                    return Button::status($row->Active);
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
                    $btn = [
                        "Edit" => route('item.edit', $row->ItemId),
                    ];
                    if ($row->Active == 1) {
                        $btn["Deactivate"] = route('item.activate', $row->ItemId);
                    } else if ($row->Active == 0) {
                        $btn["Activate"] = route('item.activate', $row->ItemId);
                        $btn["Delete"] = route('item.delete', $row->ItemId);
                    }
                    return Button::Action($btn);
                })
                ->rawColumns(['Action', 'Status'])
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
        $category = Category::all();
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
                'Code' => 'required',
            ]
        );

        $data = [
            'ItemId' => (string) Str::uuid(),
            'Code' => request('Code'),
            'Name' => request('Name'),
            'Unit' => request('Unit'),
            'ItemBehavior' => (int) request('ItemBehavior'),
            'AlertHourMaintenance' => (int) request('AlertHourMaintenance'),
            'AlertConsumable' => (int) request('AlertConsumable'),
            'IsPermanentDelete' => 0,
            'CreatedBy' => 32,
            'CreatedByLocation' => 11,
            'UpdatedBy' => 32,
            'Active' =>request('Status')
        ];

        Item::create($data);
        foreach ($request->Category as $category) {
            $data = [
                'ItemId' => $data['ItemId'],
                'CategoryId' => $category,
            ];
            DB::table('CategoryItem')->insert($data);
        }

        return redirect()->route('item.index')->with('success', 'Item has been added');
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
        $item = Item::where('ItemId', $id)->first();
        $category = Category::all();
        $CategoryItem = DB::table('CategoryItem')->where('ItemId', $id)->get();
        $selectedCategory = [];
        $unselectedCategory = [];

        foreach ($category as $category) {
            $isCategorySelected = false;

            for ($i = 0; $i < count($CategoryItem); $i++) {
                if ($CategoryItem[$i]->CategoryId == $category['CategoryId']) {
                    $isCategorySelected = true;
                    break;
                }
            }
            if ($isCategorySelected) {
                $data = [
                    'CategoryId' => $category['CategoryId'],
                    'Name' => $category['Name'],
                ];
                array_push($selectedCategory, $data);
            } else {
                $data = [
                    'CategoryId' => $category['CategoryId'],
                    'Name' => $category['Name'],
                ];
                array_push($unselectedCategory, $data);
            }
        }
        return view('Item.edit', compact('item', 'selectedCategory', 'unselectedCategory'));
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
        Item::where('ItemId', $id)->update([
            'Name' => $request->Name,
            'Code' => $request->Code,
            'Unit' => $request->Unit,
            'ItemBehavior' => (int) $request->ItemBehavior,
            'AlertHourMaintenance' => (int) $request->AlertHourMaintenance,
            'AlertConsumable' => (int) $request->AlertConsumable,
        ]);

        DB::table('CategoryItem')->where('ItemId', $id)->delete();
        if ($request->Category) {
            foreach ($request->Category as $category) {
                $data = [
                    'ItemId' => $id,
                    'CategoryId' => $category,
                ];
                DB::table('CategoryItem')->insert($data);
            }
        }
        return redirect()->route('item.index')->with('success', 'Item has been updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data = Item::where('ItemId', $id);
        $data->update(['IsPermanentDelete' => 1]);
        return redirect()->route('item.index')->with('success', 'Item has been deleted');
    }

    public function activate($id)
    {
        $data = Item::where('ItemId', $id)->first();
        if ($data->Active == 1) {
            Item::where('ItemId', $id)->update(['Active' => 0]);
        } else {
            Item::where('ItemId', $id)->update(['Active' => 1]);
        }
        return redirect()->route('item.index')->with('success', 'Status has been updated');
    }
}
