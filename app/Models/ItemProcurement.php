<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class ItemProcurement extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'ItemProcurement';
    protected $primaryKey = 'ItemProcurementId';
    protected $keyType = 'string';
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
        'CreatedDate',
        'UpdatedBy',
        'UpdatedDate',
    ];

    protected static function boot() {
        parent::boot();
        static::creating(function ($model) {
                $model->{$model->getKeyName()} = (string) Str::uuid();
        });
    }
}
