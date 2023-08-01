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
        if ($request->ajax()) {
            $location = UserModel::all();
            return DataTables::of($location)
                ->addIndexColumn()
                ->addColumn('Role', function ($row) {
                    $Role = Role::where('RoleId', $row->RoleId)->first();
                    return $Role->RoleName;
                })
                ->make(true);
        }
        return view('User.index');
    }
    public function create()
    {
        $role = Role::where('RoleId', session('user')->RoleId)->first();
        $locations = Location::where('LocationId', $role->LocationId)->first();
    
        if ($role) {
            if ($role->RoleName == 'SuperAdmin') {
                $location = Role::WhereNotIn('RoleName', ['SuperAdmin'])->get();
                return view('User.create', compact('location', 'locations'));
            } else {
                $location = Role::where('LocationId', $role->LocationId)
                                ->whereNotIn('RoleName', ['Admin Local', 'SuperAdmin'])
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
