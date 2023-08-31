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
use Illuminate\Support\Facades\File;
use App\Exports\ItemTemplate;
use App\Imports\Items;
use Excel;
use Illuminate\Support\Facades\Storage;

class itemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $item  = Item::where('IsPermanentDelete', 0)->get();
            return DataTables::of($item)
                ->addColumn('Status', function ($row) {
                    return Button::status($row->Active);
                })
                ->addColumn('Code', function ($row) {
                    return $row->Code;
                })
                ->addColumn('ItemBehavior', function ($row) {
                    $res = "";
                    if ($row['ItemBehavior'] == 1) {
                        $res .= 'Hour Usage Monitor';
                    } else if ($row['ItemBehavior'] == 2) {
                        $res .= 'Consumable';
                    } else if ($row['ItemBehavior'] == 3) {
                        $res .= 'Non Consumable';
                    }
                    if ($row['ItemBehavior'] == 1) {
                        $res .= " (".$row['AlertHourMaintenance'] . ' Hour)';
                    } else if ($row['ItemBehavior'] == 2) {
                        $res .= " (".$row['AlertConsumable'] . ' Unit)';
                    } else if ($row['ItemBehavior'] == 3) {
                        $res .= '';
                    }
                    return $res;
                })
                ->addColumn('Alert', function ($row) {
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
        session()->pull('temp-file', 'default');
        session(['temp-file' => []]);
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
        $request->validate(
            [
                'Name' => 'required',
                'Unit' => 'required',
                'Code' => 'required',
            ]
        );

        $uuid = (string) Str::uuid();
        $data = [
            'ItemId' => $uuid,
            'Code' => request('Code'),
            'Name' => request('Name'),
            'Unit' => request('Unit'),
            'UseType' => request('UseType'),
            'ItemBehavior' => (int) request('ItemBehavior'),
            'AlertHourMaintenance' => (int) request('AlertHourMaintenance'),
            'AlertConsumable' => (int) request('AlertConsumable'),
            'IsPermanentDelete' => 0,
            'CreatedBy' => session('user')->UserId,
            'CreatedByLocation' => 11,
            'UpdatedBy' => session('user')->UserId,
            'Active' => 1
        ];

        Item::create($data);
        foreach ($request->Category as $category) {
            $data = [
                'ItemId' => $data['ItemId'],
                'CategoryId' => $category,
            ];
            DB::table('CategoryItem')->insert($data);
        }

        //insert ke table ItemProcurementUpload
        $file = session('temp-file');
        foreach ($file as $file) {
            $filepath = ('images/item/'.$uuid.'/'.$file);
            $folderPath = public_path('images/item/'.$uuid);
            if (!File::isDirectory($folderPath)) File::makeDirectory($folderPath, $mode = 0777, true, true);

            $dataFile = [
                'ItemUploadId' => (string) Str::uuid(),
                'ItemId' => $uuid,
                'FilePath' => $filepath,
                'UploadedBy' => session('user')->Fullname,
            ];

            DB::table('ItemUpload')->insert($dataFile);
            File::move(public_path('/images/temp/'.$file), public_path($filepath));
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
        $uploads = DB::table('ItemUpload')->where('ItemId', $id)->get();

        session()->pull('temp-file', 'default');
        session(['temp-file' => []]);

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
        return view('Item.edit', compact('item', 'selectedCategory', 'unselectedCategory', 'uploads'));
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
            'UseType' => $request->UseType,
            'ItemBehavior' => (int) $request->ItemBehavior,
            'AlertHourMaintenance' => (int) $request->AlertHourMaintenance,
            'AlertConsumable' => (int) $request->AlertConsumable,
            'UpdatedBy' => session('user')->UserId,
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

        //insert ke table ItemProcurementUpload
        $file = session('temp-file');
        foreach ($file as $file) {
            $filepath = ('images/item/'.$id.'/'.$file);
            $folderPath = public_path('images/item/'.$id);
            if (!File::isDirectory($folderPath)) File::makeDirectory($folderPath, $mode = 0777, true, true);

            $dataFile = [
                'ItemUploadId' => (string) Str::uuid(),
                'ItemId' => $id,
                'FilePath' => $filepath,
                'UploadedBy' => session('user')->Fullname,
            ];

            DB::table('ItemUpload')->insert($dataFile);
            File::move(public_path('/images/temp/'.$file), public_path($filepath));
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
        $file = DB::table('ItemUpload')->where('ItemUploadId', $id)->first();
        unlink(public_path($file->FilePath));
        DB::table('ItemUpload')->where('ItemUploadId', $id)->delete();
        return response()->json(['message' => 'File deleted successfully'], 200);
    }

    public function template()
    {
        return Excel::download(new ItemTemplate(), 'item template.xlsx');
    }

    public function import (Request $r) {
        $r->validate([ 'file'=>'required|file|mimes:xlsx', ]);
        $file = $r->file('file');
        $name = Str::uuid() ."-". Str::replace(" ","",$file->getClientOriginalName());
        Storage::putFileAs('public', $file, $name);
        Excel::import(new Items, $name, "public");
        return redirect()->route('item.index')->with('success', 'Items has been imported');
    }
}
