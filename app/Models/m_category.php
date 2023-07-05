<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class m_category extends Model
{
    use HasFactory;
    public $timestamps = false;
    // protected $primarykey = ;
    protected $table = 'Category';
    protected $fillable = ['CategoryId', 'ParentId', 'Name', 'Active', 'IsPermanentDelete', 'CreatedBy', 'UpdatedBy'];
}
