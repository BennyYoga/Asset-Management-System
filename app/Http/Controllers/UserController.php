<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\Location;
use App\Models\UserModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Auth;


class UserController extends Controller
{
    public function index(Request $request)
    {
        // dd(UserModel::where('RoleId', 17)->first()->UserId);
        if ($request->ajax()) {
            if (session('role')->RoleName == 'SuperAdmin') {
                $users = UserModel::whereHas('fk_role', function ($query) {
                    $query->whereHas('fk_location', function ($query) {
                        $query->whereNotNull('LocationId');
                    });
                })
                ->get();
            } elseif (Str::contains(session('role')->RoleName, 'Admin Lokasi')) {
                $users = UserModel::whereHas('fk_role', function ($query) {
                    $query->whereHas('fk_location', function ($query) {
                        $query->where('LocationId', session('role')->LocationId);
                    });
                })
                ->whereHas('fk_role', function ($query) {
                    $query->where('IsEditable', 1);
                })
                ->get();
            }
            return DataTables::of($users)
                ->addIndexColumn()
                ->addColumn('Role', function ($row) {
                    return $row->fk_role->RoleName;
                })
                ->addColumn('Lokasi', function ($row) {
                    return $row->fk_role->fk_location->Name;
                })
                ->make(true);
        }
        
        return view('User.index');
    }
    

    public function admin_location(Request $request)
    {
        if ($request->ajax()) {
            $admins = UserModel::whereHas('fk_role', function ($query) {
                $query->where('RoleName', 'like', '%Admin Lokasi%');
            })->get();
        
            return DataTables::of($admins)
                ->addIndexColumn()
                ->addColumn('Role', function ($row) {
                    return $row->fk_role->RoleName;
                })
                ->addColumn('Location', function ($row) {
                    // $role = Role::whereHas('fk_location');
                    // $name = Location::where('RoleId', $role->RoleId);
                    return $row->fk_role->fk_location->Name;
                })
                ->make(true);
        }
        
        return view('User.adminlocal');
         // Use 'get()' to retrieve the results

    }
    public function create()
    {
        $role = Role::where('RoleId', session('user')->RoleId)->first();
        
        // $locations = Location::where('LocationId', $role->LocationId)->get();
        // dd($locations);
    
        if ($role) {
            if ($role->RoleName == 'SuperAdmin') {
                $location = Role::where('IsEditable', 1)->get();
                $locationIds = $location->pluck('LocationId')->toArray();

                // Mengambil lokasi-lokasi yang sesuai dengan LocationId yang ditemukan
                $locations = Location::whereIn('LocationId', $locationIds)->get();
                return view('User.create', compact('location', 'locations'));
            } else {
                $location = Role::where('LocationId', $role->LocationId)
                                ->whereNotIn('IsEditable', 1)
                                ->get();       
                return view('User.create', compact('location'));
            }
        } else {
            // Handle case when $role is null, e.g., show an error message or redirect.
            return redirect()->route('dashboard')->with('error', 'Role not found.');
        }
    }
    

    public function store(Request $request)
    {
        $request->validate([
            'Username' => 'required',
            'Fullname' => 'required',
            'Password' => 'required',
        ]);

        if($request->Password != $request->password_confirmation)
        {
            return redirect()->route('user.create')->with('error', 'Password tidak sesuai')->withInput();
        }else{
            $data = $request->all();    
            $data = [
                'UserId' => (string) Str::uuid(),
                'RoleId' => request('RoleId'),
                'Fullname' => request('Fullname'),
                'Active' => 1, 
                'IsPermanentDelete' => 0, 
                'CreatedBy' => session('user')->Fullname,
                'Username' => request('Username'),
                'Password' => Hash::make($request->Password),
            ];
        $checkusername = UserModel::where('Username', $data['Username'])->first();
        if($checkusername)
        {
            return redirect()->route('user.create')->with('error', 'Username sudah terdaftar');

        }else{
            dd($data);
        // dd($data['Password']);
        UserModel::create($data);
        return redirect()->route('dashboard.index')->with('success', 'Data berhasil ditambahkan');
        }
    }
    }

    public function store_admin(Request $request)
    {
        $request->validate([
            'Username' => 'required',
            'Fullname' => 'required',
            'Password' => 'required',
        ]);

        $data = $request->all();    
        $data = [
            'UserId' => (string) Str::uuid(),
            'RoleId' => request('RoleId'),
            'Fullname' => request('Fullname'),
            'Active' => 1, 
            'IsPermanentDelete' => 0, 
            'CreatedBy' => session('user')->Fullname,
            'Username' => request('Username'),
            'Password' => Hash::make($request->Password),
        ];
        $checkusername = UserModel::where('Username', $data['Username'])->first();
        if($checkusername)
        {
            return redirect()->route('user.create')->with('error', 'Username sudah terdaftar');

        }else{
        // dd($data['Password']);
        UserModel::create($data);
        return redirect()->route('dashboard.index')->with('success', 'Data berhasil ditambahkan');
        }
    }
    

    public function show($id)
    {

    }
    public function edit($id)
    {

    }
    public function update(Request $request)
    {

    }

    public function destroy($id)
    {
        
    }
}
