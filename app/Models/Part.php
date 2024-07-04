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

    public function approval()
    {
        return $this->hasMany(Approval::class, 'part_id', 'part_id');
    }
}
