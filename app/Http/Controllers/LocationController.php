<?php

namespace App\Http\Controllers;

use App\Models\Location;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Str;

class LocationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $location = Location::all();
            return DataTables::of($location)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $btn = '<a href=' . route('location.edit', $row->LocationId) . ' style="font-size:20px" class="text-warning mr-10"><i class="lni lni-pencil-alt"></i></a>';
                    $btn .= '<a href=' . route('location.destroy', $row->LocationId) . ' style="font-size:20px" class="text-danger mr-10"><i class="lni lni-trash-can"></i></a>';
                    return $btn;
                })
                ->make(true);
        }
        return view('Location.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $location = Location::all();
        return view('Location.form', compact('location'));
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
            'HaveProcurementProcess' => 'required',
            'Name' => 'required',
            'Active' => 'required',
        ]);

        $data = [
            'ParentId' => $request->ParentId,
            'LocationId' => (String)Str::uuid(),
            'IsPermanentDelete' => 0,
            'HaveProcurementProcess' => $request->HaveProcurementProcess,
            'Name' => $request->Name,
            'Active' => $request->Active,
        ];
        
        if ($request->input('ParentId') === '') {
            $data['ParentId'] = null; // Set nilai ParentId menjadi NULL
        }
        $data['CreatedBy'] = 123;
        $data['UpdatedBy'] = 123;
        // dd($request->ParentId);
        Location::create($data);


        return redirect()->route('location.index')->with('success', 'Lokasi berhasil ditambahkan.');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Location  $location
     * @return \Illuminate\Http\Response
     */
    public function edit($LocationId)
    {
        // $location = Location::where('LocationId', $LocationId)->first();
        $location = Location::find($LocationId);
        // dd($location);
        if (!$location) {
            return redirect()->back()->with('error', 'Location not found');
        }
        $locations = Location::where('LocationId', '!=', $LocationId)->get();
        return view('Location.edit', compact('location', 'locations'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Location  $location
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $LocationId)
    {
        $request->validate([
            'HaveProcurementProcess' => 'required',
            'Name' => 'required',
            'Active' => 'required',
        ]);

        $data = [
            'ParentId' => $request->ParentId,
            'LocationId' => (String)Str::uuid(),
            'IsPermanentDelete' => 0,
            'HaveProcurementProcess' => $request->HaveProcurementProcess,
            'Name' => $request->Name,
            'Active' => $request->Active,
        ];
        
        if ($request->input('ParentId') === '') {
            $data['ParentId'] = null; // Set nilai ParentId menjadi NULL
        }
        $data['CreatedBy'] = 123;
        $data['UpdatedBy'] = 123;
        // dd($request->ParentId);
        // Location::find($LocationId)->update($data);
        Location::find($LocationId)->update($data);
        
        return redirect()->route('location.index')->with('success', 'Lokasi berhasil diubah.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Location  $location
     * @return \Illuminate\Http\Response
     */
    public function destroy($LocationId)
    {
        $location = Location::find($LocationId);
        if (!$location) {
            return redirect()->back()->with('error', 'Lokasi tidak ditemukan.');
        }
        if ($location->ParentId === null) {
            return redirect()->back()->with('error', 'Tidak dapat menghapus Kantor Pusat.');
        }
        $hasChild = Location::where('ParentId', $location->LocationId)->exists();
            if ($hasChild) {
            return redirect()->back()->with('error', 'Tidak dapat menghapus kantor yang memiliki anak cabang.');
        }
        $location->delete();
        return redirect()->route('location.index')->with('success', 'Lokasi berhasil dihapus.');
    }
}   
