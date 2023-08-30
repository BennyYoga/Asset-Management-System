<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ApproverMaster extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'ApproverMaster';
    protected $guarded = [];
    
    protected $fillable = [   
        'ApproverMasterId',
        'RequesterId',
        'ApproverId',
        'ModuleId',
        'ApprovalOrder',
        'CreatedBy',
        'CreatedDate',
        'UpdatedBy',
        'UpdatedDate'
        ];

        public function requester() {
            return $this->belongsTo(Role::class, 'RequesterId', 'RoleId');         
        }

        public function approver() {
            return $this->belongsTo(Role::class, 'ApproverId', 'RoleId');         
        }
}
