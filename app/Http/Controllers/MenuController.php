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
                    $btn = '<a href="javascript:void(0)" data-id="'.$row->MenuId.'" class="editProduct text-warning mr-10" style="font-size: 20px" data-toggle="tooltip" data-original-title="Edit"><i class="lni lni-pencil-alt"></i></a>';
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
    public function edit($id)
    {
        $menu = Menu::where('MenuId', $id)->first();
        if ($menu) {
            return response()->json($menu);
        } else {
            return response()->json(['error' => 'Menu not found']);
        }
    }
    
    public function update(Request $request)
    {
        $request->validate([
            'MenuName' => 'required',
            'MenuDesc' => 'required',
        ]);
    
        // $menu = Menu::where('MenuId', $id)->first();
    
            $data =[
            'MenuName' => $request->MenuName,
            'MenuDesc' => $request->MenuDesc,
            'MenuIcon' => $request->MenuIcon
            ];
            // dd($data);
            Menu::where('MenuId','=',$request->post('MenuId'))->update($data);
            return redirect()->route('menu.index')->with('success', 'Menu Updated Successfully');
    }

}
