<?php

namespace App\Http\Controllers;

use App\Models\Location;
use App\Models\Role;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Str;
Use Button;
use Illuminate\Support\Facades\DB;

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
            $location = Location::where("IsPermanentDelete", 0)->get();
            return DataTables::of($location)
                ->addIndexColumn()
                ->addColumn('Status', function ($row) {
                    return Button::status($row->Active);
                })
                ->addColumn('Action', function ($row) {
                    $btn = [
                        "Edit" => route('location.edit', $row->LocationId),
                        "Href" => [
                            "url" => route("inventory.index")."?loc=".$row->LocationId,
                            "color" => "info",
                            "title" => "Inventory",
                            "icon" => "fa-solid fa-warehouse",
                        ],
                    ];
                    if ($row->Active == 1) {
                        $btn["Deactivate"] = route('location.activate', $row->LocationId);
                    } else if ($row->Active == 0) {
                        $btn["Activate"] = route('location.activate', $row->LocationId);
                        $btn["Delete"] = route('location.destroy', $row->LocationId);
                    }
                    return Button::Action($btn);
                })
                ->rawColumns(['Action', 'Status'])
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
        return view('Location.create', compact('location'));
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
        ]);

        $data = [
            'ParentId' => $request->ParentId,
            'LocationId' => (String)Str::uuid(),
            'IsPermanentDelete' => 0,
            'HaveProcurementProcess' => $request->HaveProcurementProcess,
            'Name' => $request->Name,
            'Active' => 1,
        ];

        if ($request->input('ParentId') === '') {
            $data['ParentId'] = null;
        }
        $data['CreatedBy'] = session('user')->Fullname;
        $data['UpdatedBy'] = session('user')->Fullname;
        $save = Location::create($data);
        $role =
        [
            'LocationId' => $save['LocationId'] ,
            'RoleName' => 'Admin Lokasi ('. $data['Name']. ')',
            'IsEditable' => 0,
        ];
        Role::create($role);
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
        ];

        if ($request->input('ParentId') === '') {
            $data['ParentId'] = null; // Set nilai ParentId menjadi NULL
        }
        $data['CreatedBy'] = session('user')->Fullname;
        $data['UpdatedBy'] = session('user')->Fullname;
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
        $data = Location::where('LocationId', $LocationId)->first();
        if ($data->Active == 1) {
            Location::where('LocationId', $LocationId)->update(['Active' => 0]);
        } else {
            Location::where('LocationId', $LocationId)->update(['Active' => 1]);
        }
        return redirect()->route('location.index');
    }
}
