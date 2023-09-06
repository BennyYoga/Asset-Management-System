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
        if(!session()->has('user'))
        {
            return view('Login.login');
        }else{
            // Session::flush();
            return redirect()->route('login')->with('error', 'Tidak Mempunyai Hak Akses');
        }
        
    }
    public function postLogin(Request $request)
    {
        $credentials = $request->only('Username', 'Password');
        $username = $credentials['Username'];
        $password = $credentials['Password'];
        $user = UserModel::whereRaw("BINARY Username = ?", [$username])->first(); 
        // $user = UserModel::where('Username', $credentials['Username'])->first();
        if($user && Hash::check($password, $user->Password)){
            $rolemenu = collect($user->menuRole());
            // $request->session()->put('user', [$user, $rolemenu, $user->fk_role]);
            $request->session()->put([
                // 'user',[$user, $rolemenu, $user->fk_role]);
                'user' => $user,
                'menu' => $rolemenu,
                'role' => $user->fk_role,
            ]);
            
            // dd(session('user'));
            // dd(session('role'));
            $RoleName = $user->fk_role()->first()->RoleName;
            if($RoleName == 'SuperAdmin'){
            return redirect()->route('dashboard.index')->withToastSuccess('Berhasil Login Sebagai '. $RoleName);
            }elseif($RoleName =='Admin Lokasi'){
                return redirect()->route('dashboard.index')->withToastSuccess('Berhasil Login Sebagai '. $RoleName. ' di Lokasi: '. $user->getLocName());
            }else {
                return redirect()->route('dashboard.index')->withToastSuccess('Berhasil Login Sebagai '. $RoleName. ' di Lokasi: '. $user->getLocName());
            }
        }
        else{
            return redirect()->route('login')->withToastError('Username atau Password Salah');
        }
    }

    public function logout()
    {

        Auth::logout();
        Session::flush();    
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
    public function resetPassword()
    {
        
    }
}