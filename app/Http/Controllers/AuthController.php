<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\UserModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use RealRashid\SweetAlert\Facades\Alert;

class AuthController extends Controller
{
    public function index()
    {
        // dd(session());
        if(!session()->has('user'))
        {
            return view('Login.login');
        }else{
            return redirect()->route('dashboard.index')->withToastWarning('Tidak Mempunyai Hak Akses');
        }
        
    }
    public function postLogin(Request $request)
    {
        $credentials = $request->only('Username', 'Password');
        $user = UserModel::where('Username', $credentials['Username'])->first();
        if($user && Hash::check($credentials['Password'], $user->Password)){
            $request->session()->put('user', $user);
            $RoleName = $user->fk_role()->first()->RoleName;
            $Location = $user->getLocName();
            if($RoleName == 'SuperAdmin'){
            // dd(session(['user' => $user]));
            return redirect()->route('dashboard.index')->withToastSuccess('Berhasil Login Sebagai'. $RoleName);
            }elseif($RoleName =='AdminLocal'){
                return redirect()->route('dashboard.index')->withToastSuccess('Berhasil Login Sebagai '. $RoleName. ' di Lokasi: '. $Location);
            }else {
                return redirect()->route('dashboard.index')->withToastSuccess('Berhasil Login Sebagai '. $RoleName. ' di Lokasi: '. $Location);
            }
        }
        else{
            return redirect()->route('login')->withToastError('Username atau Password Salah');
        }
    }

    public function logout()
    {
        Session::flush();
        Auth::logout();

        return redirect()->route('login')->withToastSuccess('Anda berhasil Logout');
    }
//     $request->validate([
//         'Username' => 'required',
//         'Password' => 'required',
//     ]);
//     $credentials = $request->only('Username', 'Password');
//     dd(Auth::attempt($credentials));
//     Alert::success('Success Title', 'Success Message');
//     if (Auth::attempt($credentials)) {
//         session(['pegawai' => Auth::user()]);
//         // if(Auth::user()->id_role == 1){
//             return redirect()->route('dashboard')->withToastSuccess('Selamat Anda Berhasil Login');
//         // }
//         // elseif (Auth::user()->id_role == 2) {
//         //     return redirect()->route('dashboard')->withToastSuccess('Selamat Anda Berhasil Login');
//         // }
//     } else {
//         return redirect()->route('login')->withToastError('Username dan Password Tidak Sesuai');
//     }

// }
}