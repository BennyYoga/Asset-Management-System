<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ItemDisposing extends Model
{
    use HasFactory;
    protected $table = 'ItemDisposing';
    const CREATED_AT = 'CreatedDate';
    const UPDATED_AT = 'UpdatedDate';
    public $timestamps = true;
    protected $fillable = [
        'ItemDisposingId',
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
        return $this->belongsToMany(Item::class, 'ItemDisposingDetail', 'ItemDisposingId', 'ItemId');
    }
}
