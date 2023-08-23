<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Location;
use App\Models\Menu;
use App\Models\Role;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

use function PHPUnit\Framework\returnSelf;

class RoleController extends Controller
{
    public function index(Request $request)
    {
        $role = Role::where('RoleId', session('user')->RoleId)->first();
        if ($role->RoleName == 'SuperAdmin') {
            if ($request->ajax()) {
                $role = Role::OrderBy('RoleId', 'asc')->get(); 
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
                            $btn .= '<a href="' . route('role.edits', $row->RoleId) . '" style="font-size: 20px" class="text-warning mr-10"><i class="lni lni-pencil-alt"></i></a>';
                            $btn .= '<a href="' . route('role.edit', $row->RoleId) . '" style="font-size: 20px" class="text-primary mr-10"><i class="lni lni-cog"></i></a>';
                        } elseif($row->IsEditable == 0) {
                            $btn .= '<a href="' . route('role.edits', $row->RoleId) . '" style="font-size: 20px" class="text-warning mr-10"><i class="lni lni-pencil-alt"></i></a>';
                            $btn .= '<a href="' . route('role.edit', $row->RoleId) . '" style="font-size: 20px" class="text-primary mr-10"><i class="lni lni-cog"></i></a>';
                            $btn .= '<a href="' . route('role.destroy', $row->RoleId) . '" style="font-size: 20px" class="text-danger mr-10"><i class="lni lni-power-switch"></i></a>';
                        }
                    
                        return $btn;
                    })
                    ->rawColumns(['Action'])
                    ->make(true);
            }
            return view('Role.index');
        } elseif (Str::contains($role->RoleName, 'Admin Lokasi')){
            if ($request->ajax()) {
                $user = Role::where('RoleId', session('user')->RoleId)->first();
                $role = Role::where('LocationId', '!=', null)->where('LocationId', $user->LocationId)->whereNotIn('RoleName', ['Admin Lokasi'])->get(); // Use 'get()' to retrieve the results
                return DataTables::of($role)
                    ->addColumn('Location', function ($row) {
                        $location = Location::where('LocationId', $row->LocationId)->first();
                        return $location->Name;
                    })
                    ->addColumn('Action', function($row){
                        $btn = '';
                        if ($row->IsEditable == 1) {
                            $btn .= '<a href="' . route('role.edits', $row->RoleId) . '" style="font-size: 20px" class="text-warning mr-10"><i class="lni lni-pencil-alt"></i></a>';
                            $btn .= '<a href="' . route('role.edit', $row->RoleId) . '" style="font-size: 20px" class="text-primary mr-10"><i class="lni lni-cog"></i></a>';
                        } elseif($row->IsEditable == 0) {
                            $btn .= '<a href="' . route('role.edits', $row->RoleId) . '" style="font-size: 20px" class="text-warning mr-10"><i class="lni lni-pencil-alt"></i></a>';
                            $btn .= '<a href="' . route('role.edit', $row->RoleId) . '" style="font-size: 20px" class="text-primary mr-10"><i class="lni lni-cog"></i></a>';
                            $btn .= '<a href="' . route('role.destroy', $row->RoleId) . '" style="font-size: 20px" class="text-danger mr-10"><i class="lni lni-power-switch"></i></a>';
                        }
                    
                        return $btn;
                    })  
                    ->rawColumns(['Action'])
                    ->make(true);
            }
            return view('Role.index');
        }
    }


    public function createAdminLocal()
    {
        $location = Location::all();
        return view('Role.createAdminLocal', compact('location'));
    }

    public function createRoleLocation()
    {
        // $menu = Menu::where('MenuName', '!=', 'Kelola Lokasi')->where('MenuName', '!=', 'Kelola Role')->where('MenuName', '!=', 'Master Data')->get();
        $menu = Menu::whereNotIn('MenuName', ['Kelola Lokasi', 'Kelola Role', 'Master Data', 'Kelola Admin Lokasi', 'Kelola Role Menu', 'Kelola Menu'])->get();  
        $location = Location::all();
        return view('role.createRoleLocation', compact('menu', 'location'));
    }
    public function storeRoleLocation(Request $request)
    {
        $user = session('user');
        $location = Role::where('RoleId', $user['RoleId'])->first();
        $request ->validate([
            'RoleName' => 'required',
        ]);
    if(session('user')->RoleName == 'SuperAdmin'){
        $data = [
            'RoleName' => $request->RoleName,
            'LocationId' => request('LocationId'),
            'IsEditable' => 1, 
        ];
        Role::create($data);
        return redirect()->to('role.index')->withToastSucces('Role Berhasil Ditambahkan');
        }else{
            $data = [
                'RoleName' => $request->RoleName,
                'LocationId' => $location->LocationId,
                // 'LocationId' => request('LocationId'),
                'IsEditable' => 1, 
            ];
            Role::create($data);
            return redirect()->to('role')->withToastSucces('Role Berhasil Ditambahkan');
    }
    }   

    public function storeAdminLocal(Request $request)
    {
        $request -> validate([
            'LocationId' => 'required',
        ]);
        $data =[
            'RoleName' => 'Admin Lokasi',
            'LocationId' => $request->LocationId,  
            'IsEditable'=> 0,
        ];

        Role::create($data);
        return redirect()->to('dashboard')->withToastSucces('Role Berhasil Ditambahkan');

    }

    public function edit(Request $request, $id)
    {
        $role = Role::where('RoleId', $id)->first();

        $menu = Menu::leftJoin('RoleMenu', function ($join) use ($id) {
            $join->on('Menu.MenuId', '=', 'RoleMenu.MenuId')
                ->where('RoleMenu.RoleId', '=', $id);
        })->whereNotIn('Menu.MenuId', [2, 3, 4])
        ->select('Menu.*', 'RoleMenu.RoleId AS RoleId')
        ->get();
        // dd($menu);
        $roleMenus = $menu->pluck('RoleId');
    
        return view('role.edit', compact('role', 'menu', 'roleMenus'));
    }

    public function update(Request $request, $menuId, $roleId)
{
    $rolemenu = DB::table('RoleMenu')
        ->where('RoleId', $roleId)
        ->where('MenuId', $menuId)
        ->first();

    if ($rolemenu) {
        // Remove menu from the role menu
        DB::table('RoleMenu')
            ->where('RoleId', $roleId)
            ->where('MenuId', $menuId)
            ->delete();
    } else {
        // Add menu to the role menu
        DB::table('RoleMenu')
            ->insert(['RoleId' => $roleId, 'MenuId' => $menuId]);
    }

    return response()->json(['success' => true]);
}

public function edits($id)
{
    $role = Role::where('RoleId', $id)->first();
    $location = Location::where('LocationId', $role->LocationId)->first();
    $locations = Location::all();
    if($role)
    {
        return view('Role.edits', compact('role', 'locations', 'location'));
    }
}

public function destroy($id)
{
    $role = Role::where('RoleId', $id)->first();
    if(session('user')->RoleId == $role->RoleId){
        // dd(session('user')->RoleId == $role->RoleId);
        return redirect()->route('role.index')->withToastError('Gagal Menghapus Data');
    }else{
        $role->delete();
        return redirect()->to('role.index')->withSuccessMessage('Berhasil Menghapus data');
    }
    
}

}