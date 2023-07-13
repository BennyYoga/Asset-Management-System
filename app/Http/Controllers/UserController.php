<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UserModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;



class UserController extends Controller
{
    public function index()
    {

    }
    public function create()
    {
        return view('User.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            // 'id_kantor' => 'required',
            'Username' => 'required',
            'Fullname' => 'required',
            'Password' => 'required'
        ]);
        $data = $request->all();
        if($data['Password'] != $data['Confirm']){
        return redirect('user/create')->withToastError('Password tidak sesuai')->withInput();
        }else{
        $data ['UserId'] = (string) Str::uuid();
        $data['RoleId'] = 2;
        $data['Active'] = 1; 
        $data ['IsPermanentDelete']=0;
        $data ['CreatedBy'] ='lala';
        $data['Password'] = Hash::make($request->password);
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
