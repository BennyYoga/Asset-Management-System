<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;

    protected $table = 'Item';
    public $timestamps = false;
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

}
