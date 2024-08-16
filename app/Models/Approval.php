<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Approval extends Model
{
    use HasFactory, HasUuids;

    protected $primaryKey = 'approval_id';
    public $incrementing = false;
    protected $table = 'approvals';

    protected $fillable = [
        'approval_id',
        'customer_id',
        'service_id',
        'part_id',
        'status_id',
        'entry_ticket',
        'request_date',
        'approval_date',
        'create_zulu_date',
        'approval_area_remote_date',
        'email_request',
        'status_email_request',
        'reason_description',
    ];

    public function parts()
    {
        return $this->belongsToMany(Part::class, 'approval_parts', 'approval_id', 'part_id')
                    ->withPivot('status_part_id')
                    ->withTimestamps();
    }

    public function service()
    {
        return $this->belongsTo(Service::class, 'service_id', 'service_id');
    }

    public function statusParts()
    {
        return $this->belongsToMany(StatusPart::class, 'approval_parts', 'approval_id', 'status_part_id')
                    ->withPivot('part_id')
                    ->withTimestamps();
    }

}
