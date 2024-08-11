<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Status extends Model
{
    use HasFactory, HasUuids;

    protected $primaryKey = 'status_id';
    public $incrementing = false;
    protected $table = 'statuses';

    protected $fillable = [
        'status_id',
        'status_part',
        'email_request',
        'status_email_request',
        'SN_part_good',
        'SN_part_bad',
        'status_part_used',
        'reason_description',
    ];

    public function approvals()
    {
        return $this->hasMany(Approval::class, 'status_id', 'status_id');
    }
}
