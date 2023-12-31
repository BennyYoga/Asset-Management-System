<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;

    public $incrementing = false;
    protected $table = 'Item';
    const CREATED_AT = 'CreatedDate';
    const UPDATED_AT = 'UpdatedDate';
    public $timestamps = true;
    // protected $guarded = ['ItemId'];
    protected $fillable = [
        'ItemId' ,
            'Code' ,
            'Name' ,
            'Unit' ,
            'ItemBehavior',
            'UseType',
            'AlertHourMaintenance',
            'AlertConsumable',
            'Active',
            'IsPermanentDelete',
            'CreatedBy',
            'CreatedByLocation',
            'UpdatedBy'
    ];
    protected $primaryKey = 'ItemId';

    public function Category()
    {
        return $this->belongsToMany(m_category::class, 'CategoryItem', 'ItemId', 'CategoryId');
    }

    public function ItemRequisition()
    {
        return $this->belongsToMany(ItemRequisition::class, 'ItemRequisitionDetail', 'ItemId', 'ItemRequisitonId');
    }

    public function ItemProcurement()
    {
        return $this->belongsToMany(ItemProcurement::class, 'ItemProcurementDetail', 'ItemId', 'ItemProcurementId');
    }

    public function ItemTransfer()
    {
        return $this->belongsToMany(ItemTransfer::class, 'ItemTransferDetail', 'ItemId', 'ItemTransferId');
    }

    public function ItemUse()
    {
        return $this->belongsToMany(ItemUse::class, 'ItemUseDetail', 'ItemId', 'ItemUseId');
    }

    public function ItemDisposing()
    {
        return $this->belongsToMany(ItemDisposing::class, 'ItemDisposingDetail', 'ItemId', 'ItemDisposingId');
    }

}
