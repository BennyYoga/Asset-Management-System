<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
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
                // ->addColumn('action', function ($row) {
                //     $btn = '<a href=' . route('location.edit', $row->LocationId) . ' style="font-size:20px" class="text-warning mr-10"><i class="lni lni-pencil-alt"></i></a>';
                //     $btn .= '<a href=' . route('location.destroy', $row->LocationId) . ' style="font-size:20px" class="text-danger mr-10"><i class="lni lni-trash-can"></i></a>';
                //     return $btn;
                // })
                ->make(true);
        }
        return view('User.index');
    }
    public function create()
    {
        return view('User.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'Username' => 'required',
            'Fullname' => 'required',
            'Password' => 'required',
            'Confirm' => 'required|same:Password', // Menambahkan validasi untuk konfirmasi password yang sesuai
        ]);

        $data = $request->all();    
        $data['UserId'] = (string) Str::uuid();
        $data['RoleId'] = 4;
        $data['Active'] = 1;
        $data['IsPermanentDelete'] = 0;
        // $user = UserModel::where('Username', $credentials['Username'])->first();
        // $user = session('user'); // Mendapatkan informasi pengguna dari sesi
        // $user = UserModel::where('UserId', $user->UserId)->first();
        $data['CreatedBy'] = 'p';
        $data['Password'] = Hash::make($request->Password);
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
