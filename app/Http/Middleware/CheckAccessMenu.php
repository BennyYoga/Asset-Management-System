<?php

namespace App\Http\Middleware;

use App\Models\Menu;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\UserModel;
use App\Models\Role;
use App\Models\RoleMenu;
use Illuminate\Support\Facades\Session;

class CheckAccessMenu
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next, $role)
    {
        $roles = is_array($role) ? $role : explode('|', $role);
        $user = session('user');
    
        if (!$user) {
            return redirect()->back()->withToastWarning('Anda harus login untuk mengakses halaman ini');
        }
        $users = UserModel::where('RoleId', $user->RoleId)->first();
    
        $checkrolemenu = $users->RoleMenu($roles);
    
        if ($checkrolemenu) {
            return $next($request);
        } else {
            $check = Role::where('RoleId', $user->RoleId)->first();
            foreach ($roles as $a) {
                if ($check->RoleName == $a) {
                    return $next($request);
                }
            }
        }
    
        return redirect()->back()->withToastWarning('Halaman Tidak tersedia untuk anda');
    }
    
            // abort(403, 'Unauthorized'); // Replace 'unauthorized' with the route name you want to redirect unauthorized users to.
        
        // $roles = is_array($role) ? $role : explode('|', $role);
        // $user = session('user');
        // $users = UserModel::where('RoleId', $user->RoleId)->first();

        // // $checkuser = Role::where('RoleId', $user['RoleId'])->first();
        // // $checkmenu = RoleMenu::where('RoleId', $checkuser['RoleId'])->first();
        // $checkrolemenu = $users->RoleMenu()->first();
    
        // foreach ($roles as $a) {
        //     if (Session::has('user') && $checkrolemenu->MenuName == $a) {
        //         return $next($request);
        //         // ->withToastSuccess('You have Successfully logged in');
        //     }
        // }
    
        //     return $next($request);
        // }
    }
