<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;
    
    protected $table = 'Role';
    public function fk_User()
    {
        return $this->belongsToMany(UserModel::class, 'RoleId', 'RoleId');
    }

    public function fk_location()
    {
        return $this->hasOne(Location::class, 'LocationId', 'LocationId');
    }

    public function menu()
    {
        return $this->belongsToMany(Role::class, 'MenuId');
    }

}
