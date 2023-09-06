<?php

namespace App\Http\Controllers;

use App\Models\Location;
use App\Models\Menu;
use App\Models\Role;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Database\QueryException;

use function PHPUnit\Framework\returnSelf;

class RoleController extends Controller
{
    public function index(Request $request)
    {
        $role = Role::where('RoleId', session('user')->RoleId)->first();
        $locations = Location::all();
        if ($role->RoleName == 'SuperAdmin') {
            if ($request->ajax()) {
                $role = Role::OrderBy('IsEditable', 'asc')->get();
                return DataTables::of($role)
                    ->addColumn('Location', function ($row) {
                        $location = Location::where('LocationId', $row->LocationId)->first();
                        if($location){
                            return $location->Name;
                        }else{
                            return '-';
                        }
                    })
                    ->addColumn('Action', function($row){
                        $btn = '';
                        if ($row->IsEditable == 1) {
                            $btn = '<a href="javascript:void(0)" data-id="'.$row->RoleId.'" class="editProduct text-warning mr-10" style="font-size: 20px" data-toggle="tooltip" data-original-title="Edit"><i class="lni lni-pencil-alt"></i></a>';
                            $btn .= '<a href="' . route('role.edit', $row->RoleId) . '" style="font-size: 20px" class="text-primary mr-10"><i class="lni lni-cog"></i></a>';
                            $btn .= '<a href=' . route('role.destroy', $row->RoleId) . ' style="font-size:20px" class="text-danger mr-10" onClick="notificationBeforeChange(event,this)" ><i  class="lni lni-trash-can""></i></a>';

                            // $btn .= '<a href="' . route('role.destroy', $row->RoleId) . '" style="font-size: 20px" class="text-danger mr-10"><i  class="lni lni-trash-can""></i></a>';
                        } elseif($row->IsEditable == 0) {
                            $btn .= '<a href="' . route('role.edit', $row->RoleId) . '" style="font-size: 20px" class="text-primary mr-10"><i class="lni lni-cog"></i></a>';
                        }
                    
                        return $btn;
                    })
                    ->rawColumns(['Action'])
                    ->make(true);
            }
            return view('Role.index', compact('locations'));
        } elseif (Str::contains($role->RoleName, 'Admin Lokasi')){
            if ($request->ajax()) {
                $user = Role::where('RoleId', session('user')->RoleId)->first();
                $role = Role::where('LocationId', '!=', null)->where('LocationId', $user->LocationId)->OrderBy('IsEditable', 'asc')->get();
                return DataTables::of($role)
                    ->addColumn('Location', function ($row) {
                        $location = Location::where('LocationId', $row->LocationId)->first();
                        return $location->Name;
                    })
                    ->addColumn('Action', function($row){
                        $btn = '';
                        if ($row->IsEditable == 1) {
                            $btn .= '<a href="javascript:void(0)" data-id="'.$row->RoleId.'" class="editProduct text-warning mr-10" style="font-size: 20px" data-toggle="tooltip" data-original-title="Edit"><i class="lni lni-pencil-alt"></i></a>';
                            $btn .= '<a href="' . route('role.edit', $row->RoleId) . '" style="font-size: 20px" class="text-primary mr-10"><i class="lni lni-cog"></i></a>';
                            $btn .= '<a href=' . route('role.destroy', $row->RoleId) . ' style="font-size:20px" class="text-danger mr-10" onClick="notificationBeforeChange(event,this)" ><i  class="lni lni-trash-can""></i></a>';
                            // $btn .= '<a href="' . route('role.destroy', $row->RoleId) . '" style="font-size: 20px" class="text-danger mr-10"><i class="lni lni-trash-can""></i></a>';

                        } elseif($row->IsEditable == 0) {
                            $btn .= '<a href="' . route('role.edit', $row->RoleId) . '" style="font-size: 20px" class="text-primary mr-10"><i class="lni lni-cog"></i></a>';
                        }
                    
                        return $btn;
                    })  
                    ->rawColumns(['Action'])
                    ->make(true);
            }
            return view('Role.index');
        }
    }


