<?php

namespace App\Http\Controllers;

use App\Models\Item;
use Illuminate\Support\Facades\DB;
use App\Models\Category;
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
            $item  = Item::where('IsPermanentDelete', 0)->get();
            return DataTables::of($item)
                ->addColumn('Status', function ($row) {
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
                    if ($row->Active == 1) {
                        $btn = '<a href=' . route('item.edit', $row->ItemId) . ' style="font-size:20px" class="text-warning mr-10"><i class="lni lni-pencil-alt"></i></a>';
                        $btn .= '<a href=' . route('item.activate', $row->ItemId) . ' style="font-size:20px" class="text-danger mr-10"><i class="lni lni-power-switch"></i></a>';
                        return $btn;
                    } else if ($row->Active == 0) {
                        $btn .= '<a href=' . route('item.activate', $row->ItemId) . ' style="font-size:20px" class="text-primary mr-10"><i class="lni lni-power-switch"></i></a>';
                        $btn .= '<a href=' . route('item.delete', $row->ItemId) . ' style="font-size:20px" class="text-danger mr-10"><i class="lni lni-trash-can"></i></a>';
                        return $btn;
                    }
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
        //
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
            'IsPermanentDelete' => 0,
            'CreatedBy' => 32,
            'CreatedByLocation' => 11,
            'UpdatedBy' => 32,
            'Active' =>request('Status')
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
        //
        // dd($id);

        Item::where('ItemId', $id)->update([
                'Name' => $request->Name,
                'Unit' => (int) $request->Unit,
                'ItemBehavior' => (int) $request->ItemBehavior,
                'AlertHourMaintenance' => (int) $request->AlertHourMaintenance,
                'AlertConsumable' => (int) $request->AlertConsumable,
                'Active' => (int) $request->Status,
            ]);

        // dd($request->Category);
        DB::table('CategoryItem')->where('ItemId', $id)->delete();
        if ($request->Category) {
            foreach ($request->Category as $category) {
                $data = [
                    'Uuid' => (string) Str::uuid(),
                    'ItemId' => $id,
                    'CategoryId' => $category,
                ];
                DB::table('CategoryItem')->insert($data);
            }
        }
        return redirect()->route('item.index')->withToastSuccess('Berhasil Mememperbaharui Data');
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
        return redirect()->route('item.index');
    }

    public function activate($id)
    {
        $data = Item::where('ItemId', $id)->first();
        if ($data->Active == 1) {
            Item::where('ItemId', $id)->update(['Active' => 0]);
        } else {
            Item::where('ItemId', $id)->update(['Active' => 1]);
        }
        return redirect()->route('item.index');
    }
}
