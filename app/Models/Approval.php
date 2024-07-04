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
        'ticket_id',
        'part_id',
        'status_id',
        'entry_ticket',
        'request_date',
        'approval_date',
        'create_zulu_date',
        'approval_area_remote_date',
    ];

    public function ticket()
    {
        return $this->belongsTo(Ticket::class, 'ticket_id', 'ticket_id');
    }

    public function part()
    {
        return $this->belongsTo(Part::class, 'part_id', 'part_id');
    }

    public function status()
    {
        return $this->belongsTo(Status::class, 'status_id', 'status_id');
    }
}
