<?php

namespace App\Http\Middleware;

use App\Models\UserModel;
use App\Models\Role;
use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Queue\Jobs\RedisJob;
use Illuminate\Support\Facades\Session;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */

     public function handle($request, Closure $next, $role)
     {
        $roles = is_array($role) ? $role : explode('|', $role);
        
        if (Session::has('user')) {
            $check = Role::where('RoleId', session('user')->RoleId)->first();
            
            foreach ($roles as $a) {
                if ($check->RoleName == $a) {
                    return $next($request);
                }
            }
        }
    
        // Jika sesi tidak tersedia atau peran tidak sesuai, arahkan pengguna ke halaman tertentu
        return redirect()->route('login')->withToastError('Anda Harus Login Terlebih Dahulu'); // Gantilah 'login' dengan nama route halaman login Anda
    }
            
        // $user = session('user');
        // $roles = $user->fk_role()->pluck('RoleName')->toArray();

        // if ($user->hasMenu($menu)) {
        //     foreach ($roles as $role) {
        //         if ($role == $user->RoleName) {
        //             return $next($request);
        //         }
        //     }

        //  $user = session('user');
        //  $RoleName = $user->fk_role()->first()->RoleName;
        // //  dd()
        //  if (!$user->hasMenuAccess($menu)) {
        //     //  foreach ($roles as $role) {
        //         //  if ($user->RoleName == $role) {  
        //         //  return $next($request);
        //          $roles = is_array($role)
        //          ? $role
        //          : explode('|', $role);
        //          }foreach($roles as $a){
        //          {
        //              if(Session('user') && Session('user')->RoleName == $a){
        //                 return $next($request);
        //              }
                    
        //          }
            //  }
    //          abort(404);
    //      }
         
    //      return redirect()->route('login')->with('toast_error', 'Anda harus login terlebih dahulu');
    //  }
     
}
        
