<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class dashboardController extends Controller
{
    //
    public function index()
    {
        if(session('user')){
        return view('Dashboard.index');
        }else{
            return redirect()->to('login')->with('error', 'Silahkan Lakukan login terlebih dahulu');
        }
    }
}
