<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;

    protected $table = 'Item';
    const CREATED_AT = 'CreatedDate';
    const UPDATED_AT = 'UpdatedDate';
    public $timestamps = true;
    // protected $guarded = ['ItemId'];
    protected $fillable = [
        'ItemId' ,
            'Name' ,
            'Unit' ,
            'ItemBehavior',
            'AlertHourMaintenance',
            'AlertConsumable',
            'Active',
            'IsPermanentDelete',
            'CreatedBy',
            'CreatedByLocation',
            'UpdatedBy'
    ];
    // protected $primaryKey = 'ItemId';

    public function Category()
    {
        return $this->belongsToMany(m_category::class, 'CategoryItem', 'ItemId', 'CategoryId');
    }

}
