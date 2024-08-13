<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StatusPart extends Model
{
    use HasFactory, HasUuids;

    protected $primaryKey = 'status_part_id';
    public $incrementing = false;
    protected $table = 'status_parts';

    protected $fillable = [
        'status_part_id',
        'SN_part_good',
        'SN_part_bad',
        'status_part_used',
        'status_part',
    ];
}