    public function createRoleLocation()
    {
        // $menu = Menu::where('MenuName', '!=', 'Kelola Lokasi')->where('MenuName', '!=', 'Kelola Role')->where('MenuName', '!=', 'Master Data')->get();
        // $menu = Menu::whereNotIn('MenuName', ['Kelola Lokasi', 'Kelola Role', 'Master Data', 'Kelola Admin Lokasi', 'Kelola Role Menu', 'Kelola Menu'])->get();  
        $location = Location::all();
        return view('role.createRoleLocation', compact('location'));
    }
    public function storeRoleLocation(Request $request)
    {
        $user = session('user');
        $location = Role::where('RoleId', $user['RoleId'])->first();
        $request ->validate([
            'RoleName' => 'required',
            'LocationId'=> 'required',
        ]);
    if(session('role')->RoleId == 1){
        $data = [
            'RoleName' => $request->RoleName,
            'LocationId' => $request->LocationId,
            'IsEditable' => 1,
        ];
        Role::create($data);
        return redirect()->route('role.index')->with('success', 'Data Created');
        
        }else{
            $data = [
                'RoleName' => $request->RoleName,
                'LocationId' => $location->LocationId,
                'IsEditable' => 1,
            ];
            Role::create($data);
            return redirect()->route('role.index')->with('success', 'Data Created');

    }
    }   


    public function edit(Request $request, $id)
    {
        $role = Role::where('RoleId', $id)->first();

        $menu = Menu::leftJoin('RoleMenu', function ($join) use ($id) {
            $join->on('Menu.MenuId', '=', 'RoleMenu.MenuId')
                ->where('RoleMenu.RoleId', '=', $id);
        })
        ->select('Menu.*', 'RoleMenu.RoleId AS RoleId')
        ->get();
        $roleMenus = $menu->pluck('RoleId');
        $parentMenus = Menu::whereIn('MenuId', $menu->pluck('ParentId')->toArray())
        ->select('MenuId', 'MenuName')
        ->get()
        ->keyBy('MenuId'); 
    
        return view('role.edit', compact('role', 'menu', 'roleMenus', 'parentMenus'));
    }

    public function update(Request $request, $menuId, $roleId)
{
    $rolemenu = DB::table('RoleMenu')
        ->where('RoleId', $roleId)
        ->where('MenuId', $menuId)
        ->first();

    if ($rolemenu) {
        DB::table('RoleMenu')
            ->where('RoleId', $roleId)
            ->where('MenuId', $menuId)
            ->delete();
    } else {
        DB::table('RoleMenu')
            ->insert(['RoleId' => $roleId, 'MenuId' => $menuId]);
    }

    return response()->json(['success' => true]);
}

public function edits($id)
{
    $role = Role::where('RoleId', $id)->first();
    if ($role) {
        return response()->json($role);
    } else {
        return response()->json(['error' => 'Menu not found']);
    }
}

public function updates(Request $request) 
{
    $request->validate([
        'RoleName' => 'required',
    ]);
    $location = Role::where('RoleId', session('user')->RoleId)->first();

    if(session('role')->RoleId == 1){
    $data = [
        'RoleName' => $request->RoleName,
        'LocationId' => $request->LocationId,
    ];
    }else{
        $data =[
        'RoleName' => $request->RoleName,
        'LocationId' => $location->LocationId,
        ];
    }
    // dd($data);
    Role::where('RoleId','=',$request->post('RoleId'))->update($data);

    return redirect()->route('role.index')->with('success', 'Data updated');
}

public function destroy($id)
{
    try{
    $role = Role::where('RoleId', $id)->first();
    if(session('user')->RoleId == $role->RoleId){
        // dd(session('user')->RoleId == $role->RoleId);
    return redirect()->route('role.index')->with('error', 'Delete Failed');
    }else{
        // if(session('role')->RoleId == 1){
        //     return redirect()->route('role.index')->with('error', 'Delete Failed');
        // }
        Role::where('RoleId', $id)->delete();
        // $role->delete();
        return redirect()->route('role.index')->with('success', 'Data Deleted');
    }
    }catch (QueryException $e) {    
        return redirect()->route('role.index')->with('error', 'Delete Failed');

}
    
}

}