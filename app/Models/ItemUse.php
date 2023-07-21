<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ItemUse extends Model
{
    use HasFactory;
    protected $table = 'ItemUse';
    const CREATED_AT = 'CreatedDate';
    const UPDATED_AT = 'UpdatedDate';
    public $timestamps = true;
    protected $fillable = [
        'ItemUseId',
        'LocationId',
        'ProjectId',
        'No',
        'Tanggal',
        'Notes',
        'Status',
        'Active',
        'IsPermanentDelete',
        'CreatedBy',
        'UpdatedBy',
    ];

    public function Location()
    {
        return $this->hasMany(Location::class);
    }

    public function Item()
    {
        return $this->belongsToMany(Item::class, 'ItemUseDetail', 'ItemUseId', 'ItemId');
    }
}
