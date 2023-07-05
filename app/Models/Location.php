<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Location extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $table = 'Location';
    // protected $guarded = ['id'];
    // protected $primaryKey = 'LocationId';
    protected $fillable = [
        'LocationId',
        'ParentId',
        'HaveProcurementProcess',
        'Name',
        'Active',
        'IsPermanentDelete',
        'CreatedBy',
        'CreatedDate',
        'UpdatedBy',
        'UpdatedDate',
    ];

}
