<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;
    protected $keyType ='string';
    protected $primaryKey = 'ProjectId';
    public $timestamps = false;
    protected $table = 'Project';
    protected $fillable = [   
    'ProjectId',
    'Name',
    'ParentId',
    'StartDate',
    'EndDate',
    'Active',
    'LocationId',
    'IsPermanentDelete',
    'CreatedBy',
    'UpdatedBy',
    ];

}
