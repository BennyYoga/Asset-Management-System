<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\Role;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use function PHPUnit\Framework\returnSelf;

class MenuController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $menu = Menu::orderBy('MenuId', 'asc')->get();
            return DataTables::of($menu)
                ->addColumn('action', function ($row) {
                    $btn = '<a href=' . route('menu.edit', $row->MenuId) . ' style="font-size:20px" class="text-warning mr-10"><i class="lni lni-pencil-alt"></i></a>';
                    return $btn;
                })
                ->addColumn('Parent', function($row){
                    $parent = Menu::where('MenuId', $row->ParentId)->first();
                    return $parent ?$parent->MenuName : '';
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('menu.index');
    }

    /**
     * Show the form for creating a new resource.
     *
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
        $menu = Menu::where('MenuId', $id)->first();
        $parent =Menu::where('MenuId', $menu->ParentId)->first();
        if($menu){
        return view ('menu.edit', compact('menu', 'parent'));
        }else{
            return redirect()->back()->with('error', 'Menu Tidak ditemukan');
        }
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
        $request->validate([
            'MenuName' => 'required', 
            'MenuDesc' => 'required',
        ]);

        $data = [
            'MenuName' => request('MenuName'),
            'MenuDesc' => request('MenuDesc'), 
            'MenuIcon'=>request('MenuIcon'),
        ];
        // dd($data);
        $menu = Menu::where('MenuId', $id)->first();
        if($menu){
            Menu::where('MenuId', $id)->update($data);
            return redirect()->route('menu.index')->withToastSuccess('Data has been updated');
        }else
        return redirect()->route('menu.index')->withToastError('Failed');
    }

}
