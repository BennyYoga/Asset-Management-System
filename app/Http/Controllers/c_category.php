<?php

namespace App\Http\Controllers;

use App\Models\m_category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Redis;
use Psy\CodeCleaner\ReturnTypePass;
use Illuminate\Support\Str;

class c_category extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $category = m_category::all();
            return DataTables::of($category)
                ->addColumn('Active', function ($row) {
                    return $row->Active == 0 ? 'Nonactive' : 'Active';
                })
                ->addColumn('action', function ($row) {
                    $btn = '<a href=' . route('category.edit', $row->CategoryId) . ' style="font-size:20px" class="text-warning mr-10"><i class="lni lni-pencil-alt"></i></a>';
                    $btn .= '<a href=' . route('category.destroy', $row->CategoryId) . ' style="font-size:20px" class="text-danger mr-10" data-bs-toggle="modal" data-bs-target="#staticBackdrop" id="hapusBtn"><i class="lni lni-trash-can"></i></a>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('category.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $category = m_category::all();
        return view('category.create', compact('category'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminat'IsPermanentDelete']=0;
     * 
     * dd($data)
     */
    public function store(Request $request)
    {
        
        $request->validate(
            [
            'Name' => 'required',
            'Active' => 'required',
            ]
        );
        $data =[
            'CategoryId' =>(String)Str::uuid(),
            'Name' => $request->Name,
            'Active' => $request->Active,
            'IsPermanentDelete' => 0,
            'ParentId' => $request->ParentId,
        ];
        // $user = Auth::user();
        // $data['CreatedBy'] = $user;
        // $data['UpdatedBy'] = $user;
        $data['CreatedBy'] = 'lala';
        $data['UpdatedBy'] = 'lala';
        m_category::create($data);
        return redirect()->route('category.index')->withToastSuccess('Berhasil');
        
        
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
    public function edit($CategoryId)
    {
        $category = m_category::findorfail($CategoryId);
        return view('category.edit', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $CategoryId)
    {
        $request->validate(
            [
            'Name' => 'required',
            'Active' => 'required',
            ]
        );
        $data =[
            'CategoryId' =>(String)Str::uuid(),
            'Name' => $request->Name,
            'Active' => $request->Active,
            'IsPermanentDelete' => $request->IsPermanentDelete,
            // 'ParentId' => $request->ParentId,
        ];
        // $user = Auth::user();
        // $data['CreatedBy'] = $user;
        // $data['UpdatedBy'] = $user;
        $data['CreatedBy'] = 'lala';
        $data['UpdatedBy'] = 'lala';
        m_category::find($CategoryId)->update($data);
        return redirect()->route('category.index')->withToastSuccess('Berhasil');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($CategoryId)
    {
        $category = m_category::find($CategoryId);
        $category->delete();
        return redirect()->route('category.index')->withToastSuccess('Berhasil');
    }
}
