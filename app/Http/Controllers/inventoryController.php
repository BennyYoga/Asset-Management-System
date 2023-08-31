<?php

namespace App\Http\Controllers;

use App\Models\Location;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\DB;
use Excel;
use App\Exports\Sheets\InventoryTemplate;
use App\Imports\Sheets\InventorySheet;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class inventoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $req = DB::table('Inventory')
                ->when($request->loc,function($query) use($request) {
                    $query->where("LocationId",$request->loc);
                })
                ->get();
            return DataTables::of($req)
                ->addColumn('Location', function ($row) {
                    $lokasi = Location::where('LocationId', $row->LocationId)->first();
                    return $lokasi->Name;
                })
                ->addColumn('Item', function ($row) {
                    return $row->ItemName;
                })
                ->addColumn('Maintenance', function ($row) {
                    return $row->HourMaintenance;
                })
                ->addColumn('Qty', function ($row) {
                    return $row->ItemQty;
                })
                ->make(true);
        }

        return view('Inventory.index');
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

    public function template()
    {
        return Excel::download(new InventoryTemplate(), 'inventory template.xlsx');
    }

    public function import (Request $r) {
        $r->validate([ 'file'=>'required|file|mimes:xlsx', ]);
        $file = $r->file('file');
        $name = Str::uuid() ."-". Str::replace(" ","",$file->getClientOriginalName());
        Storage::putFileAs('public', $file, $name);
        Excel::import(new InventorySheet, $name, "public");
        return redirect()->route('inventory.index')->with('success', 'Inventory has been imported');
    }
}
