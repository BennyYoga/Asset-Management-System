<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ItemRequisition extends Model
{
    use HasFactory;

    protected $table = 'ItemRequisition';
    const CREATED_AT = 'CreatedDate';
    const UPDATED_AT = 'UpdatedDate';
    public $timestamps = true;

    protected $fillable = [
        'ItemRequisitionId',
        'LocationId',
        'No',
        'Tanggal',
        'Notes',
        'Active',
        'Status',
        'IsPermanentDelete',
        'CreatedBy',
        'UpdatedBy'
    ];

    public function Location()
    {
        return $this->hasMany(Location::class);
    }

}