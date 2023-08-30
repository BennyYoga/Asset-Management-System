<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class UserModel extends Authenticatable
{
    use HasFactory;
    protected $table = 'User';
    public $timestamps = false;
    // protected $fillable =['Username','Fullname', 'Password', 'UserId', 'RoleId', 'Active', 'IsPermanentDelete', 'CreatedBy'];

    protected $guarded = ['id'];
    protected $password = 'Password';
    protected $username = 'Username';
    protected $hidden = [
        'Password', 'remember_token',
    ];
    protected static $logName = 'user';
    public function hasRole($role)
    {
        return $this->role = $role;
    }
    
    // protected $hidden = [
    //     'Password',
    //    ];

    public function getAuthPassword()
    {
        return $this->Password;
    }

    public function fk_role()
    {
        return $this->hasOne(Role::class, 'RoleId', 'RoleId');
    }


    public function getLocName()
    {
        $locationName = Role::join('Location', 'Role.LocationId', '=', 'Location.LocationId')
            ->where('Role.RoleId', $this->RoleId)
            ->value('Location.Name');
        return $locationName;
    }


    public function hasMenu($menu)
    {
        return $this->fk_role()->whereHas('Role', function ($query) use ($menu) {
            $query->where('MenuName', $menu);
        })->exists();
    }


    public function RoleMenu($roles)
    {
        $checkrolemenu = Role::join('RoleMenu', 'Role.RoleId', '=', 'RoleMenu.RoleId')
            ->join('Menu', 'RoleMenu.MenuId', '=', 'Menu.MenuId')
            ->where('Role.RoleId', $this->RoleId)
            ->whereIn('Menu.MenuId', $roles)
            ->first();

        return $checkrolemenu;
    }
    public function menuRole()
    {
        $roles = Menu::pluck('MenuId')->toArray();
        $checkrolemenu = Role::join('RoleMenu', 'Role.RoleId', '=', 'RoleMenu.RoleId')
            ->where('Role.RoleId', $this->RoleId)
            ->whereIn('RoleMenu.MenuId', $roles)->get();
        return $checkrolemenu;
    }
}
