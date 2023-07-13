<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;


class m_category extends Model
{
    use HasFactory;
    protected $keyType ='string';
    protected $primaryKey = 'CategoryId';
    public $timestamps = false;
    protected $table = 'Category';
    protected $fillable = ['CategoryId', 'ParentId', 'Name', 'Active', 'IsPermanentDelete', 'CreatedBy', 'UpdatedBy'];


    protected static function boot() {
        parent::boot();
        static::creating(function ($model) {
                $model->{$model->getKeyName()} = (string) Str::uuid();
        });
    }
    
    public function Cate()
    {
        return $this->belongsToMany(Item::class, 'CategoryItem', 'CategoryId', 'ItemId');
    }
}
