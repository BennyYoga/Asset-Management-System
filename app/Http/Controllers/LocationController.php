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
    public function index()
    {
        // if ($request->ajax()) {
        //     $location = Location::all();
        //     return DataTables::of($location)
        //         ->addIndexColumn()
        //         ->addColumn('action', function ($row) {
        //             // $btn = '<a href=' . route('pegawai.edit', $row->id_pegawai) . ' style="font-size:20px" class="text-warning mr-10"><i class="lni lni-pencil-alt"></i></a>';
        //             // $btn .= '<a href=' . route('pegawai.destroy', $row->id_pegawai) . ' style="font-size:20px" class="text-danger mr-10" data-bs-toggle="modal" data-bs-target="#staticBackdrop" id="hapusBtn"><i class="lni lni-trash-can"></i></a>';
        //             // return $btn;
        //         // ->make(true);
        // });
        // }
        $location = Location::all();
        return view('Location.index', compact('location'));
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
     * Display the specified resource.
     *
     * @param  \App\Models\Location  $location
     * @return \Illuminate\Http\Response
     */
    public function show(Location $location)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Location  $location
     * @return \Illuminate\Http\Response
     */
    public function edit($LocationId)
    {
        $location = Location::where('LocationId', $LocationId)->first();
        // dd($location);
        if (!$location) {
            return redirect()->back()->with('error', 'Location not found');
        }
        return view('Location.edit', compact('location'));
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
        Location::where('LocationId', $LocationId)->update($data);



        return redirect()->route('location.index')->with('success', 'Lokasi berhasil diubah.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Location  $location
     * @return \Illuminate\Http\Response
     */
    public function destroy(Location $location)
    {
        //
    }
}
