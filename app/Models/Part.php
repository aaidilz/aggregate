<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Part extends Model
{
    use HasFactory, HasUuids;

    protected $primaryKey = 'part_id';
    public $incrementing = false;
    protected $table = 'parts';

    protected $fillable = [
        'part_id',
        'part_number',
        'part_description',
        'part_type',
    ];

    public function approvals()
    {
        return $this->belongsToMany(Approval::class, 'approval_parts', 'part_id', 'approval_id')
                    ->withPivot('status_part_id')
                    ->withTimestamps();
    }

    public function statusPart()
    {
        return $this->belongsTo(StatusPart::class, 'status_part_id', 'status_part_id');
    }

    // public function statusParts()
    // {
    //     return $this->belongsToMany(StatusPart::class, 'approval_parts', 'part_id', 'status_part_id')
    //                 ->withPivot('approval_id')
    //                 ->withTimestamps();
    // }
}
