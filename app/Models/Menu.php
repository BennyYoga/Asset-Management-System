<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    use HasFactory;
    protected $table = ['Menu'];
    public $timestamps = false;

    public function role()
    {
        return $this->belongsToMany(Role::class, 'MenuId');
    }
}
