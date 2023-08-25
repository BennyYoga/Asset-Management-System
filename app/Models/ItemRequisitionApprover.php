<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ItemRequisitionApprover extends Model
{
    use HasFactory;

    protected $table = 'ItemRequisitionApprover';
    const CREATED_AT = 'CreatedDate';
    const UPDATED_AT = 'UpdatedDate';
    public $timestamps = true;

    protected $fillable = [
        'ItemRequisitionApprover',
        'ItemRequisition',
        'UserId',
        'Order',
        'Notes',
        'IsApproved',
        'IsDeliced',
        'CreatedDate',
        'UpdatedDate',
        'CreatedBy',
        'UpdatedBy',
    ];
}
