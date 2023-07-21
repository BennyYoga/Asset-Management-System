<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Location;
use App\Models\Menu;
use App\Models\Role;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    public function index()
    {

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
        return view('role.createRoleLocation', compact('menu'));
    }
    public function storeRoleLocation(Request $request)
    {
        $user = session('user');
        $location = Role::where('RoleId', $user['RoleId'])->first();
        $request ->validate([
            'RoleName' => 'required',
            // 'MenuId' => 'required',
        ]);
        $data = [
            'RoleId' => (string) Str::uuid(), 
            'RoleName' => $request->RoleName,
            'LocationId' => $location->LocationId,
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
}