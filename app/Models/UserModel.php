<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserModel extends Model
{
    use HasFactory;
    protected $table = 'User';
    public $timestamps = false;

    protected $guarded = ['id'];
    protected $primaryKey = 'UserId';

    protected static $logName = 'User';
    public function hasRole($role)
    {
        return $this->role = $role; 
    }
    protected $hidden = [
        'Password',
       ];
       public function getAuthPassword()
       {
        return $this->Password;
       }
}
