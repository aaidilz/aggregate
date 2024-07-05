<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerApproval extends Model
{
    use HasFactory, HasUuids;

    protected $primaryKey = 'customer_approval_id';
    public $incrementing = false;
    protected $table = 'customer_approvals';

    protected $fillable = [
        'customer_approval_id',
        'customer_id',
        'approval_id',
    ];

    public function customers()
    {
        return $this->belongsTo(Customer::class, 'customer_id', 'customer_id');
    }

    public function approvals()
    {
        return $this->belongsTo(Approval::class, 'approval_id', 'approval_id');
    }
}
