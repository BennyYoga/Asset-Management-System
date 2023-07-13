<?php

namespace App\Http\Controllers;

use App\Models\Location;
use App\Models\Project;
use GuzzleHttp\Handler\Proxy;
use Illuminate\Cache\Lock;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Yajra\DataTables\Facades\DataTables;



class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        
        if ($request->ajax()) {
            $project = Project::where('IspermanentDelete', 0)->get();
            return DataTables::of($project)
                ->addColumn('action', function ($row) {
                    $btn = '';
                    $today = date('Y-m-d');
                        // $btn = '<a href=' . route('project.edit', $row->ProjectId) . ' style="font-size:20px" class="text-warning mr-10"><i class="lni lni-pencil-alt"></i></a>';
                        if ($row->Active == 1) {
                        // $btn = '<a href=' . route('project.edit', $row->ProjectId) . ' style="font-size:20px" class="text-warning mr-10"><i class="lni lni-pencil-alt"></i></a>';
                            $btn .= '<a href=' . route('project.activate', $row->ProjectId) . ' style="font-size:20px" class="text-danger mr-10"><i class="lni lni-power-switch"></i></a>';
                            return $btn;
                        } else if ($row->Active == 0) {
                            $btn .= '<a href=' . route('project.activate', $row->ProjectId) . ' style="font-size:20px" class="text-primary mr-10"><i class="lni lni-power-switch"></i></a>';
                            $btn .= '<a href=' . route('project.destroy', $row->ProjectId) . ' style="font-size:20px" class="text-danger mr-10"><i class="lni lni-trash-can"></i></a>';
                            return $btn;
                        }
                })
                ->addColumn('Location', function ($row) {
                    $location = Location::where('LocationId', $row->LocationId)->first();
                    return $location->Name;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('project.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $location = Location::all();
        return view('Project.create', compact('location'));
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
            'Name' => 'required',
            'StartDate'=> 'required',
            'EndDate'=> 'required', 
        ]);
        $data= [
            'ProjectId' => (string) Str::uuid(),
            'Name'=> request('Name'),
            'StartDate'=>request('StartDate'),
            'EndDate' => request('EndDate'),
            'LocationId'=>request('LocationId'),
            'Active'=> 1,
            'IsPermanentDelete' => 0,
            'CreatedBy' => 'lala',
            'UpdatedBy' => 'lala',
        ];
        Project::create($data);
        return redirect()->route('project.index')->withToastSuccess('Berhasil Menambah Data');
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
        return view('Dashboard.index');
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
        $data = Project::where('ProjectId', $id);
        $data->update(['IsPermanentDelete' => 1]);
        return redirect()->route('project.index');
    }
    public function activate($id)
    {
        $data = Project::where('ProjectId', $id)->first();
        $today = date('Y-m-d');
        if ($today < $data['EndDate']){
        if ($data->Active == 1) {
            Project::where('ProjectId', $id)->update(['Active' => 0]);
        } else {
            Project::where('ProjectId', $id)->update(['Active' => 1]);
        }}
        else{
            return redirect()->route('project.index')->withToastError('Tanggal Sudah Kadaluwarsa');
        }
        return redirect()->route('project.index');

    }
}
