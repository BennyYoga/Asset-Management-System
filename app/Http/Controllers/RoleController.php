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



class RoleController extends Controller
{
    public function index(Request $request)
    {
        $role = Role::where('RoleId', session('user')->RoleId)->first();
        if ($role->RoleName == 'SuperAdmin') {
            if ($request->ajax()) {
                $role = Role::where('LocationId', '!=', null)->get(); // Use 'get()' to retrieve the results
                return DataTables::of($role)
                    ->addColumn('Location', function ($row) {
                        $location = Location::where('LocationId', $row->LocationId)->first();
                        return $location->Name;
                    })
                    ->make(true);
            }
            return view('Role.index');
        } elseif ($role->RoleName == 'Admin Local') { // Use 'elseif' instead of 'else'
            if ($request->ajax()) {
                $user = Role::where('RoleId', session('user')->RoleId)->first();
                $role = Role::where('LocationId', '!=', null)->where('LocationId', $user->LocationId)->get(); // Use 'get()' to retrieve the results
                return DataTables::of($role)
                    ->addColumn('Location', function ($row) {
                        $location = Location::where('LocationId', $row->LocationId)->first();
                        return $location->Name;
                    })
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
    if(session('user')->RoleId ==1){
        $data = [
            'RoleId' => (string) Str::uuid(), 
            'RoleName' => $request->RoleName,
            'LocationId' => request('LocationId'),
            'IsEditable' => 1, 
        ];
        Role::create($data);
        foreach ($request->Menu as $menu) {
            $data = [
                'RoleId' => $data['RoleId'],
                'MenuId' => $menu,
            ];
            DB::table('RoleMenu')->insert($data);
        }
        return redirect()->to('dashboard')->withToastSucces('Role Berhasil Ditambahkan');
        }else{
            $data = [
                'RoleId' => (string) Str::uuid(), 
                'RoleName' => $request->RoleName,
                'LocationId' => $location->LocationId,
                // 'LocationId' => request('LocationId'),
                'IsEditable' => 1, 
            ];
            Role::create($data);
            foreach ($request->Menu as $menu) {
                $data = [
                    'RoleId' => $data['RoleId'],
                    'MenuId' => $menu,
                ];
                DB::table('RoleMenu')->insert($data);
            }
            return redirect()->to('dashboard')->withToastSucces('Role Berhasil Ditambahkan');
    }
    }   

    public function storeAdminLocal(Request $request)
    {
        $request -> validate([
            'LocationId' => 'required',
        ]);
        $data =[
            'RoleId' => (String) str::uuid(),
            'RoleName' => 'Admin Local',
            'LocationId' => request('LocationId'),
            'IsEditable'=> 0,
        ];

        Role::create($data);
        return redirect()->to('dashboard')->withToastSucces('Role Berhasil Ditambahkan');

    }

    public function edit($id)
    {
        $role = Role::where('RoleId', $id)->first();
        if($role){
            return view('category.edit', compact('category', 'categories'));
        }return redirect()->to('category.index')->withToastError('Data tidak ditemukan');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'RoleName' => 'required',
        ]);
    }
}