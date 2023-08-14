<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    use HasFactory;
    protected $table = 'Menu';
    public $timestamps = false;

    public function role()
    {
        return $this->belongsToMany(Role::class, 'MenuId');
    }

    public function menurole()
    {
        $roles = DB::table('RoleMenu')
        ->leftJoin('Role', 'RoleMenu.RoleId', '=', 'Role.RoleId')
        ->where('RoleMenu.MenuId', $this->MenuId)
        ->pluck('Role.RoleName')
        ->toArray();
        return $roles;
    }
    public function parentMenu() {
        return $this->belongsTo(Menu::class, 'ParentId');
    }
}
