<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ItemProcurement extends Model
{
    use HasFactory;
    protected $table = 'ItemProcurement';
    const CREATED_AT = 'CreatedDate';
    const UPDATED_AT = 'UpdatedDate';
    public $timestamps = true;
    protected $fillable = [
        'ItemProcurementId',
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
        return $this->belongsToMany(Item::class, 'ItemProcurementDetail', 'ItemProcurementId', 'ItemId');
    }
}
