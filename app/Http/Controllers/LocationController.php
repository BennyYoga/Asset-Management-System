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
            $location = Location::where("IsPermanentDelete", 0);
            return DataTables::of($location)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $editBtn = '<a href=' . route('location.edit', $row->LocationId) . ' style="font-size:20px" class="text-warning mr-10"><i class="lni lni-pencil-alt"></i></a>';
                    if ($row->Active == 1) {
                        $deactivateBtn = '<a href=' . route('location.deactivate', $row->LocationId) . ' style="font-size:20px" class="text-danger mr-10"><i class="lni lni-cross-circle"></i></a>';
                        return $editBtn . $deactivateBtn;
                    } else {
                        $activateBtn = '<a href=' . route('location.activate', $row->LocationId) . ' style="font-size:20px" class="text-success mr-10"><i class="lni lni-checkmark-circle"></i></a>';
                        $deleteBtn = '<a href=' . route('location.destroy', $row->LocationId) . ' style="font-size:20px" class="text-danger mr-10" data-bs-toggle="modal" data-bs-target="#staticBackdrop" id="hapusBtn"><i class="lni lni-trash-can"></i></a>';
                        return $editBtn . $activateBtn . $deleteBtn;
                    }
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
        ]);

        $data = [
            'ParentId' => $request->ParentId,
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
                $checkDelete = Location::where('ParentId', $location->LocationId)
                ->where('IsPermanentDelete', 1)
                ->exists();
                if ($checkDelete) {
                    $location['IsPermanentDelete'] = 1;
                    $location->update();
                    return redirect()->route('category.index')->withToastSuccess('Berhasil Menghapus Data');
                }
                return redirect()->route('category.index')->withToastError('Tidak dapat menghapus');
            // return redirect()->back()->with('error', 'Tidak dapat menghapus kantor yang memiliki anak cabang.');
        }
        $location['IsPermanentDelete'] = 1;
        $location->update();
        // $location->delete();
        return redirect()->route('location.index')->with('success', 'Lokasi berhasil dihapus.');
    }

    public function activate($LocationId)
    {
        $location = Location::findOrFail($LocationId);
        $location->Active = 1;
        $location->save();

        return redirect()->route('location.index')->with('success', 'Location activated successfully.');
    }

    public function deactivate($LocationId)
    {
        $location = Location::findOrFail($LocationId);
        $location->Active = 0;
        $location->save();

        return redirect()->route('location.index')->with('success', 'Location deactivated successfully.');
    }
}   
