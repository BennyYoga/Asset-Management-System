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
        'ItemRequisitionApproverId',
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

    public function User()
    {
        return $this->hasOne(UserModel::class, 'UserId', 'UserId');
    }

    public function ItemRequisition()
    {
        return $this->belongsTo(ItemRequisition::class, 'ItemRequisition', 'ItemRequisition');
    }
}
