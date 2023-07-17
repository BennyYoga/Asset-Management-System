<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Location extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $primaryKey = 'LocationId';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $table = 'Location';
    // protected $guarded = ['id'];
    protected $fillable = [
        'LocationId',
        'ParentId',
        'HaveProcurementProcess',
        'Name',
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

    public function fk_role()
    {
        return $this->belongsTo(Role::class, 'LocationId', 'LocationId');
    }

    

}
