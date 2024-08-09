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
        'service_id',
        'part_id',
        'status_id',
        'entry_ticket',
        'request_date',
        'approval_date',
        'create_zulu_date',
        'approval_area_remote_date',
    ];

    public function parts()
    {
        return $this->belongsToMany(Part::class, 'approval_parts', 'approval_id', 'part_id');
    }

    // Relasi ke tabel Services
    public function service()
    {
        return $this->belongsTo(Service::class, 'service_id', 'service_id');
    }

    // Relasi ke tabel Statuses
    public function status()
    {
        return $this->belongsTo(Status::class, 'status_id', 'status_id');
    }
}
